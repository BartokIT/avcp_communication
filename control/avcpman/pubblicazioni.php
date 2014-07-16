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
            $pubs = get_pubblicazioni();
            $pubblicazioni=array();
            //TODO: manage index
            return ReturnSmarty('pubblicazioni.tpl',array("pubblicazioni"=>$pubs));
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
