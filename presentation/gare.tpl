<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
        <link href="resources/css/jquery-ui.1.11.2.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="menu.tpl"}
			</div>
			<div class="container-main">
                {$print_parameter=['all'=>$view_all]}
				<h2>Gare<a href="#" class="help">Guida</a><a href="{urlarea action="print_pdf" parameters=$print_parameter}" class="print">Stampa</a></h2>
                
				<div class="centered">Anno di gestione :
                    <select id="current-year" name="current-year">
                        {html_options options=$years selected=$year}
                    </select>
                </div>
				{authorized roles="administrator,editor"}
				<a id="new-gara" href="{urlarea action="new_gara"}">Aggiungi gara</a><br/>
				{/authorized}
				
				{authorized roles="administrator"}
				<div class="centered">Visualizza gare di tutti gli utenti<input id="view-all-gare" type="checkbox" {if $view_all eq "true" }checked="checked" {/if} href="#"/></div>
				{/authorized}
				<table id="gare-table">
					<thead>
					<tr>
						<th class="counter" style="width: 20px">N.</th>
						<th>Oggetto</th>
						<th style="width: 30px;font-size: 10px;text-align: center">Partecipanti</th>
						<th style="width: 90px;" colspan="{if $user->isRole("viewers") || $user->isRole("publisher")}1{else}4{/if}">Operazioni</th>
                        {if $user->isRole("administrator") &&  $view_all eq "true"}
                            <th>Utente</th>    
                        {/if}
					</thead>
					<tbody>
					{section name=gara loop=$gare}
						<tr class="{if $gare[gara]->dummy == "Y"}dummy{/if} {if $gare[gara]->warning}warning{/if}">
							<td class="counter">{$smarty.section.gara.index + 1}</td>
							<td class="subject">{$gare[gara]->oggetto} - <strong>{$gare[gara]->cig}</strong></td>
							<td style="width: 30px;text-align: center">{$gare[gara]->partecipanti}</td>
							<td class="operations-size"><a class="zoom" title="Visualizza dettaglio gara" href="{urlarea area="avcpman/gare" nonce="false" action="view" parameters="{$gare[gara]->gid}"}">Visualizza dettaglio</a></td>
							{authorized roles="administrator,editor"}
							<td class="operations-size"><a class="edit" title="Modifica" href="{urlarea area="avcpman/gare" action="edit" parameters="{$gare[gara]->gid}"}">Modifica</a></td>
							<td class="operations-size"><a class="edit-partecipant" title="Modifica partecipanti" href="{urlarea area="avcpman/gare/edit_partecipanti"  parameters="{$gare[gara]->gid}"}">Modifica Partecipanti</a></td>
							<td class="operations-size"><a class="delete" title="Cancella" href="{urlarea action="delete"  parameters="{$gare[gara]->gid}"}">Cancella</a></td>	                            
							{/authorized}
                            {if $user->isRole("administrator") &&  $view_all eq "true"}
                            <td style="font-size: .8em">{$gare[gara]->f_user_id}</td>    
                        {/if}
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
	<script src="resources/js/jquery-ui-1.11.2.min.js"></script>
	<script src="resources/js/bootstrap-tour-standalone.min.js"></script>
	<script src="control/reserved/avcpman/gare.js?v=0001"></script>
</html>