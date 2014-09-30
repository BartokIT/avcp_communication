<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
				<h2>Gare</h2>
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
						<tr>
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
	<script>
		$(function(){
			
			$(".delete").click(function(e) {
				e.preventDefault();
				var targetUrl = $(this).attr("href");
				var iGaraNum = $(this).parent().parent().children('.counter').text();
				var sSubject = $(this).parent().parent().children('.subject').text();
				
				$("#modal-box-message").html("Si vuole veramente eliminare la gara n. " + iGaraNum +"<br/> avente come oggetto '" + sSubject +"'?");
				$("#modal-box").dialog({
					resizable: false,					
					modal: true,
					title: "Eliminazione gara",
					buttons: {
					  "Conferma": function() {
						window.location.href = targetUrl;
					  },
					  "Annulla": function() {
						$( this ).dialog( "close" );
					  }
					}
				});
			});
			var oTour = new Tour({
				steps:[
					{
						element: "#new-gara",
						title: "Guida iniziale",
						content: "Seguendo questa guida, ti verr&agrave; spiegato in breve il funzionamento di questo sito.<br/>Tramite il pulsante 'Aggiungi gara' potrai aggiungere una nuova gara.<br/><strong> Premilo ora</strong>"
					},
					{
						path:"?action=new_gara",
						element: ".box",
						title: "Aggiungi una nuova gara",
						content: "Tramite questo pulsante potrai aggiungere una nuova gara"
					},
                    {
						path:"?action=new_gara",
						element: ".save",
						title: "Salva la gara",
						content: "Finito l'inserimento sar&agrave; necessario premere il pulsante 'Inserisci' per effettuare il salvataggio"
					},
                    {
						element: ".edit-partecipant",
						placement:"top",
						title: "Inserisci partecipanti",
						content: "Ora &egrave; necessario inserire i partecipanti alla gara"
					},
					{
						path : $(".edit-partecipant:first").attr("href"),
						element: ".edit-partecipant",
						placement:"top",
						title: "Insòljòljlti",
					}
			],
			template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>"
			});
			oTour.init();
			oTour.start();
			 if (!oTour.ended()) {
				$("#new-gara").click(function(e){                
					oTour.next();
            })
			}
		});
	</script>
</html>