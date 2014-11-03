<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
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
                {$p = ['did'=> $ditta->did]}
                <div id="show-error" style="visibility:{if isset($error)}visible{else}hidden{/if}" class="error">{if isset($error)}{$error}{/if}</div>
                {form id="edit-ditta" action="submit" parameters=$p}
                
                <div class="message">Modifica ditta</div>
                
                <div class="box">
                     <label for="ditta_edit_ragione_sociale"><span>Ragione sociale</span>
                        <input type="text" maxlength="250" id="ditta_edit_ragione_sociale" name="ditta_edit_ragione_sociale" value="{$ditta->ragione_sociale}"/>
                        <div class="inline-error"></div>
                     </label>
                     <div class="radio-estera-italiana">
                        {html_radios name="ditta_edit_estero" options=$estero selected=$ditta->estera separator=""}
                     </div>
                     <label for="ditta_edit_identificativo"><span>Identificativo fiscale</span>
                        <input type="text" id="ditta_edit_identificativo" name="ditta_edit_identificativo" value="{$ditta->identificativo_fiscale}"/>
                        <div class="inline-error"></div>
                     </label>
                     <div class="button-container">                        
                        {ifarea value="avcpman/ditte/edit"}
                            <button class="save" type="submit" name="submit" value="save">Salva</button>
                        {/ifarea}
                        {ifarea value="avcpman/ditte/new_ditta"}
                            <button class="save" type="submit" name="submit" value="save">Inserisci</button>
                        {/ifarea}
                        <button class="undo" type="submit" name="submit" value="undo">Annulla</button>
                     </div>                     
                {/form}
                </div>
                <hr class="clear" style="display: none"/>
            </div>
        </div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    <script src="resources/js/datepicker-it.js"></script>
    <script src="resources/js/support.js"></script>	    
	<script src="control/reserved/avcpman/ditte/edit.js"></script>
</html>