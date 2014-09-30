<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                <tr>
                    <td>{$indice++}</td>
                    <td>{$ditta->ragione_sociale}</td>
					<td>{$ditta->identificativo_fiscale}</td>
					<td><input type="radio" name="aggiudicatario" value="{$ditta->pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/></td>
					<th><a class="delete-ditta" title="Rimovi ditta" href="{urlarea  action="delete_raggruppamento" parameters=$p}">
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
					<tr class="raggruppamento">						
						<td class="ragione-sociale">{$ditta->ragione_sociale} (<em>{$ruoli_raggruppamento[$ditta->ruolo]}</em>)</td>
						<td class="identificativo-fiscale">{$ditta->identificativo_fiscale}</td>
						{if $ditta@first}<td rowspan="{$ditta@total}">
							<input type="radio" name="aggiudicatario" value="{$pid}" {if $ditta->aggiudicatario == "Y"}checked="checked"{/if}/>
						</td> {/if}
						<td>&nbsp;</td>
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
    <script src="resources/js/bootstrap-tour-standalone.min.js"></script>
	<script>
		$(function(){
			var oTour = new Tour({
				steps:[
					{
						element: "#new-gara",
						title: "0",
						content: "Seguendo questa guida, ti verr&agrave; spiegato in breve il funzionamento di questo sito.<br/>Tramite il pulsante 'Aggiungi gara' potrai aggiungere una nuova gara.<br/><strong> Premilo ora</strong>"
					},
					{
						path:"?action=new_gara",
						element: ".box",
						title: "1",
						content: "Tramite questo pulsante potrai aggiungere una nuova gara"
					},
                    {
						path:"?action=new_gara",
						element: ".save",
						title: "2",
						content: "Finito l'inserimento sar&agrave; necessario premere il pulsante 'Inserisci' per effettuare il salvataggio"
					},
                    {
						path : "?area=avcpman%2Fgare",
						element: ".edit-partecipant",
						placement:"top",
						title: "3",
						content: "Ora &egrave; necessario inserire i partecipanti alla gara"
					},
					{
						element: "#add-partecipant-ditta",
						placement:'left',
						title:"Aggiungi un partecipante",
						content: "&Egrave; necessario aggiungere un partecipante oppure un ragguppamento. Clicca sul pulsante per andare avanti",
					},
					
					{
						path:  $("#add-partecipant-ditta").attr("href"),
						placement:'left',
						title:"Aggiungi un partecipante",
						content: "&Egrave; possibile aggiungere una ditta, oppure ricercarne una in rubrica",
					}
			],
			template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>"
			});
			oTour.init();
			oTour.start();
			 if (!oTour.ended()) {
				$("#add-partecipant-ditta").click(function(e){                
					oTour.next();
            })
			}
		});
	</script>	
</html>