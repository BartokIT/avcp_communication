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
            $prova = "controlprova";
            echo $prova;
            echo strlen($prova);
            oppps();
            
    }
    
    /**
     * Summary
     * @Access("private")	
     */
    function logout(){
            //logout user
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
