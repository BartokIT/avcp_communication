<?php
namespace avcpman\pubblicazioni;
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
            return ReturnSmarty('ditte.tpl');
    }
    
    /**
     * Summary

     */
    function logout(){
            //logout user
    }

      /**
     * @abstract
     */
    function delete(){
            //insert new pubblication
            echo "delete";
            return ReturnInline('<html><body><h1>Default Form</h1><p>'. $this->getStatus()->getArea() .'</p></body></html>','plain');
    }
}
?>
