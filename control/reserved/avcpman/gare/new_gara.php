<?php
namespace reserved\avcpman\gare\new_gara;

class Control extends \Control
{
    /**
    * Summary
    * @Access(roles="administrator,editor",redirect=true  )
    */
    public function d()
    {
        global $contest_type;
        return ReturnSmarty(
            'gare.edit.tpl',
            array("gara"=>(object) array(
                "gid"=>-1,
                "cig"=>"",
                "oggetto"=>"",
                "f_pub_anno"=>$_SESSION["year"],
                "scelta_contraente"=>1,
                "importo"=>0,
                "importo_liquidato"=>0,
                "data_inizio"=>"",
                "data_fine"=>""),
                  "contest_type"=>$contest_type)
        );
    }

    /**
    * Summary
    * @Access(roles="administrator,editor",redirect=true)
    */
    public function submit()
    {
        if ($this->_r["submit"] == "save") {
            $dummy="N";
            if (isset($this->_r["dummy"])) {
                $dummy="Y";
            }
            if ((is_dummy_gara_present($this->user->getID()) == null
                 && isset($this->_r["dummy"])) ||
                !(isset($this->_r["dummy"])) ) {
                insert_gara(
                    $this->_r["gare_edit_cig"],
                    $this->_r["gare_edit_subject"],
                    $this->_r["gare_edit_contest_type"],
                    $this->_r["gare_edit_amount"],
                    $this->_r["gare_edit_payed_amount"],
                    $this->_r["gare_edit_job_start_date"],
                    $this->_r["gare_edit_job_end_date"],
                    $this->user->getID(),
                    $this->_r["gare_edit_year"],
                    null,
                    $dummy
                );
            }
        }
        return ReturnArea($this->status->getSiteView(), "avcpman/gare");
    }
}
?>
