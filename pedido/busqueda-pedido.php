<?php
	include_once 'procedimientos_usuario.php';
	
	if (isset($_GET['pos'])){
		$iniCio=$_GET['pos'];
	}else{
		$iniCio=0;
	}
	
	$patRon=stripslashes($_REQUEST["patRon"]);
	$opCion=stripslashes($_REQUEST["opCion"]);
	
	if(isset($patRon) && isset($opCion)){
		
		$resUlt=busqueda_usuario($patRon,$opCion,$iniCio,6);
		
		$rows = count($resUlt);		
		if($rows >0){
			
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
				<strong>Nombre</strong>
			</td>
			<td align="center">
				<strong>Tipo de usuario</strong>
			</td>
			<td align="center">
				<strong>Estado del usuario</strong>
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
				$impResos=0;
							
			//while($resUlts= $resUlt->fetch(PDO::FETCH_ASSOC)){
			foreach ($resUlt as $resUlts) {
				
				
				$i=$i+1;
				$impResos++;
?>

		<tr>
			<td align="center">		
				<?php echo $resUlts['usuario_nombre'];?>
			</td>
			<td align="center">
				<?php echo $resUlts['Nom_Tipo_Usuario'];?>
			</td>
			<td align="center">
				<?php echo $resUlts['Nombre_Estado_Usuario'];?>
			</td>
			<td align='center'>
				<!-- modificar esto, esta mal un script por cada registro -->
				<script type="text/javascript">
	
					$(document).ready(function() {
											
						$("#frm_sch").parent().find("#view<?php echo $i;?>").click(function() {
							$('#temporal').html('');
							reloadPest('Ver_usuario',"usuario/usuario_vista.php?id=<?php echo $resUlts['Idusuario'];?>");						
						});
						$("#frm_sch").parent().find("#update<?php echo $i;?>").click(function() {
							$('#temporal').html('');
							reloadPest('Modificar_usuario',"usuario/actualizar_usuario.php?id=<?php echo $resUlts['Idusuario'];?>");
						});
						$("#frm_sch").parent().find("#delete<?php echo $i;?>").click(function() {
							
							function confirmar(){
								return confirm("Esta seguro de que desea borrar este registro.");
							}
							
							if(confirmar()){
							
								$.post("usuario/borrar_usuario.php?id=<?php echo $resUlts['Idusuario'];?>", {}, function(output){
								
								if(output=="1" || output==1){
									var alerrr="Se ha borrado correctamente la informacion.";
									frm_addOpenDialogo('#frm_sch', "Eliminaci&oacute;n de datos","Datos eliminados",alerrr,"","table");		
									$('#temporal').html('');
									reloadPest("buscar_usuario","usuario/busqueda_usuario.php");
								}else if(output=="0" || output==0){
									var alerrr="Este usuario tiene facturas asociadas a el, no se puede borrar.";
									frm_addOpenDialogo('#frm_sch', "Eliminaci&oacute;n de datos","Datos dependientes",alerrr,"","table");												
										
								}
								});						
							}					
						});				
					});
					 
				 </script>
				<a href='#'	title="Ver usuario" id="view<?php echo $i;?>"><img src='img/viewmag-icono.png'></a>
				<a href="#"	title="Modificar usuario" id="update<?php echo $i;?>"><img src='img/editar-icono-32.png'></a>	
				<a href='#'	title="Eliminar usuario" id="delete<?php echo $i;?>"><img src='img/borrar-icono-32.png'></a>
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
		      if($iniCio==0){
		    ?>
		      
		    <?php
		      }else{
		        $anteRior=$iniCio-6;
		    ?>
		      <td>
		        <a href="#" title="Anterior" id="backBC"><img src="img/back-32.png"></a>
		      </td>
		    <?php
		      }
		      if($impResos==6){
		        $proXimo=$iniCio+6;	
		    ?>
		      <td>
		        <a href="#" title="Siguiente" id="nextBC"><img src="img/next-32.png"></a>
		      </td>
		    <?php 
		      }else{
		    ?>
		      
		    <?php
		      }
		    ?>
    
	<script type="text/javascript">

    $(document).ready(function() {
    
      $(".buscar_usuario #backBC").click(function() {
        $(".buscar_usuario #subsp").load("usuario/busqueda-usuario.php?pos=<?php if(isset($anteRior)){echo $anteRior;}?>&opCion=<?php echo $opCion;?>&patRon=<?php echo $patRon;?>").show();
      });
      
      $(".buscar_usuario #nextBC").click(function() {
        $(".buscar_usuario #subsp").load("usuario/busqueda-usuario.php?pos=<?php if(isset($proXimo)){echo $proXimo;}?>&opCion=<?php echo $opCion;?>&patRon=<?php echo $patRon;?>").show();
      });
      
    });
      
  </script>
  
</table><br><br>
	
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
			if($iniCio>0){						
				$anteRior=$iniCio-6;
		?>
			   	<table align="right" style="width: 14%;margin-right: 5%;text-align: right;">	    
				    <tr>
				      <td>
				        <a href="#" id="backBC"><img src="img/back-32.png"></a>
				      </td>
				    </tr>
				</table>
				<br>
			      	<script type="text/javascript">
					    $(document).ready(function() {			    
						      $(".buscar_usuario #backBC").click(function() {
						        $(".buscar_usuario #subsp").load("usuario/busqueda-usuario.php?pos=<?php if(isset($anteRior)){echo $anteRior;}?>&opCion=<?php echo $opCion;?>&patRon=<?php echo $patRon;?>").show();
						      });				      			      
					    });      
		  			</script>
		  		<br><br>
	<?php	
			}
		}		
	}	
?>
