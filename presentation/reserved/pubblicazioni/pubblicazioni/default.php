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
		<script src="<?= _i("avcpman_years.js")?>"></script>
		<script src="<?= _i("avcpman_publications.js")?>"></script>		
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
	 <!-- HEADER -->
<?php include("presentation/header.php"); ?>
<!-- CONTENT -->
	        <div id="content" > <!-- [content] -->
		        <div class="left">
						<table id="year_list" class="list" border="1"  cellspacing="0" width="200">
								<tbody>
								<tr><td id="new-distinct" colspan="4"><a id="new_year" href="#"> Nuovo anno ... </td></tr>
							   <?php
							   //Mostro gli anni
							    /*foreach ( $p['years'] as $years)
							    {
										echo '<tr class="year"><td><a href="' . _l("pubblicazioni","pubblicazioni").'&amp;anno=' . $years->year . '">' . $years->year .'</td></tr>';
								}*/							   
								?>
							   </tbody>
						</table>							   
				</div>
		        <div class="right" style="width: 80%">
					<?php if (isset($p['selected_year'])): ?>
						<div class="publications_list">
							 Pubblicazioni anno <?= $p['selected_year']?>
							 <table id="publications_list" class="list" >
							   <tbody/>
								  <?php
									   //Mostro le pubblicazioni
									   /*foreach ($p['publications'] as $publication)
									   {
											echo '<tr><td>' . $publication->numero .'</td><td>' . $publication->titolo . '</td><td><a href="#" class="edit_publication">e</a></td><td><a href="#" class="delete_publication">x</a></td></tr></tr>';
									   }*/
								  ?>
							 </table>
							 <a id="new_publication" href="#">Aggiungi pubblicazione</a>
						</div>
						<input type="checkbox" name="make_index" id="make_index"/><label for="make_index">Genera indice </label><br/>
						<div id="index_url_container">
							  <input type="text" name="index_url" id="index_url" value=""/><label for="index_url">URL dell'indice</label>
						</div>
						<div class="contest_list">
							 Gare presenti nella pubblicazione n. <span id="n_pubblicazione"/>
							 <table id="contest_list" class="list" >
							   <tbody/>
								  <?php
									   //Mostra le gare
								  ?>
							 </table>
							 <a id="new_contest" href="#">Aggiungi gara</a>
						</div>						 
					<?php endif; ?>
					
				</div>			   
	        </div> <!-- [/content] -->
			
			
			<!-- DIALOGO BOX -->
			
			<div class="invisible" id="new-year-form" title="Inserisci nuovo anno">
				<p class="validateTips">Inserire il nuovo anno</p>			   
				<form>
						<fieldset>
						  <label for="name">Anno</label>
						  <input type="text" name="anno" id="anno" class="text ui-widget-content ui-corner-all"/>
						</fieldset>
				</form>
			 </div>
		  <div class="invisible" id="new-publication-form" title="Inserisci nuova pubblicazione">
				<p class="validateTips">Inserire i dati della nuova pubblicazione</p>			   
				<form>
						<fieldset>
						  <label for="name">Titolo</label>
						  <input type="hidden" name="anno" id="anno_pubblicazione" value="<?= $p["selected_year"]?>" />
						  <input type="text" name="titolo_pubblicazione" id="titolo_pubblicazione" class="text ui-widget-content ui-corner-all"/><br/>
						  <label for="name">Abstract</label>
						  <input type="text" name="abstract_pubblicazione" id="abstract_pubblicazione" class="text ui-widget-content ui-corner-all"/><br/>
						  <label for="name">Data pubblicazione</label>
						  <input type="text" name="data_pubblicazione" id="data_pubblicazione" class="text ui-widget-content ui-corner-all"/><br/>
						  <label for="name">Data aggiornamento</label>
						  <input type="text" name="data_aggiornamento" id="data_aggiornamento" class="text ui-widget-content ui-corner-all"/><br/>
						  <label for="name">Url di pubblicazione</label>
						  <input type="text" name="url_pubblicazione" id="url_pubblicazione" class="text ui-widget-content ui-corner-all"/>			  
						</fieldset>
				</form>
		  </div>
	 <?php include("presentation/footer.php"); ?>
    </body>
</html>
