<html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Ditte</h1>
        <a href="{urlarea area="ditte" action="new_ditta"}">+</a>        
        <table>
            {section name=ditta loop=$ditte}
                <tr>
                    <td>{$smarty.section.ditta.index + 1}</td>
                    <td>
                        {if $ditte[ditta]->estera eq "Y"}
                            E
                        {else}
                            I
                        {/if}
                    </td>
                    <td>{$ditte[ditta]->ragione_sociale}</td>
                    <td>{$ditte[ditta]->identificativo_fiscale}</td>
                    <td><a href="{urlarea area="ditte" action="edit" parameters="{$ditte[ditta]->did}"}">e</a></td>
                </tr>
            {/section}
        </table>
        {include file="footer.tpl"}
    </body>
</html>