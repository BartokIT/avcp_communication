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
				{include file="menu.tpl"}
			</div>
			<div class="container-main">
				<h2>Gare<a href="#" class="help">Help</a></h2>
				<div class="centered">Anno di gestione : <span class="year">{$year}</span></div>
				<a id="new-gara" href="{urlarea action="new_gara"}">Aggiungi gara</a><br/>
				<table id="gare-table">
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
						<tr {if $gare[gara]->dummy == "Y"}class="dummy"{/if}>
							<td class="counter">{$smarty.section.gara.index + 1}</td>
							<td class="subject">{$gare[gara]->oggetto}</td>
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
		<div id="modal-box" style="display:none">
			<div id="modal-box-message">&nbsp;</div>
		</div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
	<script src="resources/js/bootstrap-tour-standalone.min.js"></script>
	<script src="control/reserved/avcpman/gare.js"></script>
</html>