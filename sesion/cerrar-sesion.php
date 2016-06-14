<!doctype html>

<html>
	<head>  	
		<meta charset="utf-8">
		<title>Cierre de sesion</title>
		<link rel="stylesheet" type="text/css" href="../css/css_default.css">
	</head>
	<body id="background_body">
		<?php
  
			session_start();
  
		?>
		<div id="transparent_div">
			<table width="600" align="center" style="top: 50px;position: relative;color: #fff;">
				<tr>
					<td align="center">
						<strong><?php echo $_SESSION['user_name']?>, el cierre de sesion fue completado satisfactoriamente.</strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="circle"></div>
						<div class="circle1"></div>
					</td>
				</tr>
			</table>
		
			<?php
		
				session_unset();
				session_destroy();
		
			?>
			<meta http-equiv="refresh" content="3;../">
		</div>
	</body>
</html>