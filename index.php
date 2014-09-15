<?php
/**
* Funzione per inizializzare l'area e la site view
*/


define("INDEX", basename($_SERVER['SCRIPT_FILENAME']));
define("PRODUCTION",false);
include("framework.php");
include("config.php");

$f = new MainFlow($config);
?>