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
     * @Access(roles="reader",redirect=true  )
     * @return object  Description
     */
    function d(){
            //default action
            echo "action default test";
            return ReturnArea($this->getStatus()->getSiteView(),"pubblicazioni","delete");
            //return ReturnInline('<html><body><h1>Default Form</h1><p>'. $this->getStatus()->getArea() .'</p></body></html>','plain');
    }
    

    

}
?>
