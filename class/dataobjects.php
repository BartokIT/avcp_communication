<?php

/**
 * Represent a control object that manage an application state
 */
class Control {
	public $security;
	public $status;
	public function __construct($params)
	{
		$this->status=$params->status;
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
 * Represent a state of the application
 */
class State {
    public $site_view="default";
    public $area=array("default");
    public function __construct($site_view,$area)
    {
        $this->site_view=$site_view;
        $this->area=explode("/",$area);
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
        return CONTROL_PATH . $this->state->getSiteView() . '\\' . str_replace("/","\\",$this->state->getArea()) . "\\Control";
    }
    public function getControlFilePath()
    {
        return CONTROL_PATH . $this->state->getSiteView() . "/" . $this->state->getArea();
    }
    public function toString()
    {
        return $this->__toString();
    }
    public function __toString()
    {
        return 	$this->state->getSiteView() . "/" . $this->state->getArea();
    }
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
			if ($values["value"] ===true || $values["value"] ===true)
			{
				$this->value=$values["value"];
			}
			else
				if (DEBUG)
						throw new Exception("Unknow annotation value");
					die();
		}
		else
			$this->value=true;
	}
}

/**
 * @Annotation
 */
final class Access 
{
	public $roles=array();
	public $type=NULL;
	public function __construct($values)
	{
		if (isset($values["value"]))
		{
			if (strcmp($values["value"],"public") == 0 || strcmp($values["value"],"private") == 0)
				$this->type = $values["value"];
			else
			{
				if (DEBUG)
					throw new Exception("Unknow annotation value");
				die();
			}
		}
		else
			$this->type = "public";
			
		if (isset($values["roles"]))
		{
			$this->roles = explode(",",$values["roles"]);		
		}
	}
	public function __toString()
	{
		return "$this->role";
	}
}


?>