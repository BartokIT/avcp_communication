	<!--[if lt IE 7]>
		<p class="chromeframe">State usando un browser <strong>datato</strong>.
		Per cortesia <a href="http://browsehappy.com/">aggiornate il vostro browser</a> oppure utilizzate Mozilla Firefox per rendere la vostra migliore la vostra esperienza di navigazione.</p>
	<![endif]-->
    <div id="container"><!-- [container] -->
        <div id="inside"> <!-- [inside] -->
	        <div id="header"><!-- [header] -->
				<div id="mini-top-bar">
					<div class="content-width">
						<div class="user_detail">
						{authorized roles="notlogged"}
							<a class="smaller" title="Accedi all'area riservata" href="{urlarea area="login"}">Accesso area riservata</a>
						{/authorized}
						{authorized roles="logged"}
						<div class="submenu">
							{$user->getDisplayName()|htmlentities}
							<ul>
								{ifarea site-view="reserved"}
									<li><a class="smaller" href="{urlarea area="avcpman" nonce="true" action="logout"}">Logout</a></li>
								{/ifarea}
								{ifarea site-view="general"}
									<li><a class="smaller" href="{urlarea area="login" nonce="true" action="logout"}">Logout</a></li>
								{/ifarea}
							</ul>
						</div>
						{/authorized}
						</div>
					</div>
				</div>
               <div class="content">
					<div class="content-width">
						<div id="h_logo">
							&nbsp;
							<img src="resources/css/images/Terracina-Logo.png" height=45 alt="Logo del Comnue di Terracina" />
						</div>
	                    <div id="h_stemma">
							<img src="resources/css/images/Terracina-Stemma-Desaturato.png" height=75 alt="Logo del Comnue di Terracina" />
						</div>
						
					</div>					
                </div>			
            </div><!-- [/header] -->
			<div id="menu_h" class="clear"><!-- [menu_h] -->
 				{include file="menu_h.tpl"}
			</div> <!-- [menu_h] -->

