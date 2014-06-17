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
$rm = new SimpleUserRoleMapper(array("claudio.papa"=>"administrator"),
			       array("CN=Remote Desktop Users,CN=Builtin,DC=terracina,DC=local"=>"reader"));
$config =  array("init_status"=>array("site_view"=>"avcpman",
				      "area"=>"pubblicazioni/def"),
		 "authentication"=>array("authenticator"=>$au,
					 "userinforetriever"=>$au,
					 "rolemapper"=>$rm,
					 "external"=>false),
		 "login_status"=>array("site_view"=>"avcpman",
				      "area"=>"pubblicazioni/login"),
		"debug"=>true,
		"flow_name"=>"main",
		"history_len"=>20 );

$f = new MainFlow($config);
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>
