<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Gara</h1>
        {$p = ['did'=> $ditta->did]}
        {form action="submit" parameters=$p}
            <input type="text" id="ditta_edit_ragione_sociale" name="ditta_edit_ragione_sociale" value="{$ditta->ragione_sociale}"/><br/>
            {html_radios name="ditta_edit_estero" options=$estero selected=$ditta->estera separator="<br/>"}        
            <input type="text" id="ditta_edit_identificativo" name="ditta_edit_identificativo" value="{$ditta->identificativo_fiscale}"/><br/>
            <button type="submit" name="submit" value="undo">Annulla</button>
            {ifarea value="ditte/edit"}
                <button type="submit" name="submit" value="save">Salva</button>
            {/ifarea}
            {ifarea value="ditte/new_ditta"}
                <button type="submit" name="submit" value="save">Inserisci</button>
            {/ifarea}
        {/form}
        {include file="footer.tpl"}
    </body>
</html>