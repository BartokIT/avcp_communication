<?php
namespace reserved\avcpman\gare;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher,editor,viewer",redirect=true)
     */
    function d()
    {
        if (!isset($this->_s["year"]))
        {
            $this->_s["year"]=date("Y");
        }
        $gare =get_gare($this->_s["year"],NULL,$this->user->getID());
        //default action
        return ReturnSmarty('gare.tpl',array("year"=>$this->_s["year"],
                                             "gare"=>$gare));
    }
    
 
	function view()
    {
		global $contest_type;
		global $ruoli_partecipanti_raggruppamento;
        if (isset($this->_r["parameter"]) || isset($this->_s["gid"]) )
        {
            $gid  = (int) isset($this->_r["parameter"])?$this->_r["parameter"]:$this->_s["gid"];
            $this->_s["gid"]=$gid;
            $gara =get_gara($gid);
            $partecipanti = get_partecipanti($gid);
            //default action
			$p = array("gara"=>$gara,
						"partecipanti"=>$partecipanti,
						"contest_type"=>$contest_type,
						"ruoli_raggruppamento"=>$ruoli_partecipanti_raggruppamento);
			if (isset($this->_r["error"]))
				$p["error"] = $this->_r["error"];
            return ReturnSmarty('gare.view.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
	
    /**
     * @Access(roles="administrator,editor")
     */	
    function edit()
    {
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit");
    }
    
	 /**
     * @Access(roles="administrator,editor,viewer")
     */
    function new_gara()
    {
        
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/new_gara");
    }

	 /**
     * @Access(roles="administrator,editor,viewer")
     */    
    function delete()
    {
        if (isset($this->_r["parameter"]))
        {
            $gid = $this->_r["parameter"];
            delete_gara($gid);
        }
        return ReturnArea($this->status->getSiteView(),$this->status->getArea()); 
    }
}
?>
