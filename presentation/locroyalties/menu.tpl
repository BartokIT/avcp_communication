<ul id="menu_v">
    {authorized roles="administrator,publisher"}
    <li>
        <a href="{urlarea nonce="false" area="loc_royalties/persone"}">Assegnazioni</a>
    </li>
    {/authorized}
    <li>
        <a href="{urlarea nonce="false" area="loc_royalties/gare"}">Alloggi</a>
    </li>
    <li>
        <a href="{urlarea nonce="false" area="loc_royalties/assegnazioni"}">Persone</a>
    </li>    
    {authorized roles="administrator"}
    <li>
        <a href="{urlarea nonce="false" area="avcpman/impostazioni"}">Impostazioni</a>
    </li>
    {/authorized}
</ul>