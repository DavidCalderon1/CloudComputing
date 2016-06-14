<?php
	if(isset($_GET['id_arch'])) {

		include '../conexion.php';

		$id =$_GET['id_arch'];
		$query ="SELECT ar_name, ar_size FROM archivos WHERE ar_id=".$id;
	    $result  	= mysql_query($query, conexion()) or die('5'.mysql_error());
	    list($ar_name, $ar_size) = mysql_fetch_array($result);
		if(file_exists($ar_name)){
/*
$file=$name;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="$name"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($size));
readfile($file);
*/
			unlink($ar_name);
			echo 1;
		}else{
			echo 0;
		}
	}
?>