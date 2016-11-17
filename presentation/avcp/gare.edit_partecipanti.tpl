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
				{include file="avcp\menu.tpl"}
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
					<div class="add-partecipant-container">
						<a id="add-partecipant-ditta" href="{urlarea action="add_ditta" parameters="{$gara->gid}"}">Aggiungi<br/>ditta</a>
						<a id="add-partecipant-raggruppamento" href="{urlarea action="add_raggruppamento" parameters="{$gara->gid}"}">Aggiungi<br/>raggruppamento</a>
						<hr class="clear" style="display: none"/>
					</div>
		{form action="save" parameters=$p}		
		
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
					<th style="width:50px;">&nbsp;</th>
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
					<td><input type="checkbox" name="aggiudicatario[]" value="{$ditta->pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/></td>
					<th><a class="delete-ditta" title="Rimovi ditta" href="{urlarea  action="delete_ditta" parameters=$p}">
						Rimuovi ditta
					</a></th>
                </tr>
            {/foreach}
			{foreach $partecipanti["raggruppamenti"] as $pid=>$rpartecipanti}
				<tr class="raggruppamento-header">
					<td rowspan="{$rpartecipanti|@count + 1}">
						{$indice++}						
					</td>
					<td colspan="3">
					Raggruppamento
					{$p = ['pid'=> $pid,'gid'=> $gara->gid]}
					<td>
						<a class="delete-raggruppamento" title="Rimuovi raggruppamento" href="{urlarea  action="delete_raggruppamento" parameters=$p}">
							Rimuovi raggruppamento
						</a>
						<a class="add-ditta-raggruppamento" title="Aggiungi ditta" href="{urlarea area="avcpman/gare/edit/add_ditta_raggruppamento" parameters="{$pid}"}">
							Aggiungi ditta
						</a>
					</td>
				</td></tr>
				{foreach $rpartecipanti as $ditta}
					{$pd= ['pid'=> $pid,'gid'=> $gara->gid,'did'=>$ditta->did]}
					<tr class="raggruppamento">	
						<td class="ragione-sociale">{$ditta->ragione_sociale} (<em>{$ruoli_raggruppamento[$ditta->ruolo]}</em>)</td>
						<td class="identificativo-fiscale">{$ditta->identificativo_fiscale}</td>
						{if $ditta@first}<td rowspan="{$ditta@total}">
							<input type="checkbox" name="aggiudicatario[]" value="{$pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/>
						</td> {/if}
						<td><a class="delete-ditta" title="Rimuovi ditta" href="{urlarea  action="delete_ditta_raggruppamento" parameters=$pd}">
							Rimuovi ditta
						</a></td>
					</tr>
				{/foreach}
            {/foreach}
			</tbody>
		</table>
		<div class="button-container">
			<button class="save" type="submit" name="submit" value="save">Salva</button>			
			<button class="undo" type="submit" name="submit" value="undo">Annulla</button>			
		</div>
		{/form}
		</div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
	<script src="resources/js/jquery-1.10.2.js"></script>
    <script src="resources/js/bootstrap-tour-standalone.js"></script>
	<script>
		$(function(){            
			var oTour = new Tour({
				steps:[
					{   path : "?area=avcpman%2Fgare"},  //step:0
					{   path : "?area=avcpman%2Fgare%2Fnew_gara"},  //step:1
                    {   path : "?area=avcpman%2Fgare%2Fnew_gara"},  //step:2
                    {   path : "?area=avcpman%2Fgare"},  //step:3
					{	//step:4
						element: "#add-partecipant-ditta",
						placement:'left',
						reflex: true,
						title:"Aggiungi un partecipante",
						content: "&Egrave; necessario aggiungere un partecipante oppure un ragguppamento. Clicca sul pulsante per andare avanti"
					},	
					{	path:  $("#add-partecipant-ditta").attr("href")	}, //step: 5
					{	path:  $("#add-partecipant-ditta").attr("href")	}, //step:6
					{	//step:7
						element: "#add-partecipant-raggruppamento",
						placement:'left',
						reflex: true,
						title:"Aggiungi un raggruppamento di partecipanti",
						content: "Ora prova ad aggiungere un raggruppamento. Clicca sul pulsante per andare avanti.",
						onNext: function(tour)
						{
							if ($(".add-ditta-raggruppamento").length < 1 ) {
								window.location = $("#add-partecipant-raggruppamento").attr("href");	//code
								return false;
							}						
						},
						onShown : function (tour)
						{							
							if ($(".add-ditta-raggruppamento").length > 0 ) {
								tour.next();
							}
						}
					},
					{	//step:8
						element: ".add-ditta-raggruppamento:first",
						placement:'left',
						reflex: true,
						title:"Aggiungi una ditta al raggruppamento",
						content: "Un raggruppamento &egrave; composto da pi&ugrave; ditte.<br/> Clicca sul pulsante per aggiungerne una al raggruppamento."
						
					},
					{   path : $(".add-ditta-raggruppamento:first").attr("href"),						
					},  //step:9
					{   path : $(".add-ditta-raggruppamento:first").attr("href")},  //step:10
					{   path : $(".add-ditta-raggruppamento:first").attr("href")},  //step:11
					{	//step: 12
						element: "[name='aggiudicatario\\[\\]']:first",
						title: "Aggiudicatario",
						reflex: true,
                        placement: 'top',
						content:"Ora &egrave; necessario specificare un aggiudicatario per la gara, selezionalo premendo sul quadrato.",						
						onNext: function(tour)
						{
							tour._options.steps[14].path = '?action=save&submit=save&aggiudicatario[]=' + $("input[name='aggiudicatario\\[\\]']:checked:first").val() + '&pid=' + $("input[name='pid']").val()+ '&gid='+$("input[name='gid']").val() + "&nonce=" + $("input[name='nonce']").val();
						}
					},
					{	//step: 13
						element: "button.save",
						title: "Salva la selezione",
						reflex: true,
						content: "Premere sul pulsante 'Salva' per salvare la scelta dell'aggiudicatario",
						onShown: function (tour)
						{
							if ($("[name='aggiudicatario\\[\\]']:first:checked").length < 1 )
							{
								tour.prev();
							}
						}
					},
					{   path : '?action=save&submit=save&pid=' + $("input[name='pid']").val()+ '&gid='+$("input[name='gid']").val() + "&nonce=" + $("input[name='nonce']").val()}  //step:14
					
			],
			template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>",
			onEnd: function(tour)
			{
				$("a").unbind();
			}
			});
			oTour.init();
			oTour.start();
			 if (!oTour.ended()) {
				$("a").unbind().click(function(e){ e.preventDefault();});
                $("button").unbind().click(function(e){ e.preventDefault();});				
			}
		});
	</script>	
</html>