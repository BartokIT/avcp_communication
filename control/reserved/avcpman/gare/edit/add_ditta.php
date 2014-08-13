<?php
namespace reserved\avcpman\gare\edit\add_ditta;
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
            $gid  = (int) $this->_r["parameter"];
            $gara = get_gara($gid);            
            //default action
        return ReturnSmarty('gare.add_ditta.tpl',array("ditta"=>(object)array(
                                                    "did"=>-1,
                                                    "ragione_sociale"=>"",
                                                    "estera"=>"N",
                                                    "identificativo_fiscale"=>""),
                                                   "estero"=>array("N"=>"Italia","Y"=>"Estero"),
                                                   "gara"=>$gid));
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/gare");
        
    }
    
    function search_ditta() {
        $ditte=array();
        if (isset($this->_r["ragione_sociale"]))
        {
            $ditte= search_ditte("",$this->_r["ragione_sociale"]);
        }
        
        if (isset($this->_r["identificativo_fiscale"]))
        {
            $ditte= search_ditte($this->_r["identificativo_fiscale"],"");
        }
        
        $ditte_string = array();
        foreach ($ditte as $ditta)
        {
            $ditte_string[]= $ditta->ragione_sociale;
        }
        return ReturnInline($ditte,"json");
    }
    
    function insert_and_add()
    {
        if ($this->_r["submit"] != "undo")
        {           
            $did= insert_ditta($this->_r["ditta_edit_identificativo"],
                         $this->_r["ditta_edit_ragione_sociale"],
                         $this->_r["ditta_edit_estero"]);
            
            $gid = $this->_r["gid"];
            add_partecipante($gid,"D",$did);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }
    
    function add()
    {
        //TODO : add check if is already added
        if ($this->_r["submit"] != "undo")
        {
            $gid = $this->_r["gid"];
            $did = $this->_r["gara_edit_search_did"];
            add_partecipante($gid,"D",$did);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare");        
    }
}
?>