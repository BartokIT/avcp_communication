<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />		
	{include file="style.tpl"}
	<link href="resources/css/ui-absolution/absolution.css" rel="stylesheet" type="text/css">
    </head>
    <body class="avcpman">		
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="menu.tpl"}
			</div>
			<div class="container-main">
				<h2>Dettaglio Pubblicazione</h2>
				<p>
						
						{$p = ['pubblicazione_edit_anno'=>$anno,'pubblicazione_edit_numero'=>$numero]}
						<div class="message">Dettaglio pubblicazione n. {$numero} per l'anno {$anno}</div>
						<div class="box">						
								<label for="pubblicazione_edit_titolo">
									<span>Titolo</span>
									{$titolo}</label>
								<label for="pubblicazione_edit_abstract">
									<span>Abstract</span>
									<input type="text" maxlength="1000" id="pubblicazione_edit_abstract"  name="pubblicazione_edit_abstract" value="{$abstract}" />
								</label>
								<label for="pubblicazione_edit_pubblicazione"><span>Data pubblicazione</span>
									<input type="text" maxlength="10" id="pubblicazione_edit_pubblicazione" name="pubblicazione_edit_pubblicazione"  value="{$data_pubblicazione}"/>
									<div class="inline-error"></div>
								</label>
								<label for="pubblicazione_edit_aggiornamento"><span>Data aggiornamento</span>
									<input type="text" maxlength="10" id="pubblicazione_edit_aggiornamento" name="pubblicazione_edit_aggiornamento"  value="{$data_aggiornamento}"/>
									<div class="inline-error"></div>
								</label>
								<label for="pubblicazione_edit_url"><span>Url di pubblicazione</span>
									<input type="text" maxlength="1000" id="pubblicazione_edit_url" name="pubblicazione_edit_url"   value="{$url}"/>
									<div class="inline-error"></div>
								</label>
						</div>						
	                    {foreach $files as $f}
						{$fid = ['fid'=>{$f->fid}]}
			               <a class="download" title="Download" href="{urlarea nonce="false" action="download_file" parameters=$fid}">Download</a>
							<br/>
						{/foreach}
				</p>
				<hr class="clear" style="display: none"/>
				</div>
		</div>
        {include file="footer.tpl"}
    </body>
	<script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    <script src="resources/js/support.js"></script>	
	<script src="control/reserved/avcpman/pubblicazioni/add_pubblicazione.js"></script>
</html>
