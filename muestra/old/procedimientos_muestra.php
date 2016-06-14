<?php

	require_once("../conexion.php");

	function seleccion_cliente(){
		
		$result=mysql_query("SELECT * FROM empresa INNER JOIN cliente ON(empresa.empresa_id=cliente.empresa_id);", conexion()) or die ("Problemas en la consuta a la base de datos: ".mysql_error());
				
		return $result;
		
	}
	
	function seleccion_sucursal($empresa){
		
		$result=mysql_query("SELECT * FROM sucursal INNER JOIN ciudad ON(sucursal.ciudad_id=ciudad.ciudad_id) WHERE empresa_id=".$empresa.";", conexion()) or die ("Problemas en la consuta a la base de datos: ".mysql_error());
				
		return $result;
		
	}
	
	if(isset($_POST['empresa'])){
		
		$result=seleccion_sucursal($_POST['empresa']);
		
?>


<?php
		
		while($results=mysql_fetch_array($result)){
			
?>

<option value="<?php echo $results['sucursal_id'];?>"><?php echo $results['sucursal_nombre']." ".$results['ciudad_nombre'];?><option>

<?php

		}
		
	}
	
	function seleccion_tipomuestra(){
	
		$result=mysql_query("SELECT * FROM tipo_muestra;", conexion()) or die("Problemas en la consutal a la base datos: ".mysql_error());
		return $result;
	
	}
	
	function ingreso_muestra($previous_code,$sucursal,$fecha,$num_factura,$tipom,$descripcion){
		
		$result=mysql_query("SELECT * FROM muestra WHERE muestra_previouscode='".$previous_code."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		
		if((mysql_num_rows($result))==0){
			
			$result=mysql_query("SELECT MAX(muestra_id)+1 as max_id FROM muestra;",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			while($results=mysql_fetch_array($result)){
				
				$max_id=$results['max_id']; 
				
			}
			
			if(((mysql_num_rows($result))==1)&&($max_id==NULL)){
				
				$max_id=1;
				
			}
			
			$result=mysql_query("SELECT cliente_identificador FROM sucursal INNER JOIN empresa ON(sucursal.empresa_id=empresa.empresa_id) INNER JOIN cliente ON(empresa.empresa_id=cliente.empresa_id) WHERE sucursal.sucursal_id='".$sucursal."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			while($results=mysql_fetch_array($result)){
				
				$clente_identificador=$results['cliente_identificador'];
				
			}
			
			$result=mysql_query("INSERT INTO muestra VALUES(".$max_id.",'".$clente_identificador.$max_id."','".$previous_code."',".$fecha.",'".$sucursal."','".$num_factura."','".$tipom."','".$descripcion."');",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			return 1;
			
		}else{
			
			return 0;
			
		}
	}

?>