<?php
$xml_doc = new DOMDocument();
$xml_doc->load("appalti2013.xml");
$xpath = new DOMXpath($xml_doc);
$metadati = array(
    "anno"=>$xpath->query("/legge190:pubblicazione/metadata/annoRiferimento/text()")->item(0)->textContent,
    "titolo"=>$xpath->query("/legge190:pubblicazione/metadata/titolo/text()")->item(0)->textContent,
    "abstract"=>$xpath->query("/legge190:pubblicazione/metadata/abstract/text()")->item(0)->textContent,
    "dataPubbicazioneDataset"=>$xpath->query("/legge190:pubblicazione/metadata/dataPubbicazioneDataset/text()")->item(0)->textContent,
    "urlFile"=>$xpath->query("/legge190:pubblicazione/metadata/urlFile/text()")->item(0)->textContent,
    "dataUltimoAggiornamentoDataset"=>$xpath->query("/legge190:pubblicazione/metadata/dataUltimoAggiornamentoDataset/text()")->item(0)->textContent,
    "entePubblicatore"=>$xpath->query("/legge190:pubblicazione/metadata/entePubblicatore/text()")->item(0)->textContent
);
$lotti_dom = $xpath->query("/legge190:pubblicazione/data/lotto");
$ditte =array();
$lotti=array();

foreach ($lotti_dom as $lotto_dom)
{       
    $lotto=array();
    $lotto["cig"] = $lotto_dom->getElementsByTagName("cig")->item(0)->textContent;
    $lotto["oggetto"] = $lotto_dom->getElementsByTagName("oggetto")->item(0)->textContent;
    $lotto["importoSommeLiquidate"] = $lotto_dom->getElementsByTagName("importoSommeLiquidate")->item(0)->textContent;
    $lotto["importoAggiudicazione"] = $lotto_dom->getElementsByTagName("importoAggiudicazione")->item(0)->textContent;
    foreach ($lotto_dom->getElementsByTagName("partecipante") as $partecipante) {
        $ditta=array();        
        $ditta["codice_fiscale"] = @$partecipante->getElementsByTagName("codiceFiscale")->item(0)->textContent;
        $id_estero = @$partecipante->getElementsByTagName("identificativoFiscaleEstero")->item(0)->textContent;
        $ditta["estero"]="N";
        if (is_null($ditta["codice_fiscale"])) {
            $ditta["estero"]="Y";
            $ditta["codice_fiscale"] = $id_estero;
        }
        $ditta["denominazione"] = $partecipante->getElementsByTagName("ragioneSociale")->item(0)->textContent;
        $ditte[$ditta["codice_fiscale"]] = $ditta;   
        $lotti[]=$lotto;
    }
}
