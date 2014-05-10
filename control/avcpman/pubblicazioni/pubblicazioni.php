<?php
/**
* $action variabile che contiene il nome dell'area corrente
*
*/

	add_to_debug("Azione",  $action);
	switch ($action)
	{
		case "insert":
			$out = insert_pubblicazione($_r->titolo,$_r->abstract,$_r->data_pubblicazione,
										$_r->data_aggiornamento,$_r->url, $_r->anno);
			if ($out)
				return new ReturnedAjax("json",array("outcome"=>true,"number"=>$out));
			else
				return new ReturnedAjax("json",array("outcome"=>false));
			break;
		case "generate_index":
			return new ReturnedAjax("json",array("outcome"=>update_crea_indice_pubblicazioni($_r->crea,$_r->anno)));
		case "delete":			
			return new ReturnedAjax("json",array("outcome"=>delete_pubblicazione($_r->anno,$_r->numero)));
		case "update_index_url":
			return new ReturnedAjax("json",array("outcome"=>update_url_indice_pubblicazioni($_r->url,$_r->anno)));
		case "update":
			$out = update_pubblicazione($_r->titolo,$_r->abstract,$_r->data_pubblicazione,
										$_r->data_aggiornamento,$_r->url, $_r->anno,$_r->numero);
			return new ReturnedAjax("json",array("outcome"=>$out));
			break;		
		case "pubblicazione_detail":			
			return new ReturnedAjax("json",get_pubblicazione_detail($_r->anno,$_r->numero));
		case "get_pubblicazioni":
			return new ReturnedAjax("json",array("pubblicazioni"=>get_pubblicazioni($_r->anno)));
		case "get_years":
			return new ReturnedAjax("json",array("anni"=>get_years()));
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
			return new ReturnedPage("pubblicazioni.php",$parameters);		
			break;
	}


?>
