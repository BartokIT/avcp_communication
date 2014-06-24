<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Gestione Posta in Uscita</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("modernizr.js","2.6.2") ?>"></script>
		<script src="<?= _i("jquery.js","1.10.2") ?>"></script>
		<script src="<?= _i("jquery-ui.js","1.10.3")?>"></script>		
	    <script src="<?= _i("jquery.ui.datepicker-it.js","1.10.3")?>"></script>
		<script src="<?= _i("jquery.jeditable.js")?>"></script>
		<script src="<?= _i("clputils.js") ?>"></script>
	<!--	<script src="<?= _i("avcpman_years.js")?>"></script>
		<script src="<?= _i("avcpman_publications.js")?>"></script>		-->
		<script src="<?= _i("avcpman_partecipants.js")?>"></script>
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
	 <!-- HEADER -->
<?php include("presentation/header.php"); ?>
<!-- CONTENT -->
	        <div id="content" > <!-- [content] -->
		        <div class="left">						   
				</div>
		        <div class="right" style="width: 80%">
						<div class="publications_list">
							 Gara per l'anno <?= $p['anno']?>
							 
							<form action="<?php echo  INDEX;?>" method="get">
								<table>
									<tbody>
									<tr>
										<td><label for="cig">Codice Identificativo Gara<br/><em>(rilasciato da AVCP)</em></label></td>
										<td><input type="text" name="cig" id="cig" class="text ui-widget-content ui-corner-all" value="<?= isset($p["cig"])?$p["cig"] : "" ?>"/><br/></td>
									</tr>
									<tr>
										<td><label for="subject">Oggetto</label></td>
										<td><input type="text" name="subject" id="subject" class="text ui-widget-content ui-corner-all" value="<?= isset($p["subject"])?$p["subject"] : "" ?>"/><br/></td>
									</tr>
									<tr>
										<td><label for="contest_type">Tipo di contraente</label></td>
										<td>
											<select name="contest_type" id="contest_type" class="text ui-widget-content ui-corner-all"/>
												<option value="1" <?= html_selected(@$p["contest_type"],1) ?>>Procedura aperta</option>
												<option value="2" <?= html_selected(@$p["contest_type"],2) ?>>Procedura ristretta</option>
												<option value="3" <?= html_selected(@$p["contest_type"],3) ?>>Procedura negoziata previa pubblicazione del bando</option>
												<option value="4" <?= html_selected(@$p["contest_type"],4) ?>>Procedura negoziata senza previa pubblicazione del bando</option>
												<option value="5" <?= html_selected(@$p["contest_type"],5) ?>>Dialogo competitivo</option>
												<option value="6" <?= html_selected(@$p["contest_type"],6) ?>>Procedura negoziata senza previa indizione di gara art. 221 D.Lgs. 163/2006</option>
												<option value="7" <?= html_selected(@$p["contest_type"],7) ?>>Sistema dinamico di acquisizione</option>
												<option value="8" <?= html_selected(@$p["contest_type"],8) ?>>Affidamento in economia - cottimo fiduciario</option>
												<option value="17" <?= html_selected(@$p["contest_type"],17) ?>>Affidamento diretto ex art. 5 della Legge n. 381/91</option>
												<option value="21" <?= html_selected(@$p["contest_type"],21) ?>>Procedura ristretta derivante da avvisi con cui si indice la gara</option>
												<option value="22" <?= html_selected(@$p["contest_type"],22) ?>>Procedura negoziata derivante da avvisi con cui si indice la gara</option>
												<option value="23" <?= html_selected(@$p["contest_type"],23) ?>>Affidamento in economia - Affidamento diretto</option>
												<option value="24" <?= html_selected(@$p["contest_type"],24) ?>>Affidamento diretto a societ&agrave; in house</option>
												<option value="25" <?= html_selected(@$p["contest_type"],25) ?>>Affidamento diretto a societ&agrave; raggruppate/consorziate o controllate nelle concessioni di LL.PP.</option>
												<option value="26" <?= html_selected(@$p["contest_type"],26) ?>>Affidamento diretto in adesione ad accordo quadro/convenzione</option>
												<option value="27" <?= html_selected(@$p["contest_type"],27) ?>>Confronto competitivo in adesione ad accordo quadro/convenzione</option>
												<option value="28" <?= html_selected(@$p["contest_type"],28) ?>>Procedura ai sensi dei regolamenti degli organi costituzionali</option>												
											</select>
										</td>
									</tr>
									<tr>
										<td><label for="amount">Importo di aggiudicazione</label></td>
										<td><input type="text" name="amount" id="amount" value="<?= isset($p["amount"])?$p["amount"]:"" ?>" class="text ui-widget-content ui-corner-all"/><br/></td>
									</tr>
									<tr>
										<td><label for="payed_amount">Importo somme liquidate</label></td>
										<td><input type="text" name="payed_amount" id="payed_amount" value="<?= isset($p["payed_amount"])?$p["payed_amount"]:""?>" class="text ui-widget-content ui-corner-all"/><br/></td>
									</tr>
									<tr>
										<td><label for="job_start_date">Data di inizio lavori</label></td>
										<td><input type="text" name="job_start_date" id="job_start_date" value="<?= isset($p["job_start_date"])?$p["job_start_date"]:""?>" class="text ui-widget-content ui-corner-all"/><br/></td>
									</tr>
									<tr>
										<td><label for="job_end_date">Data di fine lavori</label></td>
										<td><input type="text" name="job_end_date" id="job_end_date" value="<?= isset($p["job_end_date"])?$p["job_end_date"]:"" ?>" class="text ui-widget-content ui-corner-all"/><br/></td>
									</tr>
									</tbody>								
								</table>
								<?php
									if (!isset($p["cig"])):
									foreach (_l_a("pubblicazioni","gare","insert_new") as $key=>$value)
									{
										echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
									}
									echo '<input type="hidden" name="f_pub_anno" value="'. $p['anno'] . '" />';
									echo '<input type="hidden" name="f_pub_numero" value="'. $p["numero"].'" />';
									echo '<input type="submit" name="insert" value="Inserisci" />';
									echo '<input type="hidden" name="nonce" value="' . get_nonce_value("new","gara") . '" />';
										
									else:
									//	echo '<input type="submit" name="save" value="Salva" />';
								?>
							</form>
							<table id="partecipants_list" class="list" >
								<tbody/>
								<?php
									 //Mostro le pubblicazioni
									 /*foreach ($p['publications'] as $publication)
									 {
										  echo '<tr><td>' . $publication->numero .'</td><td>' . $publication->titolo . '</td><td><a href="#" class="edit_publication">e</a></td><td><a href="#" class="delete_publication">x</a></td></tr></tr>';
									 }*/
								?>
								</table>
							<a id="new_single_partecipant" href="#">Aggiungi ditta</a><br/>
							<a id="new_group_partecipant" href="#">Aggiungi raggruppamento</a>
							<?php endif;?>
						</div>					
				</div>			   
	        </div> <!-- [/content] -->
			
			
			<!-- DIALOGO BOX -->
		  <div class="invisible" id="new_single_partecipant_form" title="Inserisci nuovo partecipante">
				<p class="validateTips">Aggiungi partecipante</p>			   
				<form>
						<fieldset>
						  
						  <label for="tipo_partecipante_singolo">Ricerca ditta</label><input type="text" id="tipo_partecipante_singolo" name="tipo_partecipante_singolo">
						</fieldset>
				</form>
		  </div>
	 <?php include("presentation/footer.php"); ?>
    </body>
</html>
