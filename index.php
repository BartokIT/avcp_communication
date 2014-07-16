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
$ruoli_partecipanti_raggruppamento=array(1=>"MANDANTE",
										 2=>"MANDATARIA",
										 3=>"ASSOCIATA",
										 4=>"CAPOGRUPPO",
										 5=>"CONSORZIATA");
$contest_type=array(
					1=>"Procedura aperta",
					2=>"Procedura ristretta",
					3=>"Procedura negoziata previa pubblicazione del bando",
					4=>"Procedura negoziata senza previa pubblicazione del bando",
					5=>"Dialogo competitivo",
					6=>"Procedura negoziata senza previa indizione di gara art. 221 D.Lgs. 163/2006",
					7=>"Sistema dinamico di acquisizione",
					8=>"Affidamento in economia - cottimo fiduciario",
					17=>"Affidamento diretto ex art. 5 della Legge n. 381/91",
					21=>"Procedura ristretta derivante da avvisi con cui si indice la gara",
					22=>"Procedura negoziata derivante da avvisi con cui si indice la gara",
					23=>"Affidamento in economia - Affidamento diretto",
					24=>"Affidamento diretto a societ&agrave; in house",
					25=>"Affidamento diretto a societ&agrave; raggruppate/consorziate o controllate nelle concessioni di LL.PP.",
					26=>"Affidamento diretto in adesione ad accordo quadro/convenzione",
					27=>"Confronto competitivo in adesione ad accordo quadro/convenzione",
					28=>"Procedura ai sensi dei regolamenti degli organi costituzionali");
$au = new LDAPAuthentication("dcServer01.terracina.local",3268,
			     'CN=LDAP Reader,CN=Users,DC=terracina,DC=local',
			     'Terracina2014!!',
			     'DC=terracina,DC=local',
			     "samaccountname",
			     '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))');
$rm = new SimpleUserRoleMapper(array("claudio.papa"=>array("administrator","editors")),
			       array("CN=Remote Desktop Users,CN=Builtin,DC=terracina,DC=local"=>"reader"));
$config =  array("init_status"=>array("site_view"=>"avcpman",
				      "area"=>"def"),
		 "authentication"=>array("authenticator"=>$au,
					 "userinforetriever"=>$au,
					 "rolemapper"=>$rm,
					 "external"=>false),
		 "login_status"=>array("site_view"=>"avcpman",
				      "area"=>"login"),
		"debug"=>array("framework"=>true,
					   "smarty"=>false),
		"flow_name"=>"main",
		"history_len"=>20 );

$f = new MainFlow($config);

?>
