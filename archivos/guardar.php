	<?php
		function subirArchivo(){
			if(isset($_FILES['archivo'])) {
				$fileName = $_FILES['archivo']['name'];
				$tmpName  = $_FILES['archivo']['tmp_name'];
				$fileSize = $_FILES['archivo']['size'];
				$fileType = $_FILES['archivo']['type'];

				$tamanoMaximo = $_POST['tamanoMaximo'];
				$oculto = $_POST['oculto'];

				$fecha = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s").'-----'.date("O");
			
				$fp = fopen($tmpName, 'r');
				$content = fread($fp, $fileSize);
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc()) {
					$fileName = addslashes($fileName);
				}

				if($fileSize > $tamanoMaximo) {
					//echo 'El archivo tiene un tama&ntilde;o de '.$fileSize.' bytes y es mayor al permitido, reduzca el tama&ntilde;o a m&aacute;ximo '.$tamanoMaximo.' bytes o intente subir uno mas peque&ntilde;o';
					echo '<script> alert("El archivo tiene un peso de '.$fileSize.' bytes y es mayor al permitido, reduzca el peso a '.$tamanoMaximo.' bytes o intente subir uno mas liviano");</script>';
				}else if($fileSize == 0){
					//echo 'El archivo tiene un tama&ntilde;o de '.$fileSize.' bytes lo cual quiere decir que es mucho mayor al permitido, reduzca el tama&ntilde;o a m&aacute;ximo '.$tamanoMaximo.' bytes o intente subir uno mas peque&ntilde;o';
					echo '<script> alert("El archivo tiene un peso mucho mayor al permitido, reduzca el peso a '.$tamanoMaximo.' bytes o intente subir uno mas liviano");</script>';
				}else{
				
					include '../conexion.php';				
					if(isset($_POST['descripcion'])){
						$descripcion = $_POST['descripcion'];
	 				}else{
						$descripcion ='';
					}
					$first = 'INSERT INTO archivos (ar_name, ar_size, ar_type, ar_content, ar_descripcion) ';
					$query = "".$first."VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$descripcion')";
									
					$co =mysql_query($query, conexion()) or die('Error, query 1 fallido: '.mysql_error() ); 
	
					$consulta = "SELECT ar_id, ar_name FROM `archivos` where ar_name='".$fileName."' AND ar_type='".$fileType."' AND ar_size='".$fileSize."' AND ar_descripcion='".$descripcion."' ORDER BY ar_id DESC LIMIT 1 ";
	
					$cons =mysql_query($consulta, conexion()) or die('Error, query 2 fallido: '.mysql_error() );

					$ar_id = '';
					$name = '';

					while($results=mysql_fetch_array($cons)){
						$ar_id = $results['ar_id'];
						$name = $results['ar_name'];
					}

					if($fileName == $name){
						echo "<div title='".$fileName."'>Archivo guardado</div>";
						$respuesta['id']= $ar_id;
						$respuesta['fileName']= $fileName;
						$respuesta['fileSize']= $fileSize;
						$respuesta['fileType']= $fileType;
						$respuesta['descripcionFile']= $descripcion;
						echo "<script>";
						foreach ($respuesta as $key => $value) {
							echo '$("'.$oculto.' input#'.$key.'").val("'.$value.'");';
						}
						echo "</script>";
					}else{
						echo "<script> alert(\"ERROR, El archivo:    \t \t  ".$fileName."  \t \t  no fue guardado correctamente, por favor asigne un nombre mas corto al archivo e/o intente subirlo nuevamente\");</script>";
					}				
					mysql_close(conexion());
				}
			}
		}
	subirArchivo();
	?>		