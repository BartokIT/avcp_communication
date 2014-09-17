<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
        <link href="resources/css/ui-absolution/absolution.css" rel="stylesheet" type="text/css">
        <link href="resources/css/datatable/jquery.dataTables.css" rel="stylesheet" type="text/css">	
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="menu.tpl"}
			</div>
			<div class="container-main">
                <h2>Ditte</h2>
                <a id="new-ditta" href="{urlarea area="avcpman/ditte" action="new_ditta"}">Aggiungi ditta</a>
                {if isset($error)}
                    <p class="error">							
                        {$error}							
                    </p>
				{/if}
                <table id="ditte-table" class="ditte-table">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>I/E</th>
                            <th>Ragione sociale</th>
                            <th>Identificativo fiscale</th>
                            <th >&nbsp;</th>
                            <th >&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    {section name=ditta loop=$ditte}
                        <tr>
                            <td>{$smarty.section.ditta.index + 1}</td>
                            <td>
                                <div class="{if $ditte[ditta]->estera eq "Y"}foreign-flag{else}italian-flag{/if}">
                                {if $ditte[ditta]->estera eq "Y"}
                                    Estera
                                {else}
                                    Italiana
                                {/if}
                                </div>
                            </td>
                            <td class="name">{$ditte[ditta]->ragione_sociale}</td>
                            <td class="fiscalid">{$ditte[ditta]->identificativo_fiscale}</td>
                            <td class="operations-size"><a  class="edit" title="Modifica"  href="{urlarea area="avcpman/ditte" action="edit" parameters="{$ditte[ditta]->did}"}">Modifica</a></td>
                            <td class="operations-size"><a class="delete" title="Cancella" href="{urlarea action="avcpman/ditte" action="delete" parameters="{$ditte[ditta]->did}"}">Cancella</a></td>
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
	<script src="resources/js/jquery.dataTables.js"></script>    
	<script>
		$(function(){
            $('#ditte-table').dataTable({
            "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 4,5 ] }
            ],
            "language": {
                "url": "resources/js/datatables.Italian.json"
            }});
			$(".delete").click(function(e) {
				e.preventDefault();
				var targetUrl = $(this).attr("href");
				var sFID = $(this).parent().parent().children('.fiscalid').text();
				var sName = $(this).parent().parent().children('.name').text();
				
				$("#modal-box-message").html("Si vuole veramente eliminare la ditta '" + sName +"'<br/> avente come identificativo fiscale '" + sFID +"'?");
				$("#modal-box").dialog({
					resizable: false,					
					modal: true,
					title: "Eliminazione ditta",
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
		});
	</script>    
</html>