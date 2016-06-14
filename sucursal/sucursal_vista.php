<?php

	include 'procedimientos_sucursal.php';
	
	if(isset($_GET['id'])){
	
		$result=(seleccion_sucursal($_GET['id']));
	
	}else{
		
		$result=(seleccion_sucursal($_COOKIE['id']));
		
	}
	
	while($results=mysql_fetch_array($result)){

?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#space .Ver_Sucursal .table tr').css('height','25px');
	});
</script>

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Vista del registro</h3>
		</td>
	</tr>
</table>

<table width="60%" align="center" class="table">
	<tbody>
		<tr>
			<td>
				<strong>Razon Social de la Empresa </strong>				
			</td>
			<td>
				<?php echo $results['empresa_razonsocial'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Nombre Sucursal</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_nombre'];?>
			</td>
			</tr>
		<tr>
			<td>
				<strong>Ciudad</strong>				
			</td>
			<td>
				<?php echo $results['ciudad_nombre'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Direccion</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_direccion'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Telefono 1</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_telefono_1'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Telefono 2</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_telefono_2'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Fax</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_fax'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Celular</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_celular'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Mail</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_mail'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Web</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_web'];?>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Contacto</strong>				
			</td>
			<td>
				<?php echo $results['sucursal_contacto'];?>
			</td>
		</tr>
	</tbody>
</table><br><br>

<?php

	}
	
?>