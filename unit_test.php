<html>
	<body>
<?php

function inizializza()
{
	return new ReturnedArea("public","default");
}


define("INDEX", basename($_SERVER['SCRIPT_FILENAME']));
define("PRODUCTION",false);
include("support.php");
setlocale(LC_COLLATE, 'C');	

//$stringa = 'Iñtër  nâtiônàl\'izætiøn Haendel and also Hàndel dell\'orto';
$table_prefix = "idx_";			
$new = new Flusso("clp","nodo_principale");

echo "<p>Administrator password" . sha1("adminmike") . "</p>";


echo "<strong>TEST 1</strong> Inserisci la ditta Almaviva. <br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=insert_ditta("Almaviva espana","T","IT11122233355");
echo $r;
echo "</pre>";
echo "<strong>TEST 2</strong> Cerca la ditta Almaviva. <br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=search_ditte("IT","");
echo $r[0]->ragione_sociale;
echo "</pre>";

echo "<strong>TEST 3</strong> Ottieni tutte le ditte in archivio<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=get_ditte("IT","");
print_r($r);
echo "</pre>";


echo "<strong>TEST 4</strong>Aggiorna la ditta con id 1 con un altro nome<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=update_ditta(1,null,"ClaudioWorks Entertainment");
print_r($r);
echo "</pre>";


echo "<strong>TEST 5</strong>Inserisci una nuova gara<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=insert_gara("123456789A","Acquisto di passamontagna da rapina",6,12340.5,0,"06/05/2013","16/09/1983",2013);
print_r($r);
echo "</pre>";


echo "<strong>TEST 6</strong>Aggiorna gara con id 1<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=update_gara(1,"123456789B","Acquisto tovagliolini aggiornati",1,15.5,25.5,"31/12/2013","07/07/2014",2012);
print_r($r);
echo "</pre>";

echo "<strong>TEST 7</strong>Aggiungo la ditta 1 come partecipante della gara con id 9<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=add_partecipante(9,"D",1);
print_r($r);
echo "</pre>";


echo "<strong>TEST 8</strong>Aggiungo la ditta 6 come partecipante ad un raggruppamento per la gara con id 1<br/> Risultato:";
echo '<pre style="font-size:10px;">';
$r=add_partecipante(1,"R",6,1);
print_r($r);
echo "</pre>";
?>
	</body>
<html>