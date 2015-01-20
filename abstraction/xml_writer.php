<?php

function indent($level)
{
    $out = "";
    for ($i=0; $i < $level; $i++) {
        $out .= "\t";
    }
    return $out;
}

/**
* Scrive in una stringa la porzione di xml relativa ai metadati
**/
function write_avcp_metadata_tostring($meta, $xml_e)
{
    $tmp_dobj=DateTime::createFromFormat('d/m/Y', $meta->data_aggiornamento);
    $tmp_dobjP=DateTime::createFromFormat('d/m/Y', $meta->data_pubblicazione);
    $xml_e= $xml_e->appendChild(new DomElement("metadata"));
    $xml_e->appendChild(new DomElement("titolo"))->appendChild(new DOMText( $meta->titolo));
    $xml_e->appendChild(new DomElement("abstract"))->appendChild(new DOMText($meta->abstract));
    $xml_e->appendChild(new DomElement("dataPubbicazioneDataset", $tmp_dobjP->format("Y-m-d")));
    $xml_e->appendChild(new DomElement("entePubblicatore", $meta->ente_pubblicatore));
    $xml_e->appendChild(new DomElement("dataUltimoAggiornamentoDataset", $tmp_dobj->format("Y-m-d")));
    $xml_e->appendChild(new DomElement("annoRiferimento"))->appendChild(new DOMText($meta->anno));
    $xml_e->appendChild(new DomElement("urlFile"))->appendChild(new DOMText($meta->url));
    $xml_e->appendChild(new DomElement("licenza", $meta->licenza));
    return $outstring;
}

/**
* Scrive in una stringa la parte iniziale delle informazioni ssu di un singolo lotto
*/
function write_avcp_lotto_pre_tostring($meta, $lotto_info, $xml_e)
{
    global $contest_type;

    $outstring = indent(2) ."<lotto>\n";
    $xml_e->appendChild(new DomElement("cig", $lotto_info->cig));
    $xml_e_proponente = $xml_e->appendChild(new DomElement("strutturaProponente"));
    $xml_e_proponente->appendChild(new DomElement("codiceFiscaleProp"))->appendChild(new DOMText($meta->cf_ente_pubblicatore));
    $xml_e_proponente->appendChild(new DomElement("denominazione"))->appendChild(new DOMText($meta->ente_pubblicatore));
    $xml_e->appendChild(new DomElement("oggetto"))->appendChild(new DOMText($lotto_info->oggetto));
    $xml_e->appendChild(new DomElement("sceltaContraente", str_pad($lotto_info->scelta_contraente, 2, "0", STR_PAD_LEFT) . "-" . strtoupper($contest_type[$lotto_info->scelta_contraente])));

    return $outstring;
}

/**
* Scrive in una stringa la parte finale delle informazioni su di un singolo lotto
*/
function write_avcp_lotto_post_tostring($lotto_info, $xml_e)
{
    $outstring  =indent(3) . "<importoAggiudicazione>" . $lotto_info->importo . "</importoAggiudicazione>\n";
    $xml_e->appendChild(new DomElement("importoAggiudicazione"))->appendChild(new DOMText($lotto_info->importo));
    $outstring .=indent(3) ."<tempiCompletamento>\n";
    $xml_e_tempi = new DomElement("tempiCompletamento");
    $xml_e->appendChild($xml_e_tempi);
    if (!(is_null($lotto_info->data_inizio)  || trim($lotto_info->data_inizio) == '')) {
        $tmp_inizio=DateTime::createFromFormat('d/m/Y', $lotto_info->data_inizio);
        $outstring .=indent(4) ."<dataInizio>" .  $tmp_inizio->format("Y-m-d") . "</dataInizio>\n";
        $xml_e_tempi->appendChild(new DomElement("dataInizio"))->appendChild(new DOMText($tmp_inizio->format("Y-m-d")));
    }
    if (!(is_null($lotto_info->data_fine)  || trim($lotto_info->data_fine) == '')) {
        $tmp_completamento=DateTime::createFromFormat('d/m/Y', $lotto_info->data_fine);
        $outstring .=indent(4) . "<dataUltimazione>" . $tmp_completamento->format("Y-m-d") . "</dataUltimazione>\n";
        $xml_e_tempi->appendChild(new DomElement("dataUltimazione"))->appendChild(new DOMText($tmp_completamento->format("Y-m-d")));//->appendChild(new DOMText(tmp_completamento->format("Y-m-d")));
    }
    $outstring .=indent(3) ."</tempiCompletamento>\n";
    $outstring .=indent(3) ."<importoSommeLiquidate>" . $lotto_info->importo_liquidato . "</importoSommeLiquidate>\n";
    $xml_e->appendChild(new DomElement("importoSommeLiquidate"))->appendChild(new DOMText($lotto_info->importo_liquidato));
    $outstring .=indent(2) . "</lotto>\n";
    return $outstring;
}

function write_avcp_partecipante_tostring_ditta($partecipante_info, $xml_e, $aggiudicatario = false)
{
    $outstring="";
    $xml_e_partecipante = null;
    
    if ($aggiudicatario) {
        $xml_e_partecipante = $xml_e->appendChild(new DomElement("aggiudicatario"));
    } else {
        $xml_e_partecipante = $xml_e->appendChild(new DomElement("partecipante"));
    }
    
    if (strcmp($partecipante_info->estera, "N") == 0) {
            $xml_e_partecipante->appendChild(new DomElement("codiceFiscale", $partecipante_info->identificativo_fiscale));
    } else {
        $xml_e_partecipante->appendChild(new DomElement("identificativoFiscaleEstero", $partecipante_info->identificativo_fiscale));
    }
    $xml_e_partecipante->appendChild(new DomElement("ragioneSociale"))->appendChild(new DOMText($partecipante_info->ragione_sociale));

    return $outstring;
}

function write_avcp_partecipante_tostring_raggruppamento($partecipante_info, $xml_e, $aggiudicatario = false)
{
    global $ruoli_partecipanti_raggruppamento;

    $xml_e_partecipante = null;
    if ($aggiudicatario) {
        $xml_e_partecipante = $xml_e->appendChild(new DomElement("aggiudicatarioRaggruppamento"));
    } else {
        $xml_e_partecipante = $xml_e->appendChild(new DomElement("raggruppamento"));
    }

    foreach ($partecipante_info as $membro) {
        $xml_e_membro = $xml_e_partecipante->appendChild(new DomElement("membro"));
        if (strcmp($membro->estera, "N") == 0) {
            $xml_e_membro->appendChild(new DomElement("codiceFiscale", $membro->identificativo_fiscale));
        } else {
            $xml_e_membro->appendChild(new DomElement("identificativoFiscaleEstero", $membro->identificativo_fiscale));
        }
        $xml_e_membro->appendChild(new DomElement("ragioneSociale", $membro->ragione_sociale));
        $xml_e_membro->appendChild(new DomElement("ruolo", $ruoli_partecipanti_raggruppamento[$membro->ruolo]));
    }
    return $outstring;
}



function write_avcp_xml_to_string($meta, $lotti_info)
{
    $xml_doc = new DOMDocument();
    $xml_doc->formatOutput = true;
    $xml_e=$xml_doc->createElementNS('legge190_1_0', 'legge190:pubblicazione');
    $xml_e->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $xml_e->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation', 'legge190_1_0 datasetAppaltiL190.xsd');
    $xml_doc->appendChild($xml_e);
    $xml_e_data = $xml_doc->createElement('data');
    $xml_e->appendChild($xml_e_data);
    foreach ($lotti_info as $lotto_info) {
        $aggiudicatario=null;
        $xml_e_lotto = $xml_doc->createElement('lotto');
        $xml_e_data->appendChild($xml_e_lotto);
        write_avcp_lotto_pre_tostring($meta, $lotto_info, $xml_e_lotto);
        $xml_e_partecipanti = $xml_e_lotto->appendChild($xml_doc->createElement('partecipanti'));
        
        if (isset($lotto_info->partecipanti["ditte"])) {
            foreach ($lotto_info->partecipanti["ditte"] as $partecipante) {
                write_avcp_partecipante_tostring_ditta($partecipante, $xml_e_partecipanti);
                if ($partecipante->aggiudicatario != null && $partecipante->aggiudicatario == "Y") {
                    $aggiudicatario = $partecipante;
                }
            }
        }
        
        if (isset($lotto_info->partecipanti["raggruppamenti"])) {
            foreach ($lotto_info->partecipanti["raggruppamenti"] as $partecipante) {
                write_avcp_partecipante_tostring_raggruppamento($partecipante, $xml_e_partecipanti);
                $fk = key($partecipante);
                if ($partecipante[$fk] != null  &&
                    $partecipante[$fk]->aggiudicatario != null  &&
                    $partecipante[$fk]->aggiudicatario == "Y") {
                    $aggiudicatario = $partecipante;
                    $aggiudicatario["tipo"]="raggruppamento";
                }
            }
        }
        $xml_e_aggiudicatari = $xml_e_lotto->appendChild($xml_doc->createElement('aggiudicatari'));

        if ($aggiudicatario != null) {
            if (is_object($aggiudicatario)) {
                write_avcp_partecipante_tostring_ditta($aggiudicatario, $xml_e_aggiudicatari, true);
            } else {
                unset($aggiudicatario["tipo"]);
                write_avcp_partecipante_tostring_raggruppamento($aggiudicatario, $xml_e_aggiudicatari, true);
            }
        }
    }
    return $xml_doc->saveXML();
}

?>