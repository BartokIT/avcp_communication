<ul id="menu_v">
    {authorized roles="administrator,publisher"}
    <li>
        <a href="{urlarea nonce="false" area="avcpman/pubblicazioni"}">Pubblicazioni</a>
    </li>
    {/authorized}
    <li>
        <a href="{urlarea nonce="false" area="avcpman/gare"}">Gare</a>
    </li>
    <li>
        <a href="{urlarea nonce="false" area="avcpman/ditte"}">Ditte</a>
    </li>
    {authorized roles="administrator"}
    <li>
        <a href="{urlarea nonce="false" area="avcpman/impostazioni"}">Impostazioni</a>
    </li>
    {/authorized}
</ul>