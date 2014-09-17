<?php
namespace reserved\avcpman\ditte;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
            $ditte =get_ditte();
            $parameters=array("ditte"=>$ditte);
            //default action
            if (isset($this->_r["error"]))
                $parameters["error"]=$this->_r["error"];
            return ReturnSmarty('ditte.tpl',$parameters);
    }
    
    function edit(){
        
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte/edit");
    }
    
    function new_ditta(){
        
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte/new_ditta");
    }
    
    function delete()
    {
        if (isset($this->_r["parameter"]))
        {
            $did = $this->_r["parameter"];
            $used=is_ditta_partecipante($did);
            
            $error=NULL;
            if ($used)
                $error=array("error"=>"La ditta partecipa ad una o pi&ugrave; gare, &egrave; necessario eliminare prima le sue partecipazioni");
            else
                delete_ditta($did);
            return ReturnArea($this->status->getSiteView(),$this->status->getArea(),NULL,$error);
        
        }
        else
                return ReturnArea($this->status->getSiteView(),$this->status->getArea()); 
    }
}
?>
