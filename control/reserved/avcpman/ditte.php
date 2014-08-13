<?php
namespace reserved\avcpman\ditte;
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
    function d(){
            $ditte =get_ditte();
            //default action
            return ReturnSmarty('ditte.tpl',array("ditte"=>$ditte));
    }
    
    function edit(){
        
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte/edit");
    }
    
    function new_ditta(){
        
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte/new_ditta");
    }
}
?>
