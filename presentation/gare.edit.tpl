<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Ditta</h1>
        {$p = ['gid'=> $gara->gid]}
        {form action="submit" parameters=$p}
            <label for="year">Anno
            <input type="text" name="gare_edit_year" id="gare_edit_year" value="{$gara->f_pub_anno}"/></label><br/>
            <label for="cig">Codice Identificativo Gara<em>(rilasciato da AVCP)</em>
            <input type="text" name="gare_edit_cig" id="gare_edit_cig" value="{$gara->cig}"/></label><br/>
            <label for="subject">Oggetto
            <input type="text" name="gare_edit_subject" id="gare_edit_subject" value="{$gara->oggetto}"/></label><br/>
            <label for="contest_type">Tipo di contraente
            {html_options name="gare_edit_contest_type" options=$contest_type selected=$gara->scelta_contraente separator="<br/>"}</label><br/>
            <label for="amount">Importo di aggiudicazione
		<input type="text" name="gare_edit_amount" id="gare_edit_amount" value="{$gara->importo}"/>
            </label><br/>
	    <label for="payed_amount">Importo somme liquidate
                <input type="text" name="gare_edit_payed_amount" id="gare_edit_payed_amount" value="{$gara->importo_liquidato}" />
            </label><br/>
	    <label for="job_start_date">Data di inizio lavori
                <input type="text" name="gare_edit_job_start_date" id="gare_edit_job_start_date" value="{$gara->data_inizio}" />
            </label><br/>
	    <label for="job_end_date">Data di fine lavori
			<input type="text" name="gare_edit_job_end_date" id="gare_edit_job_end_date" value="{$gara->data_fine}" />
            </label><br/>
            {ifarea value="gare/edit"}
                <button type="submit" name="submit" value="save">Salva</button>
            {/ifarea}
            {ifarea value="gare/new_gara"}
                <button type="submit" name="submit" value="save">Inserisci</button>
            {/ifarea}
            <button type="submit" name="submit" value="undo">Annulla</button>
        {/form}
        {include file="footer.tpl"}
    </body>
</html>