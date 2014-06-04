<?php

/**
 * Represent a control object that manage an application state
 */
class Control {	
	public $status;
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
class State {
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
}

class History {
	
}

class HistoryItem
{
    public $state;
    public $action;
    public $skippable;
    public $automatic;
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
	public function __construct($values)
	{
		//Read the user role allowed to execute specific action
		if (isset($values["value"]))
		{
			$this->roles = explode(",",$values["value"]);
		}
		
			
	}
	public function __toString()
	{
		return "$this->roles";
	}
}



?>