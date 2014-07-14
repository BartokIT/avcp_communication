<?php
namespace avcpman\gare\edit;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
        $contest_type=array(
                1=>"Procedura aperta",
                2=>"Procedura ristretta",
                3=>"Procedura negoziata previa pubblicazione del bando",
                4=>"Procedura negoziata senza previa pubblicazione del bando",
                5=>"Dialogo competitivo",
                6=>"Procedura negoziata senza previa indizione di gara art. 221 D.Lgs. 163/2006",
                7=>"Sistema dinamico di acquisizione",
                8=>"Affidamento in economia - cottimo fiduciario",
                17=>"Affidamento diretto ex art. 5 della Legge n. 381/91",
                21=>"Procedura ristretta derivante da avvisi con cui si indice la gara",
                22=>"Procedura negoziata derivante da avvisi con cui si indice la gara",
                23=>"Affidamento in economia - Affidamento diretto",
                24=>"Affidamento diretto a societ&agrave; in house",
                25=>"Affidamento diretto a societ&agrave; raggruppate/consorziate o controllate nelle concessioni di LL.PP.",
                26=>"Affidamento diretto in adesione ad accordo quadro/convenzione",
                27=>"Confronto competitivo in adesione ad accordo quadro/convenzione",
                28=>"Procedura ai sensi dei regolamenti degli organi costituzionali");
        if (isset($this->_r["parameter"]))
        {
            $gid  = (int) $this->_r["parameter"];
            $gara =get_gara($gid);
            
            //default action
            return ReturnSmarty('gare.edit.tpl',array("gara"=>$gara,
                                                "contest_type"=>$contest_type));
        }
        else
                return ReturnArea($this->status->getSiteView(),"ditte");
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
            return ReturnArea($this->status->getSiteView(),"gare/edit_partecipanti");
        }
        else    
            return ReturnArea($this->status->getSiteView(),"gare");
    }    
}
?>