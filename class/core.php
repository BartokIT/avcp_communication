<?php
define("CONTROL_PATH","control/");
define("PRESENTATION_PATH","presentation/");
define("LIB_PATH","lib/");

/**
 * Default configuration settings variable
 */
$config = (object) array("init_status"=>array("site_view"=>"default", "area"=>"default"), "debug"=>false, "flow_name"=>NULL, "login_status"=>NULL,"history_len"=>10 );

/**
 * Init Doctrine library to manage annotation
 */
require_once LIB_PATH . 'Doctrine/Common/ClassLoader.php';
$DoctrineClassLoader = new Doctrine\Common\ClassLoader('Doctrine\Common', LIB_PATH);
$DoctrineClassLoader->register();


/**
 * Explantion of variable abbreviation:
 * <ul>
 *  <li>$c - oggetto di controllo passato ai file di controllo</li>
 *  <li>$_s - session
 *  <li>$co - control object
 * </ul>
 */
class MainFlow
{
    public $init_state = NULL;
    public $debug=false;
    public $user=NULL;
    public $history=NULL;
    public $states_cache=array();
    public $default_action ="d";
    public $_s=NULL;
    /**
     * @property State $state The current state of the application
     * */
    public $state=NULL;
    public $flow_name="";
    public $annotation_reader = NULL;
    public $control=NULL;
    public $login_state=NULL;
    public $action=NULL;
    
    public function __construct()
    {
        global $config;
        $configuration = array();
        if (func_num_args() > 0)
        {
            $arg_list = func_get_args();
            $configuration =  $arg_list[0];
        }
        else
        {
            $configuration = $config;
        }
        
        $this->init_state=new State($configuration->init_status["site_view"],
                                    $configuration->init_status["area"]);
        $this->debug=$configuration->debug;
        define("DEBUG",$this->debug);
        
        $this->flow_name=$configuration->flow_name;
        $this->reader=new \Doctrine\Common\Annotations\AnnotationReader();
        
        if (isset($_REQUEST["resources"]))
            $this->print_resources();
        else
        {
            $this->load_state();
            $this->execute_action();
        }
    }
    
    
    public function error_page()
    {
        $i;
    }
    
    /**
     * Routine that returns various resource file
     */
    public function print_resources(){
        
    }
    
    public function load_state()
    {
        @session_start();
        $this->_s=@$_SESSION[sha1($this->flow_name)];
        if ($this->_s === NULL)
        {
            $this->state= $this->_s["_state"] = clone $this->init_state;
            $this->history= $this->_s["_history"] = array();
        }
        else
        {
            $this->history = $this->_s["_history"];
            $this->state = $this->_s["_state"];
        }        
    }
    
    /**
     * Search for a state control file and add it to cache
     * @param State $status the state object instance for with
     */
    public function retrieve_control($status)
    {
        if (isset($this->states_cache[$status . ""]))
        {
            return $this->states_cache[$status . ""];
        }
        else
        {
            $control_file_path=$status->getControlFilePath();
            //TODO: add control to default keyword
            if (file_exists($control_file_path) && is_file($control_file_path))
            {
                //Extract control class annotation
                echo $control_file_path;
                require_once $control_file_path;
                echo '$c= new ' . $status->getControlManagerClassName() . '($status);';
                eval('$c= new ' . $status->getControlManagerClassName() . '($status);');
                
                $this->read_annotation($c);
                $this->states_cache[$status .""] = $status;
                $status->setControlObject($c);
            }
            else
            {
                $this->error_page(500,"Impossible to retrieve control file [" . $control_file_path . "]");
            }
        }
    }

    /**
     * Read the annotation inserted in the object and set the
     * metainfo for the relative status
     * @param Control $object 
     * */
    public function read_annotation($object)
    {
        //TODO: insert caching system
        $reflClass = new ReflectionObject($object);
        $return =(object) array("methods"=>array(),"class"=>array());
        $return->class= $this->reader->getClassAnnotations($reflClass);
        foreach ($return->class as $a)
        {
            //set the skippable and delegation properties
            if ($a instanceof Skippable) { $object->getStatus()->setSkippable($a->value); break; }
            if ($a instanceof AncestorDelegation) { $object->getStatus()->wantDelegate($a->value); break; }
        }
        
        $methods = $reflClass->getMethods();
        foreach ($methods  as $method)
        {            
            $return->methods[$method->getName()] =$this->reader->getMethodAnnotations($method);
        }
        
        $object->getStatus()->setMetainfo($return);
        
    }
    

    /**
     * Controlla se l'utente corrente ha i permessi per effettuare l'azione corrente
     * @param State $state istanza della classe State per la quale verificare i diritti di accesso
     * @param string $action una stringa che contiene la action da eseguire
     * @return boolean <strong>true</strong> se l'utente corrente ha diritto di accesso/<strong>false</strong> altrimenti
     */
    public function check_permission($state,$action)
    {
        if (isset($this->states_cache[$state .""]))
        {
            
            $ma = $this->states_cache[$state .""]->getMetainfo()->methods[$action];
            $access_info =NULL;
            foreach($ma as $a)
            {
                if ($a instanceof Access)
                {
                    $access_info=$a;
                    break;
                }
            }
            if ( !is_null($access_info))
            {
                if (in_array("everyone",$access_info->roles))
                    return true;
                
                foreach ($this->user as $user_role)
                {
                    if (in_array($user_role,$access_info->roles))
                        return true;
                }
                return false;
            }
            else //the action is accessible if is not specified access info
                return true;
            
        }
        //TODO: emettere un warning?
        return true;
    }
    
    /**
     * Salta ad un nuovo stato memorizzando le informazioni nella history
     * @param State $next_state This is the state wich need to go to.
     * @param boolean $inconditional True if the jump request come from the header, false if it is from an elaboration
     */
    public function go_to_state($next_state,$inconditional)
    {
        $this->state = $next_state;
    }
    
    /**
     * Salta ad uno stato gerarchicamente superiore, se si trova in uno stato
     * nel quale non vi è più alcun superiore, restituisce l'oggetto stesso
     * @param object $state Description
     * @return object  Description  
     */
    public function delegate_to_ancestor($state) {
        if ($this->state->isRoot())
            return $state;
        else
        {
            $aa = $this->state->getAreaArray();
            array_pop($aa);            
            $as = implode("/",$aa);
            $ns = new State($this->state->getSiteView(),$as);
            $this->retrieve_control($ns);
            
            //TODO: log the status change to the state history
            $this->state = $ns;
        }
    }
    
    /**
     * This method set the correct action requested by the user
     * */
    public function retrieve_action()
    {
        // If the action is null then search from the request
        if (is_null($this->action))
        {
            if (isset($_REQUEST["action"]))
            {
                //if the state is not skippable and is requested a inconditional jump
                //to another state, than the default action is setted
                if (!($this->state->isSkippable()) && $this->request_to_jump())
                    $this->action = $this->default_action;
                else
                    $this->action = $_REQUEST["action"];
                
            }
            else //if the action is not set, return the default action
                $this->action = $this->default_action;
        }
        else
        {
            //nothing to do    
        }
    }
    /**
     * This method control if the state passed as argument, can manage the action specified
     * @param State $state The state for wich need to check the action
     * @param string $action The string thath represente the action to be checked
     * @return boolean True or false if respectively support or not the action
     * */
    public function action_exists($state,$action)
    {
        if (method_exists($state->getControlObject(),$action))
            return true;
        else
            return false;
    }
    
    public function request_to_jump() {}
    
    
    /**
     * This is the main method of the execution
     * */
    public function execute_action()
    {
        
        
        //controllo se è necessario è possibile ed è richiesto salto
        if ($this->state->isSkippable() && $this->request_to_jump())
        {
            go_to_state(/* requested state*/);
        }
        
        //At first execution loop, return object is void (NilObject)
        $ro = new NilObject();
        do
        {
            $this->retrieve_control($this->state);
            $this->retrieve_action();
            
            //interpello tutti i controllori di gerarchia superiore
            //fino a trovarne uno che sappia gestire
            while (!$this->action_exists($this->state,$this->action) &&
                   $this->state->wantDelegate()  && //true if is permitted to delegate to ancestor
                   !$this->state->isRoot()) //root state is a state without ancestor
            {
                $this->delegate_to_ancestor($this->state);
            }
            
            if (!$this->action_exists($this->state,$this->action))
            {
                $ro = $this->error_page(500,"Current application state is not capable to manage specified action");
            }
            else
            {        
                if (!$this->check_permission($this->state,$this->action))
                {
                    //se non ho i diritti 
                    $ro = $this->error_page(403,"Access restricted to authorized principal");
                }
                else
                {
                    //$ro = $this->jump_to_state($this->login_state);
                    $ro = $this->state->getControlObject()->{$this->action}();
                    $this->manage_ro($ro);                   
                }
            }
        } while ( $ro instanceof BackObject);
    }
    
    
    /**
     * This method provide managemente for the returned object of the execution flow.
     * Depends on the type of the object different behaviour will be maked.
     * @param ReturnObject $ro The returned object
     * */
    public function manage_ro($ro)
    {
        if ($ro instanceof BackObject)
        {
            //If the returned object is a new state
            if ($ro instanceof ReturnedArea)
            {
                $this->go_to_state($ro->getStatus());
                $this->action = $ro->getAction();
            }
        }
        
    }
}
?>