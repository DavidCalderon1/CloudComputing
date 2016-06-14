<?php

	require_once("../conexion.php");
	$conn = conexion();

	function ingreso_cliente($nombre,$direccion,$telefono){
		
		$result=$GLOBALS['conn']->query("SELECT MAX(IdCliente)+1 as max_id FROM VENTA.cliente;");
		
		while($results = $result->fetch(PDO::FETCH_ASSOC)){				
			$max_cid=$results['max_id']; 				
		}
		
		$rows = count($result);	
		if(($rows==1)&&($max_cid==NULL)){				
			$max_cid=1;				
		}
		
		$result=$GLOBALS['conn']->query("INSERT INTO VENTA.cliente (IdCliente, Nom_Cliente, Dir_Cliente, Tel_Cliente) VALUES (".$max_cid.",'".$nombre."','".$direccion."','".$telefono."');");
		setcookie("id","".$max_cid."",time()+60*60*24*365,"/");			
		return 1;
		
	}
	
	function seleccion_cliente($id){
		
		$result=$GLOBALS['conn']->query("SELECT IdCliente, Nom_Cliente, Dir_Cliente, Tel_Cliente FROM venta.cliente WHERE IdCliente ='".$id."';");
		$result = $result->fetchAll();				
		return $result;		
	}
	
	function busqueda_cliente($patron,$opcion,$limit_inicio,$limit_pasos){
		
		if($opcion==1){
			$condicion = "Nom_Cliente";
		}
		if($opcion==2){
			$condicion = "Dir_Cliente";
		}
		if($opcion==3){
			$condicion = "Tel_Cliente";
		}
		$result=$GLOBALS['conn']->query("SELECT * FROM ( SELECT IdCliente, Nom_Cliente, Dir_Cliente, Tel_Cliente, ROW_NUMBER() OVER (ORDER BY IdCliente) as row FROM venta.cliente ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";");
		//echo "SELECT * FROM ( SELECT IdCliente, Nom_Cliente, Dir_Cliente, Tel_Cliente, ROW_NUMBER() OVER (ORDER BY IdCliente) as row FROM venta.cliente ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";";
		$result = $result->fetchAll();
		return $result;
	}
	
	function actualizar_cliente($IdCliente,$nombre,$direccion,$telefono){
		
		$result=$GLOBALS['conn']->query("SELECT IdCliente FROM VENTA.cliente WHERE IdCliente='".$IdCliente."';");
			
		while($results = $result->fetch(PDO::FETCH_ASSOC)){
			$u_IdCliente=$results['IdCliente']; 
		}
		if(($IdCliente==$u_IdCliente)){
			$result=$GLOBALS['conn']->query("UPDATE VENTA.cliente SET Nom_Cliente='".$nombre."', Dir_Cliente='".$direccion."', Tel_Cliente='".$telefono."' WHERE IdCliente='".$IdCliente."';");
			setcookie("id","".$u_IdCliente."",time()+60*60*24*365,"/");
			return 1;			
		}
		/* verificar si es necesario modificar las facturas del cliente*/
		/*
		if(($empresa_nit!=$u_empresa_nit)&&($cliente_identificador!=$u_cliente_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			$result_2=mysql_query("SELECT * FROM cliente WHERE cliente_identificador='".$cliente_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)&&((mysql_num_rows($result_2)==0))){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE cliente SET cliente_identificador='".$cliente_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit!=$u_empresa_nit)&&($cliente_identificador==$u_cliente_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit==$u_empresa_nit)&&($cliente_identificador!=$u_cliente_identificador)){
			
			$result_2=mysql_query("SELECT * FROM cliente WHERE cliente_identificador='".$cliente_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_2)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE cliente SET cliente_identificador='".$cliente_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		*/
	}

	function borrar_cliente($IdCliente){
							
		$result=$GLOBALS['conn']->query("DELETE FROM VENTA.cliente WHERE IdCliente='".$IdCliente."';");
		
		if($result->rowCount()>0){
			return 1;			
		}else{			
			return 0;			
		}		
	}
	
?>
