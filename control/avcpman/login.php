<?php
namespace avcpman\login;
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
            echo "<p>login\n</p>";
            return $this->user->login("claudio.papa","Inpdap02");            
    }    
}
?>
