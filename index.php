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
*/

$config =  array("init_status"=>array("site_view"=>"avcpman",
				      "area"=>"pubblicazioni/def"),
		"debug"=>true,
		"flow_name"=>"main",
		"history_len"=>20 );

new MainFlow($config);
var_dump($_SESSION);
//phpinfo();
?>
