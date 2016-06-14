<?php

	include 'procedimientos_muestra.php';
	
	if(isset($_GET['id'])){
	
		$resultMV=(seleccion_muestra($_GET['id']));
	
	}else{
		
		$resultMV=(seleccion_muestra($_COOKIE['id']));
		
	}
	
	while($resultsMV=mysql_fetch_array($resultMV)){
	
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#space .Ver_Muestra .table tr').css('height','25px');
		$('#space .Ver_Muestra .table td').css('padding','0px 5px 0px 5px');
		$('#space .Ver_Muestra .table input').css({'margin':'0px 5px 0px 0px','padding':'0px 5px 0px 5px','float':'left','border-radius': '0px'});
		
		$('#space .Ver_Muestra .table input#<?php echo $resultsMV['ar_id'];?>').click(function(){
			volcarArchivo(<?php echo $resultsMV['ar_id'];?>);			
		});
	});
</script>

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Vista del registro</h3>
		</td>
	</tr>
</table>

<table align="center" width="80%" class="table">
	<tr>
		<td>
			<strong>Codigo de la muestra:</strong>
		</td>
		<td>
			<?php echo $resultsMV['muestra_sid'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Cliente:<strong>
		</td>
		<td>
			<?php echo $resultsMV['empresa_razonsocial'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Sucursal:</strong>
		</td>
		<td>
			<?php echo $resultsMV['sucursal_nombre'].' '.$resultsMV['ciudad_nombre'];?>
		</td>
	</tr>
	<tr>
		<td> 
			<strong>Codigo antiguo:</strong>
		</td>
		<td>
			<?php echo $resultsMV['muestra_previouscode'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Fecha:<strong>
		</td>
		<td>
			<?php echo $resultsMV['muestra_fecha'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Tipo de muestra:</strong>
		</td>
		<td>
			<?php echo $resultsMV['tipo_muestra'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Numero de Factura:</strong>
		</td>
		<td>
			<?php echo $resultsMV['muestra_numfactura'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Referencia:</strong>
		</td>
		<td>
			<?php echo $resultsMV['muestra_referencia'];?>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Remisi&oacute;n:</strong>
		</td>
		<td>
			<input type="button" name="<?php echo $resultsMV['ar_id'];?>" id="<?php echo $resultsMV['ar_id'];?>" title="<?php echo $resultsMV['ar_name'];?>" value="<?php echo $resultsMV['ar_name'];?>" />
			<input type="button" id="GeoClose" value="Cerrar visor de archivos" onclick="closeWin()" style="display:none;"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong>Descripci&oacute;n:</strong>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p align="justify"><?php echo $resultsMV['muestra_descripcion'];?></p>
		</td>
	</tr>
</table>
<br><br>

<?php

	}

?>