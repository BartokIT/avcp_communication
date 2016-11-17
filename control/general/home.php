<?php
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends Control
{
    /**
     * Summary
     * @return object  Description
     */
    function d(){
			if ($this->user->isLogged())
		{
			return ReturnArea("reserved","home");
		}
		else
		{
		   return ReturnSmarty('index.tpl');
        }
         
    }

	
}
?>
