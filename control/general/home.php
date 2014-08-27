<?php
namespace general\home;
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
            return ReturnSmarty('index.tpl');
    }

	
}
?>
