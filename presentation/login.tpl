<!DOCTYPE html>
    <head>
    <title>Comunicazioni AVCP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{include file="style.tpl"}
    </head>
    <body>
        {include file="header.tpl"}
		<div class="content-width">
		<h2>Login</h2>
				<div class="login-content">
					<!--
						<img class="profile-img" src="resources/css/avatar_login.png" alt="">
					-->
					{form action="login"}
					{if isset($error)}
						<p class="error">
							
						{$error}							
						</p>
					{/if}
					<label class="hidden-label" for="Email">Email</label>
					<input id="user" name="user" type="text" placeholder="Utente" value="" spellcheck="false" class="">
					<label class="hidden-label" for="Passwd">Password</label>
					<input id="passwd" name="passwd" type="password" placeholder="Password" class="">
					<input id="signon" name="signon" class="rc-button rc-button-submit" type="submit" value="Accedi">
					{/form}
				  </div>
			</div>	            		
    </body>
</html>