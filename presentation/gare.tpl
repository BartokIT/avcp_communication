<!DOCTYPE html>
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
				<h2>Gare</h2>
				<div class="centered">Anno di gestione : <span class="year">{$year}</span></div>
				<a id="new-gara" href="{urlarea action="new_gara"}">Aggiungi gara</a><br/>
				<table>
					<thead>
					<tr>
						<th class="counter" style="width: 20px">N.</th>
						<th>Oggetto</th>
						<th style="width: 30px;font-size: 10px;text-align: center">Partecipanti</th>
						<th style="width: 90px;" colspan="3">Operazioni</th>					
					</tr>
					</thead>
					<tbody>
					{section name=gara loop=$gare}
						<tr>
							<td class="counter">{$smarty.section.gara.index + 1}</td>
							<td>{$gare[gara]->oggetto}</td>
							<td style="width: 30px;text-align: center">{$gare[gara]->partecipanti}</td>
							<td class="operations-size"><a class="edit" title="Modifica" href="{urlarea area="avcpman/gare" action="edit" parameters="{$gare[gara]->gid}"}">Modifica</a></td>
							<td class="operations-size"><a class="edit-partecipant" title="Modifica partecipanti" href="{urlarea area="avcpman/gare/edit_partecipanti"  parameters="{$gare[gara]->gid}"}">Modifica Partecipanti</a></td>
							<td class="operations-size"><a class="delete" title="Cancella" href="{urlarea action="delete"  parameters="{$gare[gara]->gid}"}">Cancella</a></td>
						</tr>
					{/section}
					</tbody>
				</table>
			</div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
</html>