<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Gare</h1>
        <a href="{urlarea action="new_gara"}">+</a><br/>
		Anno di gestione : {$year}
        <table>
            {section name=gara loop=$gare}
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