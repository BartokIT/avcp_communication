<?php
namespace reserved\avcpman\gare\new_gara;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
        function d(){
                global $contest_type;
                return ReturnSmarty('gare.edit.tpl',array("gara"=>(object)array(
                                                        "gid"=>-1,
                                                        "cig"=>"",
                                                        "oggetto"=>"",
                                                        "f_pub_anno"=>"",
                                                        "scelta_contraente"=>1,
                                                        "importo"=>0,
                                                        "importo_liquidato"=>0,
                                                        "data_inizio"=>"",
                                                        "data_fine"=>""),
                                                        "contest_type"=>$contest_type));
        }

        function submit(){
                if ($this->_r["submit"] == "save")
                {
                        insert_gara($this->_r["gare_edit_cig"],
                             $this->_r["gare_edit_subject"],
                             $this->_r["gare_edit_contest_type"],
                             $this->_r["gare_edit_amount"],
                             $this->_r["gare_edit_payed_amount"],
                             $this->_r["gare_edit_job_start_date"],
                             $this->_r["gare_edit_job_end_date"],
                             $this->_r["gare_edit_year"]
                             );
                }
                return ReturnArea($this->status->getSiteView(),"avcpman/gare");
        }
    
    
}
?>