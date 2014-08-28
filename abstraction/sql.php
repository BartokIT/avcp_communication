<?php

include_once "lib/ezSQL/shared/ez_sql_core.php";
include_once "lib/ezSQL/mysqli/ez_sql_mysqli.php";
//include_once "lib/ezSQL/mssql/ez_sql_mssql.php";


$db_host="localhost";
$db_name="avcp_terracina";
$db_user="root";
$db_pass="root";


global $id_db_connection,$db;

$db = new ezSQL_mysqli($db_user, $db_pass, $db_name, $db_host); 
//$db = new ezSQL_mssql($db_user, $db_pass, $db_name, $db_host);
//$other_db_tables = $db->get_results("SHOW TABLES");
$db->prefix="avcpman_";

$db_schema=array();
$db_schema[$db->prefix . "gara"]=array(
    "cig"=>array("type"=>"string","null"=>false),
    "oggetto"=>array("type"=>"string","lenght"=>255,"null"=>true),
    "scelta_contraente"=>array("type"=>"int","null"=>true),
    "importo"=>array("type"=>"numeric","null"=>true),
    "importo_liquidato"=>array("type"=>"numeric","null"=>true),
    "data_inizio"=>array("type"=>"date","format"=>'Y-m-d',"null"=>true),
    "data_fine"=>array("type"=>"date","format"=>'Y-m-d',"null"=>true),
	"userid"=>array("type"=>"string","lenght"=>100,"null"=>true),
    "f_pub_anno"=>array("type"=>"int","null"=>true),
    "f_pub_numero"=>array("type"=>"int","null"=>true)
);

$db_schema[$db->prefix . "pubblicazione"]=array(
    "numero"=>array("type"=>"int","null"=>false),
    "anno"=>array("type"=>"int","null"=>false),
    "titolo"=>array("type"=>"string","lenght"=>1000,"null"=>true),
	"abstract"=>array("type"=>"string","lenght"=>1000,"null"=>true),
	"url"=>array("type"=>"string","lenght"=>1000,"null"=>true),
    "data_pubblicazione"=>array("type"=>"date","format"=>'Y-m-d',"null"=>true),
    "data_aggiornamento	"=>array("type"=>"date","format"=>'Y-m-d',"null"=>true)
);

$db_schema[$db->prefix . "part_ditta"]=array(
    "pid"=>array("type"=>"int","null"=>false),
    "did"=>array("type"=>"int","null"=>false)
);

$db_schema[$db->prefix . "ditta"]=array(
    "ragione_sociale"=>array("type"=>"string","lenght"=>250,"null"=>true),
    "estera"=>array("type"=>"string","lenght"=>1,"null"=>false),
    "identificativo_fiscale"=>array("type"=>"string","lenght"=>250,"null"=>false)
);
$db_schema[$db->prefix . "partecipanti"]=array(
    "gid"=>array("type"=>"int","null"=>false),
    "tipo"=>array("type"=>"string","lenght"=>1,"null"=>false)
);
$db_schema[$db->prefix . "raggruppamento"]=array(
    "pid"=>array("type"=>"int","null"=>false),
    "did"=>array("type"=>"int","null"=>false),
    "ruolo"=>array("type"=>"int","null"=>false)
);

function sql_escape($table,$column,$value)
{
    return $value;
}

function sql_create_array($function_name,$arguments)
{
	$function_info = new ReflectionFunction($function_name);
	$returned = array();
	$i=0;
	//var_dump($arguments);
	foreach ($function_info->getParameters() as $parameter_info) {
		if (isset($arguments[$i]) && ($arguments[$i] !== null && $arguments[$i] !== ""))
			$returned[$parameter_info->getName()] = $arguments[$i];
		$i++;
	}
	return $returned;
}


function build_insert_string($table,$params)
{
    global $db_schema;

    if (!isset($db_schema[$table]))
        return (object) array("error"=>true,"error_string"=>"Table " . $table . " not managed");
    
    $sql_string = "INSERT INTO " . $table . " ";
    $column_string = "(";
    $values_string = " VALUES (";
    foreach ($db_schema[$table] as $column=>$detail)
    {
        
        if (isset($params[$column]) && $params[$column] !== null)
        {
            
            switch($detail["type"])
            {
                case "float":
                case "int":
                    $column_string .= $column;
                    $values_string .= $params[$column];
                    break;
                case "numeric":
                case "string":
                    $column_string .= $column;
                    $values_string .= "\"{$params[$column]}\"";
                    break;
                case "date":
                    $tmp_dobj=DateTime::createFromFormat('d/m/Y',$params[$column]);
                    $column_string .= $column;
                    
                    $values_string .= '"' . $tmp_dobj->format($detail["format"]) . '"';
                    break; 
            }
            $column_string .= ",";
            $values_string .= ","; 
        }
        else
        {
            if ( $detail["null"] == false )
                return (object)array("error"=>true,"error_string"=>"Mandatory column " . $column . " for table " . $table . " not found");
        }
    }
    $column_string = substr($column_string,0,-1) . ") ";
    $values_string = substr($values_string,0,-1) . ")";
    $sql_string .= $column_string . $values_string;
    
    return $sql_string;
}

function build_update_string($table,$params,$where_clausule="")
{
    global $db_schema;

    if (!isset($db_schema[$table]))
        return (object) array("error"=>true,"error_string"=>"Table " . $table . " not managed");
    
    $sql_string = "UPDATE " . $table . " SET ";
    $update_string = "";

    foreach ($params as $column=>$value)
    {        
        if (isset($db_schema[$table][$column]))
        {
            $detail = $db_schema[$table][$column];
            switch($detail["type"])
            {
                case "float":
                case "int":
                    $update_string .= $column . " = " . $value;
                    break;
                case "numeric":
                case "string":
                    $update_string .= $column . ' = "' . $value . '"';
                    break;
                case "date":
                    $tmp_dobj=DateTime::createFromFormat('d/m/Y',$params[$column]);
                    $update_string .= $column . ' = "' . $tmp_dobj->format($detail["format"]) . '"';;
                    break; 
            }

            $update_string .= ","; 
        }
    }

    $update_string = substr($update_string,0,-1) . " ";
    $sql_string .= $update_string . $where_clausule;
    return $sql_string;
}


/*
if (!$id_db_connection)
{
	echo <<<EOF
	<div style="text-align:center">
		<div style="margin:auto; border: 3px dashed red;width:20em;height:5em;line-height:5em;">
			Impossibile connettersi al server database
		</div>	
	</div>
EOF;
	die();
}

if (!mysql_select_db($db_name,$id_db_connection))
{
	echo <<<EOF
	<div style="text-align:center">
		<div style="margin:auto; border: 3px dashed red;width:20em;height:5em;line-height:5em;">
			Impossibile connettersi al database
		</div>	
	</div>
EOF;
	die();
}
mysql_query("SET NAMES utf8");*/
?>