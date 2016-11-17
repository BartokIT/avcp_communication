<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
        <link href="resources/css/jquery-ui.1.11.2.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="locroyalties\menu.tpl"}
			</div>
			<div class="container-main">                
				<h2>Canoni di locazione                    
                    <a href="#" class="help">Guida</a>
                </h2>
                
				<div class="centered">Anno di gestione :
                    <select id="current-year" name="current-year">
                        {html_options options=$years selected=$year}
                    </select>
                </div>
				{authorized roles="administrator,editor"}
				<a id="new-gara" href="{urlarea action="new_gara"}">Aggiungi contratto</a><br/>
				{/authorized}
				<table id="gare-table">
					<thead>
					<tr>
						<th class="counter" style="width: 20px">N.</th>
						<th>Oggetto</th>
						<th style="width: 30px;font-size: 10px;text-align: center">....</th>
						<th style="width: 90px;">Operazioni</th>
					</thead>
					<tbody>
					{section name=contratto loop=$contract}
						<tr>
                       </tr>
					{/section}
					</tbody>
				</table>
			</div>
			<hr class="clear" style="display: none"/>
		</div>
		<div id="modal-box" style="display:none">
			<div id="modal-box-message">&nbsp;</div>
		</div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.11.2.min.js"></script>
	
</html>