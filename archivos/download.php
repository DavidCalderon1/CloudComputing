<?php
	if(isset($_GET['id'])) {
	    include '../conexion.php';
		/*$connection=mysql_connect("$bdservidor","$bdunombre","$bdpass")
			or die("Error conectando a la base de datos");
			
		$db=mysql_select_db("$bdnombre", conexion())
			or die ("Error seleccionando la base de datos");
		*/
	    $id      	= $_GET['id'];
	    $query  	= "SELECT name, type, size, content FROM archivos WHERE ar_id = '$id'";
	    $result  	= mysql_query($query, conexion()) or die('Error, query fallido: '.mysql_error());
	    list($name, $type, $size, $content) = mysql_fetch_array($result);

	    header("Content-Disposition: attachment; filename=$name");
	    header("Content-length: $size");
	    header("Content-type: $type");
	    echo $content;
	    exit;
	}
?>
