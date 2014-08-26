<?php
namespace reserved\avcpman;
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
	
	function logout()
	{
		$result= $this->user->logout();
		return ReturnArea("general","home");			
	}
   
}

?>
