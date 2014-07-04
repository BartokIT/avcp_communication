<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Ditta</h1>
        
        {form action="submit"}
            
 
            <label for="cig">Codice Identificativo Gara<em>(rilasciato da AVCP)</em></label>
            <input type="text" name="cig" id="cig" value=""/><br/>
            <label for="subject">Oggetto</label>
            <input type="text" name="subject" id="subject" value=""/><br/>
            <label for="contest_type">Tipo di contraente</label>
            {html_options name="gare_edit_contest_type" options=$contest_type  separator="<br/>"}<br/>
            <label for="amount">Importo di aggiudicazione</label>
			<input type="text" name="amount" id="amount" value=""/><br/>
			<label for="payed_amount">Importo somme liquidate</label>
            <input type="text" name="payed_amount" id="payed_amount" value="" /><br/>
			<label for="job_start_date">Data di inizio lavori</label>
			<input type="text" name="job_start_date" id="job_start_date" value="" /><br/>
			<label for="job_end_date">Data di fine lavori</label>
			<input type="text" name="job_end_date" id="job_end_date" value="" /><br/>
        {/form}
        {include file="footer.tpl"}
    </body>
</html>