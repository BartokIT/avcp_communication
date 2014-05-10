<?php
define("CONTROL_PATH","control/");
define("PRESENTATION_PATH","presentation/");
define("LIB_PATH","lib/");

/**
 * Default configuration settings variable
 */
$config = (object) array("initial_site_view"=>"default", "initial_area"=>"default", "debug"=>false, "flow_name"=>NULL, "login_status"=>NULL,"history_len"=>10 );

/**
 * Init Doctrine library to manage annotation
 */
require_once LIB_PATH . 'Doctrine/Common/ClassLoader.php';;
$DoctrineClassLoader = new Doctrine\Common\ClassLoader('Doctrine\Common', LIB_PATH);
$DoctrineClassLoader->register();

require_once "dataobjects.php";
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
    public $state=NULL;
    public $flow_name="";
    public $annotation_reader = NULL;
    public $control=NULL;
    public $login_state=NULL;
    public function __construct($configuration)
    {
        $this->state=new State();
        $this->init_state=new State($configuration->initial_site_view,$configuration->initial_area);
        $this->debug=$configuration->debug;
        define("DEBUG",$this->debug);
        
        $this->flow_name=$configuration->flow_name;
        $this->annotation_reader=new \Doctrine\Common\Annotations\AnnotationReader();
        
        if (isset($_REQUEST["resources"]))
            print_resources();
        else
        {
            load_state();
            execute_action();
        }
    }
    
    /**
     * Routine that returns various resource file
     */
    public function print_resources(){}
    
    public function load_state()
    {
        @session_start();
        $_s=@$_SESSION[sha1($this->flow_name)];
        if ($_s === NULL)
        {
            $this->state= $_s["_state"] = clone $this->init_state();
            $this->history= $_s["_history"] = array();
        }
        else
        {
            $this->history = $_s["_history"];
            $this->state = $_s["_state"];
        }        
    }
    
    /**
     * Search and return a state control file 
     * @return object  Control object
     */
    public function retrieve_control($state)
    {
        $control_file_path=$state->getControlFilePath();
        if (file_exists($control_file_path))
        {
            //Extract control class annotation
            require_once($control_file_path);
            $cfs= '$c= new ' . $state->getControlManagerClassName() . '();';
            eval($cfs);
            MainFlow::read_annotation($c);
            if (!isset($this->states_cache[$state->toString()]))
                $this->states_cache[$state->toString()] = MainFlow::read_annotation($state->getControlManagerClassName());
            
            eval('$c = new ' . $state->getControlManagerClassName . '();');
            return $c;
        }
        else
        {
            error_page(500,"Impossible to retrieve control file [" . $control_file_path . "]");
        }
    }

    static public function read_annotation($class)
    {
        //TODO: insert caching system
        $reflClass = new ReflectionObject($class);
        $return->class= $this->reader->getClassAnnotations($reflClass);
        $methods = $reflClass->getMethods();
        foreach ($methods  as $method)
        {            
            $return->methods[$method->getName()] =$this->reader->getMethodAnnotations($method);
        }
        
        return $return; 
    }
    
    
    /**
     * Controlla se è possibile uscire incondizionatamente dallo stato attuale dell'applicazione
     * @param State $state istanza della classe State per la quale effettuare il controllo
     * @return boolean <strong>true</strong> se e' possibile uscirne/<strong>false</strong> altrimenti
     */
    public function is_skippable($state)
    {
        if (isset($this->states_cache[$state .""]))
            return $this->states_cache[$state .""]["class"]->value;
        else
            return true;
    }
    
    /**
     * Controlla se l'utente corrente ha i permessi per effettuare l'azione corrente
     * @param State $state istanza della classe State per la quale verificare i diritti di accesso
     * @param string $action una stringa che contiene la action da eseguire
     * @return boolean <strong>true</strong> se l'utente corrente ha diritto di accesso/<strong>false</strong> altrimenti
     */
    public function check_permission($state,$action)
    {
        if (isset($this->states_cache[$state .""]) &&
            isset($this->check_permission[$state .""]["methods"][$action]))
        {
            $access_info = $this->check_permission[$state .""]["methods"][$action];
            if (strcmp($access_info->type,"public")== 0 )
                return true;
            
            if (in_array("Everyone",$access_info->roles))
                return true;
            foreach ($this->user as $user_role)
            {
                if (in_array($user_role,$access_info->roles))
                    return true;
            }
            return false;
        }
        //TODO: emettere un warning?
        return true;
    }
    
    /**
     * Salta ad un nuovo stato memorizzando le informazioni nella history
     * @param object $next_state Description
     * @return object  Description
     */
    public function jump_to_state($next_state)  { }
    
    /**
     * Salta ad uno stato gerarchicamente superiore, se si trova in uno stato
     * nel quale non vi è più alcun superiore, restituisce una oggetto
     * senza alcun methodo
     * @param object $state Description
     * @return object  Description  
     */
    public function delegate_to_ancestor($state) {}
    
    public function execute_action()
    {
        
        
        //controllo se è necessario è possibile ed è richiesto salto
        if (is_skippable($this->state) && request_to_jump())
        {
            jump_to_state(/* requested state*/);
        }
        
        $ro = new NilObject();
        $co=$this->retrieve_control($this->state);
        //interpello tutti i controllori di gerarchia superiore
        //fino a trovarne uno che sappia gestire
        do
        {
            while (!action_exists($this->state,$this->action) &&
                   delegate_to_ancestor($this->state) && //se lo stato permette di delegare ai superiori
                   !root_state($this->state)) //root state è una classe control vuota
            {
                move_to_parent($this->state);
            }
            
            if (!action_exists($this->state,$this->action))
            {
                $ro = error_page(500,"Current application state is not capable to manage specified action");
            }
            else
            {        
                if (!check_permission($this->state,$this->action))
                {
                    //se non ho i diritti 
                    $ro = error_page(403,"Access restricted to authorized principal");
                }
                else
                {
                    $ro = jump_to_state($this->login_state);                
                }
            }
        } while ( $ro instanceof BackObject)
    }
}
?>