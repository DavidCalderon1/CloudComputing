<?php

	include 'procedimientos_cliente.php';
	
	if(isset($_GET['id'])){
	
		$result=(seleccion_cliente($_GET['id']));
	
	}else{
		
		$result=(seleccion_cliente($_COOKIE['id']));
		
	}
		
	//while($results=mysql_fetch_array($result)){
	foreach ($result as $results) {

?>
<div>
<table width="90%" align="center">
  <tr>
    <td>
      <h3>Vista del cliente</h3>
    </td>
  </tr>
</table>

<table width="40%" align="center" class="table" id="imgCliente">
	<tbody>
		  <tr>
			<td>
			  <img id="imgCliente" src="img/userDef.png">				
			</td>
		</tr>
	</tbody>
</table>

<table width="40%" align="center" class="table" id="infoCliente">
	<tbody>
		  <tr>
			<td>
			  <strong>Nombre</strong>				
			</td>
			<td>
			  <?php echo $results['Nom_Cliente'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Direcci&oacute;n</strong>				
			</td>
			<td>
			  <?php echo $results['Dir_Cliente'];?>
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Tel&eacute;fono</strong>				
			</td>
			<td>
			  <?php echo $results['Tel_Cliente'];?>
			</td>
		  </tr>
	</tbody>
</table>
<!--
<script type="text/javascript">
	$(document).ready(function() {
		$(".Ver_Cliente #agregar_sucursal").click(function() {			
			mostrarNavegAdicional('Agregar Sucursal');
			validarPestExternas("Agregar_Sucursal","sucursal/agregar_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>");															
		});
	
		$("#subspacLS").load("sucursal/listado_sucursal.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo $_COOKIE['id'];}?>").show();
	
		
		$(".Ver_Cliente > div").css({'width':'100%','height':'100%'});
		$('.Ver_Cliente input[type="reset"],.Ver_Cliente input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
				
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
