<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
    <link href="resources/css/ui-absolution/absolution.css" rel="stylesheet" type="text/css">
    <link href="resources/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="avcpman">
        {include file="header.tpl"}
		<div class="content-width">
			<div class="left-float container-menu">
				{include file="menu.tpl"}
			</div>
            <div class="container-main">
                <h2>Gara</h2>                
                {$p = ['gid'=> $gara->gid]}
                {form id="edit-gara" action="submit" parameters=$p}
                    <div class="message">Modifica gara</div>
                    <div class="box">
                        <label class="year" for="year"><span>Anno</span>
                            <input type="text" maxlength="4" name="gare_edit_year" id="gare_edit_year" value="{$gara->f_pub_anno}"/>
                            <div class="inline-error"></div>
                        </label>
                        <label class="cig" for="cig"><span>Codice Identificativo Gara<br/><em>(rilasciato da AVCP)</em></span>
                            <input type="text"  maxlength="10" name="gare_edit_cig" id="gare_edit_cig" value="{$gara->cig}"/>
                            <div class="inline-error"></div>
                        </label>
                        <label for="subject"><span>Oggetto</span>
                            <input type="text"  maxlength="250" name="gare_edit_subject" id="gare_edit_subject" value="{$gara->oggetto}"/>
                            <div class="inline-error"></div>
                        </label>
                        <label for="contest_type"><span>Tipo di contraente</span>
                            {html_options name="gare_edit_contest_type" options=$contest_type selected=$gara->scelta_contraente separator="<br/>"}</label>
                        <label for="amount"><span>Importo di aggiudicazione</span>
                            <input type="text" name="gare_edit_amount" id="gare_edit_amount" value="{$gara->importo}"/>
                            <div class="inline-error"></div>
                        </label>
                        <label for="payed_amount"><span>Importo somme liquidate</span>
                            <input type="text" name="gare_edit_payed_amount" id="gare_edit_payed_amount" value="{$gara->importo_liquidato}" />
                            <div class="inline-error"></div>
                        </label>
                        <label for="job_start_date"><span>Data di inizio lavori</span>
                            <input type="text" name="gare_edit_job_start_date" id="gare_edit_job_start_date" value="{$gara->data_inizio}" />
                            <div class="inline-error"></div>
                        </label>
                        <label for="job_end_date"><span>Data di fine lavori</span>
                            <input type="text" name="gare_edit_job_end_date" id="gare_edit_job_end_date" value="{$gara->data_fine}" />
                            <div class="inline-error"></div>
                        </label>
                        <div class="button-container">
                            {ifarea value="avcpman/gare/edit"}
                                <button class="save" type="submit" name="submit" value="save">Salva</button>
                            {/ifarea}
                            {ifarea value="avcpman/gare/new_gara"}
                                <button class="save" type="submit" name="submit" value="save">Inserisci</button>
                            {/ifarea}
                            <button  class="undo" type="submit" name="submit" value="undo">Annulla</button>
                        </div>
                    </div>
                {/form}
            </div>
			<hr class="clear" style="display: none"/>
		</div>
        {include file="footer.tpl"}
    </body>
    <script src="resources/js/jquery-1.10.2.js"></script>
	<script src="resources/js/jquery-ui-1.10.4.min.js"></script>
    <script src="resources/js/datepicker-it.js"></script>
    <script src="resources/js/support.js"></script>
    <script src="resources/js/bootstrap-tour-standalone.min.js"></script>
	<script src="control/reserved/avcpman/gare/new_gara.js"></script>
    
</html>