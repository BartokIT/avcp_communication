<?php
//namespace reserved\avcpman\pubblicazioni\add_pubblicazione;
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher"  )
     */    
    function d(){
        if (isset($this->_r["pubblicazioni_anno"]))
        {
            $anno  = (int) $this->_r["pubblicazioni_anno"];
            $message = "";
	        $settings =get_settings(array("prefisso_url"));
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
            {
				
			    return ReturnSmarty('avcp/pubblicazione.edit.tpl',
                                    array(
                                        "anno"=>$anno,
                                        "titolo"=>"",
                                        "abstract"=>"",
                                        "numero"=>-1,
                                        "data_aggiornamento"=>date("d/m/Y"),
                                        "data_pubblicazione"=>date("d/m/Y"),
                                        "url"=>$settings["prefisso_url"] .$anno . ".xml"
                                    )
                                   );
			}
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
    
 
    /**
     * @Access(roles="administrator,publisher"  )
     */        
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
			{
				$true = set_gare_pubblicazione($anno,$pid);
				
				//Now we store the xml file in the database
				$settings = get_settings(array("cf_ente","ente","licenza"));
				$pubblicazione = get_pubblicazione_detail($anno,$pid);
				$lotti = get_gare($anno,$pid);
				foreach ($lotti as $lotto)
				{
					$lotto->partecipanti = get_partecipanti($lotto->gid);
				}
				
				$pubblicazione->licenza = $settings["licenza"];
				$pubblicazione->ente_pubblicatore = $settings["ente"];
				$pubblicazione->cf_ente_pubblicatore = $settings["cf_ente"];
				$content = write_avcp_xml_to_string($pubblicazione, $lotti);
				$name="avcp_" . $anno . "_" . $pid . ".xml";
                preg_match('@^(?:https?://)?(?:[^/]+/)+([^/]+)@i',$pubblicazione->url, $matches);
                if (count($matches) == 2)
                {
                    $name = $matches[1];
                }
                
				insert_file($content, "P", $anno, $pid, $name);
			}
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
}
?>
