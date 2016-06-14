<?php
	if(isset($_POST['formulario'])){//isset($_POST['print']) && 
		//$printPage='<script>printpage();</script>';
?>
<!doctype html>
<html>
	<head>
		<script>
			function printpage(){			
			window.print();
			}
		</script>
	</head>
	<body>
		<h2>Geoanalyst: <?php echo $_POST['formulario']; ?></h2>
		<br>
		<input type="hidden" id="ejecutarPrint" onclick="printpage()">
	</body>
</html>
<?php
			//echo $_POST['print'];
			//echo $printPage;		
	}
?>