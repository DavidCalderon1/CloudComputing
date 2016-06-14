<?php

	include 'procedimientos_sucursal.php';
	
	if (isset($_GET['pos'])){
		$inicio=$_GET['pos'];
	}else{
		$inicio=0;
	}
	
	if(isset($_GET['id'])){
		
		$result=listado_sucursal($_GET['id'],$inicio,4);
		
		if((mysql_num_rows($result))>0){
			
?>

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Listado Sucursales</h3>
		</td>
	</tr>
</table>
<table align="center" border="0" class="table" width="90%">
	<thead>
		<tr>
			<td align="center">
				<strong>Nombre Sucursal</strong>
			</td>
			<td align="center">
				<strong>Ciudad</strong>
			</td>
			<td align="center">
				<strong>Direccion</strong>
			</td>
			<td>
			</td>
		</tr>
	</thead>
	<tbody>
	
<?php

			if(isset($_COOKIE['i'])){
				$i=($_COOKIE['i']);
			}
			$impresos=0;
			
			while($results=mysql_fetch_assoc($result)){
			
			
				$i=$i+1;
				$impresos++;
?>

		<tr>
			<td align="center">		
				<?php echo $results['sucursal_nombre'];?>
			</td>
			<td align="center">
				<?php echo $results['ciudad_nombre'];?>
			</td>
			<td align="center">
				<?php echo $results['sucursal_direccion'];?>
			</td>
			<td align='center'>
				<script type="text/javascript">
	
					$(document).ready(function() {
					
						$(".Ver_Cliente #view<?php echo $i;?>").click(function() {
							$('#temporal').html('');
							reloadPest("Ver_Sucursal","sucursal/sucursal_vista.php?id=<?php echo $results['sucursal_id'];?>");												
						});
						$(".Ver_Cliente #update<?php echo $i;?>").click(function() {
							$('#temporal').html('');
							reloadPest("Actualizar_Sucursal","sucursal/actualizar_sucursal.php?id=<?php echo $results['sucursal_id'];?>");												
						});
						$(".Ver_Cliente #delete<?php echo $i;?>").click(function() {
							
							function confirmar(){
								return confirm("Esta seguro de que desea borrar este registro.");
							}
							
							if(confirmar()){
							
								$.post("sucursal/borrar_sucursal.php?id=<?php echo $results['sucursal_id'];?>", {}, function(output){
								
								if(output=="1" || output==1){
									var alerrr="Se ha borrado correctamente la informacion.";
									frm_addOpenDialogo('Ver_Cliente', "Eliminaci&oacute;n de datos","Datos eliminados",alerrr,"","table");												
							
									$('#temporal').html('');
									reloadPest("Ver_Cliente","cliente/cliente_vista.php?id=<?php echo $_GET['id'];?>");
								}else if(output=="0" || output==0){
									var alerrr="Esta sucursal contiene muestras registradas, no se puede borrar";
									frm_addOpenDialogo('Ver_Cliente', "Eliminaci&oacute;n de datos","Datos dependientes",alerrr,"","table");							
								}
								});
							
							}
						
						});
					
					});
					 
				 </script>
				<a href='#'	title="Ver Sucursal"	id="view<?php echo $i;?>"><img src='img/viewmag-icono.png'></a>
				<a href="#"	title="Actualizar Sucursal" id="update<?php echo $i;?>"><img src='img/editar-icono-32.png'></a>	
				<a href='#'	title="Eliminar Sucursal" id="delete<?php echo $i;?>"><img src='img/borrar-icono-32.png'></a>
			</td>
		</tr>
	
<?php
		
			}
		
?>
	</tbody>
</table>
<table align="right" style="width: 14%;margin-right: 5%;text-align: right;">
    <tr>
    			
    <?php
			if($inicio==0){
    ?>
      
    <?php
			}else{
				$anterior=$inicio-4;
    ?>
      <td>
        <a href="#" id="backLS"><img src="img/back-32.png"></a>
      <td>
    <?php
			}
			if($impresos==4){
				$proximo=$inicio+4;	
    ?>
      <td>
        <a href="#" id="nextLS"><img src="img/next-32.png"></a>
      </td>
    <?php 
			}else{
							
			}
    ?>
    </tr>
  </table>  
  	<script type="text/javascript">
	    $(document).ready(function() {
	    
		      $("#backLS").click(function() {
		        $("#subspacLS").load("sucursal/listado_sucursal.php?pos=<?php if(isset($anterior)){echo $anterior;}?>&id=<?php echo $_GET['id'];?>").show();
		      });
		      
		      $("#nextLS").click(function() {
		        $("#subspacLS").load("sucursal/listado_sucursal.php?pos=<?php if(isset($proximo)){echo $proximo;}?>&id=<?php echo $_GET['id'];?>").show();
		      });
	      
	    });      
  	</script>
  
	
<?php
			

		}else{
			if($inicio>0){
						
			$anterior=$inicio-4;
	?>
	
		<table align="center" border="0" class="table" width="90%">
			<thead>
				<tr>
					<td align="center">
						<strong>No hay mas resultados para su busqueda.</strong>
					</td>					
				</tr>
			</thead>
			</thead>
			</thead>
		</table>
	   	<table align="right" style="width: 14%;margin-right: 5%;text-align: right;">	    
		    <tr>
		      <td>
		        <a href="#" id="backLS"><img src="img/back-32.png"></a>
		      </td>
		    </tr>
		</table>
	      	<script type="text/javascript">
			    $(document).ready(function() {			    
				      $("#backLS").click(function() {
				        $("#subspacLS").load("sucursal/listado_sucursal.php?pos=<?php if(isset($anterior)){echo $anterior;}?>&id=<?php echo $_GET['id'];?>").show();
				      });				      			      
			    });      
  			</script>
    <?php
			}
		}
		
	}
	
?>