<?php

	require_once("../conexion.php");
	$conn = conexion();

	function ingreso_proveedor($nombre,$direccion,$telefono){
		
		$result=$GLOBALS['conn']->query("SELECT MAX(IdProveedor)+1 as max_id FROM COMPRA.proveedor;");
		
		while($results = $result->fetch(PDO::FETCH_ASSOC)){				
			$max_cid=$results['max_id']; 				
		}
		
		$rows = count($result);	
		if(($rows==1)&&($max_cid==NULL)){				
			$max_cid=1;				
		}
		
		$result=$GLOBALS['conn']->query("INSERT INTO COMPRA.proveedor (IdProveedor, Nom_Proveedor, Dir_Proveedor, Tel_Proveedor) VALUES (".$max_cid.",'".$nombre."','".$direccion."','".$telefono."');");
		setcookie("id","".$max_cid."",time()+60*60*24*365,"/");			
		return 1;
		
	}
	
	function seleccion_proveedor($id){
		
		$result=$GLOBALS['conn']->query("SELECT IdProveedor, Nom_Proveedor, Dir_Proveedor, Tel_Proveedor FROM COMPRA.proveedor WHERE IdProveedor ='".$id."';");
		$result = $result->fetchAll();				
		return $result;		
	}
	
	function busqueda_proveedor($patron,$opcion,$limit_inicio,$limit_pasos){
		
		if($opcion==1){
			$condicion = "Nom_Proveedor";
		}
		if($opcion==2){
			$condicion = "Dir_Proveedor";
		}
		if($opcion==3){
			$condicion = "Tel_Proveedor";
		}
		$result=$GLOBALS['conn']->query("SELECT * FROM ( SELECT IdProveedor, Nom_Proveedor, Dir_Proveedor, Tel_Proveedor, ROW_NUMBER() OVER (ORDER BY IdProveedor) as row FROM COMPRA.proveedor ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";");
		//echo "SELECT * FROM ( SELECT IdProveedor, Nom_Proveedor, Dir_Proveedor, Tel_Proveedor, ROW_NUMBER() OVER (ORDER BY IdProveedor) as row FROM COMPRA.proveedor ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";";
		$result = $result->fetchAll();
		return $result;
	}
	
	function actualizar_proveedor($IdProveedor,$nombre,$direccion,$telefono){
		
		$result=$GLOBALS['conn']->query("SELECT IdProveedor FROM COMPRA.proveedor WHERE IdProveedor='".$IdProveedor."';");
			
		while($results = $result->fetch(PDO::FETCH_ASSOC)){
			$u_IdProveedor=$results['IdProveedor']; 
		}
		if(($IdProveedor==$u_IdProveedor)){
			$result=$GLOBALS['conn']->query("UPDATE COMPRA.proveedor SET Nom_Proveedor='".$nombre."', Dir_Proveedor='".$direccion."', Tel_Proveedor='".$telefono."' WHERE IdProveedor='".$IdProveedor."';");
			setcookie("id","".$u_IdProveedor."",time()+60*60*24*365,"/");
			return 1;			
		}
		/* verificar si es necesario modificar los productos o los pedidos del Proveedor*/
		/*
		if(($empresa_nit!=$u_empresa_nit)&&($cliente_identificador!=$u_Proveedor_identificador)){
			
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
		
		if(($empresa_nit!=$u_empresa_nit)&&($cliente_identificador==$u_Proveedor_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit==$u_empresa_nit)&&($cliente_identificador!=$u_Proveedor_identificador)){
			
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

	function borrar_proveedor($IdProveedor){
							
		$result=$GLOBALS['conn']->query("DELETE FROM COMPRA.proveedor WHERE IdProveedor='".$IdProveedor."';");
		
		if($result->rowCount()>0){
			return 1;			
		}else{			
			return 0;			
		}		
	}
	
?>
