<?php
namespace reserved\avcpman\pubblicazioni\edit_pubblicazione;
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno  = (int) $this->_r["anno"];
			$numero =  (int) $this->_r["numero"];
			$p = (array)get_pubblicazione_detail($anno,$numero);
            return ReturnSmarty('pubblicazione.edit.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
    
 
    
    function save()
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
			if ($pid !== false)
				$true = set_gare_pubblicazione($anno,$pid);
            else	
				echo "problema";
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
}
?>