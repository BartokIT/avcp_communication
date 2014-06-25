<?php
define("CONTROL_PATH","control/");
define("PRESENTATION_PATH","presentation/");
define("LIB_PATH","lib/");
//inizializzo la sessione
include_once("class/globalfun.php");
parse_resources();
@session_start();
date_default_timezone_set('Europe/Rome');

require_once(LIB_PATH . 'Smarty/Smarty.class.php');
require_once "class/dataobjects.php";
include_once("class/returned_object.php");
include_once("class/core.php");
include ("abstraction/authentication.php");
include ("abstraction/sql_manager.php");
/*
ini_set('error_reporting',  E_ALL & ~E_DEPRECATED  );
ini_set('display_errors', 'On');
ini_set('display_startup_errors','On');
ini_set("magic_quotes_gpc",FALSE); 
*/
//set_time_limit(30);
/*


include_once("class/crono.php");
global $crono;
$crono = new Crono();
include_once("abstraction/sql.php");
include_once("class/generalized.php");

include_once("class/flusso.php");
include_once("application.php");
include_once("class/returned_object.php");
include_once("class/debug.php");
include_once("abstraction/sql_manager.php");
	

function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);
    return $value;
}

if (get_magic_quotes_gpc()) {
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}
*/

?>
