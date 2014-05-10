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
$lib = 'lib/';
require_once $lib . 'Doctrine/Common/ClassLoader.php';
$classLoader = new Doctrine\Common\ClassLoader('Doctrine\Common', $lib);
$classLoader->register();



use Doctrine\Common\Annotations\Annotation;


require_once "class/dataobjects.php"; 
//require_once "class/core.php"; 

define("DEBUG",true);
$path = "control/avcpman/pubblicazioni/default.php" ;
/*$tokens = token_get_all(file_get_contents($path));*/

echo "<pre>";
//print_r($tokens);
echo "</pre>";

$methods = array();
$tmp_docblock = NULL;
$instance_name = '$c';

function oppps()
{
	echo "oppps;";
}

function r1()
{
	 
	
	$c = new Control();
	$c->stampa=function($p){
		 
		echo "p".$p;
	};
	return $c;
}

function r2()
{
	
	$p="cacca";
	$path = "control/avcpman/pubblicazioni/default.php" ;	
	include $path;	
	$site_view = "public";
	eval('$c = new avcpman\pubblicazioni\Control($site_view);');
	$reflClass = new ReflectionObject($c);
	$reader = new \Doctrine\Common\Annotations\AnnotationReader();
	
	$return = (object)array("class"=>NULL,"methods"=>NULL);
	$return->class= $reader->getClassAnnotations($reflClass);
	$methods = $reflClass->getMethods();
	foreach ($methods  as $method)
	{            
		$return->methods[$method->getName()] =$reader->getMethodAnnotations($method);
	}
	print_r($return);
	return $c;
}

$p=r2();
$p->insert();
/*
foreach($tokens as $token) {
	echo token_name($token[0]) . "<br/>";
    if( $token[0] == T_DOC_COMMENT) {
	        $comments[] = $token[1];
    }
}

*/



echo "OK;";
?>
