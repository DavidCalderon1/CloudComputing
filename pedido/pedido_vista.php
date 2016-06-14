<?php

	include 'procedimientos_pedido.php';
	
	if(isset($_GET['id'])){
	
		$result=(seleccion_pedido($_GET['id']));
	
	}else{
		
		$result=(seleccion_pedido($_COOKIE['id']));
		
	}
		
	//while($results=mysql_fetch_array($result)){
	foreach ($result as $results) {

?>
<div>
<table width="90%" align="center">
  <tr>
    <td>
      <h3>Vista del pedido</h3>
    </td>
  </tr>
</table>

<table width="40%" align="center" class="table" id="imgpedido">
	<tbody>
		  <tr>
			<td>
			  <img id="imgpedido" src="img/userDef.png">				
			</td>
		</tr>
	</tbody>
</table>

<table width="40%" align="center" class="table" id="infopedido">
	<tbody>
		  <tr>
			<td>
			  <strong>Fecha</strong>
			</td>
			<td>
			  <?php echo $results['Fecha_Pedido'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Producto</strong>				
			</td>
			<td>
			  <?php echo $results['Nom_Producto'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Cantidad de productos</strong>				
			</td>
			<td>
			  <?php echo $results['Cantidad_Pedido'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Valor del pedido</strong>				
			</td>
			<td>
			  <?php echo $results['Valor_Pedido'];?>
			</td>
		  </tr>
	</tbody>
</table>
<!--
<script type="text/javascript">
	$(document).ready(function() {
		$(".Ver_pedido #agregar_sucursal").click(function() {			
			mostrarNavegAdicional('Agregar Sucursal');
			validarPestExternas("Agregar_Sucursal","sucursal/agregar_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>");															
		});
	
		$("#subspacLS").load("sucursal/listado_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>").show();
	
		
		$(".Ver_pedido > div").css({'width':'100%','height':'100%'});
		$('.Ver_pedido input[type="reset"],.Ver_pedido input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
				
	});
</script>
-->
<table align="right" id="agregar" style="width: 14%;margin-right: 7%;text-align: right;">
	<tr>
		<td>
			<input type="button" id="facturas" name="facturas" value="" disabled>
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
