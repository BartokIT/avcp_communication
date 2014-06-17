<?php



/**
 * Represente an user that access to the application
 * */
class User implements Serializable {
	/* System parameter */
	/**
	 * @property MainFlow $flow Contains a refer to the execution flow
	 * */
	private $flow;
	private $session;
	
	/* User specific parameter*/
	private $logged=FALSE;
	
	private $groups;
	
	private $roles;
	
	/**
	 * @property string $first_name The first name of the user
	 * */
	private $first_name=NULL;
	
	/**
	 * @property string $surname Surname of the user
	 * */	
	private $surname=NULL;
	
	private $id=NULL;
	private $displayed_name=NULL;
	
	public function __construct($fl,&$s)
	{
		$this->flow = $fl;
		$this->session = &$s;
		$this->roles=array();		
	}
	
	public function addUserRole($role)
	{
		$this->roles[$role]=$role;
	}
	/**
	 * Get the user identifier
	 * */
	public function getID()
	{
		return $this->id;
	}

	/**
	 * @return array Return the array wich user belong
	 * */
	public function getGroups()
	{
		return $this->groups;
	}
	
	public function setGroups($groups)
	{
		$this->groups = $groups;
	}
	
	public function setName($first,$suname,$displayname=NULL)
	{
		$this->first_name= $first;
		$this->surname=$suname;
		$this->displayed_name = $displayname;
	}
	
	public function login($id,$password=NULL)
	{
		//echo "<p>login called</p>";
		$auth_config = $this->flow->configuration->authentication;
		
		//check if the authentication is alreay done
		$identified=false;
		if (!$auth_config["external"])
		{
			$identified=$auth_config["authenticator"]->authenticate($id,$password);
			
		}
		else
		{
			if (isset($_SERVER['PHP_AUTH_USER'])) {
				$id= $_SERVER['PHP_AUTH_USER'];
				$identified=true;
			}
		}
		
		if ($identified)
		{
			$this->id = $id;
			$auth_config["userinforetriever"]->getUserInfo($this);
			$auth_config["rolemapper"]->setUserRoles($this);
			$this->session["_user"]=serialize($this);
			return true;
		}
		else
			return false;
	}
	
	public function logout()
	{
		unset($this->session["_user"]);
	}
	
	public function isLogged()
	{
		return $this->logged;
	}
	
	public function getRoles()
	{
		return $this->roles;
	}
	
	public function getDisplayName()
	{
		if (is_null($this->displayed_name) || empty($this->displayed_name))
			return $this->first_name . " " . $this->surname;
		else
			return $this->displayed_name;		
	}
	
	/**
	 * Imposta il riferimento al flusso di esecuzione
	 * */
	public function setFlow($fl)
	{
		$this->flow = $fl;
	}
	
	public function setSession(&$s)
	{
		$this->session=&$s;
	}
	
	/**
	 * Method that serialize user object without refering to flow and session
	 * */
	public function serialize() {
		$p = array();
		$op = get_object_vars($this);
		foreach ($op as $key=>$value)
		{
			if (!($key == "flow" || $key == "session"))
			{
				$p[$key]=$value;
			}
		}
		return serialize($p);
    }
	
    public function unserialize($data) {
		$data = unserialize($data);
		foreach ($data as $key => $value){
			$this->$key = $value; 
		}        
    }
}

/**
 * Represent a control object that manage an application state
 */
class Control {	
	public $status;
	public $user;
	/**
	 * This method make a Control status class.
	 * @param MainFlow $fl Contain a refer to the main execution flow
	 * @param State $st Contain a refer to the state that this control object manage
	 * @param array $r Contain a refer to the request array
	 * @param array $s Contain a refer to the session area specific for this status
	 * */
	public function __construct($fl,$st,$r,$s)
	{
		//@TODO: check if the object is an instance of the class State
		$this->status=$st;
		$this->user = $fl->user;
		$st->setControlObject($this); //double linked class :D		
	}
	
	/**
	 * Return the status that is managed by this object
	 * @return State  the state in question
	 * */
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
    /*public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
			
            return call_user_func_array($func, $args);
        }
    }*/		
}


/**
 * Represent a state of the application, contains generical information and
 * store control class instance
 */
class State implements Serializable {
    public $site_view="default";
    public $area=array("default");
    private $control=NULL;
	private $metainfo=NULL;
	private $skippable=true;
	private $want_delegate=true;
	
	public function __construct($site_view,$area)
    {
        $this->site_view=$site_view;
        $this->area= explode("/",$area);
    }
	
	public function setMetainfo($sc)
	{
		$this->metainfo=$sc;
	}
	
	public function getMetainfo()
	{
		return $this->metainfo;
	}
	
	/**
	 * This method check if the state is a root state, means that it doesn't have an
	 * ancestor state to wich delegate execution flow
	 * @return boolean Return true if is the root state, false otherwise
	 * */
	public function isRoot()
	{
		if (count($this->area) == 1)
			return true;
		else
			return false;
	}
	
	/**
     * Controlla se è possibile uscire incondizionatamente dallo stato in questione
     * @return boolean <strong>true</strong> se e' possibile uscirne/<strong>false</strong> altrimenti
     */
	public function isSkippable()
	{
		return $this->skippable;
	}
	public function setSkippable($boolean)
	{
		$this->skippable=$boolean;
	}
    
	/**
	 * Check if the state want to delegate the execution of action to its ancestor
	 * @return boolean  Return <strong>true</strong> if it permit delegation <strong>false</strong> otherwise
	 * */
    public function wantDelegate()
	{
		return $this->want_delegate;
	}
	
	public function setAncestorDelegation($boolean)
	{
		$this->want_delegate=$boolean;
	}
    
	
    public function setControlObject($c)
    {
	// @TODO: insert instance type control
		$this->control = $c;
    }
    
	public function getControlObject()
    {
		return $this->control;
    }
	
    public function getArea()
    {
        return implode("/",$this->area);
    }
    
    public function getAreaArray()
    {
        return $this->area;
    }
    
    public function getSiteView()
    {
        return $this->site_view;
    }
    
	public function getControlManagerClassName()
    {
        return  $this->getSiteView() . '\\' . str_replace("/","\\",$this->getArea()) . "\\Control";
    }
    public function getControlFilePath()
    {
        return CONTROL_PATH . $this->getSiteView() . "/" . $this->getArea()  . ".php";
    }
    public function toString()
    {
        return $this->__toString();
    }
    public function __toString()
    {
        return 	$this->getSiteView() . "/" . $this->getArea();
    }
	
		/**
	 * Method that serialize user object without refering to flow and session
	 * */
	public function serialize() {
		$p = array("site_view"=>$this->getSiteView(),"area"=>$this->getAreaArray());
		return serialize($p);
    }
	
    public function unserialize($data) {
		$data = unserialize($data);
		foreach ($data as $key => $value){
			$this->$key = $value; 
		}        
    }
}

class History {
	private $states_list=array();
	private $_s;
	public function __construct(&$_s)
	{		
		if (isset($_s["_history"]))
		{
			$this->_s = &$_s["_history"];		
			$this->states_list = unserialize($this->_s);
		}
		else
		{
			$_s["_history"]=serialize(array());
			$this->_s = &$_s["_history"];		
		}
	}
	
	public function addHistoryItem($item)
	{
		$this->states_list[]=$item;
		$this->_s=serialize($this->states_list);
	}
	
	public function addDelegatedItem($item)
	{
		$this->states_list[count($this->states_list) - 1]->delegation[]=$item;
	}
}

class HistoryItem
{
	/**
	 * @property State $state A status item
	 * */
    public $state;
	/**
	 * @property string $action A string representation of an action
	 * */
    public $action;
	
	/**
	 * @property array $delegation An array with the states delegated by current item
	 * */
    public $delegation=array();
	public function __construct($state,$action=NULL)
	{
		$this->state=$state;
		$this->action=$action;
	}
}


/**
 * This annotation set an application state as "skippable", this mean that is
 * possibile to jump to another state inconditionally, without this the current
 * state need to intercept the execution flow
 * @Annotation
*/
final class Skippable{
	public $value=true;
	public function __construct($values)
	{
		if (isset($values["value"]))
		{
			if ($values["value"] ===true || $values["value"] ===false)
			{
				$this->value=$values["value"];
			}
			else
			{	if (DEBUG)
						throw new Exception("Unknow annotation value");
				die();
			}
		}
		else
			$this->value=true;
	}
}

/**
 * This annotation class control if the execution of the status is allowed to
 * flow through a status hierarchical upper.
 * @Annotation
 * */
final class AncestorDelegation {
	public $value=true;
	public function __construct($values)
	{
		if (isset($values["value"]))
		{
			if ($values["value"] ===true || $values["value"] ===false)
			{
				$this->value=$values["value"];
			}
			else
			{	if (DEBUG)
						throw new Exception("Unknow annotation value");
				die();
			}
		}
		else
			$this->value=true;
	}
}

/**
 * This annotation allow to control the acces to a control object method,
 * each method represent a state's action so this annotation restrict the
 * access to some actions
 * @Annotation
 */
final class Access 
{
	public $roles=array("everyone"); //default access is for everyone
	public $redirect=false;
	public function __construct($values)
	{
		//Read the user role allowed to execute specific action
		if (isset($values["value"]))
		{
			$this->roles = explode(",",$values["value"]);
		}
		if (isset($values["roles"]))
		{
			$this->roles = explode(",",$values["roles"]);
		}
		
		if (isset($values["redirect"]))
		{
			$this->redirect = $values["redirect"];
		}	
	}
	public function redirectToLogin()
	{
		return $this->redirect;
	}
	
	public function __toString()
	{
		return "$this->roles";
	}
}



?>