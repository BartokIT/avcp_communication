        <!--[if lt IE 7]>
            <p class="chromeframe">State usando un browser <strong>datato</strong>. Per cortesia <a href="http://browsehappy.com/">aggiornate il vostro browser</a> o <a href="http://www.google.com/chromeframe/?redirect=true">attivate Google Chrome Frame</a> per rendere la vostra migliore la vostra esperienza di navigazione.</p>
        <![endif]-->
    <div id="container">
        <div id="inside"> <!-- [inside] -->
	        <div id="header"><!-- [header] -->
                <div class="content">
                    <div id="h_main"><a href="<?php echo _l("default","default") ?>"><img src="resources/css/logo-def.png" alt="Logo del Conservatorio di Latina" /></a></div>
                </div>
				<div class="menu"><ul>
					<?php
						//if (isset($_SESSION["user"]) && !(isset($_REQUEST["action"]) && strcmp($_REQUEST["action"],"logout") == 0))
						if (strcmp($p["site_view"],"public") != 0)
							echo '<li><a href="'. _l("default","default","logout")  . '">Logout (' . $p["user"]->display_name .')</a></li>';
					?>
				</ul></div>
            </div><!-- [/header] -->

