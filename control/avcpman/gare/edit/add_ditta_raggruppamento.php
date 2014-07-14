<?php
namespace avcpman\gare\edit\add_ditta_raggruppamento;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
        global $ruoli_partecipanti_raggruppamento;
        if (isset($this->_r["parameter"]))
        {
            $pid  = (int) $this->_r["parameter"];
            $gara = get_gara_from_pid($pid);            
            //default action
        return ReturnSmarty('gare.add_ditta.tpl',array("ditta"=>(object)array(
                                                    "did"=>-1,
                                                    "ragione_sociale"=>"",
                                                    "estera"=>"N",
                                                    "identificativo_fiscale"=>""),
                                                   "estero"=>array("N"=>"Italia","Y"=>"Estero"),
                                                   "gara"=>$gara->gid,
                                                   "partecipante"=>$pid,
                                                   "ruolo"=>$ruoli_partecipanti_raggruppamento));
        }
        else
            return ReturnArea($this->status->getSiteView(),"gare");
        
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
            $pid = $this->_r["pid"];
            add_partecipante($gid,"R",$did,$this->_r["gare_edit_ruolo_type"],$pid);
        }
        return ReturnArea($this->status->getSiteView(),"gare");
    }
    
    function add()
    {
        //TODO : add check if is already added
        if ($this->_r["submit"] != "undo")
        {
            $gid = $this->_r["gid"];
            $did = $this->_r["gara_edit_search_did"];
            $pid = $this->_r["pid"];
            add_partecipante($gid,"R",$did,$this->_r["gare_edit_ruolo_type"],$pid);
        }
        return ReturnArea($this->status->getSiteView(),"gare");        
    }
}
?>