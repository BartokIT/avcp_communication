<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
		<link href="resources/css/ui-absolution/absolution.css" rel="stylesheet" type="text/css">
		<link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="avcp\menu.tpl"}
			</div>
			<div class="container-main">
				<h2>Impostazioni</h2>
				<p>
						{form id="edit_settings" action="save"}
						<div class="message">Modifica impostazioni</div>
						<div class="box">						
								<label for="ente_name_edit"><span>Ente pubblicatore</span>
									<input type="text" maxlength="100" id="ente_name_edit" name="ente_name_edit" value="{$settings["ente"]}"/>
									<div class="inline-error"></div>
								</label>
								<label for="ente_cf_edit"><span>Codice Fiscale Ente</span>
									<input type="text" maxlength="15" id="ente_cf_edit" name="ente_cf_edit"  value="{$settings["cf_ente"]}"/>
									<div class="inline-error"></div>
								</label>
								<label for="licenza_edit"><span>Licenza</span>
									<input type="text" maxlength="10" id="licenza_edit" name="licenza_edit"  value="{$settings["licenza"]}"/>
									<div class="inline-error"></div>
								</label>
								<label for="prefisso_url"><span>Prefisso URL</span>
									<input type="text" maxlength="1000" id="prefisso_url" name="prefisso_url"  value="{$settings["prefisso_url"]}"/>
									<div class="inline-error"></div>
								</label>								
								<div class="button-container">
								<button class="save" type="submit" name="submit" value="save">Salva</button>								
								<button class="undo" type="submit" name="submit" value="undo">Annulla</button>
								</div>
						</div>						
						{/form}
				</p>
			</div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>	
    <script src="resources/js/support.js"></script>	
	<script>
		$(function(){
			 var s =[{
				'o':$('#ente_cf_edit'),
				'm':'Inserire un identificativo fiscale corretto',
				't':'idfiscale'
				}
			];
		
			var sButtonPressed;
			$('button').click(function() { 
				sButtonPressed = $(this).attr('value') 
			});
		
			$(s).each(function(i,v) {
				v.o.keydown(function()
				{
					v.o.removeClass('red-background-error');
					v.o.next('div').text('');
				});
				
				v.o.change(function()
				{
					v.o.removeClass('red-background-error');
					v.o.next('div').text('');
				});
			});
		
			$("#edit_settings").submit(function(event)
			{
				
				if (sButtonPressed == "undo") {
				    return true;
				}
				else
				    return validateElements(s);
			});
		});
	</script>
</html>
