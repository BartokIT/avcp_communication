<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{include file="style.tpl"}
        <link href="resources/css/jquery-ui.1.11.2.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />        
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="avcp\menu.tpl"}
			</div>
			<div class="container-main">
                {$print_parameter=['all'=>$view_all]}
				<h2>Gare</h2>
                {form id="copy-gara" action="submit"}
				<div class="centered">Anno di gestione :
                    <select id="current-year" name="current-year">
                        {html_options options=$years selected=$year}
                    </select>
                </div>
				<div class="centered">Copia nell'anno :
                    <select id="destination-year" name="destination-year">
                        {html_options options=$years_destination selected=$destination_year}
                    </select>
                </div>
				{authorized roles="administrator"}
				<div class="centered">Visualizza gare di tutti gli utenti<input id="view-all-gare" type="checkbox" {if $view_all eq "true" }checked="checked" {/if} href="#"/></div>
				{/authorized}
                
				<table id="gare-table">
					<thead>
					<tr>
                        <th>&nbsp;</th>
						<th class="counter" style="width: 20px" >N.</th>
						<th>Oggetto</th>						                        
                        {if $user->isRole("administrator") &&  $view_all eq "true"}
                            <th>Utente</th>    
                        {/if}
					</thead>
					<tbody>					
                    {foreach $gare as $gara}
						<tr >
                            <td>
                                {if $gara->present eq "" }
                                <input type="checkbox" name="gid[]" value="{$gara->gid}"/>
                                {/if}
                            </td>
							<td class="counter">{$gara@index + 1}</td>
							<td class="subject">{$gara->oggetto} - <strong>{$gara->cig}</strong></td>                            
                            {if $user->isRole("administrator") && $view_all eq "true"}
                            <td style="font-size: .8em">{$gara->f_user_id}</td>    
                        {/if}
						</tr>
					{/foreach}
					</tbody>
				</table>
                
                <div class="button-container">
                    <button class="save" type="submit" name="submit" value="save">Copia</button>
                    <button  class="undo" type="submit" name="submit" value="undo">Annulla</button>
                </div>
                {/form}
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
    <script src="control/reserved/avcpman/gare/copy.js?v=0001"></script>
</html>