<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
		<link href="resources/css/ui-absolution/absolution.css" rel="stylesheet" type="text/css">
		<link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="avcpman">		
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="avcp\menu.tpl"}
			</div>
			<div class="container-main">
				<h2>Gare</h2>
		{$p = ['gid'=> $gara]}
		
		<p>
			<div class="message">Ricerca ditta e aggiungila alla gara</div>
			<div class="box">
				<label for="ditta_search"><span>Ricerca ditta:</span>			
					<input type="text" id="ditta_search" name="ditta_search" value=""/>
				</label>
				<div class="recap-ditta">
					<p id="search_result">				
					</p>
				</div>
				{form id="add-ditta" action="add" parameters=$p}
				{ifarea value="avcpman/gare/edit/add_ditta_raggruppamento"}
					{$p['pid']=$partecipante}
					<label for="gare_edit_ruolo_type"><span>Ruolo ditta:</span>
						{html_options name="gare_edit_ruolo_type" options=$ruolo selected=1 separator="<br/>"}
					</label>
				{/ifarea}<br/>
					<input type="hidden" id="gara_edit_search_did" name="gara_edit_search_did" value="-1" />
					<div class="button-container">
						<button class="save" type="submit" id="ditta_edit_add" name="submit" value="add" disabled>Aggiungi</button>
						<button class="undo" type="submit" name="submit" value="undo">Annulla</button>
					</div>
				{/form}
			</div>
		</p>
		<p class="centered"><em>oppure</em></p>
		<p>						
			{form id="edit-ditta" action="insert_and_add" parameters=$p}
			<div class="message">Inserisci nuova ditta e aggiungila alla gara</div>
                <div class="box">
					<label for="ditta_edit_ragione_sociale"><span>Ragione sociale</span>
						<input type="text" id="ditta_edit_ragione_sociale" name="ditta_edit_ragione_sociale" value="{$ditta->ragione_sociale}"/>
                        <div class="inline-error"></div>
					</label>
				<div class="radio-estera-italiana">
					{html_radios name="ditta_edit_estero" options=$estero selected=$ditta->estera separator=""}
				</div>
				<label for="ditta_edit_identificativo"><span>Identificativo fiscale</span>
					<input type="text" id="ditta_edit_identificativo" name="ditta_edit_identificativo" value="{$ditta->identificativo_fiscale}"/>
                    <div class="inline-error"></div>
				</label>
				{ifarea value="avcpman/gare/edit/add_ditta_raggruppamento"}
				    {$p['pid']=$partecipante}
					<label for="gare_edit_ruolo_type"><span>Ruolo ditta:</span>
						{html_options name="gare_edit_ruolo_type" options=$ruolo selected=1 separator=""}
					</label>
				{/ifarea}<br/>
				<div class="button-container">
					<button class="save" type="submit" id="ditta_edit_insert_and_add" name="submit" value="add">Inserisci</button>					
					<button class="undo" type="submit" name="submit" value="undo">Annulla</button>
				</div>
				{/form}
			</div>
		</p>
		<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
	<script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
	<script src="control/reserved/avcpman/gare/edit/add_ditta.js?v=0003"></script>
	<script src="resources/js/support.js?v=0001"></script>
	<script src="resources/js/bootstrap-tour-standalone.min.js"></script>
	<script src="control/reserved/avcpman/ditte/edit.js?v=0001"></script>	
</html>