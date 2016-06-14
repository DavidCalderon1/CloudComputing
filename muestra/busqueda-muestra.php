<?php

	include 'procedimientos_muestra.php';
	
	if (isset($_GET['poss'])){
		$inicioMu=$_GET['poss'];
	}else{
		$inicioMu=0;
	}
	
	$patronMu=stripslashes($_REQUEST["patronMu"]);
	$opcionMu=stripslashes($_REQUEST["opcionMu"]);
	
	if(isset($patronMu) && isset($opcionMu)){
		
		$resultMu=busqueda_muestra($patronMu,$opcionMu,$inicioMu,6);
		
		if(mysql_num_rows($resultMu)>0){
			
?>

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Resultado de la busqueda</h3>
		</td>
	</tr>
</table>
<table align="center" border="0" class="table" width="90%">
	<thead>
		<tr>
			<td align="center">				
				<strong>Tipo de muestra</strong>
			</td>
			<td align="center">
				<strong>Cliente</strong>
			</td>
			<td align="center">
				<strong>Codigo antiguo</strong>
			</td>
			<td align="center">
				<strong>No. de factura</strong>
			</td>
			<td align="center">
				<strong>Fecha</strong>
			</td>
			<td align="center">
				<strong>Referencia</strong>
			</td>
			<td>
			</td>
		</tr>
	</thead>
	<tbody>
	
<?php

				if(isset($_COOKIE['i'])){
					$is=($_COOKIE['i']);
				}
				$impresosMu=0;
				
			while($resulMu=mysql_fetch_assoc($resultMu)){
				
				
				$is=$is+1;
				$impresosMu++;
?>

	<tr>
		<td align="center">		
			<?php echo $resulMu['tipo_muestra'];?>
		</td>
		<td align="center">
			<?php echo $resulMu['empresa_razonsocial'];?>
		</td>
		<td align="center">
			<?php echo $resulMu['muestra_previouscode'];?>
		</td>
		<td align="center">		
			<?php echo $resulMu['muestra_numfactura'];?>
		</td>
		<td align="center">
			<?php echo $resulMu['muestra_fecha'];?>
		</td>
		<td align="center">
			<?php echo $resulMu['muestra_referencia'];?>
		</td>
		<td align='center'>
			<script type="text/javascript">

				$(document).ready(function() {
										
					$(".buscar_muestra #view<?php echo $is;?>").click(function() {
						$('#temporal').html('');
						reloadPest('Ver_Muestra',"muestra/muestra_vista.php?id=<?php echo $resulMu['muestra_id'];?>");						
					});
					$(".buscar_muestra #update<?php echo $is;?>").click(function() {
						$('#temporal').html('');
						reloadPest('Modificar_Muestra',"muestra/actualizar_muestra.php?id=<?php echo $resulMu['muestra_id'];?>");
					});
					$(".buscar_muestra #delete<?php echo $is;?>").click(function() {
						
						function confirmar(){
							return confirm("Esta seguro de que desea borrar este registro.");
						}
						
						if(confirmar()){
						
							$.post("muestra/borrar_muestra.php?id=<?php echo $resulMu['muestra_id'];?>", {}, function(output){
							
							if(output=="1" || output==1){
								alert("Se ha borrado correctamente la informacion.");
								$('#temporal').html('');
								reloadPest("buscar_muestra","muestra/busqueda_muestra.php");
							}else if(output=="0" || output==0){
								alert("Esta muestra tiene sucursales asociadas a el, no se puede borrar.");
							}
							});
						
						}
					
					});
				
				});
				 
			 </script>
			<a href='#'	title="Ver Muestra" id="view<?php echo $is;?>"><img src='img/viewmag-icono.png'></a>
			<a href="#"	title="Modificar Muestra" id="update<?php echo $is;?>"><img src='img/editar-icono-32.png'></a>	
			<a href='#'	title="Eliminar Muestra" id="delete<?php echo $is;?>"><img src='img/borrar-icono-32.png'></a>
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
      if($inicioMu==0){
    ?>
      
    <?php
      }else{
        $anteriorMu=$inicioMu-6;
    ?>
      <td>
        <a href="#" id="backBM"><img src="img/back-32.png"></a>
      </td>
    <?php
      }
      if($impresosMu==6){
        $proximoMu=$inicioMu+6;	
    ?>
      <td>
        <a href="#" id="nextBM"><img src="img/next-32.png"></a>
      </td>
    <?php 
      }else{
    ?>
      
    <?php
      }
    ?>
    
	<script type="text/javascript">

    $(document).ready(function() {
    
      $(".buscar_muestra #backBM").click(function() {
        $(".buscar_muestra #res_SchMue").load("muestra/busqueda-muestra.php?poss=<?php if(isset($anteriorMu)){echo $anteriorMu;}?>&opcionMu=<?php echo $opcionMu;?>&patronMu=<?php echo $patronMu;?>").show();
      });
      
      $(".buscar_muestra #nextBM").click(function() {
        $(".buscar_muestra #res_SchMue").load("muestra/busqueda-muestra.php?poss=<?php if(isset($proximoMu)){echo $proximoMu;}?>&opcionMu=<?php echo $opcionMu;?>&patronMu=<?php echo $patronMu;?>").show();
      });
      
    });
      
  </script>
  
</table>
	
<?php
	
		}else{
		
	?>	
				<table align="center" border="0" class="table" width="90%">
					<thead>
						<tr>
							<td align="center">
								<strong>No hay mas resultados para su busqueda.</strong>
							</td>					
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<br>
		<?php		
			if($inicioMu>0){						
				$anteriorMu=$inicioMu-4;
		?>
			   	<table align="right" style="width: 14%;margin-right: 5%;text-align: right;">	    
				    <tr>
				      <td>
				        <a href="#" id="backBM"><img src="img/back-32.png"></a>
				      </td>
				    </tr>
				</table>
				<br>
			      	<script type="text/javascript">
					    $(document).ready(function() {			    
						      $(".buscar_muestra #backBM").click(function() {
						        $(".buscar_muestra #res_SchMue").load("muestra/busqueda-muestra.php?poss=<?php if(isset($anteriorMu)){echo $anteriorMu;}?>&opcionMu=<?php echo $opcionMu;?>&patronMu=<?php echo $patronMu;?>").show();
						      });			      			      
					    });      
		  			</script>
		  		<br><br>
	<?php	
			}		
		}		
	}	
?>
