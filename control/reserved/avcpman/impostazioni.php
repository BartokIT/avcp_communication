<?php
namespace reserved\avcpman\impostazioni;
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
    function d()
    {

        $settings =get_settings(array("ente","licenza","cf_ente"));
        //default action
        return ReturnSmarty('settings.tpl',array("settings"=>$settings));
    }
    
    function save()
    {
        if ( isset($this->_r["ente_name_edit"]) &&
             isset($this->_r["ente_cf_edit"]) &&
             isset($this->_r["licenza_edit"]))
        {            
            $p = array ("ente"=>$this->_r["ente_name_edit"],
                        "cf_ente"=>$this->_r["ente_cf_edit"],
                        "licenza"=>$this->_r["licenza_edit"]);
            if ( set_settings($p) === false)
                return ReturnArea($this->status->getSiteView(),$this->status->getArea()); 
        }
        return ReturnArea($this->status->getSiteView(),"avcpman\gare"); 
    }
}
?>
