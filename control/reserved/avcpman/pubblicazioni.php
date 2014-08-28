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
            return ReturnSmarty('pubblicazioni.tpl',array("pubblicazioni"=>$pubs));
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
            delete_pubblicazione($anno,$numero);
            return ReturnArea($this->status->getSiteView(),$this->status->getArea());
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
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno = $this->_r["anno"];
            $numero = $this->_r["numero"];
            $settings = get_settings(array("cf_ente","ente","licenza"));
            $pubblicazione = get_pubblicazione_detail($anno,$numero);
            $lotti = get_gare($anno,$numero);
            foreach ($lotti as $lotto)
            {
                $lotto->partecipanti = get_partecipanti($lotto->gid);
            }
            
            $pubblicazione->licenza = $settings["licenza"];
            $pubblicazione->ente_pubblicatore = $settings["ente"];
            $pubblicazione->cf_ente_pubblicatore = $settings["cf_ente"];
            
            header ("Content-Type:text/xml");
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="avcp_' .$anno . '_' . $numero . '"');
            echo write_avcp_xml_to_string($pubblicazione,$lotti);
            
        }
        else
        {
            return ReturnSmarty('pubblicazioni.tpl',array("pubblicazioni"=>$pubs));            
        }
    }
}
?>