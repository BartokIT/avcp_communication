<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Pubblicazioni</h1>
        <p>
            Crea pubblicazione anno:
            {form area="pubblicazioni/add_pubblicazione" method="get"}			
				<input type="tex" id="pubblicazioni_anno" name="pubblicazioni_anno" value="" />
				<button type="submit" name="submit" value="make">Crea</button>
			{/form}
        </p>
        Pubblicazioni:
        <table>
            {foreach $pubblicazioni as $p}
                <tr>                    
                    <td>
                        {$p->anno}
                    </td>
                    <td>
                        {$p->titolo}
                    </td>
                    <td>
                        {$p->data_aggiornamento}
                    </td>
                    <td>
                        {$p = ['numero'=>$p->numero,'anno'=>$p->anno]}
                        <a href="{urlarea action="download_file" parameters=$p}">d</a>
                    </td>
                </tr>
            {/foreach}
        </table>
        {include file="footer.tpl"}
    </body>
</html>