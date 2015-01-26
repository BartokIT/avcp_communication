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
						<div class="message">Dettaglio pubblicazione n. {$numero} per l'anno {$anno}</div>
						<div class="box recap-pubblicazione">
							<div class="label"><span class="left">Titolo:</span><span class="right">{$titolo}</span></div>
							<div class="label"><span class="left">Abstract:</span><span class="right">{$abstract}</span></div>
							<div class="label"><span class="left">Date pubblicazione:</span><span class="right">{$data_pubblicazione}</span></div>
							<div class="label"><span class="left">Data aggiornamento:</span><span class="right">{$data_aggiornamento}</span></div>							
							<div class="label"><span class="left">Url pubblicazione:</span><span class="right">{$url}</span></div>														
						</div>						
						<table class="publications-table">
						<thead>
							<tr>
								<th colspan="5">Revisioni file</th>
							</tr>
							<tr>
								<th>N.</th>
								<th>Download</th>
							</tr>
						</thead>
						<tbody>
							{foreach $files as $f}
							<tr>
							<td>{$f@index + 1}</td>
							<td>
									{$fid = ['fid'=>{$f->fid}]}
									   <a class="download" title="Download" href="{urlarea nonce="false" action="download_file" parameters=$fid}">Download</a>
							</td>
							</tr>
							{/foreach}			
						</tbody>
					</table>

				</p>
				<hr class="clear" style="display: none"/>
				</div>
		</div>
        {include file="footer.tpl"}
    </body>
	<script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    <script src="resources/js/support.js"></script>	
	<script src="control/reserved/avcpman/pubblicazioni/add_pubblicazione.js?v=0001"></script>
</html>
