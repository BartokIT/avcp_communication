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
        return ReturnArea($this->status->getSiteView(),"gare");
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