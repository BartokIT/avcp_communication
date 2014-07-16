<?php
namespace avcpman\pubblicazioni\add_pubblicazione;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
        if (isset($this->_r["pubblicazioni_anno"]))
        {
            $anno  = (int) $this->_r["pubblicazioni_anno"];
                        
            //default action
            return ReturnSmarty('pubblicazione.edit.tpl',array("anno"=>$anno));
        }
        else
            return ReturnArea($this->status->getSiteView(),"pubblicazioni");
    }
    
 
    
    function add()
    {
        //TODO : add check if is already added
        if ($this->_r["submit"] != "undo")
        {
            $titolo = $this->_r["pubblicazione_edit_titolo"];
            $abstract = $this->_r["pubblicazione_edit_abstract"];
            $data_pubblicazione = $this->_r["pubblicazione_edit_pubblicazione"];
            $data_aggiornamento = $this->_r["pubblicazione_edit_aggiornamento"];
            $url = $this->_r["pubblicazione_edit_url"];
            $anno = $this->_r["pubblicazione_edit_anno"];
            $pid = insert_pubblicazione($titolo,$abstract,$data_pubblicazione,$data_aggiornamento,$url,$anno);
            $true = set_gare_pubblicazione($anno,$pid);
            
        }
        return ReturnArea($this->status->getSiteView(),"pubblicazioni");
    }
}
?>