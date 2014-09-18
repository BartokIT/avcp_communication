<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <link  rel="stylesheet" href="resources/css/grid-layout.css" type="text/css">   
	{include file="style.tpl"}
    </head>
    <body class="error">
		<div id="stretch"></div>
        {include file="header.tpl"}
        <div class="content-width">
            <div class="error-container">
                <div class="row clearfix">
                    <div class="col-1 level-1 info-box">
                        <h1>&lt; {$error_code} /&gt;</h1>
						<h2>Si  &egrave; verificato un problema</h2>
                        <p>
                            Stai cercando di accedere ad una pagina non presente/non autorizzata
							oppure vi &egrave; un errore interno,<br/> per cortesia torna alla home page.<br/>
						</p>
							<a  href="{urlarea area="home" action="d"}">Home</a>
							{if $debug == true}
							<div style="">
								{$message}
							</div>
							{/if}
                        
                    </div>
                </div>
            </div>
        </div>
        {include file="footer.tpl"}
    </body>
</html>