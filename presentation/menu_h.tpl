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
                    <li><a class="smaller" href="{urlarea area="home" action="avcpman"}">Comunicazioni AVCP</a></li>
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