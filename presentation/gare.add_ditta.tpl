<html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
	<link href="resources/css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Gara</h1>
		{$p = ['gid'=> $gara]}
		
		<p>
			Ricerca ditta:
			
			<input type="text" id="ditta_search" name="ditta_search" value=""/><br/>
			
			<p id="search_result">				
			</p>
			{form action="add" parameters=$p}
			{ifarea value="gare/edit/add_ditta_raggruppamento"}
				{$p['pid']=$partecipante}
				{html_options name="gare_edit_ruolo_type" options=$ruolo selected=1 separator="<br/>"}
			{/ifarea}<br/>
				<input type="hidden" id="gara_edit_search_did" name="gara_edit_search_did" value="-1" />
				<button type="submit" name="submit" value="undo">Annulla</button>
				<button type="submit" id="ditta_edit_add" name="submit" value="add" disabled>Aggiungi</button>
			{/form}
		</p>
		<p>- oppure-</p>
		<p>
			Inserisci nuova ditta e aggiungila alla gara			
			{form action="insert_and_add" parameters=$p}			
				<input type="text" id="ditta_edit_ragione_sociale" name="ditta_edit_ragione_sociale" value="{$ditta->ragione_sociale}"/><br/>
				{html_radios name="ditta_edit_estero" options=$estero selected=$ditta->estera separator="<br/>"}        
				<input type="text" id="ditta_edit_identificativo" name="ditta_edit_identificativo" value="{$ditta->identificativo_fiscale}"/><br/>
				{ifarea value="gare/edit/add_ditta_raggruppamento"}
				    {$p['pid']=$partecipante}
					{html_options name="gare_edit_ruolo_type" options=$ruolo selected=1 separator="<br/>"}
				{/ifarea}<br/>
				<button type="submit" name="submit" value="undo">Annulla</button>
				<button type="submit" id="ditta_edit_insert_and_add" name="submit" value="add">Inserisci e Aggiungi</button>
			{/form}
		</p>
        {include file="footer.tpl"}
		<script src="resources/js/jquery-1.10.2.js"></script>
		<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
		<script src="control/avcpman/gare/edit/add_ditta.js"></script>
    </body>
</html>