<?php

	require_once("../conexion.php");
	$conn = conexion();

	function ingreso_usuario($nombre,$password,$tipo_usuario,$estado_usuario){
		
		$result=$GLOBALS['conn']->query("SELECT MAX(IdUsuario)+1 as max_id FROM RRHH.usuario;");
		
		while($results = $result->fetch(PDO::FETCH_ASSOC)){				
			$max_cid=$results['max_id']; 				
		}		
		$rows = count($result);	
		if(($rows==1)&&($max_cid==NULL)){				
			$max_cid=1;				
		}
		$password = md5($password);
		$result=$GLOBALS['conn']->query("INSERT INTO RRHH.usuario (Idusuario, usuario_nombre, usuario_password, Usuario_IdTipo_Usuario, Estado_Usuario) VALUES (".$max_cid.",'".$nombre."','".$password."','".$tipo_usuario."','".$estado_usuario."');");
		setcookie("id","".$max_cid."",time()+60*60*24*365,"/");			
		return 1;
		
	}
	
	function seleccion_tipo_usuario(){
		
		$result=$GLOBALS['conn']->query("SELECT IdTipo_Usuario, Nom_Tipo_Usuario FROM RRHH.tipo_usuario;");
		//$result = $result->fetchAll();				
		return $result;		
	}
	
	function seleccion_usuario($id){
		
		$result=$GLOBALS['conn']->query("SELECT U.Idusuario, U.usuario_nombre, U.usuario_password, U.Usuario_IdTipo_Usuario, TU.Nom_Tipo_Usuario, U.Estado_Usuario, IIF( U.Estado_Usuario = 1 , 'Activo', 'Inactivo') AS Nombre_Estado_Usuario FROM RRHH.usuario AS U INNER JOIN RRHH.tipo_usuario AS TU ON(U.Usuario_IdTipo_Usuario = TU.IdTipo_Usuario) WHERE U.Idusuario ='".$id."';");
		$result = $result->fetchAll();				
		return $result;		
	}
	
	function busqueda_usuario($patron,$opcion,$limit_inicio,$limit_pasos){
		
		if($opcion==1){
			$condicion = "usuario_nombre";
		}
		if($opcion==2){
			$condicion = "Usuario_IdTipo_Usuario";
		}
		if($opcion==3){
			$condicion = "Estado_Usuario";
		}
		$result=$GLOBALS['conn']->query("SELECT * FROM ( SELECT U.Idusuario, U.usuario_nombre, U.Usuario_IdTipo_Usuario, TU.Nom_Tipo_Usuario, U.Estado_Usuario, IIF( U.Estado_Usuario = 1 , 'Activo', 'Inactivo') AS Nombre_Estado_Usuario, ROW_NUMBER() OVER (ORDER BY U.Idusuario) as row FROM RRHH.usuario AS U INNER JOIN RRHH.tipo_usuario AS TU ON(U.Usuario_IdTipo_Usuario = TU.IdTipo_Usuario) ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";");
		//echo "SELECT * FROM ( SELECT U.Idusuario, U.usuario_nombre, U.Usuario_IdTipo_Usuario, TU.Nom_Tipo_Usuario, U.Estado_Usuario, IIF( U.Estado_Usuario = 1 , 'Activo', 'Inactivo') AS Nombre_Estado_Usuario, ROW_NUMBER() OVER (ORDER BY U.Idusuario) as row FROM RRHH.usuario AS U INNER JOIN RRHH.tipo_usuario AS TU ON(U.Usuario_IdTipo_Usuario = TU.IdTipo_Usuario) ) a WHERE ".$condicion." LIKE '%".$patron."%' AND row > ".$limit_inicio." and row <= ".($limit_inicio + $limit_pasos).";";
		$result = $result->fetchAll();
		return $result;
	}
	
	function actualizar_usuario($Idusuario,$nombre,$password,$tipo_usuario,$estado_usuario){
		/*consulta el idusuario para compararlo, si no salen resultados es incorrecto*/
		$result=$GLOBALS['conn']->query("SELECT Idusuario FROM RRHH.usuario WHERE Idusuario='".$Idusuario."';");
			
		while($results = $result->fetch(PDO::FETCH_ASSOC)){
			$u_Idusuario=$results['Idusuario']; 
		}
		/*consulta el password recibido, si es igual al actual entonces no lo encripta en md5*/
		$result2=$GLOBALS['conn']->query("SELECT usuario_password FROM RRHH.usuario WHERE Idusuario='".$Idusuario."';");
			
		while($results2 = $result2->fetch(PDO::FETCH_ASSOC)){
			$u_password=$results2['usuario_password']; 
		}
		if($password != $u_password){
			$password = md5($password);
		}
		if($Idusuario==$u_Idusuario){
			
			$result=$GLOBALS['conn']->query("UPDATE RRHH.usuario SET usuario_nombre='".$nombre."', usuario_password='".$password."', Usuario_IdTipo_Usuario='".$tipo_usuario."', Estado_Usuario='".$estado_usuario."' WHERE Idusuario='".$Idusuario."';");
			setcookie("id","".$u_Idusuario."",time()+60*60*24*365,"/");
			return 1;			
		}
		/* verificar si es necesario modificar las facturas del usuario*/
		/*
		if(($empresa_nit!=$u_empresa_nit)&&($usuario_identificador!=$u_usuario_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			$result_2=mysql_query("SELECT * FROM usuario WHERE usuario_identificador='".$usuario_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)&&((mysql_num_rows($result_2)==0))){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE usuario SET usuario_identificador='".$usuario_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit!=$u_empresa_nit)&&($usuario_identificador==$u_usuario_identificador)){
			
			$result_1=mysql_query("SELECT * FROM empresa WHERE empresa_nit='".$empresa_nit."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_1)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		
		if(($empresa_nit==$u_empresa_nit)&&($usuario_identificador!=$u_usuario_identificador)){
			
			$result_2=mysql_query("SELECT * FROM usuario WHERE usuario_identificador='".$usuario_identificador."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
			
			if((mysql_num_rows($result_2)==0)){

				$result=mysql_query("UPDATE empresa SET empresa_razonsocial='".$empresa_razonsocial."', empresa_nit='".$empresa_nit."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				$result=mysql_query("UPDATE usuario SET usuario_identificador='".$usuario_identificador."'  WHERE empresa_id='".$empresa_id."';",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
				
				setcookie("id","".$empresa_id."",time()+60*60*24*365,"/");
				
				return 1;
				
			}else{
				
				return 0;
				
			}
			
		}
		*/
	}

	function borrar_usuario($Idusuario){
							
		$result=$GLOBALS['conn']->query("DELETE FROM RRHH.usuario WHERE Idusuario='".$Idusuario."';");
		
		if($result->rowCount()>0){
			return 1;			
		}else{			
			return 0;			
		}		
	}
	
?>
