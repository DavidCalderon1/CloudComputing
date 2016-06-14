<?php

	require_once("../conexion.php");

	function ingreso_sucursal($empresa_id, $nombre, $ciudad, $direccion, $telefono1, $telefono2, $fax, $celular, $mail, $web, $contacto){
		$result=mysql_query("SELECT sucursal_nombre FROM sucursal WHERE sucursal_nombre='".$nombre."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());
		if((mysql_num_rows($result))==0){		
			$result=mysql_query("SELECT MAX(sucursal_id)+1 as max_id FROM sucursal;",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());			
			while($results=mysql_fetch_array($result)){				
				$max_id=$results['max_id'];				
			}
			
			if(((mysql_num_rows($result))==1)&&($max_id==NULL)){				
				$max_id=1;				
			}
			
			$result=mysql_query("INSERT INTO sucursal VALUES (".$max_id.", ".$empresa_id.", '".$nombre."', '".$ciudad."', '".$direccion."', '".$telefono1."', '".$telefono2."','".$fax."', '".$celular."', '".$mail."','".$web."', '".$contacto."');", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());			
			return 1;
		}else{
			return 0;
		}
	}

	function seleccion_pais(){		
		$result=mysql_query("SELECT * FROM pais;", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		return $result;		
	}

	function seleccion_departamento($pais){		
		$result=mysql_query("SELECT * FROM departamento WHERE pais_id=".$pais.";", conexion()) or die("Problemas en la consulta en la base de datos: ".mysql_error());		
		return $result;		
	}

	if(isset($_POST['pais'])){
		$result=seleccion_departamento($_POST['pais']);		
		?>
			<option value=""></option>
		<?php
			while($results=mysql_fetch_array($result)){
		?>
				<option value="<?php echo $results['departamento_id']?>"><?php echo $results['departamento_nombre']?></option>
		<?php
			}
		}

	function seleccion_ciudad($departamento){		
		$result=mysql_query("SELECT * FROM ciudad WHERE departamento_id=".$departamento.";", conexion()) or die("Problemas en la consulta en la base de datos: ".mysql_error());		
		return $result;		
	}

	if(isset($_POST['departamento'])){
		$result=seleccion_ciudad($_POST['departamento']);	
	?>
		<option value=""></option>
	<?php
		while($results=mysql_fetch_array($result)){
	?>
			<option value="<?php echo $results['ciudad_id']?>"><?php echo $results['ciudad_nombre']?></option>
	<?php
		}
	}

	function listado_sucursal($empresa_id,$limit_inicio,$limit_pasos){		
		$result=mysql_query("SELECT * FROM sucursal INNER JOIN ciudad ON(sucursal.ciudad_id=ciudad.ciudad_id) WHERE empresa_id=".$empresa_id." LIMIT ".$limit_inicio.", ".$limit_pasos." ;",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		return $result;		
	}

	function seleccion_sucursal($sucursal_id){		
		$result=mysql_query("SELECT * FROM (sucursal INNER JOIN ciudad ON(sucursal.ciudad_id=ciudad.ciudad_id)) INNER JOIN empresa ON(sucursal.empresa_id=empresa.empresa_id) WHERE sucursal_id=".$sucursal_id.";",conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		return $result;		
	}

	function actualizar_sucursal($sucursal_id, $nombre, $ciudad, $direccion, $telefono1, $telefono2, $fax, $celular, $mail, $web, $contacto){		
		$result=mysql_query("SELECT sucursal_nombre FROM sucursal WHERE sucursal_id='".$sucursal_id."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		while($results=mysql_fetch_array($result)){			
			$nombrea=$results['sucursal_nombre']; 			
		}
		if($nombrea==$nombre){			
			$result=mysql_query("UPDATE sucursal SET ciudad_id='".$ciudad."', sucursal_direccion='".$direccion."', sucursal_telefono_1='".$telefono1."', sucursal_telefono_2='".$telefono2."', sucursal_fax='".$fax."',  sucursal_celular='".$celular."', sucursal_mail='".$mail."', sucursal_web='".$web."', sucursal_contacto='".$contacto."' WHERE sucursal_id=".$sucursal_id.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());			
			return 1;
		}
		
		if($nombrea!=$nombre){		
			$result=mysql_query("SELECT sucursal_nombre FROM sucursal WHERE sucursal_nombre='".$nombre."';", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
			if((mysql_num_rows($result))==0){			
				$result=mysql_query("UPDATE sucursal SET sucursal_nombre='".$nombre."', ciudad_id='".$ciudad."', sucursal_direccion='".$direccion."', sucursal_telefono_1='".$telefono1."', sucursal_telefono_2='".$telefono2."', sucursal_fax='".$fax."',  sucursal_celular='".$celular."', sucursal_mail='".$mail."', sucursal_web='".$web."', sucursal_contacto='".$contacto."' WHERE sucursal_id=".$sucursal_id.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());			
				return 1;			
			}else{			
				return 0;				
			}		
		}
	}
	
	function borrar_sucursal($id){	
		$result=mysql_query("SELECT * FROM muestra WHERE sucursal_id=".$id.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());		
		if((mysql_num_rows($result))==0){		
			$result=mysql_query("DELETE FROM sucursal WHERE sucursal_id=".$id.";", conexion()) or die("Problemas en la consulta a la base de datos: ".mysql_error());			
			return 1;			
		}else{		
			return 0;		
		}
	}

?>