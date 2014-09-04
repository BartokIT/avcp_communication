<!DOCTYPE html>
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
                <h2>Pubblicazioni</h2>
                <div class="centered form-new-publication">
                    <div id="show-error" style="visibility:{if isset($error)}visible{else}hidden{/if}" class="error">{if isset($error)}{$error}{/if}</div>
                    {form id="new_publication" area="avcpman/pubblicazioni/add_pubblicazione" method="get"}
                    <label for="pubblicazioni_anno">Crea pubblicazione anno: </label>
                        <input  autocomplete="off" type="text" maxlength="4" id="pubblicazioni_anno" name="pubblicazioni_anno" value="" />
                        <button class="add" type="submit" name="submit" value="make">Crea</button>
                    {/form}
                </div>
                
                <table class="publications-table">
                    <thead>
                        <tr>
                            <th colspan="4">Pubblicazioni</th>
                        </tr>
                        <tr>
                            <th>Anno</th>
                            <th>Descrizione</th>
                            <th>Ultimo<br/>aggiornamento</th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <a class="download" title="Download" href="{urlarea nonce=false action="download_file" parameters=$p}">Download</a>
                            </td>
                            <td>
                                <a class="delete" title="Cancella pubblicazione" href="{urlarea action="delete" parameters=$p}">Elimina</a>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    <script src="resources/js/support.js"></script>
	<script src="control/reserved/avcpman/pubblicazioni.js"></script>
</html>
