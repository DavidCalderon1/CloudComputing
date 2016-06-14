<?php
	if(isset($_GET['id'])) {

		include '../conexion.php';

		$id = $_GET['id'];

		$query = "SELECT ar_name, ar_content FROM archivos WHERE ar_id=".$id;
		
	    $result = mysql_query($query, conexion()) or die('55');
		
	    list($ar_name, $ar_content) = mysql_fetch_array($result);

		$ourFileName = $ar_name;
		$ourFileHandle = fopen($ourFileName, 'w') or die('0');
		fwrite($ourFileHandle, $ar_content);
		fclose($ourFileHandle);

		echo $ourFileName;

	}
?>