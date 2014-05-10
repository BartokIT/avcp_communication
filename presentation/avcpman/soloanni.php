<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Gestione Posta in Uscita</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("modernizr.js","2.6.2") ?>"></script>
		<script src="<?= _i("jquery.js","1.10.2") ?>"></script>
		<script src="<?= _i("jquery-ui.js","1.10.3")?>"></script>		
		<script src="<?= _i("avcpman_years.js")?>"></script>			
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
<!-- HEADER -->
<?php
    include("presentation/header.php");
?>
<!-- CONTENT -->
	        <div id="content" > <!-- [content] -->
		        <div class="left">
						<table id="year_list" class="list" border="1"  cellspacing="0" width="200">
								<tbody>
								<tr><td id="new-distinct" colspan="4"><a id="new_year" href="#"> Nuovo anno ... </td></tr>
							   <?php
							    foreach ( $p['years'] as $years)
							    {
										echo '<tr class="year"><td><a href="' . _l("pubblicazioni","pubblicazioni").'&amp;anno=' . $years->anno . '">' . $years->anno .'</td></tr>';
								}							   
								?>
							   </tbody>
						</table>							   
				</div>
		        <div class="right"></div>			   
	        </div> <!-- [/content] -->
			<div class="invisible" id="new-year-form" title="Inserisci nuovo anno">
				<p class="validateTips">Inserire il nuovo anno</p>			   
				<form>
						<fieldset>
						  <label for="name">Anno</label>
						  <input type="text" name="anno" id="anno" class="text ui-widget-content ui-corner-all"/>
						</fieldset>
				</form>
			  </div>
<?php include("presentation/footer.php"); ?>
    </body>
</html>
