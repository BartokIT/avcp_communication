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
    /**
     * @property array $_s Maintain a refer to the session
     * */
    public $_s=NULL;
    /**
     * @property array $_r Maintain a link to the reqests array
     * */
    public $_r=NULL;
    /**
     * @property State $state The current state of the application
     * */
    public $state=NULL;
    public $flow_name="";
    public $annotation_reader = NULL;
    public $control=NULL;
    public $login_state=NULL;
    public $action=NULL;
    public $delegation_stack=array();
    
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
        $this->_r = $_REQUEST;
        if (isset($_REQUEST["resources"]))
            $this->print_resources();
        else
        {
            $this->load_state();
            $this->execute_action();
        }
    }
    
    /**
     * Print out an error page to inform the user about
     * eventual problem
     * */
    public function error_page($http_code,$message)
    {
        http_response_code($http_code);
        echo <<<OUT
            <pre>
                $message
            </pre>        
OUT;
        die();
    }
    
    /**
     * Routine that returns various resource file
     */
    public function print_resources(){
        
    }
    
    /**
     * Load the status stored in the session or set the initial status
     * if this is a new execution flow
     * */
    private function load_state()
    {
        @session_start();
        if (!isset($_SESSION[sha1($this->flow_name)]))
            $_SESSION[sha1($this->flow_name)]=array();
        
        $this->_s=&$_SESSION[sha1($this->flow_name)];
        if (count($this->_s)==0)
        {
            $this->state= clone $this->init_state;
            $this->retrieve_control($this->state);
            $this->_s["_state"] = serialize ($this->state);            
            $this->history= $this->_s["_history"] = array();
        }
        else
        {
            $this->history = $this->_s["_history"];
            $this->state =unserialize( $this->_s["_state"]);
        }
    }
    
    /**
     * Search for a state control file and add it to cache, also permit to check if the
     * control file of the status exists and is valid
     * @param State $status the state object instance for with
     */
    private function retrieve_control($status)
    {
        global $keywords;
        //if the status control file is already read, set the correspondently control object
        if (isset($this->states_cache[$status . ""]))
        {
            $status->setControlObject($this->states_cache[$status . ""]->getControlObject());
            return;
        }
        else
        {
            //...else retrieve control object from the file system
            $control_file_path=$status->getControlFilePath();
                        
            if (file_exists($control_file_path) && is_file($control_file_path))
            {
                //check if some reserved words are used in namespace string
                $unusable_words  = array_intersect($status->getAreaArray(),$keywords);
                if (count($unusable_words)>0)
                {
                    $this->error_page(500,"Sorry you are using reserved word in control object namespace [" . implode(",",$unusable_words) . "]");
                }
                else
                {
                    //Extract control class annotation
                    require_once $control_file_path;
                    $session = $this->init_session($status);                    
                    eval('$c= new ' . $status->getControlManagerClassName() . '($this,$status,$this->_r,$session);');
                    
                    $this->read_annotation($c);
                    $this->states_cache[$status .""] = $status;
                    $status->setControlObject($c);
                }
            }
            else
            {
                $this->error_page(500,"Impossible to retrieve control file [" . $control_file_path . "]");
            }
        }
    }

    /**
     * Initialize the portion of session dedicated to the status passed
     * @param State $state The state whose session is for
     * */
    private function &init_session($state)
    {
        $sa = $state->getAreaArray();
        
        if (!isset($this->_s[$state->getSiteView()]))
            $this->_s[$state->getSiteView()]=array();
        
        $a = &$this->_s[$state->getSiteView()];
        foreach ($sa as $area)
        {
            if (!isset($a[$area]))
                $a[$area]=array();
            $a=&$a[$area];
        }
        return $a;
    }
    
    /**
     * Read the annotation inserted in the object and set the
     * metainfo for the relative status
     * @param Control $object 
     * */
    private function read_annotation($object)
    {
        //TODO: insert caching system
        $reflClass = new ReflectionObject($object);
        $return =(object) array("methods"=>array(),"class"=>array());
        $return->class= $this->reader->getClassAnnotations($reflClass);
        foreach ($return->class as $a)
        {
            //set the skippable and delegation properties
            if ($a instanceof Skippable) { $object->getStatus()->setSkippable($a->value); }
            if ($a instanceof AncestorDelegation) { $object->getStatus()->setAncestorDelegation($a->value); }
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
     * Goes to another status storing the information into the session and write the history
     * @param State $next_state This is the state wich need to go to.
     * @param boolean $inconditional True if the jump request come from the header, false if it is from an elaboration
     */
    public function go_to_state($next_state,$inconditional=false)
    {
        $this->state = $next_state;
        $this->retrieve_control($this->state);
        $this->_s["_state"]=serialize($next_state);
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
            //push the current state up to the stack
            array_push($this->delegation_stack,$state);
            
            //get upper (or lower?) lever control state
            $aa = $state->getAreaArray();
            array_pop($aa);            
            $as = implode("/",$aa);
            $ns = new State($state->getSiteView(),$as);
            $this->retrieve_control($ns);            
            //TODO: log the status change to the state history
            $this->state = $ns;
        }
    }
    
    /**
     * This routine reset data structure of the delegation process, to permit
     * correct information storing and logical processing
     * */
    public function delegation_restore()
    {
        
        while (count($this->delegation_stack) > 1)
        {
            $this->state = array_pop($this->delegation_stack);
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
        echo "action exists: " .  $state . " " . (method_exists($state->getControlObject(),$action)?"true":"false"   );
        
        if (method_exists($state->getControlObject(),$action))
            return true;        
        else        
            return false;
    }
    
    /**
     * This method return an area directl requested by the user via GET or POST
     * or, if there is no resquest, return false
     * @return mixed Return false if there is no requests, or the area requested
     * */
    public function request_to_jump()
    {
        if (isset($this->_r["area"]))
        {
            return new State($this->state->getSiteView(),$this->_r["area"]);
        }
        else
            return false;
    }
    
    
    /**
     * This is the main method of the execution
     * */
    public function execute_action()
    {
        //controllo se è necessario è possibile ed è richiesto salto
        if ($this->state->isSkippable() && ( (boolean)$this->request_to_jump()))
        {
            $this->go_to_state($this->request_to_jump(),true);
        }
        
        //At first execution loop, return object is void (NilObject)
        $ro = new NilObject();
        do
        {
            //retrieve control class for the state
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
            
            //Check if the action exists or not
            if (!$this->action_exists($this->state,$this->action))
            {
                $ro = $this->error_page(500,"Current application state is not capable to manage specified action");
            }
            else
            {
                //check if the user has the permission to execute
                if (!$this->check_permission($this->state,$this->action))
                {
                    $ro = $this->error_page(403,"Access restricted to authorized principal");
                }
                else
                {
                    //$ro = $this->jump_to_state($this->login_state);
                    $ro = $this->state->getControlObject()->{$this->action}();                    
                    $this->manage_ro($ro,0);
                    //reset possibile delegation
                    $this->delegation_restore();
                }
            }
        } while ( $ro instanceof BackObject);
        
        $this->manage_ro($ro,1);
    }
    
    
    /**
     * This method provide managemente for the returned object of the execution flow.
     * Depends on the type of the object different behaviour will be maked.
     * @param ReturnObject $ro The returned object
     * */
    public function manage_ro($ro,$phase=0)
    {
        if ($ro instanceof BackObject && $phase==0)
        {
            //If the returned object is a new state
            if ($ro instanceof ReturnedArea)
            {
                $this->go_to_state($ro->getStatus());
                if (is_null($ro->getAction()))
                    $this->action = $this->default_action;
                else
                    $this->action = $ro->getAction();
            }
        }
        else if ($ro instanceof PrintableObject && $phase==1)
        {
            include PRESENTATION_PATH . $ro->getPage();
        }
    }
}
?>