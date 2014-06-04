<?php
namespace avcpman\pubblicazioni\login;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
* @AncestorDelegation(true)
*/
class Control extends \Control
{
    /**
     * Summary
     * @return object  Description
     */
    function d(){
            //default action
            return ReturnPage("test.html");
            
    }
    
}
?>
