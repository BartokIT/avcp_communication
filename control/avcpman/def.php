<?php
namespace avcpman\def;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,publisher,reader,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
            //default action
            return ReturnSmarty('index.tpl');
    }
    /**
     * Summary
     */
    function logout(){
        $this->user->logout();
    }


    function login(){
            return $this->user->login("claudio.papa","Inpdap02");
    }    
}
?>
