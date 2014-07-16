<html>
    <head>
    <title>Comunicazioni AVCP</title>
	<link href="resources/css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Nuova pubblicazione</h1>		
		<p>
			Inserisci pubblicazione {$anno}
			{$p = ['pubblicazione_edit_anno'=>$anno]}
			{form action="add" parameters=$p}
				<label for="anno">Titolo
					<input type="text" name="pubblicazione_edit_titolo" value=""/><br/>
				</label>					
					<label for="name">Abstract</label>
					<input type="text" name="pubblicazione_edit_abstract"/><br/>
					<label for="name">Data pubblicazione</label>
					<input type="text" name="pubblicazione_edit_pubblicazione"/><br/>
					<label for="name">Data aggiornamento</label>
					<input type="text" name="pubblicazione_edit_aggiornamento"/><br/>
					<label for="name">Url di pubblicazione</label>
					<input type="text" name="pubblicazione_edit_url"/><br/>
					<button type="submit" name="submit" value="undo">Annulla</button>
            {ifarea value="pubblicazioni/edit"}
                <button type="submit" name="submit" value="save">Salva</button>
            {/ifarea}
            {ifarea value="pubblicazioni/add_pubblicazione"}
                <button type="submit" name="submit" value="save">Inserisci</button>
            {/ifarea}
			{/form}
		</p>
        {include file="footer.tpl"}
		<script src="resources/js/jquery-1.10.2.js"></script>
		<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    </body>
</html>