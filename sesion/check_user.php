<?php	

	if(isset($_SESSION['user_name'])){
	
?>
	<div id="session">
		<a id="signin-link" href="#">
            <strong><?php echo $_SESSION['user_name']?></strong>
        </a>
    </div>
	<div id="signin-dropdown">
        <div id="session">
			<a id="signin-link" href="sesion/cerrar-sesion.php">
				<strong>Cerrar sesion</strong>
			</a>
		</div>				
    </div>	
<?php

	}else{
	
?>		
	<div id="session">
		<a id="signin-link" href="#">
            <strong>Iniciar Sesion</strong>
        </a>
    </div>
    <div id="signin-dropdown">
        <form method="post" class="signin" action="sesion/validate-user.php">
            <fieldset class="textbox">
				<label class="username">
					<span>Nombre se usuario o Email</span>
					<input id="username" name="username" value="" type="text" autocomplete="on">
				</label>
              
				<label class="password">
					<span>Contrase&ntilde;a</span>
					<input id="password" name="password" value="" type="password">
				</label>
            </fieldset>
              
            <fieldset class="remb">
				<label class="remember">
					<input type="checkbox" value="1" name="remember_me" />
					<span>Recordarme</span>
				</label>
				<button class="submit button" type="submit">Ingresar</button>
            </fieldset>
            <p>
				<a class="forgot" href="#">&#191;Olvido su contrase&ntilde;a&#63;</a>
            </p>
        </form>
    </div>
	
<?php

	}
	
?>