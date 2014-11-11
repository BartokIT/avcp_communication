<?php
namespace reserved\avcpman\ditte\new_ditta;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editor",redirect=true  )
     * @return object  Description
     */
    function d(){
            return ReturnSmarty('ditte.edit.tpl',array("ditta"=>(object)array(
                                                        "did"=>-1,
                                                        "ragione_sociale"=>"",
                                                        "estera"=>"N",
                                                        "identificativo_fiscale"=>""),
                                                       "estero"=>array("N"=>"Italiana","Y"=>"Estera")));

    }
	
    /**
     * @Access(roles="administrator,editor" )
     */    
    function is_ditta_presente()
    {
        $d = get_ditta_by_cf($this->_r["identificativo_fiscale"]);
        if ($d === false)
                return  ReturnInline(array("present"=>false),"json");
        else
                return  ReturnInline(array("present"=>true),"json");
    }

    /**
     * @Access(roles="administrator,editor")
     */    
    function submit(){
        if ($this->_r["submit"] == "save")
        {
                $d = get_ditta_by_cf($this->_r["ditta_edit_identificativo"]);
                if ($d !== false)
                {
                        return ReturnSmarty('ditte.edit.tpl',array("ditta"=>(object)array(
                                                        "did"=>-1,
                                                        "ragione_sociale"=>$this->_r["ditta_edit_ragione_sociale"],
                                                        "estera"=>$this->_r["ditta_edit_estero"],
                                                        "identificativo_fiscale"=>$this->_r["ditta_edit_identificativo"]),
                                                       "estero"=>array("N"=>"Italiana","Y"=>"Estera"),
                                                       "error"=>"La ditta &egrave; gi&agrave; presente in rubrica"));
                }
                else
                {
                     insert_ditta($this->_r["ditta_edit_identificativo"],
                     $this->_r["ditta_edit_ragione_sociale"],
                     $this->_r["ditta_edit_estero"]);
                }
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
    
}
?>