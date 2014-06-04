<?php
namespace avcpman\pubblicazioni\def;
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
            echo "called default";
            
    }
    

    
    /**
     * @abstract
     * @Access(roles="administrator")
     */
    function insert(){
            //insert new pubblication
            echo $this->status;
    }
}
?>
