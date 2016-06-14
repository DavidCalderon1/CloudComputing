<?php

	include 'procedimientos_producto.php';
	
	if(isset($_GET['id'])){
	
		$result=(seleccion_producto($_GET['id']));
	
	}else{
		
		$result=(seleccion_producto($_COOKIE['id']));
		
	}
		
	//while($results=mysql_fetch_array($result)){
	foreach ($result as $results) {

?>
<div>
<table width="90%" align="center">
  <tr>
    <td>
      <h3>Vista del producto</h3>
    </td>
  </tr>
</table>

<table width="40%" align="center" class="table" id="imgproducto">
	<tbody>
		  <tr>
			<td>
			  <img id="imgproducto" src="img/userDef.png">				
			</td>
		</tr>
	</tbody>
</table>

<table width="40%" align="center" class="table" id="infoproducto">
	<tbody>
		  <tr>
			<td>
			  <strong>Nombre</strong>				
			</td>
			<td>
			  <?php echo $results['nom_producto'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Descripci&oacute;n</strong>				
			</td>
			<td>
			  <?php echo $results['desc_producto'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Valor unitario</strong>				
			</td>
			<td>
			  $<?php echo $results['ValorUnit_Producto'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Proveedor</strong>				
			</td>
			<td>
			  <?php echo $results['nom_proveedor'];?>
			</td>
		  </tr>
	</tbody>
</table>
<!--
<script type="text/javascript">
	$(document).ready(function() {
		$(".Ver_producto #agregar_sucursal").click(function() {			
			mostrarNavegAdicional('Agregar Sucursal');
			validarPestExternas("Agregar_Sucursal","sucursal/agregar_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>");															
		});
	
		$("#subspacLS").load("sucursal/listado_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>").show();
	
		
		$(".Ver_producto > div").css({'width':'100%','height':'100%'});
		$('.Ver_producto input[type="reset"],.Ver_producto input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
				
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
