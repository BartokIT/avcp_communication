<html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        {include file="header.tpl"}
        {include file="menu.tpl"}
        <h1>Smarty Template</h1>
        <p>
           {$user->getDisplayName()} <br/>
           {urlarea action="delete"}
           
        </p>
        {authorized roles="reader"}
            <p>
                {lorem}
            </p>
        {/authorized}
        {include file="footer.tpl"}
    </body>
</html>