<?php
namespace reserved\avcpman\pubblicazioni;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @return object  Description
     */
    function d()
    {
            //default action
            $pubs = get_pubblicazioni();
            $pubblicazioni=array();
            //TODO: manage index
            $parameters = array("pubblicazioni"=>$pubs);
            if (isset($this->_r["error"]))
            {
                $parameters["error"]=$this->_r["error"];
            }
            return ReturnSmarty('pubblicazioni.tpl',$parameters);
    }

    
      /**
     * @abstract
     */
    function delete()
    {
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            update_gare($anno,$numero,null,null,null,null,null,null,null,null,"NULL");
            delete_pubblicazione($anno,$numero);
            
        }
		return ReturnArea($this->status->getSiteView(),$this->status->getArea());
    }
	
    
	function edit()
	{
		if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            return ReturnArea($this->status->getSiteView(),$this->status->getArea()  . "/edit_pubblicazione");
        }
	}
	
    function verify_anno()
    {
        if (isset($this->_r["anno"]))
        {
            $anno = $this->_r["anno"];
            if (!is_year_gare_present($anno))
            {
                return ReturnInline(array("trouble"=>true,"message"=>"Non sono presenti gare per l'anno specificato"),"json");
            }
            else if (is_year_publication_present($anno))
            {
                return ReturnInline(array("trouble"=>true,"message"=>"E' stata gia creata una pubblicazione per l'anno richiesto"),"json");
            }
            else
                return ReturnInline(array("trouble"=>false),"json");
        }        
    }
    
    function download_file()
    {
        global $xml_writer;
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            /*$settings = get_settings(array("cf_ente","ente","licenza"));
            $pubblicazione = get_pubblicazione_detail($anno,$numero);
            $lotti = get_gare($anno,$numero);
            foreach ($lotti as $lotto)
            {
                $lotto->partecipanti = get_partecipanti($lotto->gid);
            }
            
            $pubblicazione->licenza = $settings["licenza"];
            $pubblicazione->ente_pubblicatore = $settings["ente"];
            $pubblicazione->cf_ente_pubblicatore = $settings["cf_ente"];
            */
            return new \ReturnedFile('get_file',array($anno, $numero),
                                     'avcp_' .$anno . '_' . $numero,"text/xml");
            //echo write_avcp_xml_to_string($pubblicazione,$lotti);
            
			
        }
        else
        {
            return ReturnSmarty('pubblicazioni.tpl',array("pubblicazioni"=>$pubs));            
        }
    }
}
?>