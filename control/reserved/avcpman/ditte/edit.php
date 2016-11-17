<?php
//namespace reserved\avcpman\ditte\edit;
class Control extends \Control
{
    /**
     * @Access(roles="administrator,editor",redirect=true  )
     */
    function d(){
        if (isset($this->_r["parameter"]))
        {
            $did  = (int) $this->_r["parameter"];
            $ditta =get_ditta($did);
            
            //default action
            return ReturnSmarty('avcp/ditte.edit.tpl',array("ditta"=>$ditta,
                                                       "estero"=>array("N"=>"Italiana","Y"=>"Estera")));
        }
        else
                return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }

    /**
     * @Access(roles="administrator,editor",redirect=true  )
     */    
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