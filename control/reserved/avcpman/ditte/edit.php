<?php
namespace reserved\avcpman\ditte\edit;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
        if (isset($this->_r["parameter"]))
        {
            $did  = (int) $this->_r["parameter"];
            $ditta =get_ditta($did);
            
            //default action
            return ReturnSmarty('ditte.edit.tpl',array("ditta"=>$ditta,
                                                       "estero"=>array("N"=>"Italia","Y"=>"Estero")));
        }
        else
                return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
    
    function submit()
    {
        
        if ($this->_r["submit"] == "save")
        {
                update_ditta($this->_r["did"],
                     $this->_r["ditta_edit_identificativo"],
                     $this->_r["ditta_edit_ragione_sociale"],
                     $this->_r["ditta_edit_estero"]);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
}
?>