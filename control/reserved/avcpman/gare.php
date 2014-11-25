<?php
namespace reserved\avcpman\gare;
include_once LIB_PATH . "dompdf-0.6.1/dompdf_config.inc.php";
	
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher,editor,viewer",redirect=true)
     */
    function d()
    {
        if (!isset($this->_s["year"]))
        {
            $this->_s["year"]=date("Y");
        }
        
        $all=!!($this->user->isRole("administrator") && isset($this->_r["all"]) && ($this->_r["all"] == "true"));        
		if ($all)
        {
            $gare =get_gare($this->_s["year"]);
            $view_all = "true";
        }
		else
        {
			$gare =get_gare($this->_s["year"],NULL,$this->user->getID());
            $view_all = "false";
        }
        //default action
		
        return ReturnSmarty('gare.tpl',array("year"=>$this->_s["year"],
                                             "gare"=>$gare,
                                             "view_all"=>$view_all));
    }
    
 
	function view()
    {
		global $contest_type;
		global $ruoli_partecipanti_raggruppamento;
        if (isset($this->_r["parameter"]) || isset($this->_s["gid"]) )
        {
            $gid  = (int) isset($this->_r["parameter"])?$this->_r["parameter"]:$this->_s["gid"];
            $this->_s["gid"]=$gid;
            $gara =get_gara($gid);
            $partecipanti = get_partecipanti($gid);
            //default action
			$p = array("gara"=>$gara,
						"partecipanti"=>$partecipanti,
						"contest_type"=>$contest_type,
						"ruoli_raggruppamento"=>$ruoli_partecipanti_raggruppamento);
			if (isset($this->_r["error"]))
				$p["error"] = $this->_r["error"];
            return ReturnSmarty('gare.view.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/ditte");
    }
	
    /**
     * @Access(roles="administrator,editor")
     */	
    function edit()
    {
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/edit");
    }
    
	 /**
     * @Access(roles="administrator,editor,viewer")
     */
    function new_gara()
    {
        
        return ReturnArea($this->status->getSiteView(),"avcpman/gare/new_gara");
    }

	 /**
     * @Access(roles="administrator,editor,viewer")
     */    
    function delete()
    {
        if (isset($this->_r["parameter"]))
        {
            $gid = $this->_r["parameter"];
            delete_gara($gid);
        }
        return ReturnArea($this->status->getSiteView(),$this->status->getArea()); 
    }


	function print_pdf()
	{
		global $contest_type;
		$year = $this->_s["year"];
		$administrator = $this->user->isRole("administrator") && isset($this->_r["all"]) && ($this->_r["all"] == "true");
		if ($administrator)
			$gare =get_gare($year);
		else
			$gare =get_gare($year,NULL,$this->user->getID());
		
		$html = <<<END
		<html><head>
		<style type="text/css">

@page {
	margin: 2cm;
}

body {
  font-family: sans-serif;
	margin: 0.5cm 0;
	text-align: justify;
}

#header,
#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
}

#header {
  top: 0;
	border-bottom: 0.1pt solid #0B5A71;
}

#footer {
  bottom: 0;
  border-top: 0.1pt solid #0B5A71;
}

#header table,
#footer table {
	width: 100%;
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
  padding: 0;
	width: 50%;
}

.page-number {
  text-align: center;
}

.page-number:before {
  content: "Pagina " counter(page);
}

hr {
  page-break-after: always;
  border: 0;
}
h2 {
	text-align:center;
	
}
table#data
{
	border-collapse: collapse;
	margin: auto;
	width: 100%;
	text-align: center;
}

table#data td,th
{
	border: 1px solid #555;
	padding: .5em;
}
table#data thead 
{
	background-color: #7CB2C1;
}
table#data thead th
{
	
	font-weight: bold;	
}
</style>
</head><body>
END;
		$html .= '<div id="header"><table><tr><td>Elenco gare per trasmissione AVCP</td><td style="text-align: right;">'. $this->user->getDisplayName() .'</td></tr></table></div>';
        $html .= '<div id="footer"> <div class="page-number"></div></div>';
		$html .= '<h2> Anno ' . $year .'</h2>';
		$html .= '<table id="data">';
		$html .= <<<END
		
		<thead>
			<tr>
				<th>Oggetto</th>
				<th>CIG</th>
				<th>Tipo contraente</th>
				<th>Importo <br/>aggiudicazione</th>
				<th>Importo <br/>somme liquidate</th>
				<th>Data <br/>inizio lavori</th>
				<th>Data <br/>fine lavori</th>
END;
		if ($administrator)
		{
			$html .= "<th>Utente</th>";
		}
			
		$html .= <<<END
			</tr>
		</thead>
		<tbody>
END;
		foreach ($gare as $gara)
		{
			$html .= "<tr><td>$gara->oggetto</td><td>$gara->cig</td><td>".$contest_type[$gara->scelta_contraente] ."</td>";
			$html .= "<td>$gara->importo</td><td>$gara->importo_liquidato</td>";
			$html .= "<td>$gara->data_inizio</td><td>$gara->data_fine</td>";
			if ($administrator)
				$html .= "<td>$gara->f_user_id</td>";
			$html .= "</tr>";
		}
		
		$html .= "<tbody></table>";		
		$html .='</body></html>';
		$dompdf = new \DOMPDF();
		
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'landscape');
		$dompdf->render();
		$dompdf->stream("hello_world.pdf", array("Attachment" => false));
	}
}
?>
