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
            //$this->user->logout();
            $this->user->login("claudio.papa","Inpdap02");
            //return ReturnInline(array("prova","pipp"),'json');
            return ReturnInline('<html><body><h1>Inline Tests</h1><p>'. $this->user->getDisplayName() .'</p></body></html>','plain');
            
    }
    
}
?>
