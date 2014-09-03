<?php
namespace reserved\avcpman\pubblicazioni\add_pubblicazione;
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
            $message = "";
            if (!is_year_gare_present($anno))
            {
                $message= "Non sono presenti gare per l'anno specificato";
                return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni",NULL,array("error"=>$message));                
            }
            else if (is_year_publication_present($anno))
            {
                $message= "E' stata gia creata una pubblicazione per l'anno richiesto";
                return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni",NULL,array("error"=>$message));
            }
            else
                return ReturnSmarty('pubblicazione.edit.tpl',array("anno"=>$anno));
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
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
        return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
}
?>