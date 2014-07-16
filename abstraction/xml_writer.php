<?php

	function indent($level)
	{
		$out = "";
		for ($i=0; $i < $level ; $i++)
		{
			$out .= "\t";
		}
		return $out;
	}
	/**
	* Scrive in una stringa la porzione di xml relativa ai metadati
	**/
	function write_avcp_metadata_tostring($meta)
	{
		$outstring  = indent(1) . "<metadata>\n";
		$outstring .= indent(2) . "<titolo>" . $meta->titolo . "</titolo>\n";
		$outstring .= indent(2) . "<abstract>" . $meta->abstract . "</abstract>\n";
		$outstring .= indent(2) . "<dataPubblicazioneDataset>" . $meta->data_pubblicazione . "</dataPubblicazioneDataset>\n";
		$outstring .= indent(2) . "<entePubblicatore>" . $meta->ente_pubblicatore . "</entePubblicatore>\n";
		$outstring .= indent(2) . "<dataUltimoAggiornamentoDataset>" . $meta->data_aggiornamento . "</dataUltimoAggiornamentoDataset>\n";
		$outstring .= indent(2) ."<annoRiferimento>" . $meta->anno . "</annoRiferimento>\n";
		$outstring .= indent(2) ."<urlFile>" . $meta->url . "</urlFile>\n";
		$outstring .= indent(2) ."<licenza>" . $meta->licenza . "</licenza>\n";
		$outstring .= indent(1) . "</metadata>\n";
		return $outstring;
	}
	
	/**
	* Scrive in una stringa la parte iniziale delle informazioni ssu di un singolo lotto
	*/
	function write_avcp_lotto_pre_tostring($lotto_info)
	{
		$outstring = indent(2) ."<lotto>\n";
		$outstring .= indent(3) ."<cig>" . $lotto_info["cig"] . "</cig>\n";
		$outstring .= indent(3) ."<strutturaProponente>\n";
		$outstring .= indent(4) ."<codiceFiscaleProp>" . $lotto_info["codice_fiscale_proponente"] . "</codiceFiscaleProp>\n";
		$outstring .= indent(4) ."<denominazione>" . $lotto_info["denominazione_proponente"] . "</denominazione>\n";		
		$outstring .= indent(3) ."</strutturaProponente>\n";		
		$outstring .= indent(3) ."<oggetto>" . $lotto_info["oggetto"] . "</oggetto>\n";
		$outstring .= indent(3) ."<sceltaContraente>" . $lotto_info["scelta_contraente"] . "</sceltaContraente>\n";
		
		return $outstring;
	}
	/**
	* Scrive in una stringa la parte finale delle informazioni su di un singolo lotto
	*/	
	function write_avcp_lotto_post_tostring($lotto_info)
	{

		$outstring  =indent(3) . "<importoAggiudicazione>" . $lotto_info["importo_aggiudicazione"] . "</importoAggiudicazione>\n";
		$outstring .=indent(3) ."<tempiCompletamento>\n";
		$outstring .=indent(4) ."<dataInizio>" . $lotto_info["data_inizio"] . "</dataInizio>\n";
		$outstring .=indent(4) ."<dataUltimazione>" . $lotto_info["data_fine"] . "</dataUltimazione>\n";		
		$outstring .=indent(3) ."</tempiCompletamento>\n";		
		$outstring .=indent(3) ."<importoSommeLiquidate>" . $lotto_info["importo_liquidato"] . "</importoSommeLiquidate>\n";
		$outstring .=indent(2) . "</lotto>\n";		
		return $outstring;
	}	
	
	function write_avcp_partecipante_tostring($partecipante_info)
	{
		$outstring="";
		
		if (strcmp($partecipante_info["tipo"],"ditta") == 0)
		{
			$outstring .= indent(4) ."<partecipante>\n";
			if (strcmp($partecipante_info["nazione"],"I") == 0)
				$outstring .= indent(5) . "<codiceFiscale>" . $partecipante_info["identificativo"] . "</codiceFiscale>\n";
			else
				$outstring .= indent(5) . "<identificativoFiscaleEstero>" . $partecipante_info["identificativo"] . "</identificativoFiscaleEstero>\n";
			$outstring .=indent(5) . "<ragioneSociale>" . $partecipante_info["ragione_sociale"] . "</ragioneSociale>\n";
			$outstring .= indent(4) . "</partecipante>\n";
		}
		else
		{
			$outstring .= indent(4) . "<raggruppamento>\n";			
			foreach ($partecipante_info["membri"] as $membro )
			{
				$outstring .= indent(5) . "<membro>\n";
				if (strcmp($membro["nazione"],"I") == 0)
					$outstring .= indent(6) ."<codiceFiscale>" . $membro["identificativo"] . "</codiceFiscale>\n";
				else
					$outstring .= indent(6) ."<identificativoFiscaleEstero>" . $membro["identificativo"] . "</identificativoFiscaleEstero>\n";
				$outstring .= indent(6) ."<ragioneSociale>" . $membro["ragione_sociale"] . "</ragioneSociale>\n";
				$outstring .= indent(6) ."<ruolo>" . $membro["ruolo"] . "</ruolo>\n";
				$outstring .= indent(5) . "</membro>\n";				
			}
			$outstring .= indent(4) . "</raggruppamento>\n";			
		}
		return $outstring;
	}
	
	function write_avcp_aggiudicatario_tostring($aggiudicatario_info)
	{
		$outstring="";
		
		if (strcmp($aggiudicatario_info["tipo"],"ditta") == 0)
		{
			$outstring .= indent(4) ."<aggiudicatario>\n";
			if (strcmp($aggiudicatario_info["nazione"],"I") == 0)
				$outstring .= indent(5) . "<codiceFiscale>" . $aggiudicatario_info["identificativo"] . "</codiceFiscale>\n";
			else
				$outstring .= indent(5) . "<identificativoFiscaleEstero>" . $aggiudicatario_info["identificativo"] . "</identificativoFiscaleEstero>\n";
			$outstring .=indent(5) . "<ragioneSociale>" . $aggiudicatario_info["ragione_sociale"] . "</ragioneSociale>\n";
			$outstring .= indent(4) . "</aggiudicatario>\n";
		}
		else
		{
			$outstring .= indent(4) . "<aggiudicatarioRaggruppamento>\n";			
			foreach ($aggiudicatario_info["membri"] as $membro )
			{
				$outstring .= indent(5) . "<membro>\n";
				if (strcmp($membro["nazione"],"I") == 0)
					$outstring .= indent(6) ."<codiceFiscale>" . $membro["identificativo"] . "</codiceFiscale>\n";
				else
					$outstring .= indent(6) ."<identificativoFiscaleEstero>" . $membro["identificativo"] . "</identificativoFiscaleEstero>\n";
				$outstring .= indent(6) ."<ragioneSociale>" . $membro["ragione_sociale"] . "</ragioneSociale>\n";
				$outstring .= indent(6) ."<ruolo>" . $membro["ruolo"] . "</ruolo>\n";
				$outstring .= indent(5) . "</membro>\n";				
			}
			$outstring .= indent(4) . "</aggiudicatarioRaggruppamento>\n";			
		}	
		return $outstring;
	}
	
	function write_avcp_xml_to_string($meta,$lotti_info)	
	{
		$outstring ='<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
		$outstring .= '<legge190:pubblicazione xsi:schemaLocation="legge190_1_0 datasetAppaltiL190.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:legge190="legge190_1_0">' . "\n";
		$outstring .= write_avcp_metadata_tostring($meta);
		$outstring .= indent(1) . "<data>\n";
		foreach ($lotti_info as $lotto_info)
		{
			$outstring .= write_avcp_lotto_pre_tostring($lotto_info);
			$outstring .= indent(3) . "<partecipanti>\n";
			foreach ($lotto_info["partecipanti"] as $partecipante)
				$outstring .= write_avcp_partecipante_tostring( $partecipante);
			$outstring .= indent(3) . "</partecipanti>\n";
			
			$outstring .= indent(3) . "<aggiudicatari>\n";
			foreach ($lotto_info["aggiudicatari"] as $partecipante)
				$outstring .= write_avcp_aggiudicatario_tostring( $partecipante);			
			$outstring .= indent(3) . "</aggiudicatari>\n";			
			$outstring .= write_avcp_lotto_post_tostring($lotto_info);
		}
		$outstring .= indent(1) . "</data>\n";
		$outstring .= '</legge190:pubblicazione>';
		return $outstring;
	}
	
	 // Test routine
	
	header ("Content-Type:text/xml");
	echo write_avcp_xml_to_string(array("titolo"=>"Pubblicazione n. 1", 
										"abstract"=>"Pubblicazione n. 1 abstract",
										"data_pubblicazione"=>"2013-05-25",
										"data_ultimo_aggiornamento"=>"2014-01-10",
										"ente_pubblicatore"=>"Comune di Terracina",
										"anno"=>"2013",
										"url"=>"http://www.comune.terracina.lt.it",
										"licenza"=>"IODL"),array(array("cig"=>"1234568790",
																	   "oggetto"=>"Acquisto tovaglionini",
																	   "scelta_contraente"=>"14 - BOOO",
																	   "codice_fiscale_proponente"=>"123123123",
																	   "denominazione_proponente"=>"Comune di Terracina",
																	   "importo_aggiudicazione"=>"123.54",
																	   "importo_liquidato"=>"23.54",
																	   "data_inizio"=>"2013/05/05",
																	   "data_fine"=>"2013/08/05",
																	   "partecipanti"=>array(	
																			array("tipo"=>"ditta","nazione"=>"E","identificativo"=>"465465","ragione_sociale"=>"smartmedia"),
																			array("tipo"=>"raggruppamento",
																				  "membri"=>array(array("nazione"=>"I","identificativo"=>"1111","ragione_sociale"=>"ditta 1","ruolo"=>"capogruppo"),
																								array("nazione"=>"E","identificativo"=>"222","ragione_sociale"=>"ditta 2","ruolo"=>"associata")))
																		),
																	    "aggiudicatari"=>array(	
																			array("tipo"=>"ditta","nazione"=>"E","identificativo"=>"465465","ragione_sociale"=>"smartmedia"),
																			array("tipo"=>"raggruppamento",
																				  "membri"=>array(array("nazione"=>"I","identificativo"=>"1111","ragione_sociale"=>"ditta 1","ruolo"=>"capogruppo"),
																								array("nazione"=>"E","identificativo"=>"222","ragione_sociale"=>"ditta 2","ruolo"=>"associata")))
																		)
																	   )));
	
?>
