<?php
	require_once("../conexion.php");

/*volca todos los registro de la tabla empresa*/
	function seleccion_cliente(){
		
		$result=mysql_query("SELECT * FROM empresa INNER JOIN cliente ON(empresa.empresa_id=cliente.empresa_id);", conexion()) or die ("Problemas en la consuta a la base de datos: ".mysql_error());
				
		return $result;
		
	}
	
/*volca todos los registro de la tabla sucursal segun el parametro que le dan para el campo empresa_id*/
	function seleccion_sucursal($empresa){
		
		$result=mysql_query("SELECT * FROM sucursal INNER JOIN ciudad ON(sucursal.ciudad_id=ciudad.ciudad_id) WHERE empresa_id=".$empresa.";", conexion()) or die ("Problemas en la consuta a la base de datos: ".mysql_error());
				
		return $result;		
	}
/*se encarga de validar si por POST le envian una variable de nombre empresa y ejecuta la funcion correspondiente*/
	if(isset($_POST['empresa'])){
		
		$result=seleccion_sucursal($_POST['empresa']);
		
		while($results=mysql_fetch_array($result)){
			
	?>
			<option value="<?php echo $results['sucursal_id'];?>" title='<?php echo $results['sucursal_nombre']." ".$results['ciudad_nombre'];?>'><?php echo $results['sucursal_nombre']." ".$results['ciudad_nombre'];?></option>
	<?php

		}		
	}
	
	
/*volca todos los registro de la tabla tipo_muestra*/
	function seleccion_tipomuestra(){
	
		$result=mysql_query("SELECT * FROM tipo_muestra;", conexion()) or die("Problemas en la consutal a la base datos: ".mysql_error());
		return $result;
	
	}
	
/*sirve para validar que el codigo antiguo no este ya en la BD*/
	function codigoAntiguo($previous_code){
		$queryCodigo = "SELECT * FROM muestra WHERE muestra_previouscode='".$previous_code."';";
		$result=mysql_query($queryCodigo, conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		
		if(((mysql_num_rows($result))==0)||($previous_code=="")){
			
			echo "1";
		}else{
			
			echo "0";
		}
	}
/*se encarga de validar si por POST le envian una variable de nombre codigoAntiguo y ejecuta la funcion correspondiente*/	
	if(isset($_POST['codigoAntiguo'])){
		
		codigoAntiguo($_POST['codigoAntiguo']);
	}
	
	
/*sirve para entregar el id valido ( MAX(id)+1 ) para la proxima insercion en las tablas de la BD*/
	function idMaximo($id, $tabla){			
			$result=mysql_query("SELECT MAX(".$id.")+1 as max_id FROM ".$tabla.";",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			while($results=mysql_fetch_array($result)){
				
				$max_id=$results['max_id'];				
			}			
			if(((mysql_num_rows($result))==1)&&($max_id==NULL)){
				
				$max_id=1;				
			}			
			return $max_id;
	}
	
/*sirve para entregar el cliente_identificador para la proxima insercion en las tablas de la BD*/
	function clienteIdentificador($sucursal){			
			
			$result=mysql_query("SELECT cliente_identificador FROM sucursal INNER JOIN empresa ON(sucursal.empresa_id=empresa.empresa_id) INNER JOIN cliente ON(empresa.empresa_id=cliente.empresa_id) WHERE sucursal.sucursal_id='".$sucursal."' LIMIT 1;", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			/*
			while($results=mysql_fetch_array($result)){
				
				$cliente_identificador=$results['cliente_identificador'];				
			}*/
			$results=mysql_fetch_array($result);
			$cliente_identificador=$results['cliente_identificador'];
			echo $cliente_identificador;
	}
	
	if(isset($_POST['idSucursal'])){
		
		clienteIdentificador($_POST['idSucursal']);
	}

/*sirve para insertar un nuevo registro en la tabla de control 'entrada_salida_muestra' a partir de la muestra que acaba de guardarse*/
	function entrada_salida_muestra($sucursal,$fecha,$max_id){
		
			$esmMax_id=idMaximo('esm_id','entrada_salida_muestra');
			
			$esmCampos ="INSERT INTO entrada_salida_muestra (esm_id,muestra_id,esm_procedencia,esm_destino,fecha) ";
			$esmQuery =$esmCampos."VALUES(".$esmMax_id.",".$max_id.",".$sucursal.",61,'".$fecha."')";
			
			$result=mysql_query($esmQuery,conexion()) or die("Problemas en la consulata a la base de datos: ".mysql_error());
			
			setcookie("id","".$max_id."",time()+60*60*24*365,"/");
			
			return 1;
	}
	
	function ingreso_muestra($clente_identificador,$previous_code,$fecha,$sucursal,$num_factura,$tipom,$referencia,$archivoId,$descripcion){
				
			$max_id=idMaximo('muestra_id','muestra');	
			$identCliente = $clente_identificador.$max_id;
			
			$queryCampos ="INSERT INTO muestra (muestra_id,muestra_sid,muestra_previouscode,muestra_fecha,sucursal_id,muestra_numfactura,tipom_id,muestra_referencia,ar_id,muestra_descripcion) "; 
			$queryDatos = $queryCampos."VALUES(".$max_id.",'".$identCliente."','".$previous_code."','".$fecha."',".$sucursal.",'".$num_factura."','".$tipom."','".$referencia."',".$archivoId.",'".$descripcion."')";
			
			$result=mysql_query($queryDatos,conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error()." 0");
			
			$esmResult = entrada_salida_muestra($sucursal,$fecha,$max_id);
			
			return $esmResult;	
	}

	function actualizar_muestra($muestraId,$clienteId,$codigo,$fecha,$sucursal,$numfac,$tipoMuestra,$referencia,$archivoId,$descripcion){	
			
			$UpdMuestra ="UPDATE `muestra` SET `muestra_sid` = '".$clienteId.$muestraId."', `muestra_previouscode` = '".$codigo."', `muestra_fecha` = '".$fecha."', `sucursal_id` = '".$sucursal."', `muestra_numfactura` = '".$numfac."', `tipom_id` = '".$tipoMuestra."', `muestra_referencia` = '".$referencia."', `ar_id` = '".$archivoId."', `muestra_descripcion` = '".$descripcion."' WHERE `muestra`.`muestra_id` = ".$muestraId."";
			$result=mysql_query($UpdMuestra, conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			setcookie("id","".$muestraId."",time()+60*60*24*365,"/");
			
			return 1;
	}

	function seleccion_muestra($id){
		
		$selMuestCampos ="SELECT mu.muestra_id, mu.muestra_sid, emp.empresa_id, emp.empresa_razonsocial, suc.sucursal_id, suc.sucursal_nombre, ciu.ciudad_nombre, mu.muestra_previouscode,  mu.muestra_fecha, tpm.tipom_id, tpm.tipo_muestra, mu.muestra_numfactura, mu.muestra_referencia, mu.ar_id, ar.ar_name,  mu.muestra_descripcion, cli.cliente_identificador ";
		$selMuestJoins =$selMuestCampos."FROM muestra as mu INNER JOIN archivos as ar ON(mu.ar_id=ar.ar_id) INNER JOIN tipo_muestra as tpm ON(mu.tipom_id=tpm.tipom_id) INNER JOIN sucursal as suc ON(mu.sucursal_id=suc.sucursal_id) INNER JOIN ciudad as ciu ON(suc.ciudad_id=ciu.ciudad_id) INNER JOIN empresa as emp ON(suc.empresa_id=emp.empresa_id) INNER JOIN cliente AS cli ON ( emp.empresa_id = cli.empresa_id ) WHERE muestra_id=".$id;
	
		$result=mysql_query($selMuestJoins, conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
	
		return $result;
	
	}	
	
	function busqueda_muestra($patron,$opcion,$limit_inicio,$limit_pasos){
		$selMuestCamposBus ="SELECT mu.muestra_id, mu.muestra_sid, emp.empresa_id, emp.empresa_razonsocial, suc.sucursal_id, suc.sucursal_nombre, ciu.ciudad_nombre, mu.muestra_previouscode,  mu.muestra_fecha, tpm.tipom_id, tpm.tipo_muestra, mu.muestra_numfactura, mu.muestra_referencia, mu.ar_id, ar.ar_name,  mu.muestra_descripcion, cli.cliente_identificador ";
		$selMuestJoinsBus =$selMuestCamposBus."FROM muestra as mu INNER JOIN archivos as ar ON(mu.ar_id=ar.ar_id) INNER JOIN tipo_muestra as tpm ON(mu.tipom_id=tpm.tipom_id) INNER JOIN sucursal as suc ON(mu.sucursal_id=suc.sucursal_id) INNER JOIN ciudad as ciu ON(suc.ciudad_id=ciu.ciudad_id) INNER JOIN empresa as emp ON(suc.empresa_id=emp.empresa_id) INNER JOIN cliente AS cli ON ( emp.empresa_id = cli.empresa_id ) WHERE ";
			 
		if($opcion==1){			
			$result=mysql_query($selMuestJoinsBus."tpm.tipo_muestra LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		if($opcion==2){			
			$result=mysql_query($selMuestJoinsBus."emp.empresa_razonsocial LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		if($opcion==3){
			$result=mysql_query($selMuestJoinsBus."mu.muestra_previouscode LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		if($opcion==4){
			$result=mysql_query($selMuestJoinsBus."mu.muestra_numfactura LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		if($opcion==5){
			$result=mysql_query($selMuestJoinsBus."mu.muestra_fecha LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		if($opcion==6){
			$result=mysql_query($selMuestJoinsBus."mu.muestra_referencia LIKE CONCAT('%".$patron."%') LIMIT ".$limit_inicio.", ".$limit_pasos.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		}
		
		return $result;
		
	}
	
	mysql_close(conexion());
?>