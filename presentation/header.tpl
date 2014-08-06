        <!--[if lt IE 7]>
            <p class="chromeframe">State usando un browser <strong>datato</strong>. Per cortesia <a href="http://browsehappy.com/">aggiornate il vostro browser</a> o <a href="http://www.google.com/chromeframe/?redirect=true">attivate Google Chrome Frame</a> per rendere la vostra migliore la vostra esperienza di navigazione.</p>
        <![endif]-->
    <div id="container">
        <div id="inside"> <!-- [inside] -->
	        <div id="header"><!-- [header] -->
				<div id="mini-top-bar">
					<div class="content-width">
						<div class="user_detail">
						{authorized roles="notlogged"}
							<a href="{urlarea area="login"}">Accesso area riservata</a>
						{/authorized}
						{authorized roles="logged"}
							{$user->getDisplayName()}
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
			<div id="menu_h" class="clear">
				{include file="menu_h.tpl"}
			</div>

