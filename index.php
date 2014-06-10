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

$au = new LDAPAuthentication("dcServer01.terracina.local",3268,
			     'CN=LDAP Reader,CN=Users,DC=terracina,DC=local',
			     'Terracina2014!!',
			     'DC=terracina,DC=local',
			     "samaccountname",
			     '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))');
$config =  array("init_status"=>array("site_view"=>"avcpman",
				      "area"=>"pubblicazioni/def"),
		 "authentication"=>array("authenticator"=>$au,
					 "userinforetriever"=>$au,
					 "external"=>false),
		"debug"=>true,
		"flow_name"=>"main",
		"history_len"=>20 );

$f = new MainFlow($config);
//var_dump($f->user);
var_dump($_SESSION);


?>
