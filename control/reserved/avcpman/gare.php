<?php
namespace reserved\avcpman\gare;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
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
    
    
    function edit()
    {
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit");
    }
    
    function new_gara()
    {
        
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/new_gara");
    }
    
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
