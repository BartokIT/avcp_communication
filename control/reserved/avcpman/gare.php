<?php
namespace reserved\avcpman\gare;

include_once LIB_PATH . "wkhtmltopdf/Pdf.php";

/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher,editor,viewer",redirect=true)
     */
    public function d()
    {
        
        $month = (int) date("m");
        
        //Get the list of years to be used
        $years=get_years_gare();
        if ($month == 1) {
                $years[((int)date("Y")) - 1]=((int)date("Y")) - 1;
        }
        $years[(int)date("Y") ]=(int)date("Y");
        
        //Set default year if no year is selected
        if (!isset($_SESSION["year"])) {
            if ($month == 1) {
                $_SESSION["year"]=((int)date("Y")) - 1;
            } else {
                $_SESSION["year"]=date("Y");
            }
        }
        else {
            if (!in_array($_SESSION["year"],$years)) {
                if ($month == 1) {
                    $_SESSION["year"]=((int)date("Y")) - 1;
                } else {
                    $_SESSION["year"]=date("Y");
                }   
            }
        }            
        
        $all=!!($this->user->isRole("administrator") &&
                isset($this->_s["all"]) && $this->_s["all"]);
        
        if ($all) {
            $gare =get_gare($_SESSION["year"]);
            $view_all = "true";
        } else {
                $gare =get_gare($_SESSION["year"], null, $this->user->getID());
                $view_all = "false";
        }
        //verifiche sui problemi relativi ad una gara
        foreach ($gare as $gid=>$gara) {
            $gare[$gid]->warning=false;
            //se non ci sono partecipanti
            if ($gara->partecipanti == 0) {
                $gare[$gid]->warning=true;
            }
            if ($gara->importo > $gara->importo_liquidato) {
                $gare[$gid]->warning=true;
            }
            if (is_null($gara->data_inizio) || is_null($gara->data_fine)) {
                $gare[$gid]->warning=true;
            }
        }
            
        return ReturnSmarty('gare.tpl', array("year"=>$_SESSION["year"],
                                              "years"=>$years,
                                              "gare"=>$gare,
                                              "view_all"=>$view_all));
    }
    
    public function set_current_year()
    {
        if (isset($this->_r["year"])) {
            $y = $this->_r["year"]*1;
            $cy = date("Y")*1;
            if (($y > 1950) && ($y <= $cy)) {
                $_SESSION["year"] = $y;
            }
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }
    
    public function set_view_all()
    {
        if (isset($this->_r["all"])) {
            if (strcmp($this->_r["all"], "true") == 0) {
                $this->_s["all"] = true;
            } else {
                $this->_s["all"] = false;
            }
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }
    
    public function view()
    {
        global $contest_type;
        global $ruoli_partecipanti_raggruppamento;
        if (isset($this->_r["parameter"]) || isset($this->_s["gid"])) {
            $gid  = (int) isset($this->_r["parameter"])?$this->_r["parameter"]:$this->_s["gid"];
            $this->_s["gid"]=$gid;
            $gara =get_gara($gid);
            $partecipanti = get_partecipanti($gid);
            //default action
            $p = array("gara"=>$gara,
                       "partecipanti"=>$partecipanti,
                       "contest_type"=>$contest_type,
                       "ruoli_raggruppamento"=>$ruoli_partecipanti_raggruppamento);
            if (isset($this->_r["error"])) {
                $p["error"] = $this->_r["error"];
            }
            return ReturnSmarty('gare.view.tpl', $p);
        } else {
            return ReturnArea($this->status->getSiteView(), "avcpman/ditte");
        }
    }

    /**
    * @Access(roles="administrator,editor")
    */
    public function edit()
    {
        return ReturnArea($this->status->getSiteView(), "avcpman/gare/edit");
    }
    
    /**
    * @Access(roles="administrator,editor,viewer")
    */
    public function new_gara()
    {
        return ReturnArea($this->status->getSiteView(), "avcpman/gare/new_gara");
    }

    /**
    * @Access(roles="administrator,editor,viewer")
    */
    public function delete()
    {
        if (isset($this->_r["parameter"])) {
            $gid = $this->_r["parameter"];
            delete_gara($gid);
        }
        return ReturnArea($this->status->getSiteView(), $this->status->getArea());
    }


    public function print_pdf()
    {
        global $contest_type;
        global $ruoli_partecipanti_raggruppamento;
        $year = $_SESSION["year"];
        $administrator = $this->_r["all"];
        if ($administrator) {
            $gare =get_gare($year);
        } else {
            $gare =get_gare($year,null, $this->user->getID());
        }
        
        foreach ($gare as $lotto) {
            $lotto->partecipanti = get_partecipanti($lotto->gid);
		}
		$html = <<<END
        <html><head>
		
		<style type="text/css">

body {
	font-family: sans-serif;
	font-size: 13px;
	text-align: center;
	
}


table#data
{
	width :95%;
	margin: auto;
	border-collapse: collapse;
	font-size:12px;
}

table#data thead th
{
	vertical-align: bottom;
}

table#data td, table#data th
{
	border: 1px solid black;
	vertical-align: top;
	
}
 
table#data thead th, table#data th
{
	background-color: #ACD2E1;
	text-align: center;
}
table .subject
{
	width: 400px;
	padding: 10px;
	text-align: justify;
}
table .money, table .cig,table .contest_type, table .data,
table .partecipante_n, table .partecipante, table .users
{
	text-align: center;
}

table .contest_type
{
	font-size: .95em;
}
table .users
{
	font-size: 11px;
}

table .number
{
	background-color: #ACD2E1;
	text-align:center;
}
td div,tbody {
     page-break-inside: avoid !important;	 
}
.grey
{
	background-color: #EEE;
}

table .partecipante_n em
{
	font-size: .8em;
}

tbody 
{
	border-bottom: 3px solid  black !important;
}
thead
{
	margin-bottom: 3px !important;
	padding-bottom: 3px !important;
}

</style>
</head><body>
END;
		$html .= '<h1>Elenco gare per trasmissione AVCP</h1><div> Inserimento effettuato da: ' . $this->user->getDisplayName() .'</div>';        
		$html .= '<h2> Anno ' . $year .'</h2>';
		$html .= '<table id="data">';
		$html .= <<<END
		
		<thead>
			<tr>
				<th class="subject">Oggetto</th>
				<th >CIG</th>
				<th>Tipo <br/>contraente</th>
				<th>Importo <br/>aggiudicazione</th>
				<th>Importo <br/>somme liquidate</th>
				<th>Data <br/>inizio lavori</th>
				<th>Data <br/>fine lavori</th>
END;
		$cols = 7;
		if ($administrator)
		{
			$html .= "<th>Utente</th>";
			$cols++;
		}
			
		$html .= <<<END
			</tr>
		</thead>
		
END;
        $j=1;
        foreach ($gare as $gara) {
			$count_ditte = 0; $html_partecipanti ="";
			foreach ($gara->partecipanti["ditte"] as $partecipante)
			{
				$aggiudicatario = "";
				if ($partecipante->aggiudicatario == 'Y')
					$aggiudicatario = "*";
				$row_style="";
				if ($count_ditte % 2)
				{
					$row_style="grey";
				}
				$html_partecipanti .= '<tr><td class="partecipante_n">' . ($count_ditte + 1)  . $aggiudicatario. '</td><td class="' .  $row_style . ' partecipante" colspan="' . ($cols - 1 ) .  '">' .  htmlentities($partecipante->ragione_sociale,ENT_QUOTES,"UTF-8") . ' / ' . $partecipante->identificativo_fiscale . 	'</td></tr>';
				$count_ditte++;
			}
			$p=0;
			foreach ($gara->partecipanti["raggruppamenti"] as $raggruppamento)
			{
				$p++;
				$i=0;
				foreach ($raggruppamento as $ditta)
				{					
					$html_partecipanti .= "<tr>";
					if ($ditta->aggiudicatario == 'Y')
						$aggiudicatario = "*";
					if ($i == 0)
						$html_partecipanti .= '<td  class="partecipante_n" rowspan="' . count($raggruppamento) .'">' . ($count_ditte + 1). $aggiudicatario . '<br/>(<em>Raggr.. ' . $p . '</em>)</td>';
					$row_style="";
				if ($count_ditte % 2)
				{
					$row_style="grey";
				}
					$html_partecipanti .= '<td  class="' .  $row_style . ' partecipante" colspan="' . ($cols - 1) .'">' . htmlentities($ditta->ragione_sociale) . " / " . $ditta->identificativo_fiscale  . " / <em>" . $ruoli_partecipanti_raggruppamento[$ditta->ruolo] .  "</em>" . '</td></tr>';
					$count_ditte++;	
					$i++;
				}	
			}
			$count_ditte +=  2;
			$html .= '<tbody><tr><td  class="number" colspan="' . $cols . '"><strong>Lotto '. $j .'</strong></td></tr><tr class="first"><td class="subject" rowspan="'.$count_ditte.'"><div>' . htmlentities($gara->oggetto,ENT_QUOTES,"UTF-8") . '</div></td><td class="cig">' 
					. $gara->cig . '</td><td class="contest_type">' . $contest_type[$gara->scelta_contraente] ."</td>";
			$html .= '<td class="money"> &euro; ' . number_format($gara->importo,2,',','.') . '</td><td class="money"> &euro; ' . number_format($gara->importo_liquidato,2,",",".") .'</td>';
			$html .= '<td class="data">' . $gara->data_inizio .'</td><td class="data">' . $gara->data_fine . '</td>';
			if ($administrator)
				$html .= '<td class="users">' . $gara->f_user_id . '</td>';
			$html .= '</tr><tr><th colspan="7">Partecipanti</th></tr>' . $html_partecipanti;
			
			$html .= "</tbody>";
			$j++;
		}
		
		$html .= "</table>";		
		$html .='</body></html>';
;
		$wkpdf = new \mikehaertl\wkhtmlto\Pdf(array("binary"=>$this->_fl->configuration->pdf["exec"],
													"orientation"=>"landscape",
													"footer-font-size"=>"10",
													"footer-left"=>" * - aggiudicatario lotto",	
													"header-font-size"=>"9",
													"header-right"=>"[date] [time]",
													"footer-right"=>"[page]/[topage]",													
													"margin-bottom"=>"15mm"
													));
		$wkpdf->addPage($html);
		if (!$wkpdf->send()) {
			throw new \Exception('Could not create PDF: '.$wkpdf->getError());
		}
	}
}