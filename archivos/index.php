<html>
	<head>
		<title>Descarga imagenes desde MySQL</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>

<body>
	PAGINA PRINCIPAL <BR>

	<?php
		include '../conexion.php';		

		$query  = "SELECT ar_id, name, descripcion FROM archivos";
		$result = mysql_query($query, conexion())or die('Error, query fallido: '.mysql_error());
		if(mysql_num_rows($result) == 0) {
		    echo "Database is empty <br>";
		} 
		else {
	?>
		
			<H1>CONSULTA DE CATALOGO</H1> 
			<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=1> 
				<TR>
					<TD> id Articulo</TD>
					<TD> nombre</TD>
					<TD> ImagenDesc</TD>
					<TD> Imagen</TD>
				</tr>	
	<?php	
		
				while($results = mysql_fetch_assoc($result)) {
					echo"<tr>
							<td> ".$results['ar_id']." </td> 
							<td> ".$results['name']." </td> 
							<td> ".$results['descripcion']." </td> 
							"; 			
	?>				
							<td height=300><img src="download.php?id=<?php echo $results['ar_id'];?>"> </td>
							<!--td width="800px" height="1000px" ><embed width="100%" height="100%" name="plugin" src="download.php?id=<?php echo $results['ar_id'];?>" type="application/pdf"></td-->	

						</tr>
	<?php						
				}  
			}
	?>
		 
			 </table> 
	</body>
</html>

