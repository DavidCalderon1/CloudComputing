<?php

	include 'procedimientos_usuario.php';
	
	if(isset($_GET['id'])){
	
		$result=(seleccion_usuario($_GET['id']));
	
	}else{
		
		$result=(seleccion_usuario($_COOKIE['id']));
		
	}
		
	//while($results=mysql_fetch_array($result)){
	foreach ($result as $results) {

?>
<div>
<table width="90%" align="center">
  <tr>
    <td>
      <h3>Vista del usuario</h3>
    </td>
  </tr>
</table>

<table width="40%" align="center" class="table" id="imgusuario">
	<tbody>
		  <tr>
			<td>
			  <img id="imgusuario" src="img/userDef.png">				
			</td>
		</tr>
	</tbody>
</table>

<table width="40%" align="center" class="table" id="infousuario">
	<tbody>
		  <tr>
			<td>
			  <strong>Nombre</strong>				
			</td>
			<td>
			  <?php echo $results['usuario_nombre'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Tipo de usuario</strong>				
			</td>
			<td>
			  <?php echo $results['Nom_Tipo_Usuario'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Estado del usuario</strong>				
			</td>
			<td>
			  <?php echo $results['Nombre_Estado_Usuario'];?>
			</td>
		  </tr>
	</tbody>
</table>
<!--
<script type="text/javascript">
	$(document).ready(function() {
		$(".Ver_usuario #agregar_sucursal").click(function() {			
			mostrarNavegAdicional('Agregar Sucursal');
			validarPestExternas("Agregar_Sucursal","sucursal/agregar_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>");															
		});
	
		$("#subspacLS").load("sucursal/listado_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>").show();
	
		
		$(".Ver_usuario > div").css({'width':'100%','height':'100%'});
		$('.Ver_usuario input[type="reset"],.Ver_usuario input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
				
	});
</script>
-->
<table align="right" id="agregar" style="width: 14%;margin-right: 7%;text-align: right;">
	<tr>
		<td>
			<!--input type="button" id="agregar_sucursal" name="agregar_sucursal" value="Agregar Sucursal"-->
			<input type="button" id="facturas" name="facturas" value="---">
		</td>
	</tr>
</table>
<br><br>

<?php

	}

?>

<div id="subspacLS" style="min-height: 20px;">
</div>
</div>
