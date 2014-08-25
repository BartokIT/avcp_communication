<?php
namespace reserved\avcpman\gare\edit_partecipanti;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
       global $contest_type;
        if (isset($this->_r["parameter"]))
        {
            $gid  = (int) $this->_r["parameter"];
            $gara =get_gara($gid);
            $partecipanti = get_partecipanti($gid);
            //default action
            return ReturnSmarty('gare.edit_partecipanti.tpl',array("gara"=>$gara,
                                                "partecipanti"=>$partecipanti,
                                                "contest_type"=>$contest_type));
        }
        else
                return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }
    
    function save()
    {
        if ($this->_r["submit"] == "save")
        {
            $gid= $this->_r["gid"];
            $pid= $this->_r["aggiudicatario"];
            update_aggiudicatario($gid,$pid);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }
    
    function add_raggruppamento()
    {
        if (isset($this->_r["parameter"]))
        {
            $gid  = (int) $this->_r["parameter"];
            insert_raggruppamento($gid);
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti");
    }
    
    function add_ditta()
    {
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit/add_ditta");
    }    
}
?>