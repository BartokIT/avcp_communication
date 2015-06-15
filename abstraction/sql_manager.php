<?php
include("sql.php");



function clean_currency_value($amount) {
    if (preg_match("/^\d+(?:,?[0-9]{3})*(?:\.\d{0,2})?$/i", $amount, $matches))
    {
        $amount = str_replace(",","",$amount);
    }
    else if (preg_match("/^\d+(?:\.?[0-9]{3})*(?:,\d{0,2})?$/i", $amount, $matches))
    {
        $amount = str_replace(".","",$amount);
        $amount = str_replace(",",".",$amount);
    }
    return $amount;
}

function execute_sql_file($id_sql_connection, $database_name, $sql_file) {
    $select_result = mysql_select_db($database_name, $id_sql_connection);
    $install_path = dirname($_SERVER['SCRIPT_FILENAME']) . "/";

    if ($select_result == false) {
        return false;
    } else {
		$file_array= file($install_path . $sql_file);

		if ($file_array == false) {
			//echo $install_path . $sql_file;
			return false;
		} else {
			$no_problem = false;
			$sql_string_commands = "";

			//scorro le righe per vedere quelle che iniziano con un commento

			foreach($file_array as $row)
			{
				$trim_row = trim($row);

				//se inizia con un commento le ignoro altrimenti le inserisco in un array
				if (!preg_match("/^--.*/", $trim_row))
				{
					$sql_string_commands .= " " . $trim_row;
				}
			}


			//splitto i vari comandi sql che sono divisi da un ";"
			$sql_commands = explode(";",$sql_string_commands);

			foreach ($sql_commands as $sql_query)
			{
				//echo $sql_query . "<br/>";
				//echo htmlspecialchars($content);

				$create_tables_result = mysql_query($sql_query);

				if (!$create_tables_result) {
					switch ( mysql_errno())
					{
						//ERRORI GRAVI
						default: //errore sconosciuto
							echo mysql_error() . " " . mysql_errno() ." <br/>";
						case 1005: //errore di impossibilità creazione tabella - GRAVE
							$no_problem = $no_problem && FALSE;
							echo mysql_error() . " " . mysql_errno() ." <br/>";
							break;

							//ERRORI NON GRAVI
						case 1065: //query vuota
						case 1062: //chiave già esistente	
						case 1050: //tabella già esistente
					}
				}
					
			}

			return $no_problem;
		}
	}
}



/**
 * Permette di ottenere le credenziali di accesso al sistema
 **/
function get_user_credential($user) {
	global $db;
	$user=$db->escape($user);
	$row = $db->get_row("SELECT u.name, u.access_password, u.user_roles FROM " . $db->prefix . "users u  WHERE u.id='$user'");

	if ($row == NULL)
	    return array();
	else
	    return (object) array("name"=>$row->name, "password"=>$row->access_password, "roles"=>explode(";",$row->user_roles));
}

/**
 * Ottiene la lista degli anni presenti in archivio
 **/
function get_years() {
	global $db;
	$years = $db->get_results("SELECT DISTINCT anno, i.url, i.generare FROM " . $db->prefix . "indice i ORDER BY anno DESC");

	if ($years == NULL)
		return array();
	else
		return $years;
}


function get_years_gare()
{
	global $db;
	$years = $db->get_col("SELECT DISTINCT g.f_pub_anno FROM " . $db->prefix . "gara g ORDER BY g.f_pub_anno DESC");
    $result = array();
    foreach ($years as $y) {
        $result[$y] = $y;
    }
	if ($years == NULL)
		return array();
	else
		return $result;
}

/**
 * Ottiene la lista degli anni presenti in archivio
 **/
function is_year_gare_present($anno)
{
	global $db;
	$anno = $db->escape($anno*1);
	$years = $db->get_col("SELECT DISTINCT g.f_pub_anno FROM " . $db->prefix . "gara g WHERE g.f_pub_anno = $anno");

	if ($years == NULL)
		return false;
	else
		return true;
}

/**
 * Ottiene la lista degli anni presenti in archivio
 **/
function is_year_publication_present($anno)
{
	global $db;
	$anno = $db->escape($anno*1);
	$years = $db->get_col("SELECT DISTINCT anno FROM " . $db->prefix . "pubblicazione p WHERE p.anno = $anno");

	if ($years == NULL)
		return false;
	else
		return true;
}

/**
 * Permette di inserire un anno in archivio
 **/
function insert_year($anno,$transaction=true)
{
		global $db;
		if (!is_numeric($anno))
				return false;
		$anno = $db->escape($anno*1);
		if ($transaction)
			$db->query("BEGIN");
		$result = $db->query("INSERT INTO " . $db->prefix . "indice (anno) VALUES ($anno)");
		if ($transaction)
			$db->query("COMMIT");
		return $result;
}

function update_crea_indice_pubblicazioni($crea,$anno)
{
		global $db;
		//echo $crea;
		$generare="F";
		if ($crea == "true")
				$generare="T";
		$result = $db->query("UPDATE " . $db->prefix . 'indice SET generare = "' . $generare . '" WHERE anno = ' . $anno );
		return $result;
	
}

function update_url_indice_pubblicazioni($url,$anno)
{
		global $db;
		$url=$db->escape($url);
		
		$result = $db->query("UPDATE " . $db->prefix . 'indice SET url = "' . $url .'" WHERE anno = ' . $anno );
		return $result;
	
}

/**
 * Permette di ottenere l'elenco delle pubblicazioni effettuate per un determinato anno
 **/
function get_pubblicazioni($anno=NULL)
{
	global $db;
	$whereanno="";
	if (!is_null($anno))
	{
		$whereanno = " WHERE p.anno = $anno ";
	}
	
	$publications = $db->get_results("SELECT p.anno, p.modified, p.titolo, p.abstract, p.numero, p.url, DATE_FORMAT(p.data_pubblicazione,'%d/%m/%Y') as data_pubblicazione, DATE_FORMAT(p.data_aggiornamento,'%d/%m/%Y') as data_aggiornamento FROM " . $db->prefix . "pubblicazione p $whereanno ORDER BY p.numero ASC");

	if ($publications == NULL)
		return array();
	else
		return $publications;
}

/**
 * Restituisce un oggetto contenente i dettagli di una singola pubblicazione
 * */
function get_pubblicazione_detail($anno,$numero)
{
	global $db;

	$publication = $db->get_row("SELECT p.numero, p.anno, p.titolo, p.abstract, DATE_FORMAT(p.data_pubblicazione,'%d/%m/%Y') as data_pubblicazione,DATE_FORMAT(p.data_aggiornamento,'%d/%m/%Y') as data_aggiornamento, p.url FROM " . $db->prefix . "pubblicazione p WHERE p.anno = $anno AND p.numero = $numero");
 
	if ($publication == NULL)
		return array();
	else
		return $publication;
}

/**
 * Permette di elminare una pubblicazione
 * */
function delete_pubblicazione($anno,$numero)
{
		global $db;
		$result = $db->query("DELETE FROM " . $db->prefix . "pubblicazione  WHERE anno = $anno AND numero = $numero");
		if ($result === FALSE)
				return false;
		else
				return true;
}

/**
 * Permette di aggiornare i valori di una pubblicazione
 * */
function update_pubblicazione($titolo,$abstract,$data_pubblicazione, $data_aggiornamento,$url,$anno,$numero)
{
	global $db;
	if (!is_numeric($anno))
				return false;
    
	$anno = $db->escape($anno*1);	
	$titolo = $db->escape($titolo);
	$abstract = $db->escape($abstract);
	$url = $db->escape($url);
    $data_pubblicazione = DateTime::createFromFormat('d/m/Y',$data_pubblicazione);
	$data_aggiornamento = DateTime::createFromFormat('d/m/Y',$data_aggiornamento);
	$db->query("BEGIN");

	$result = $db->query("UPDATE " . $db->prefix . 'pubblicazione SET ' .
								'titolo = "' . $titolo . '",' . 
								'abstract = "' . $abstract . '",' .
								'data_pubblicazione = "' .   $data_pubblicazione->format('Y-m-d'). '",'.
								'data_aggiornamento = "'. $data_aggiornamento->format('Y-m-d') .'",' .
								'url = "' . $url . '"  WHERE  numero = '.$numero.' AND anno = '. $anno );
    $db->query("COMMIT");
    return $result;
}

/**
 *
 **/
function set_gare_pubblicazione($anno,$numero,$ids=array(),$transaction=true)
{
    global $db;
	if (count($ids) == 0 )
	{
		if ($transaction)
			$db->query("BEGIN");
		$result = $db->query("UPDATE " . $db->prefix . 'gara SET ' .
								' f_pub_numero = ' . $numero .  								
								' WHERE  f_pub_anno = ' . $anno );
		if ($transaction)
			$db->query("COMMIT");
	}
	
    if ($result)
		return true;
	else
		return false;
}

/**
 * Inserisci una nuova pubblicazione
 * */
function insert_pubblicazione($titolo,$abstract,$data_pubblicazione, $data_aggiornamento,$url,$anno)
{
	global $db;
	if (!is_numeric($anno))
				return false;
    
	$anno = $db->escape($anno*1);	
	$titolo = $db->escape($titolo);
	$abstract = $db->escape($abstract);
	$url = $db->escape($url);
    $data_pubblicazione = DateTime::createFromFormat('d/m/Y',$data_pubblicazione);
	$data_aggiornamento = DateTime::createFromFormat('d/m/Y',$data_aggiornamento);
	$db->query("BEGIN");
	$result = $db->get_row("SELECT anno FROM " . $db->prefix . "indice WHERE anno =" . $anno);
	if ($result == NULL)
	{
		$result = $db->query("INSERT INTO " . $db->prefix . "indice (anno) " .
						   ' VALUES ( ' . $anno . ')');
		if ($result === false)
		{
			$db->query("ROLLBACK");	
			return false;
		}
	}
	$numero = $db->get_var("SELECT MAX(p.numero) FROM " . $db->prefix . "pubblicazione p WHERE p.anno = $anno");
    $numero = $numero*1 + 1;
	$result = $db->query("INSERT INTO " . $db->prefix . "pubblicazione (numero,titolo,abstract,anno,data_pubblicazione,data_aggiornamento,url) " .
							   ' VALUES ( ' . $numero . ',"' . $titolo . '","' . $abstract . '",' . $anno . ',"' .
							   $data_pubblicazione->format('Y-m-d'). '","' . $data_aggiornamento->format('Y-m-d') .'","' . $url . '")');
    if ($result === false)
	{	
		$db->query("ROLLBACK");	    
	    return false;
	}
	else
	{
		$db->query("COMMIT");
		return $numero;
	}	
}

function is_dummy_gara_present($userid)
{
	global $db;
	
	$userid = $db->escape($userid);

	
    $query_string= "SELECT  g.gid " .
	" FROM " . $db->prefix . 'gara g WHERE g.f_user_id = "' .$userid . '" AND g.dummy = "Y"';
	$gare = $db->get_row($query_string);	
	return $gare;
}

function update_dummy_gara_year($userid, $year)
{
	global $db;
	
	$userid = $db->escape($userid);
    $year = $db->escape($year);
	
    //$query_string= "SELECT  g.gid " . " FROM " . $db->prefix . 'gara g WHERE g.f_user_id = "' .$userid . '" AND g.dummy = "Y"';
    $query_string= "UPDATE " . $db->prefix . 'gara SET f_pub_anno = ' . $year . '  WHERE dummy = "Y" AND f_user_id ="' . $userid . '"';
	$result = $db->query($query_string);
    if ($result === false)
	{
		return false;
	}
	return true;
}

function get_gare_stream($anno, $anno_destination, $userid=null) {
    global $db;
    $numero_string="";
    $anno = $db->escape($anno*1);    
    $anno_destination = $db->escape($anno_destination*1);
    
    if (!is_null($userid))
	{
		$userid = $db->escape($userid);
		$numero_string .= 'AND g.f_user_id = "' .$userid . '"';
	}
	
    $query_string = "SELECT  g.gid, g.dummy, g.cig, g.oggetto, g.scelta_contraente, g.f_user_id, g.streamid, g2.gid as present, " .
        "g.importo, g.importo_liquidato, DATE_FORMAT( g.data_inizio,'%d/%m/%Y') as data_inizio, DATE_FORMAT( g.data_fine,'%d/%m/%Y') as data_fine " .
        " from (SELECT streamid, gid from avcpman_gara where streamid <> gid AND f_pub_anno = $anno_destination ) g2 " . 
        " right join avcpman_gara g on g.gid = g2.streamid where g.gid = g.streamid AND g.f_pub_anno = $anno " . $numero_string;
    
    $gare = $db->get_results($query_string);
    if ($gare == NULL)
        return array();
    else
        return $gare;
}

/**
 * restituisce l'insieme delle gare di un certo anno e di una determinata pubblicazione
 * */
function get_gare($anno,$numero=null,$userid=null)
{
	global $db;
	$anno = $db->escape($anno*1);
	$numero_string="";
	
	if (!is_null($numero))
	{
		$numero = $db->escape($numero);
		$numero_string .= "AND g.f_pub_numero = $numero";
	}
	
	if (!is_null($userid))
	{
		$userid = $db->escape($userid);
		$numero_string .= 'AND g.f_user_id = "' .$userid . '"';
	}
	
    $query_string= "SELECT  g.gid, g.dummy,g.cig, g.oggetto, g.scelta_contraente, g.f_user_id, " .
	"g.importo, g.importo_liquidato,DATE_FORMAT( g.data_inizio,'%d/%m/%Y') as data_inizio, DATE_FORMAT( g.data_fine,'%d/%m/%Y') as data_fine,".
	" COUNT(p.pid) as partecipanti FROM " . $db->prefix . "gara g LEFT JOIN " . $db->prefix . "partecipanti p ON g.gid = p.gid  WHERE g.f_pub_anno = $anno " . $numero_string . " GROUP BY g.gid";
	$gare = $db->get_results($query_string);	

	if ($gare == NULL)
		return array();
	else
		return $gare;
}


/**
 * Restituisce l'insieme delle gare di un certo anno e di una determinata pubblicazione
 * */
function get_gara($gid)
{
	global $db;
	$gid = $db->escape($gid*1);
	
	$gara = $db->get_row("SELECT g.gid, g.cig, g.oggetto, g.scelta_contraente, " .						 
						 "g.importo, g.importo_liquidato,DATE_FORMAT( g.data_inizio,'%d/%m/%Y') as data_inizio, ".
						 "DATE_FORMAT( g.data_fine,'%d/%m/%Y') as data_fine, g.f_pub_anno, g.f_pub_numero FROM " . $db->prefix . "gara g WHERE  g.gid = $gid ");
	

	if ($gara == NULL)
		return array();
	else
		return $gara;
}

/**
 * Cancella una ditta dal database
 ** */
function delete_ditta($did)
{
	global $db;
	$did = $db->escape($did*1);
	
	$result = $db->query("DELETE FROM " . $db->prefix . "ditta " .	
						   " WHERE " . $db->prefix . "ditta.did = $did ");
	

	if ($result === FALSE)
		return false;
	else
		return true;
}


/**
 * Rimuove una gara e tutti i partecipanti associati
 **/
function delete_gara($gid)
{
    global $db;
	$db->query("BEGIN");
	$result = $db->query("DELETE FROM " . $db->prefix . "raggruppamento ".	
						   " WHERE " . $db->prefix . "raggruppamento.pid IN ( " .
						   " SELECT p.pid FROM " . $db->prefix . "partecipanti p " .
						   " WHERE p.gid = $gid " . 
						   " ) ");
    if ($result === FALSE)
	{
		$db->query("ROLLBACK ");
		return false;
	}
	
	$result = $db->query("DELETE FROM " . $db->prefix . "part_ditta ".	
						   " WHERE " . $db->prefix . "part_ditta.pid IN ( " .
						   " SELECT p.pid FROM " . $db->prefix . "partecipanti p " .
						   " WHERE p.gid = $gid" . 
						   " ) ");
    if ($result ===FALSE)
	{
		$db->query("ROLLBACK ");
		return false;
	}
	
	$result = $db->query("DELETE FROM " . $db->prefix . "partecipanti " .	
						   " WHERE " . $db->prefix . "partecipanti.gid = $gid ");

	if ($result === FALSE)
	{
		$db->query("ROLLBACK ");
		return false;
	}
	
	$result = get_gara($gid);
	if ($result === FALSE)
	{		
		$db->query("ROLLBACK");
		return false;
	}
	
	set_modified_bit_pubblicazione($result->f_pub_anno);
	$result = $db->query("DELETE FROM " . $db->prefix . "gara " .	
						   " WHERE " . $db->prefix . "gara.gid = $gid ");	
	
    if ($result ===FALSE )
	{		
		$db->query("ROLLBACK");
		return false;
	}
    else
	{
		$db->query("COMMIT");
		return true;
	}

}

function copy_gare($gids, $destination_year) {
	global $db;

    $db->query("BEGIN");
    
    $gids_string = implode(",",$gids);
    
    $query_string= "SELECT gid, cig, oggetto, scelta_contraente, importo, importo_liquidato, data_inizio, data_fine, f_user_id, f_pub_anno, dummy, streamid FROM " .
                    $db->prefix . 'gara WHERE gid IN (' . $gids_string .')';
    $gare = $db->get_results($query_string);
	if ($gare === NULL) {
		$db->query("ROLLBACK");
		return false;
	}
    else {
        $new_ids = array();
        foreach ($gare as $gara) {
            $sql_string = build_insert_string($db->prefix . "gara", array("cig"=>$gara->cig, "oggetto"=>$gara->oggetto, 
                                                                        "scelta_contraente"=>$gara->scelta_contraente,"importo"=>$gara->importo,
                                                                        "importo_liquidato"=>$gara->importo_liquidato,"data_inizio"=>$gara->data_inizio,
                                                                        "data_fine"=>$gara->data_fine, "f_user_id" => $gara->f_user_id,
                                                                        "f_pub_anno"=>$destination_year, "streamid"=>$gara->streamid,
                                                                        "dummy"=>$gara->dummy));
           $result = $db->query($sql_string);
            if ($result === false) {
                $db->query("ROLLBACK");
                return false;
            }
            else {
                $new_gara_id = $db->insert_id;
                $part_string = "SELECT pa.pid, pa.gid, pa.tipo, pa.aggiudicatario, pd.did FROM " . $db->prefix . 'partecipanti pa, ' . 
                                $db->prefix . 'part_ditta pd  WHERE pa.tipo = "D"  AND pa.gid ='  . $gara->gid . ' AND pa.pid = pd.pid';
                $part_ditte = $db->get_results($part_string);
                foreach ($part_ditte as $ditta) {
                    
                    $insert_partecipante = "INSERT INTO " . $db->prefix . "partecipanti (gid,tipo, aggiudicatario) VALUES (" . $new_gara_id . ',"' . 
                        $ditta->tipo . '","'. $ditta->aggiudicatario . '")';
                    $result = $db->query($insert_partecipante);
                    if ($result === false) {
                        $db->query("ROLLBACK");
                        return false;
                    } 
                    $pid_new = $db->insert_id;
                    $insert_partecipante = "INSERT INTO " . $db->prefix . "part_ditta (did,pid) VALUES (" . $ditta->did . ',' . 
                        $pid_new . ')';
                    $result = $db->query($insert_partecipante);
                    if ($result === false) {
                        $db->query("ROLLBACK");
                        return false;
                    } 
                }
                                
                $new_ids[] = $new_gara_id;
            }
        }
        

        $db->query("COMMIT");
        return $new_ids;
    }
}

/**
 * Inserisce una nuova gara nel database
 * */
function insert_gara($cig=null,$oggetto=null,$scelta_contraente=null,$importo=null,$importo_liquidato=null,
					 $data_inizio=null,$data_fine=null,$f_user_id=null,$f_pub_anno=null,$f_pub_numero=null, $dummy=null)
{
	global $db;
	$db->query("BEGIN");
	
	$data=sql_create_array(__FUNCTION__,func_get_args());
	//if the CIG is null then fill with 10 zeros
	if ($cig==null)
		$data["cig"] = "0000000000";
		
	$sql_string = build_insert_string($db->prefix . "gara",$data);	
	$result = $db->query($sql_string);
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$gid = $db->insert_id;
    $sql_string = build_update_string($db->prefix . "gara",array("streamid"=>$gid), "WHERE gid =" . $gid);
    $result = $db->query($sql_string);
	
    if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
    
	if (!set_modified_bit_pubblicazione($f_pub_anno))
	{
		$db->query("ROLLBACK");
		return false;
	}
	
    $db->query("COMMIT");
	
	if ($result)
		return $gid;
	else
		return false;	
}

/**
 * Aggiorno i dati principali di una gara
 * */
function update_gare($anno,$numero,$cig=null,$oggetto=null,$scelta_contraente=null,$importo=null,$importo_liquidato=null,
					 $data_inizio=null,$data_fine=null,$f_pub_anno=null,$f_pub_numero=null,$transaction=true)
{
	global $db;
	if ($transaction) $db->query("BEGIN");	
	$data=sql_create_array(__FUNCTION__,func_get_args());
	unset($data["anno"]);
	unset($data["numero"]);
	$sql_string = build_update_string($db->prefix . "gara",$data," WHERE f_pub_anno = " .  $anno . " AND f_pub_numero = " . $numero );
	$result = $db->query($sql_string);

	
	if ($result === false)
	{
	   	if ($transaction) $db->query("ROLLBACK");
		return false;
	}
	else
	{
	   	if ($transaction) $db->query("COMMIT");
		return true;	
	}
}


/**
 * Aggiorno i dati principali di una gara
 * */
function update_gara($gid,$cig=null,$oggetto=null,$scelta_contraente=null,$importo=null,$importo_liquidato=null,
					 $data_inizio=null,$data_fine=null,$f_pub_anno=null,$f_pub_numero=null)
{
	global $db;
	$db->query("BEGIN");	
	$data=sql_create_array(__FUNCTION__,func_get_args());
	unset($data["gid"]);
	$sql_string = build_update_string($db->prefix . "gara",$data," WHERE gid = $gid");
	$result = $db->query($sql_string);
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$result=set_modified_bit_pubblicazione($f_pub_anno);
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	else
	{
		$db->query("COMMIT");
		return true;
	}
}

/**
 * Ricerca una o più ditte in base ad un identificativo o ad una ragione sociale
 * */
function search_ditte($identificativo,$ragione_sociale)
{
	global $db;
	$where_clausule = array();
	$where_string ="";
	if (!empty($identificativo))
		$where_clausule[] = " d.identificativo_fiscale LIKE '%" . $identificativo ."%'";
	
	if (!empty($ragione_sociale))
		$where_clausule[] = "d.ragione_sociale LIKE '%" . $ragione_sociale ."%'";

	if (count($where_clausule) != 0)
		$where_string = " WHERE " .  implode(" OR ", $where_clausule);
	
	//echo $where_string;
	$ditte = NULL;
	$ditte = $db->get_results("SELECT d.did, d.ragione_sociale, d.estera, d.identificativo_fiscale FROM " . $db->prefix . "ditta d " . $where_string);
	if ($ditte == NULL)
		return array();
	else
		return $ditte;
}



/**
 * Restituisce l'elenco di tutte le ditte
 * */
function get_ditte()
{
	global $db;
	
	$ditte = $db->get_results("SELECT d.did, d.ragione_sociale, d.estera, d.identificativo_fiscale FROM " . $db->prefix . 'ditta d WHERE d.dummy <> "Y" OR d.dummy IS NULL');
	if ($ditte == NULL)
		return array();
	else
	{
		return $ditte;
	}
	
}


/**
 * Restituisce l'elenco di tutte le ditte
 * */
function get_ditta($did)
{
	global $db;
	
	$ditta = $db->get_row("SELECT d.did, d.ragione_sociale, d.estera, d.identificativo_fiscale FROM " . $db->prefix . "ditta d WHERE d.did = " . $did);
	if ($ditta == NULL)
		return array();
	else
		return $ditta;
}

/**
 * Restituisce l'elenco di tutte le ditte
 * */
function get_ditta_by_cf($cf)
{
	global $db;
	
	$ditta = $db->get_row("SELECT d.did, d.ragione_sociale, d.estera, d.identificativo_fiscale FROM " . $db->prefix . 'ditta d WHERE d.identificativo_fiscale = "' . $cf . '"');
	if ($ditta == NULL)
		return false;
	else
		return $ditta;
}

/**
 * Permette di controllare se la ditta è utilizzata in qualche gare
 * */
function is_ditta_partecipante($did,$gid=NULL)
{
	global $db;
	$append = "";
	if ($gid != NULL)
		$append = " AND p.gid = " . $gid;
	$ditta = $db->get_row("SELECT r.did FROM " . $db->prefix . "raggruppamento r, " . $db->prefix . "partecipanti p WHERE r.did = " . $did . " AND r.pid = p.pid " . $append);	
	if ($ditta != NULL)
		return true;
		
	$ditta = $db->get_row("SELECT pa.did FROM " . $db->prefix . "part_ditta pa, " . $db->prefix . "partecipanti  p WHERE pa.did = " . $did . " AND p.pid = pa.pid " . $append);
	if ($ditta == NULL)
		return false;
	else
		return true;
}

/**
 * Inserisce una singola ditta nel database
 * */

function insert_ditta($identificativo_fiscale,$ragione_sociale,$estera)
{
	global $db;
	$db->query("BEGIN");
	//prepare automatically the data array picking parameters name
	$data=sql_create_array(__FUNCTION__,func_get_args());
	
	//build the insert string semi-automatically
	$sql_string = build_insert_string($db->prefix . "ditta",$data);
	$result = $db->query($sql_string);
	if ($result === FALSE)
		$db->query("ROLLBACK");
	else
		$db->query("COMMIT");

	if ($result)
		return $db->insert_id;
	else
		return false;	
}


/**
 *  Permette di aggiornare i dati di una ditta
 * 
 * @param int $id                     Description
 * @param string $identificativo_fiscale Description
 * @param string $ragione_sociale        Description
 * @param string $estera                 Description
 * 
 * @return Type    Description				
 */
function update_ditta($id,$identificativo_fiscale=null,$ragione_sociale=null,$estera=null)
{
	global $db;
	$db->query("BEGIN");

	//prepare automatically the data array picking parameters name
	$data=sql_create_array(__FUNCTION__,func_get_args());
	unset($data["id"]);

	//build the update string semi-automatically
	$sql_string = build_update_string($db->prefix . "ditta",$data," WHERE did = $id");
	$result = $db->query($sql_string);
	$db->query("COMMIT");

	if ($result)
		return $result;
	else
		return false;	
}

function get_gara_from_pid($pid)
{
    global $db;
	$pid = $db->escape($pid*1);
	
	$gara = $db->get_row("SELECT g.gid, g.cig, g.oggetto, g.scelta_contraente, " .
						 "g.importo, g.importo_liquidato,DATE_FORMAT( g.data_inizio,'%d/%m/%Y') as data_inizio, ".
						 "DATE_FORMAT( g.data_fine,'%d/%m/%Y') as data_fine, g.f_pub_anno, g.f_pub_numero " .
						 "FROM " . $db->prefix . "gara g, " . $db->prefix . "partecipanti p WHERE  p.pid = $pid AND p.gid = g.gid" );
	

	if ($gara == NULL)
		return array();
	else
		return $gara;
}

function update_aggiudicatario($gid,$pid,$transaction=true)
{
	global $db;
	if ($transaction)
		$db->query("BEGIN");
		
	$result = $db->query("UPDATE " . $db->prefix . 'partecipanti SET aggiudicatario = "N" WHERE gid = ' . $gid );	
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	
    $result = $db->query("UPDATE " . $db->prefix . 'partecipanti SET aggiudicatario = "Y" WHERE pid = ' . $pid . ' AND gid = ' . $gid );
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	$result = get_gara($gid);
	$result = set_modified_bit_pubblicazione($result->f_pub_anno);
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	else
	{
		if ($transaction)
		{	$db->query("COMMIT");
		}
		return true;
	}
}

function update_aggiudicatari($gid,$pids,$transaction=true)
{
	global $db;
	if ($transaction)
		$db->query("BEGIN");
		
	$result = $db->query("UPDATE " . $db->prefix . 'partecipanti SET aggiudicatario = "N" WHERE gid = ' . $gid );	
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	$pids = implode(",",$pids);
    $result = $db->query("UPDATE " . $db->prefix . 'partecipanti SET aggiudicatario = "Y" WHERE pid IN (' . $pids . ') AND gid = ' . $gid );
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	$result = get_gara($gid);
	$result = set_modified_bit_pubblicazione($result->f_pub_anno);
	if ($result === false)
	{
		if ($transaction)
			$db->query("ROLLBACK");
		return false;
	}
	else
	{
		if ($transaction)
		{	$db->query("COMMIT");
		}
		return true;
	}
}

function get_gare_by_ditta($did)
{
    $sql = 'select * from avcpman_ditta d, avcpman_part_ditta pd, avcpman_partecipanti p, avcpman_gara g where d.did= 48 AND d.did = pd.did AND p.pid=pd.pid AND g.gid = p.gid;';
    
}
function get_partecipanti($gid)
{
    global $db;
	$raggruppamenti=array();
	$ditte=array();
	$ditte = $db->get_results("SELECT  p.aggiudicatario, p.pid, d.did, d.ragione_sociale, d.estera, d.identificativo_fiscale FROM " . $db->prefix . "ditta d , " . $db->prefix . "part_ditta pd, " . $db->prefix . "partecipanti p  WHERE p.gid = " . $gid . ' AND p.tipo = "D" AND p.pid = pd.pid AND pd.did = d.did');
	$ditte_raggruppamento = $db->get_results("SELECT p.aggiudicatario, p.pid, r.ruolo, d.did, d.estera, d.identificativo_fiscale, d.ragione_sociale" .
									   " FROM " . $db->prefix . "partecipanti p LEFT JOIN " . $db->prefix . "raggruppamento r ON  p.pid = r.pid ".
									   " LEFT JOIN " . $db->prefix . "ditta d  ON  d.did = r.did" .
									   " WHERE p.gid = $gid " . ' AND p.tipo = "R" ' .
									   " ORDER BY p.pid");
	
	if (!is_null($ditte_raggruppamento ))
	foreach ($ditte_raggruppamento as $r_ditta)
	{
		if (!isset($raggruppamenti[$r_ditta->pid]))
		{
		    $raggruppamenti[$r_ditta->pid] = array();
		}
		if (!is_null($r_ditta->did))
				$raggruppamenti[$r_ditta->pid][]=$r_ditta;
	}
	
	if ($ditte == NULL)
		$ditte= array();

    return array("ditte"=>$ditte,"raggruppamenti"=>$raggruppamenti);	
}


/**
 * Permette di aggiungere un raggruppamento alla gara specificata
 * @param string gid Identificativo della gara
 * */
function insert_raggruppamento($gid)
{
	global $db;
	
	$db->query("BEGIN");
	$result=$db->query(build_insert_string($db->prefix . "partecipanti",array("gid"=>$gid,"tipo"=>"R")));
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$pid=$db->insert_id;
	$result = get_gara($gid);	
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	if (!set_modified_bit_pubblicazione($result->f_pub_anno))
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$db->query("COMMIT");
	
	return $pid;
}

function insert_or_update_user_info($id, $name=null, $access_password=null, $user_roles=null, $transaction=true)
{
	global $db;
	if ($transaction)
		$db->query("BEGIN");
	
    
	//build the insert string semi-automatically
	$sql_string = build_insert_string($db->prefix . "ditta",$data);
	$result = $db->query("INSERT INTO " . $db->prefix . 'files 	(content, ctype,anno,numero) ' .
						' VALUES ("' . $content . '","' . $tipo . '",' . $anno . ','. $numero . ' )');	
	if ($transaction)
		if ($result === FALSE)
			$db->query("ROLLBACK");
		else
			$db->query("COMMIT");

	if ($result)
		return $db->insert_id;
	else
		return false;	
}

function delete_partecipante($pid,$type)
{
	global $db;
	if ($type == "R")
	{
		$result = $db->query("DELETE FROM " . $db->prefix . "raggruppamento ".	
						   " WHERE " . $db->prefix . "raggruppamento.pid = $pid ");
		if ($result === FALSE)
		{
			$db->query("ROLLBACK");
			return false;
		}
	}
	else
	{
		$result = $db->query("DELETE FROM " . $db->prefix . "part_ditta ".	
						   " WHERE " . $db->prefix . "part_ditta.pid = $pid ");
		if ($result === FALSE)
		{
			$db->query("ROLLBACK");
			return false;
		}
	}
	
	$result = $db->query("DELETE FROM " . $db->prefix . "partecipanti ".	
						   " WHERE " . $db->prefix . "partecipanti.pid = $pid ");
    
	$result = $db->get_row("SELECT p.gid FROM " . $db->prefix . "partecipanti p WHERE p.pid = " . $pid);	
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	if (!set_modified_bit_pubblicazione(1))
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$db->query("COMMIT");
	return true;

}

function delete_ditta_raggruppamento($pid,$did)
{
	global $db;
	$db->query("BEGIN");
	
	$result = $db->get_row("SELECT p.gid FROM " . $db->prefix . "partecipanti p WHERE p.pid = " . $pid);
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$result = get_gara($result->gid);
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	if (!set_modified_bit_pubblicazione($result->f_pub_anno))
	{
		$db->query("ROLLBACK");
		return false;
	}	
	
	$result = $db->query("DELETE FROM " . $db->prefix . "raggruppamento ".	
						   " WHERE " . $db->prefix . "raggruppamento.pid = $pid AND " . $db->prefix ."raggruppamento.did = $did");
	
	
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
					   
    	
    if (!$result)
	{
		$db->query("ROLLBACK");
		return false;
	}
    else
	{
		$db->query("COMMIT");
		return true;
	}
}

/**
 * Rimuove un raggruppamento partecipante ad una gara, con i suoi partecipanti
 * @param int $pid Identificatore del raggruppamento partecipante da rimuovere
 * */
function delete_raggruppamento($pid)
{
	global $db;
	$db->query("BEGIN");
	$result = $db->get_row("SELECT p.gid FROM " . $db->prefix . "partecipanti p WHERE p.pid = " . $pid);	
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	if (!set_modified_bit_pubblicazione($result->f_pub_anno))
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$result = $db->query("DELETE FROM " . $db->prefix . "raggruppamento ".	
						   " WHERE " . $db->prefix . "raggruppamento.pid = $pid ");
    if ($result === FALSE)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$result = $db->query("DELETE FROM " . $db->prefix . "partecipanti ".	
						   " WHERE " . $db->prefix . "partecipanti.pid = $pid ");
    
	
    if (!$result)
	{
		$db->query("ROLLBACK");
		return false;
	}
    else
	{
		$db->query("COMMIT");
		return true;
	}
}

/**
 * Permette di aggiungere un partecipante ad una gara
 * 
 * @param unknown $gid   Description
 * @param unknown $tipo  Description
 * @param unknown $did   Description
 * @param unknown $ruolo Description
 * @param unknown $pid   Description
 * 
 * @return Type    Description
 */
function add_partecipante($gid,$tipo,$did,$ruolo=null,$pid=null)
{
	global $db;
	$db->query("BEGIN");	
	
		
	//need to verify if the participation is already inserted
	if ($tipo == "D")
	{
		$check_pid = $db->get_var("SELECT p.pid FROM " . $db->prefix . "partecipanti p, " . $db->prefix . "part_ditta pd WHERE pd.did = $did AND p.gid = $gid AND p.pid = pd.pid");
		if ($check_pid)
			return false;
	}
	else if ($tipo == "R")
	{
		$check_pid = $db->get_var("SELECT p.pid FROM " . $db->prefix . "partecipanti p, " . $db->prefix . "raggruppamento r WHERE r.did = $did AND p.gid = $gid AND p.pid = r.pid");
		
		if ($ruolo === null)
				return false;
		if ($check_pid)
			return false;
		
	}
	
	//if we don't have a partecipant identifier then create e new partecipant
	if ($pid === null)
	{
		$result=$db->query(build_insert_string($db->prefix . "partecipanti",array("gid"=>$gid,"tipo"=>$tipo)));
		if ($result === false)
		{
			$db->query("ROLLBACK");
			return false;
		}
		$pid=$db->insert_id;
	}
	
	//if the type is "R" that stand for raggruppamento, then we add a company to the group
	if ($tipo == "R")
	{
		$result=$db->query(build_insert_string($db->prefix . "raggruppamento",
						       array("pid"=>$pid,"did"=>$did,
							     "ruolo"=>$ruolo)));
		if ($result === false)
		{
			$db->query("ROLLBACK");
			return false;
		}
	}
	else if ($tipo == "D")
	//else if the type is "D" (ditta) we add a single partecipant to the contest
	{
		$result=$db->query(build_insert_string($db->prefix . "part_ditta",
						       array("pid"=>$pid,"did"=>$did)));
		if ($result === false)
		{
			$db->query("ROLLBACK");
			return false;
		}
	}
	
	$result = get_gara($gid);	
	if ($result === false)
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	if (!set_modified_bit_pubblicazione($result->f_pub_anno))
	{
		$db->query("ROLLBACK");
		return false;
	}
	
	$db->query("COMMIT");    
	return true;
}


function get_settings($keys=array())
{
		global $db;
		$return = array();
		if (count($keys) > 0)
		{
				$where = 'skey ="' . implode('" OR skey="',$keys) . '"';
				$results = $db->get_results("SELECT skey, svalue FROM " .$db->prefix . "settings WHERE " . $where);
				//	echo "SELECT skey, svalue FROM " .$db->prefix . "settings WHERE " . $where;
				if (is_null($results))
						return false;
				foreach ($results as $row)
				{
						$return[$row->skey]=$row->svalue;
				}
		}
		return $return;
		
}

function set_settings($keys_value=array())
{
		global $db;
		$return = array();
		$db->query("BEGIN");
		
		$result = false;
		foreach ($keys_value as $key=>$value)
		{
			$value = sql_escape($db->prefix . 'settings','svalue',$value);
			$result = $db->query("UPDATE " . $db->prefix . 'settings SET svalue = "' . $value . '" WHERE skey = "' . $key .'"');
			if ($result === false)
			{
				$db->query("ROLLBACK");
				return false;
			}		
		}

		$db->query("COMMIT");
		return true;
		
}

/**
 * Inserisce un file nel database
 * */

function insert_file($content,$tipo,$anno,$numero=NULL,$filename=NULL,$transaction=true)
{
	global $db;
	if ($transaction)
		$db->query("BEGIN");
	//prepare automatically the data array picking parameters name
	$data=sql_create_array(__FUNCTION__,func_get_args());
	$content = $db->escape($content);
	//build the insert string semi-automatically
	//$sql_string = build_insert_string($db->prefix . "ditta",$data);
	$result = $db->query("INSERT INTO " . $db->prefix . 'files 	(content, ctype, anno, numero, filename) ' .
						' VALUES ("' . $content . '","' . $tipo . '",' . $anno . ','. $numero . ',"' . $filename . '")');	
	if ($transaction)
		if ($result === FALSE)
			$db->query("ROLLBACK");
		else
			$db->query("COMMIT");

	if ($result)
		return $db->insert_id;
	else
		return false;	
}


function get_file_filename($fid)
{
    global $db;
	//build the insert string semi-automatically
	$result = $db->get_row('SELECT f.filename FROM ' . $db->prefix . 'files f WHERE f.fid = ' . $fid  );	

	if ($result)
	{
		return $result->filename;
	}
	else
	{
		return false;
	}
}
function get_file($fid)
{
	global $db;
	//build the insert string semi-automatically
	$result = $db->get_row('SELECT f.content FROM ' . $db->prefix . 'files f WHERE f.fid = ' . $fid  );	

	if ($result)
	{
		return $result->content;
	}
	else
	{
		return false;
	}
}


function get_last_filename($anno,$numero)
{
	global $db;
	//build the insert string semi-automatically
	$result = $db->get_row('SELECT f.filename FROM ' . $db->prefix . 'files f INNER JOIN (SELECT MAX(fid) as maxfid FROM ' . $db->prefix . 'files  WHERE anno = ' . $anno . ' AND numero = ' . $numero . ' ) f1 on (f.fid = f1.maxfid) WHERE f.anno = ' . $anno . ' AND f.numero = ' . $numero );	

	if ($result)
	{
		return $result->filename;
	}
	else
	{
		return false;
	}
}

function get_last_file($anno,$numero)
{
	global $db;
	//build the insert string semi-automatically
	$result = $db->get_row('SELECT f.content FROM ' . $db->prefix . 'files f INNER JOIN (SELECT MAX(fid) as maxfid FROM ' . $db->prefix . 'files  WHERE anno = ' . $anno . ' AND numero = ' . $numero . ' ) f1 on (f.fid = f1.maxfid) WHERE f.anno = ' . $anno . ' AND f.numero = ' . $numero );	

	if ($result)
	{

			return $result->content;
	}
	else
	{
		return false;
	}
}


function get_files_list($anno,$numero)
{
	global $db;
	//build the insert string semi-automatically
	$result = $db->get_results('SELECT f.fid FROM ' . $db->prefix . 'files f  WHERE f.anno = ' . $anno . ' AND f.numero = ' . $numero  . ' ORDER BY f.fid');	

	if ($result)
	{
			return $result;
	}
	else
	{
		return false;
	}
}


function delete_files($anno,$numero,$transaction=true)
{
	global $db;
	//build the insert string semi-automatically

	if ($transaction)	$db->query("BEGIN");
	
	$result = $db->query('DELETE FROM ' . $db->prefix . 'files WHERE anno = ' . $anno . ' AND numero = ' . $numero);	

	if ($result === FALSE)
	{
		if ($transaction)  $db->query("ROLLBACK");
		return false;
	}
	else
	{
		if ($transaction)	$db->query("COMMIT");
		return true;
	}
}

function set_modified_bit_pubblicazione($anno,$bit=1)
{
	global $db;
	$bit = $bit * 1;
	//prepare automatically the data array picking parameters name
	$data=sql_create_array(__FUNCTION__,func_get_args());

	$result = $db->query("UPDATE " . $db->prefix . 'pubblicazione ' .
						' SET modified = ' . $bit. '  WHERE anno = ' . $anno);	
	

	if ($result === false)
		return false;
	else
		return true;	
}

function start_transaction()
{
	global $db;
	$db->query("BEGIN");
}

function commit_transaction()
{
	global $db;
	$db->query("COMMIT");
}

function rollback_transaction()
{
	global $db;
	$db->query("ROLLBACK");
}



?>
