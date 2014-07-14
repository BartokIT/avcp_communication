<html>
    <head>
	<title>Comunicazioni AVCP</title>
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Ditta</h1>
        {$p = ['gid'=> $gara->gid]}
        Anno: {$gara->f_pub_anno}<br/>
        Codice Identificativo Gara: {$gara->cig}<br/>
		Oggetto: {$gara->oggetto}<br/>
        Tipo di contraente: {$contest_type[$gara->scelta_contraente]}<br/>
        Importo di aggiudicazione: {$gara->importo} <br/>           
	    Importo somme liquidate: {$gara->importo_liquidato} <br/>
        Data di inizio lavori: {$gara->data_inizio} <br/>
		Data di fine lavori: {$gara->data_fine} <br/>
		
		<a href="{urlarea action="add_ditta" parameters="{$gara->gid}"}">+ ditta</a>
		<a href="{urlarea action="add_raggruppamento" parameters="{$gara->gid}"}">+ raggruppamento</a>
		<table>
			<th>Partecipanti</th>
			{$indice=1}
			{foreach $partecipanti["ditte"] as $ditta}
                <tr>
                    <td>{$indice++}</td>
                    <td>{$ditta->ragione_sociale}</td>
					<td>{$ditta->identificativo_fiscale}</td>
                </tr>
            {/foreach}
			{foreach $partecipanti["raggruppamenti"] as $pid=>$rpartecipanti}
				<tr><td colspan="3">
					Raggruppamento {$indice++}
					<a href="{urlarea area="gare/edit/add_ditta_raggruppamento" parameters="{$pid}"}">
						+
					</a>
				</td></tr>
				{foreach $rpartecipanti as $ditta}
					<tr>
						{if $ditta@first}<td rowspan="{$ditta@total}"></td> {/if}
						<td>{$ditta->ragione_sociale}</td>
						<td>{$ditta->identificativo_fiscale}</td>				
					</tr>
				{/foreach}
            {/foreach}
		</table>
        {include file="footer.tpl"}
    </body>
</html>