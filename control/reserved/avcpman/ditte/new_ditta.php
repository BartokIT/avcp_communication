<?php
namespace reserved\avcpman\ditte\new_ditta;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
            return ReturnSmarty('ditte.edit.tpl',array("ditta"=>(object)array(
                                                        "did"=>-1,
                                                        "ragione_sociale"=>"",
                                                        "estera"=>"N",
                                                        "identificativo_fiscale"=>""),
                                                       "estero"=>array("N"=>"Italia","Y"=>"Estero")));

    }
    
    function submit(){
        if ($this->_r["submit"] == "save")
        {
                insert_ditta($this->_r["ditta_edit_identificativo"],
                     $this->_r["ditta_edit_ragione_sociale"],
                     $this->_r["ditta_edit_estero"]);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
    
}
?>