<html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
        <div class="content-width">
			<div class="left-float container-menu">
				{include file="menu.tpl"}
			</div>
            <div class="container-main">
                <h2>Gara</h2>            
        {$p = ['gid'=> $gara->gid]}
		<div class="message">Modifica partecipanti</div>
                    <div class="box recap-ditta">
							<div class="label"><span class="left">Anno:</span><span class="right">{$gara->f_pub_anno}</span></div>
							<div class="label"><span class="left">Codice Identificativo Gara: </span><span class="right">{$gara->cig}</span></div>
							<div class="label"><span class="left">Oggetto: </span><span class="right">{$gara->oggetto}</span></div>
							<div class="label"><span class="contraente-type left">Tipo di contraente: </span><span class="right">{$contest_type[$gara->scelta_contraente]}</span></div>
							<div class="label"><span class="left">Importo di aggiudicazione: </span><span class="right">&#8364; {$gara->importo}</span></div>
							<div class="label"><span class="left">Importo somme liquidate: </span><span class="right">&#8364; {$gara->importo_liquidato}</span></div>
							<div class="label"><span class="left">Data di inizio lavori: </span><span class="right">{$gara->data_inizio}</span></div>
							<div class="label"><span class="left">Data di fine lavori: </span><span class="right">{$gara->data_fine}</span></div>
					</div>
					<div class="add-partecipant-container">
						<a id="add-partecipant-ditta" href="{urlarea action="add_ditta" parameters="{$gara->gid}"}">Aggiungi<br/>ditta</a>
						<a id="add-partecipant-raggruppamento" href="{urlarea action="add_raggruppamento" parameters="{$gara->gid}"}">Aggiungi<br/>raggruppamento</a>
						<hr class="clear" style="display: none"/>
					</div>
		{form action="save" parameters=$p}		
		
		<table class="partecipants-table">
			<thead>
				<tr>
					<th colspan="4">Partecipanti</th>
				</tr>
				<tr>
					<th>N.</th>
					<th>Ditta</th>
					<th>Idenfiticativo<br/>fiscale</th>
					<th>Aggiudicatario</th>
				</tr>
			</thead>
			<tbody>
			{$indice=1}
			{foreach $partecipanti["ditte"] as $ditta}
                <tr>
                    <td>{$indice++}</td>
                    <td>{$ditta->ragione_sociale}</td>
					<td>{$ditta->identificativo_fiscale}</td>
					<td><input type="radio" name="aggiudicatario" value="{$ditta->pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/></td>
                </tr>
            {/foreach}
			{foreach $partecipanti["raggruppamenti"] as $pid=>$rpartecipanti}
				<tr>
					<td rowspan="{$rpartecipanti|@count + 1}">
						{$indice++}
						
					</td>
					<td class="raggruppamento-header" colspan="3">
					Raggruppamento
					<a class="add-ditta-raggruppamento" href="{urlarea area="avcpman/gare/edit/add_ditta_raggruppamento" parameters="{$pid}"}">
						Aggiungi ditta
					</a>
				</td></tr>
				{foreach $rpartecipanti as $ditta}
					<tr class="raggruppamento">
						
						<td>{$ditta->ragione_sociale}</td>
						<td>{$ditta->identificativo_fiscale}</td>
						{if $ditta@first}<td rowspan="{$ditta@total}">
							<input type="radio" name="aggiudicatario" value="{$pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/>
						</td> {/if}
					</tr>
				{/foreach}				
            {/foreach}
			</tbody>
		</table>
		<button type="submit" name="submit" value="undo">Annulla</button>
		<button type="submit" name="submit" value="save">Salva</button>		
		{/form}
		            </div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
</html>