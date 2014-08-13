<?php
namespace reserved\home;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @return object  Description
     */
    function d(){
            //default action
            return ReturnSmarty('index.tpl');
    }
	
	function avcpman()
	{
		return ReturnArea($this->status->getSiteView(),"avcpman/gare");
	}   
}

?>
