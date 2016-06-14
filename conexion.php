<?php
	/* realiza la conexion con la base de datos de sql azure*/
	function conexion(){		
		$datosDB = "sqlsrv:server = tcp:servidor-cloud1.database.windows.net,1433; Database = CloudBD1";
		$usuario = "AdminBD1";
		$password = "cloudbd1*";
		
		try {
			$conn = new PDO($datosDB, $usuario, $password);
			$conn->setAttribute(constant('PDO::SQLSRV_ATTR_DIRECT_QUERY'), true);			
			$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $e){
			print( "Error al conectar a SQL Server." );
			die(print_r($e));
		}
		return $conn;	
	}
	
	//$conn = conexion();
	
	/* Cadena de conexion obtenida de portal.azure.com
	Server: servidor-cloud1.database.windows.net,1433 \r\nSQL Database: CloudBD1\r\nUser Name: AdminBD1\r\n\r\nPHP Data Objects(PDO) Sample Code:\r\n\r\ntry {\r\n   $conn = new PDO ( \"sqlsrv:server = tcp:servidor-cloud1.database.windows.net,1433; Database = CloudBD1\", \"AdminBD1\", \"{your_password_here}\");\r\n    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );\r\n}\r\ncatch ( PDOException $e ) {\r\n   print( \"Error connecting to SQL Server.\" );\r\n   die(print_r($e));\r\n}\r\n\rSQL Server Extension Sample Code:\r\n\r\n$connectionInfo = array(\"UID\" => \"AdminBD1@servidor-cloud1\", \"pwd\" => \"{your_password_here}\", \"Database\" => \"CloudBD1\", \"LoginTimeout\" => 30, \"Encrypt\" => 1, \"TrustServerCertificate\" => 0);\r\n$serverName = \"tcp:servidor-cloud1.database.windows.net,1433\";\r\n$conn = sqlsrv_connect($serverName, $connectionInfo);
	*/
	

	/* selecciona todas las filas de la tabla PRUEBA */	
	/*
	function getColumnas($conn) {		
		$sql = 'SELECT COLUMNA_1, COLUMNA_2, COLUMNA_3, COLUMNA_4 FROM PRUEBA ORDER BY COLUMNA_2';
		
		foreach ($conn->query($sql) as $row) {
			print $row['COLUMNA_1'] . "\t";
			print $row['COLUMNA_2'] . "\t";
			print $row['COLUMNA_3'] . "<br>";
			print $row['COLUMNA_4'] . "<br>";
			print "<br>";
		}
	}
	getColumnas($conn);
	*/
?>