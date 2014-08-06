<div class="content-width">
    <ul>    
        <li class="active">
            <a class="home" href="{urlarea area="home"}">Home</a>
        </li>
        {authorized roles="logged"}
        <li>
            <div class="submenu">
                Procedure            
                <ul>
                    <li><a href="#">Item 1</a></li>
                    <li><a href="#">Item 2</a></li>
                </ul>
            </div>
        </li>
        <li>
            <a href="{urlarea area="ditte"}">Contatti</a>
        </li>
        {/authorized}
    </ul>
</div>