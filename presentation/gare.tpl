<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
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
                    <td>{$smarty.section.gara.index + 1}</td>
                    <td>{$gare[gara]->oggetto}</td>
					<td>{$gare[gara]->partecipanti}</td>
                    <td><a href="{urlarea area="gare" action="edit" parameters="{$gare[gara]->gid}"}">e</a></td>
					<td><a href="{urlarea area="gare/edit_partecipanti"  parameters="{$gare[gara]->gid}"}">ep</a></td>
                </tr>
            {/section}
        </table>
        {include file="footer.tpl"}
    </body>
</html>