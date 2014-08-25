<?php
namespace reserved\avcpman\gare\edit;
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
            
            //default action
            return ReturnSmarty('gare.edit.tpl',array("gara"=>$gara,
                                                "contest_type"=>$contest_type));
        }
        else
                return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
    
    function submit()
    {
        if ($this->_r["submit"] == "save")
        {
                update_gara(
                    $this->_r["gid"],
                    $this->_r["gare_edit_cig"],
                     $this->_r["gare_edit_subject"],
                     $this->_r["gare_edit_contest_type"],
                     $this->_r["gare_edit_amount"],
                     $this->_r["gare_edit_payed_amount"],
                     $this->_r["gare_edit_job_start_date"],
                     $this->_r["gare_edit_job_end_date"],
                     $this->_r["gare_edit_year"]
                     );
            $this->_r["parameter"]=$this->_r["gid"];
            return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit_partecipanti");
        }
        else    
            return ReturnArea($this->status->getSiteView(),"avcpman/gare");
    }    
}
?>