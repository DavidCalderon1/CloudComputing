<?php setcookie("i","0",time()+60*60*24*365,"/"); ?>
<?php setcookie("id","0",time()+60*60*24*365,"/"); ?>
<?php session_start(); ?>
<!doctype html>
<html>
 <head>

  <title>CloudSystem :: Bienvenido</title>


 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta http-equiv="Content-Style-Type" content="text/css" />

 <meta name="version" content="1.0.1" />
 

	<link rel="stylesheet" type="text/css" href="css/css_default.css">
    <link rel="stylesheet" type="text/css" href="css/css_login.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">

    <script type="text/javascript" src="js/jquery-1.9.0.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>    
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript">$.ajaxSetup({ cache: false });</script>
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript" src="js/accordion.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
    <!--<script src="js/css.js"></script>-->

</head>
	<script type="text/javascript">
		
					$(document).ready(function() {
						forInicio();
						
						navDefault();
						
						menuClick();
						
						runCheckButton();

						pestanaSortable();
						
						resizeWindow();
						
						setTimeout(function(){
							resizeWindow();
						},1000);
							
						
						$(window).resize(function(){
							resizeWindow();
						});
						
						labelCheck('body');
						
						//$( "#acordion" ).accordion();
						
					});
					
	</script>
				
  <body>
  	<div id="bodyTotal">
	    <div id="top-stuff">
	      <div id="top-bar-out">
	        <div id="container" align="right">
	          <div id="topnav">
	            <div class="active-links">
					<?php
						include 'sesion/check_user.php';
					?>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div id="line_logo">
	    	<br><font size="+4">CloudSystem</font>		
	    </div>
	    
				
		<?php
				
			If(isset($_SESSION['user_name'])){
					
		?>
				
				  <div id="menu">				
					<ul class="topnav" id="acordion">
					  <li><a href="#" id="inicio" onclick="navDefault()">Inicio</a></li>
					  <li><a href="#">Cliente</a>
						<ul>
						   <li><a href="#" id="agregar_cliente">Nuevo cliente</a></li>
						   <li><a href="#" id="buscar_cliente">Busqueda de clientes</a></li>
						</ul>
					  </li>
					  <li><a href="#">Proveedor</a>
						<ul>
						   <li><a href="#" id="agregar_proveedor">Nuevo proveedor</a></li>
						   <li><a href="#" id="buscar_proveedor">Busqueda de proveedores</a></li>
						</ul>
					  </li>
					  <li><a href="#">Usuario</a>
						<ul>
						   <li><a href="#" id="agregar_usuario">Nuevo usuario</a></li>
						   <li><a href="#" id="buscar_usuario">Busqueda de usuarios</a></li>
						</ul>
					  </li>
					  <li><a href="#">Producto</a>
						<ul>
						   <li><a href="#" id="agregar_producto">Nuevo producto</a></li>
						   <li><a href="#" id="buscar_producto">Busqueda de productos</a></li>
						</ul>
					  </li>
					  <li><a href="#">Pedido</a>
						<ul>
						   <li><a href="#" id="agregar_pedido">Nuevo pedido</a></li>
						   <!--<li><a href="#" id="buscar_pedido">Busqueda de pedidos</a></li>-->
						</ul>
					  </li>
					  <!--
					  <li><a href="#">Muestra</a>
						<ul>
						   <li><a href="#" id="agregar_muestra">Nueva muestra</a></li>
						   <li><a href="#" id="buscar_muestra">Busqueda de muestras</a></li>
						</ul>
					  </li>
					  <li><a href="#">Colaborador</a>
						<ul>
						   <li><a href="#" id="agregar_colaborador">Nuevo colaborador</a></li>
						   <li><a href="#" id="buscar_colaborador">Busqueda de colaborador</a></li>
						</ul>
					  </li>
					  <li><a href="#">Perfil de Usuario</a>
						<ul>
						   <li><a href="#" id="vacio">Ver perfil</a></li>
						   <li><a href="#" id="vacio">Editar perfil</a></li>
						</ul>
					  </li> 
						-->
				  </div>
				  <script type="text/javascript">
				  	$(document).ready(function(){
				  		$('body > div > #navegacion, body > div > #index').css({'margin-left':'2px'});
				  	});				  	
				  </script>				  
			<?php
				}else{
					echo "						
				  <script>
				  	$(document).ready(function(){
				  		$('body > div > #navegacion, body > div > #index').css({'margin-left':'14%'});
				  	});
				  </script>	
						";
				}				
			?>
				
		<div id="temporal">
		</div>
		<div id="navegacion">	
		</div>
		<div id="index">
			<div id="pestana">
			</div>
			<div id="space">	
			</div>
		</div>
<div>
	<form action="muestra/procedimientos_muestra.php" method="post" name="testForm">
		<!--input type="text" name="codigoAntiguo">
		<input type="submit" name="testEnvio" value="Probar"-->
	</form>
</div>
		<div id="foot">
			<div id="footCont">
				<div id="itemFootBottom">
					Copyright(c) 2016 
				</div>
			</div>
		</div>
	</div>
  </body>
</html>	