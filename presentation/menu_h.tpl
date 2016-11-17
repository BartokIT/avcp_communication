<div class="content-width">
    <ul>
        {if strpos($state->getArea(), "avcpman") === 0}
        <li class="active">
            <a  href="#">Comunicazioni AVCP</a>
        </li>
        {/if}
        <li class="{if $state->getArea() == "home"}active{/if}">
            <a class="home" href="{urlarea area="home"}">Home</a>
        </li>
        {authorized roles="logged"}
        {ifarea site-view="reserved"}
        <li>
            <div class="submenu">
                Procedure            
                <ul>
                    <li><a class="smaller" href="{urlarea area="home" nonce="false" action="avcpman"}">Comunicazioni AVCP</a></li>
                   <li><a class="smaller" href="{urlarea area="home" nonce="false" action="locroyalties"}">Canoni di locazione</a></li>
                    <li><a class="smaller" href="http://intranet.terracina.local/folium/">Protocollo</a></li>
                    <li><a class="smaller" href="http://intranet.terracina.local/portal/">CiviliaWeb - Procedure</a></li>
                    <li><a class="smaller" href="http://intranet.terracina.local/cartellini/">Cartellino Web</a></li>

                </ul>
            </div>
        </li>
        <li>
            <a href="#">Contatti</a>
        </li>
        {/ifarea}
        {/authorized}
    </ul>
</div>
