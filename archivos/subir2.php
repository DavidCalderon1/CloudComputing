<html>
	<head>
		<title>Mantenimiento al Catalogo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
		.box {
		    font-family: Arial, Helvetica, sans-serif;
		    font-size: 12px;
		    border: 1px solid #000000;
		}
		-->
		</style>
	</head>

	<body>
		
		<form 	action="" 
				method="post" 
				enctype="multipart/form-data" 
				name="uploadform">
			<table 	width="350" 
					border="0" 
					cellpadding="1" 
					cellspacing="1" 
					class="box">
					
						<tr>
							<td width="80">
								Codigo <br>
								<input 	name=	"codigo"
										type=	"text" 
										class=	"box" 
										id=		"codigo">
								<br>
								Descripcion	<br>
								<textarea name="descripcion" rows="10" cols="40"></textarea>
							</td>
						
						</tr>
						
					    <tr> 
							
						    <td width="246">
								
							
							<?php /*SHOW VARIABLES LIKE  'max_allowed_packet'*/ ?>
								<input 	type=	"hidden"
										name=	"tamanoMaximo" 
										value=	"1048576">

								<input 	type=	"hidden"
										name=	"MAX_FILE_SIZE" 
										value=	"20000000">
								
								<input 	name=	"userfile"
										type=	"file" 
										class=	"box" 
										id=		"userfile"> <br>
								<input 	name=	"upload" 
										type=	"submit" 
										class=	"box" 
										id=		"upload" 
										value=	"  Enviar  ">
										
						    </td>
					    </tr>
						
			</table>
		</form>
		
		<?php
			if(isset($_POST['upload'])) {
				$fileName = $_FILES['userfile']['name'];
				$tmpName  = $_FILES['userfile']['tmp_name'];
				$fileSize = $_FILES['userfile']['size'];
				$fileType = $_FILES['userfile']['type'];

				$tamanoMaximo = $_POST['tamanoMaximo'];

				$fp = fopen($tmpName, 'r');
				$content = fread($fp, $fileSize);
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc()) {
					$fileName = addslashes($fileName);
				}

				if($fileSize > $tamanoMaximo) {
					echo ' El archivo tiene un tama&ntilde;o de '.$fileSize.' bytes y es mayor al permitido, reduzca el tama&ntilde;o a m&aacute;ximo '.$tamanoMaximo.' bytes o intente subir uno mas peque&ntilde;o';
				}else if($fileSize == 0){
					echo ' El archivo tiene un tama&ntilde;o de '.$fileSize.' bytes lo cual quiere decir que es mucho mayor al permitido, reduzca el tama&ntilde;o a m&aacute;ximo '.$tamanoMaximo.' bytes o intente subir uno mas peque&ntilde;o';
				}else{
				

				include '../conexion.php';				
				
				$codigo = $_POST['codigo']; 
				$descripcion = $_POST['descripcion']; 
				
				
				$first = 'INSERT INTO archivos (name, size, type, content, descripcion ) ';
				$query = "".$first."VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$descripcion')";
								
				$co =mysql_query($query, conexion()) or die('Error, query fallido: '.mysql_error() ); 

				echo "<br>File $fileName uploaded<br>";

				}
			}        
		?>
	</body>
</html>

	