<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
    </head>
    <body class="login">
		<div id="stretch"></div>
		
        {include file="header.tpl"}
		<div class="content-width">		
				<div class="login-content">
					<div class="blur"></div>
					
					<!--
						<img class="profile-img" src="resources/css/avatar_login.png" alt="">
					-->
					{form action="login"}
					{if isset($error)}
						<p class="error">
							
						{$error}							
						</p>
					{/if}
					<!--[if lt IE 9]>
						<label class="label-login" for="Email">Utente</label>
					<![endif]-->
					<input id="user" name="user" type="text" placeholder="Utente" value="" spellcheck="false" class="">
					<!--[if lt IE 9]>
						<label class="label-login" for="Passwd">Password</label>
					<![endif]-->
					<input id="passwd" name="passwd" type="password" placeholder="Password" class="">
					<input id="signon" name="signon" class="rc-button rc-button-submit" type="submit" value="Accedi">
					{/form}
					
				 </div>
			</div>
		{include file="footer.tpl"}
    </body>
</html>