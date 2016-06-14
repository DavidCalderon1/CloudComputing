<?php
	/* Elimina, Crea, Inserta y selecciona una tabla y sus datos */
	$datosDB = "sqlsrv:server = tcp:servidor-cloud1.database.windows.net,1433; Database = CloudBD1";
	$usuario = "AdminBD1";
	$password = "cloudbd1*";
	
	/*Conexion con sql azure*/
	$conn = new PDO($datosDB, $usuario, $password);
	$conn->setAttribute(constant('PDO::SQLSRV_ATTR_DIRECT_QUERY'), true);

	$stmt1 = $conn->query("DROP TABLE #php_test_table");

	$stmt2 = $conn->query("CREATE TABLE #php_test_table ([c1_int] int, [c2_int] int)");

	$v1 = 1;
	$v2 = 2;

	$stmt3 = $conn->prepare("INSERT INTO #php_test_table (c1_int, c2_int) VALUES (:var1, :var2)");
	$exitosa=false;
	
	if ($stmt3) {
		$stmt3->bindValue(1, $v1);
		$stmt3->bindValue(2, $v2);

		if ($stmt3->execute()){
			echo "Ejecucion exitosa \n";
			$exitosa=true;
		}else{
			echo "Ejecucion fallida \n";
		}
	}else{
		var_dump($conn->errorInfo());
	}
	
	/* selecciona todas las filas de la tabla #php_test_table */		
	function getColumnas($conn, $exitosa) {
		if ($exitosa){			
			$sql = 'SELECT c1_int, c2_int FROM #php_test_table';
			
			echo '<table border=1 >';		
			print "<tr>";
			print "<td><b> c1_int </b></td>";
			print "<td><b> c2_int </b></td>";
			print "</tr>";
			foreach ($conn->query($sql) as $row) {
				print "<tr>";
				print "<td>" . $row['c1_int'] . "</td>";
				print "<td>" . $row['c2_int'] . "</td>";
				print "</tr>";
			}
			echo '</table>';
		}
	}
	getColumnas($conn, $exitosa);
	
	$sql = 'SELECT c1_int, c2_int FROM #php_test_table';
	$getName = $conn->prepare($sql);
	$getName->execute();
	$result = $getName->fetch(PDO::FETCH_ASSOC);
	echo $result['c1_int'];
		
	//$stmt4 = $conn->query("DROP TABLE #php_test_table");
?>