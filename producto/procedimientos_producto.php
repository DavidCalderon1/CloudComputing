<?php

	require_once("../conexion.php");
	$conn = conexion();

	function ingreso_producto($nombre,$descripcion,$ValorUnit_Producto,$idproveedor){
		
		$result=$GLOBALS['conn']->query("SELECT MAX(Idproducto)+1 as max_id FROM COMPRA.producto;");
		
		while($results = $result->fetch(PDO::FETCH_ASSOC)){				
			$max_cid=$results['max_id']; 				
		}		
		$rows = count($result);	
		if(($rows==1)&&($max_cid==NULL)){				
			$max_cid=1;				
		}
		$result=$GLOBALS['conn']->query("INSERT INTO COMPRA.producto (Idproducto, Nom_producto, Desc_producto, ValorUnit_Producto, producto_IdProveedor) VALUES (".$max_cid.",'".$nombre."','".$descripcion."','".$ValorUnit_Producto."','".$idproveedor."');");
		setcookie("id","".$max_cid."",time()+60*60*24*365,"/");			
		return 1;
	}
	
	function seleccion_proveedor(){
		
		$result=$GLOBALS['conn']->query("SELECT IdProveedor, Nom_Proveedor FROM COMPRA.proveedor;");
		//$result = $result->fetchAll();				
		return $result;		
	}
	
	function seleccion_producto($id){
		
		$result=$GLOBALS['conn']->query("SELECT p.Idproducto, p.nom_producto, p.desc_producto, p.ValorUnit_Producto, p.producto_IdProveedor, pr.idproveedor, pr.nom_proveedor FROM COMPRA.producto AS P INNER JOIN COMPRA.proveedor AS pr ON(p.producto_idproveedor = pr.idproveedor) WHERE p.idproducto ='".$id."';");
		$result = $result->fetchAll();				
		return $result;		
	}
	
	function busqueda_producto($patron,$opcion,$limit_inicio,$limit_pasos){
		
		if($opcion==1){
			$condicion = "Nom_producto";
		}
		if($opcion==2){
			$condicion = "Desc_producto";
		}
		if($opcion==3){
			$condicion = "ValorUnit_Producto";
		}
		if($opcion==4){
			$condicion = "IdProveedor";
		}
		$result=$GLOBALS['conn']->query("SELECT * FROM ( SELECT p.Idproducto, p.Nom_producto, p.Desc_producto, p.ValorUnit_Producto, pr.Nom_Proveedor, ROW_NUMBER() OVER (ORDER BY p.Idproducto) as row FROM COMPRA.producto AS p INNER JOIN COMPRA.proveedor AS pr ON(p.producto_IdProveedor = pr.Idproveedor) ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";");
		//echo "SELECT * FROM ( SELECT U.Idproducto, U.producto_nombre, U.producto_IdTipo_producto, TU.Nom_Tipo_producto, U.Estado_producto, IIF( U.Estado_producto = 1 , 'Activo', 'Inactivo') AS Nombre_Estado_producto, ROW_NUMBER() OVER (ORDER BY U.Idproducto) as row FROM RRHH.producto AS U INNER JOIN RRHH.tipo_producto AS TU ON(U.producto_IdTipo_producto = TU.IdTipo_producto) ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";";
		$result = $result->fetchAll();
		return $result;
	}
	
	function actualizar_producto($Idproducto,$nombre,$descripcion,$ValorUnit_Producto,$idproveedor){
		/*consulta el idproducto para compararlo, si no salen resultados es incorrecto*/
		$result=$GLOBALS['conn']->query("SELECT Idproducto FROM COMPRA.producto WHERE Idproducto='".$Idproducto."';");
			
		while($results = $result->fetch(PDO::FETCH_ASSOC)){
			$u_Idproducto=$results['Idproducto']; 
		}
		
		if($Idproducto==$u_Idproducto){
			
			$result=$GLOBALS['conn']->query("UPDATE COMPRA.producto SET Nom_producto='".$nombre."', Desc_producto='".$descripcion."' ValorUnit_Producto='".$ValorUnit_Producto."', producto_IdProveedor='".$idproveedor."' WHERE Idproducto='".$Idproducto."';");
			setcookie("id","".$u_Idproducto."",time()+60*60*24*365,"/");
			return 1;			
		}
		/* verificar si es necesario modificar las facturas del producto*/
		/*
		if(($empresa_nit!=$u_empresa_nit)&&($producto_identificador!=$u_producto_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			$result_2=mysql_query("SELECT * FROM producto WHERE producto_identificador='".$producto_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)&&((mysql_num_rows($result_2)==0))){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE producto SET producto_identificador='".$producto_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit!=$u_empresa_nit)&&($producto_identificador==$u_producto_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit==$u_empresa_nit)&&($producto_identificador!=$u_producto_identificador)){
			
			$result_2=mysql_query("SELECT * FROM producto WHERE producto_identificador='".$producto_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_2)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE producto SET producto_identificador='".$producto_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		*/
	}

	function borrar_producto($Idproducto){
							
		$result=$GLOBALS['conn']->query("DELETE FROM COMPRA.producto WHERE Idproducto='".$Idproducto."';");
		
		if($result->rowCount()>0){
			return 1;			
		}else{			
			return 0;			
		}		
	}
	
?>
