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
                <h2>Ditte</h2>
                <a id="new-ditta" href="{urlarea area="avcpman/ditte" action="new_ditta"}">Aggiungi ditta</a>
                {if isset($error)}
                    <p class="error">							
                        {$error}							
                    </p>
				{/if}
                <table class="ditte-table">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>&nbsp;</th>
                            <th>Ragione sociale</th>
                            <th>Identificativo fiscale</th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                    </thead>
                           
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
                            <td>{$ditte[ditta]->ragione_sociale}</td>
                            <td>{$ditte[ditta]->identificativo_fiscale}</td>
                            <td class="operations-size"><a  class="edit" title="Modifica"  href="{urlarea area="avcpman/ditte" action="edit" parameters="{$ditte[ditta]->did}"}">Modifica</a></td>
                            <td class="operations-size"><a class="delete" title="Cancella" href="{urlarea action="avcpman/ditte" action="delete" parameters="{$ditte[ditta]->did}"}">Cancella</a></td>
                        </tr>
                    {/section}
                </table>
			</div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
</html>