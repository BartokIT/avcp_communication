<?php
namespace avcpman\pubblicazioni\def;
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
            echo "called default";
            
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
