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
            </div>
        </div>
        {include file="footer.tpl"}
    </body>
</html>