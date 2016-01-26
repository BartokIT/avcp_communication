<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
	    <link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
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
				<div id="show-error" style="visibility:{if isset($error)}visible{else}hidden{/if}" class="error">{if isset($error)}{$error}{/if}</div>
				<div class="message">Modifica partecipanti</div>
				<div class="box recap-ditta">
						<div class="label"><span class="left">Anno:</span><span class="right">{$gara->f_pub_anno}</span></div>
						<div class="label"><span class="left">Codice Identificativo Gara: </span><span class="right">{$gara->cig}</span></div>
						<div class="label"><span class="left">Oggetto: </span><span class="right">{$gara->oggetto}</span></div>
						<div class="label contraente-type"><span class="left">Tipo di contraente: </span><span class="right">{$contest_type[$gara->scelta_contraente]}</span></div>
						<div class="label"><span class="left">Importo di aggiudicazione: </span><span class="right">&#8364; {$gara->importo}</span></div>
						<div class="label"><span class="left">Importo somme liquidate: </span><span class="right">&#8364; {$gara->importo_liquidato}</span></div>
						<div class="label"><span class="left">Data di inizio lavori: </span><span class="right">{$gara->data_inizio}</span></div>
						<div class="label"><span class="left">Data di fine lavori: </span><span class="right">{$gara->data_fine}</span></div>
				</div>
				<table class="partecipants-table">
					<thead>
						<tr>
							<th colspan="5">Partecipanti</th>
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
						{$p = ['pid'=> $ditta->pid,'gid'=> $gara->gid]}
						<tr>
							<td>{$indice++}</td>
							<td>{$ditta->ragione_sociale}</td>
							<td>{$ditta->identificativo_fiscale}</td>
							<td><input type="checkbox" name="aggiudicatario" value="{$ditta->pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{else} disabled="disabled"{/if}/></td>
						</tr>
					{/foreach}
					{foreach $partecipanti["raggruppamenti"] as $pid=>$rpartecipanti}
						<tr class="raggruppamento-header">
							<td rowspan="{$rpartecipanti|@count + 1}">
								{$indice++}						
							</td>
							<td colspan="3">
							Raggruppamento
						</td>
						</tr>
						{foreach $rpartecipanti as $ditta}
							{$pd= ['pid'=> $pid,'gid'=> $gara->gid,'did'=>$ditta->did]}
							<tr class="raggruppamento">	
								<td class="ragione-sociale">{$ditta->ragione_sociale} (<em>{$ruoli_raggruppamento[$ditta->ruolo]}</em>)</td>
								<td class="identificativo-fiscale">{$ditta->identificativo_fiscale}</td>
								{if $ditta@first}<td rowspan="{$ditta@total}">									
                                    <input type="checkbox" name="aggiudicatario" value="{$pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{else} disabled="disabled"{/if}/>
								</td> {/if}
							</tr>
						{/foreach}
					{/foreach}
					</tbody>
				</table>
			</div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
</html>