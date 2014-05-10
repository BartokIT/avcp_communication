<?php
/**
* $action variabile che contiene il nome dell'area corrente
*
*/

	add_to_debug("Azione",  $action);
	switch ($action)
	{
		case "insert_new":
			if(verify_nonce($_r->nonce))
			{
				insert_gara($_r->cig,$_r->subject,$_r->contest_type,$_r->amount,$_r->payed_amount,$_r->job_start_date,$_r->job_end_date,$_r->f_pub_anno,$_r->f_pub_numero);
			}
			return new ReturnedPage("gara.php",array("anno"=>$_r->f_pub_anno,"numero"=>$_r->f_pub_numero,
									"cig"=>$_r->cig,"subject"=>$_r->subject,"contest_type"=>$_r->contest_type,
									"amount"=>$_r->amount,"payed_amount"=>$_r->payed_amount,"job_start_date"=>$_r->job_start_date,
									"job_end_date"=>$_r->job_end_date,"f_pub_anno"=>$_r->f_pub_anno,"f_pub_numero"=>$_r->f_pub_numero));
			break;
		case "search_ditta":
			
			$result = search_ditta($_r->stringa_ricerca, $_r->stringa_ricerca);
			
			return new ReturnedAjax("json",array("ditte"=>$result));
		case "new":			
			return new ReturnedPage("gara.php",array("anno"=>$_r->anno,"numero"=>$_r->numero));
		
		case "get_gare":
			return new ReturnedAjax("json",array("gare"=>get_gare($_r->numero,$_r->anno)));

		default:			
		case "":
			/* Show the list of the years*/			
			$parameters=array("years"=>get_years(),
							  "publications"=>array());
			if (isset($_r->anno))
			{
				$parameters["publications"]=get_pubblicazioni($_r->anno);
				$parameters["selected_year"]=$_r->anno;
			}			
			return new ReturnedPage("default.php",$parameters);		
			break;
	}


?>
