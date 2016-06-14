<?php

	require_once("../conexion.php");
	$conn = conexion();

	function ingreso_pedido($fecha_pedido,$pedidos_idproducto,$cantidad_pedido,$valor_pedido){
		
		$result=$GLOBALS['conn']->query("SELECT MAX(IdPedido)+1 as max_id FROM COMPRA.pedido;");
		
		while($results = $result->fetch(PDO::FETCH_ASSOC)){				
			$max_cid=$results['max_id']; 				
		}		
		$rows = count($result);	
		if(($rows==1)&&($max_cid==NULL)){				
			$max_cid=1;				
		}
		
		$result=$GLOBALS['conn']->query("INSERT INTO COMPRA.pedido (IdPedido, Fecha_Pedido, Pedidos_IdProducto, Cantidad_Pedido, Valor_Pedido) VALUES (".$max_cid.",'".$fecha_pedido."','".$pedidos_idproducto."','".$cantidad_pedido."','".$valor_pedido."');");
		setcookie("id","".$max_cid."",time()+60*60*24*365,"/");			
		return 1;
		
	}
	
	function seleccion_proveedor(){
		
		$result=$GLOBALS['conn']->query("SELECT IdProveedor, Nom_Proveedor FROM COMPRA.proveedor;");
		//$result = $result->fetchAll();				
		return $result;		
	}
	
	function seleccion_producto(){
		
		$result=$GLOBALS['conn']->query("SELECT p.IdProducto, p.Nom_Producto, p.Desc_Producto, p.ValorUnit_Producto, p.Producto_IdProveedor, pr.IdProveedor, pr.Nom_Proveedor FROM COMPRA.producto AS P INNER JOIN COMPRA.proveedor AS pr ON(p.Producto_IdProveedor = pr.IdProveedor);");
		//$result = $result->fetchAll();				
		return $result;		
	}
	
	function seleccion_producto_proveedor($id){
		
		$result=$GLOBALS['conn']->query("SELECT p.IdProducto, p.Nom_Producto, p.Desc_Producto, p.ValorUnit_Producto, p.Producto_IdProveedor, pr.IdProveedor, pr.Nom_Proveedor FROM COMPRA.producto AS P INNER JOIN COMPRA.proveedor AS pr ON(p.Producto_IdProveedor = pr.IdProveedor) WHERE pr.IdProveedor ='".$id."';");
		//$result = $result->fetchAll();				
		return $result;		
	}
	
	function seleccion_pedido($id){
		
		$result=$GLOBALS['conn']->query("SELECT pe.IdPedido, pe.Fecha_Pedido, pe.Pedidos_IdProducto, pro.Nom_Producto, pe.Cantidad_Pedido, pe.Valor_Pedido 
		FROM COMPRA.pedido AS pe INNER JOIN COMPRA.producto AS pro ON(pe.Pedidos_IdProducto = pro.IdProducto) WHERE pe.IdPedido ='".$id."';");
		$result = $result->fetchAll();				
		return $result;		
	}
	
	function busqueda_pedido($patron,$opcion,$limit_inicio,$limit_pasos){
		
		if($opcion==1){
			$condicion = "Fecha_Pedido";
		}
		if($opcion==2){
			$condicion = "Pedidos_IdProducto";
		}
		if($opcion==3){
			$condicion = "Cantidad_Pedido";
		}
		if($opcion==4){
			$condicion = "Valor_Pedido";
		}
		if($opcion==5){
			$condicion = "IdProveedor";
		}
		$result=$GLOBALS['conn']->query("SELECT * FROM ( 
		SELECT pe.IdPedido, pe.Fecha_Pedido, pe.Pedidos_IdProducto, pro.Nom_Producto, pe.Cantidad_Pedido, pe.Valor_Pedido, prov.Nom_Proveedor 
		, ROW_NUMBER() OVER (ORDER BY U.IdPedido) as row 
		FROM COMPRA.pedido AS pe INNER JOIN COMPRA.producto AS pro ON(pe.Pedidos_IdProducto = pro.IdProducto) INNER JOIN COMPRA.proveedor AS prov ON(pro.Producto_IdProveedor = prov.IdProveedor)
		) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";");
		//echo "SELECT * ...
		$result = $result->fetchAll();
		return $result;
	}
	
	function actualizar_pedido($idpedido,$fecha_pedido,$pedidos_idproducto,$cantidad_pedido,$valor_pedido){
		/*consulta el idpedido para compararlo, si no salen resultados es incorrecto*/
		$result=$GLOBALS['conn']->query("SELECT IdPedido FROM COMPRA.pedido WHERE IdPedido='".$idpedido."';");
			
		while($results = $result->fetch(PDO::FETCH_ASSOC)){
			$u_idpedido=$results['IdPedido']; 
		}
		if($idpedido==$u_idpedido){
			
			$result=$GLOBALS['conn']->query("UPDATE COMPRA.pedido SET Fecha_Pedido='".$fecha_pedido."', Pedidos_IdProducto='".$pedidos_idproducto."', Cantidad_Pedido='".$cantidad_pedido."', Valor_Pedido='".$valor_pedido."' WHERE Idpedido='".$Idpedido."';");
			setcookie("id","".$u_Idpedido."",time()+60*60*24*365,"/");
			return 1;			
		}
		/* verificar si es necesario modificar las facturas del pedido*/
		/*
		if(($empresa_nit!=$u_empresa_nit)&&($pedido_identificador!=$u_pedido_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			$result_2=mysql_query("SELECT * FROM pedido WHERE pedido_identificador='".$pedido_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)&&((mysql_num_rows($result_2)==0))){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE pedido SET pedido_identificador='".$pedido_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit!=$u_empresa_nit)&&($pedido_identificador==$u_pedido_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit==$u_empresa_nit)&&($pedido_identificador!=$u_pedido_identificador)){
			
			$result_2=mysql_query("SELECT * FROM pedido WHERE pedido_identificador='".$pedido_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_2)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE pedido SET pedido_identificador='".$pedido_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		*/
	}

	function borrar_pedido($idpedido){
							
		$result=$GLOBALS['conn']->query("DELETE FROM COMPRA.pedido WHERE IdPedido='".$idpedido."';");
		
		if($result->rowCount()>0){
			return 1;			
		}else{			
			return 0;			
		}		
	}
	
?>
