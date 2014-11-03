<ul id="menu_v">
    {authorized roles="administrator,publisher"}
    <li>
        <a href="{urlarea area="avcpman/pubblicazioni"}">Pubblicazioni</a>
    </li>
    {/authorized}
    <li>
        <a href="{urlarea area="avcpman/gare"}">Gare</a>
    </li>
    <li>
        <a href="{urlarea area="avcpman/ditte"}">Ditte</a>
    </li>
    {authorized roles="administrator,publisher"}
    <li>
        <a href="{urlarea area="avcpman/impostazioni"}">Impostazioni</a>
    </li>
    {/authorized}
</ul>