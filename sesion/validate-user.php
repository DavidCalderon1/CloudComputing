<!doctype html>

<?php 

	include '../conexion.php';
	
?>

<html>
	<head>
		<title>Login CloudSystem</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/css_default.css">
	</head>
	<body id="background_body">
		<div id="transparent_div">
			<?php
				$usuario_password = md5($_POST['password']);
				$sql="select Estado_Usuario as validacion from RRHH.usuario where Usuario_Nombre = '".$_POST['username']."' and Usuario_Password = '".$usuario_password."' ";	
				//echo $sql;
				$conn = conexion();
				$result = $conn->prepare($sql);
				if ($result->execute()){
					$results = $result->fetch(PDO::FETCH_ASSOC);
					if($results['validacion']==1){
						session_start();
						$_SESSION['user_name']=$_POST['username'];
					
			?>
		
			<table width="600" align="center" style="top: 50px;position: relative;color: #fff;">
				<tr>
					<td align="center">
						<font color="#FFFFFF"><strong>Bienvenido de nuevo <?php echo $_POST['username'] ?>, Gracias por iniciar sesión.</strong></font>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="circle"></div>
						<div class="circle1"></div>
					</td>
				</tr>
			</table>
		
			<meta http-equiv="refresh" content="3;../">
		
			<?php
			
					}else if($results['validacion']==2){
				
			?>

			<table width="600" align="center" style="top: 50px;position: relative;color: #fff;">
				<tr>
					<td align="center">
						<font color="#FFFFFF"><strong>El usuario no esta activo, por favor comun&iacute;quese con el administrador para solucionarlo.</strong></font>
						<meta http-equiv="refresh" content="6;../">
					</td>
				</tr>
			</table>
		
			<?php
			
					}else{
				
			?>

			<table width="600" align="center" style="top: 50px;position: relative;color: #fff;">
				<tr>
					<td align="center">
						<font color="#FFFFFF"><strong>Has introducido un nombre de usuario o contraseña no válidos. No olvides que la contraseña es	sensible a min&uacute;sculas y may&uacute;sculas.</strong></font>
						<meta http-equiv="refresh" content="6;../">
					</td>
				</tr>
			</table>
		
			<?php
			
					}
				}
				
			?>
			
		</div>
	</body>
</html>
