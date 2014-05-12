<?php
/**
* Funzione per inizializzare l'area e la site view
*/

function inizializza()
{
	return new ReturnedArea("public","default");
}


define("INDEX", basename($_SERVER['SCRIPT_FILENAME']));
define("PRODUCTION",false);
include("framework.php");
/*setlocale(LC_COLLATE, 'C');	

//$stringa = 'Iñtër  nâtiônàl\'izætiøn Haendel and also Hàndel dell\'orto';
$table_prefix = "idx_";			
$new = new Flusso("clp","nodo_principale");
		
$nome_file = $new->elaborates();
*/

/* Doctrine tests */
$config = (object) array("init_status"=>array("site_view"=>"avcpman",
					      "area"=>"pubblicazioni/def"),
			 "debug"=>true,
			 "flow_name"=>"main",
			 "login_status"=>NULL,
			 "history_len"=>10 );
var_dump($config);
new MainFlow($config);
?>
