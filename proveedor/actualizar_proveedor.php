<?php

	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}

	include 'procedimientos_proveedor.php';

	if(isset($_POST['enviar'.$i.''])){
	
		echo actualizar_proveedor($_GET['id'],$_POST['nombre'],$_POST['direccion'],$_POST['telefono']);
		
	}else{	
	
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}

		if(isset($_GET['id'])){
		
			$result=(seleccion_proveedor($_GET['id']));
		
		}else{
			
			$result=(seleccion_proveedor($_COOKIE['id']));
			
		}
		
		foreach ($result as $results) {
		
?>
		<script type="text/javascript">
		 
			$(document).ready(function(){
			  
				$("#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
					var ThisVal =$('#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>').val();
					
					var nom=$('#frm_upd<?php echo $i;?> #nombre').val();
					var dir=$('#frm_upd<?php echo $i;?> #direccion').val();
					var tel=$('#frm_upd<?php echo $i;?> #telefono').val();
				  
					if(nom!="" && dir!="" && tel!="")
					{
						
						$.post("proveedor/actualizar_proveedor.php?id=<?php echo $results['IdProveedor'];?>", {enviar<?php echo $i;?>:ThisVal, nombre:nom, direccion:dir, telefono:tel}, function(output){
							
							if(output=="1" || output==1){
								var aler = ("Se ha registrado correctamente la informacion.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
								
								var soyYop =$('#frm_upd<?php echo $i;?>').parent('#contenedor').attr('name');
								$('#pestana .pestActiva[name="'+soyYop+'"]').hide(500,function(){
										$(this).remove();
										beforeClose('Ver_Proveedor');
								});
								cerrarPestana('Modificar_Proveedor');
								$('#temporal').html('');
								reloadPest("Ver_Proveedor","proveedor/proveedor_vista.php?id=<?php echo $results['IdProveedor'];?>");													 
							}else if(output=="0" || output==0){
								var aler = ("Existe un registro con el mismo nombre o identificador se restableceran los campos por defecto.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos no validos",aler,"","#nombre");
							 	$('#temporal').html('');
							 	reloadPest("Ver_Proveedor","proveedor/proveedor_vista.php?id=<?php echo $results['IdProveedor'];?>");													 
							}
							//alert(output);
							//$("#frm_upd<?php echo $i;?>").text("<div>" + output + "</div>");
							//$("#space").load("search_client.php").show();
						});
					}
					else
					{
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagprov<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
						
						alert("Existe algun campo vacio!");
					}
				});
			  
				$("#frm_upd<?php echo $i;?> #cancel").click(function() {					
					var soyYopt =$('#frm_upd<?php echo $i;?>').parent('#contenedor').attr('name');
					$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
						$(this).remove();
						beforeClose('buscar_proveedor');
					});
					cerrarPestana('Modificar_Proveedor');					
				});
				
				$('#frm_upd<?php echo $i;?>').css('height','100%');
				$(".Modificar_Proveedor form tr:last ").css({'text-align':'center'});
				$('#frm_upd<?php echo $i;?> input[type="reset"],#frm_upd<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
					
				recorridoDinamico('frm_upd<?php echo $i;?>');							
			});
		  
		</script>
		
		<form id="frm_upd<?php echo $i;?>" style="height:100%;" name="frm_upd<?php echo $i;?>" method="post">
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Modificar Proveedor</h3>
				</td>
			</tr>
		</table>
		<p>
		<table align="center" id="inputs">
			<tr>
				<td>
					<strong>Nombre</strong>				
				</td>
				<td>
					<input type="text" id="nombre" name="nombre" value="<?php echo $results['Nom_Proveedor'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Direcci&oacute;n</strong>				
				</td>
				<td>
					<input type="text" id="direccion" name="direccion" value="<?php echo $results['Dir_Proveedor'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Tel&eacute;fono</strong>				
				</td>
				<td>
					<input type="text" id="telefono" name="telefono" value="<?php echo $results['Tel_Proveedor'];?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<br>
					<input type="reset" id="cancel" name="cancel" value="Cancelar" />
					<input type="button" id="enviar<?php echo $i;?>" name="enviar<?php echo $i;?>" value="Guardar" />
				</td>
			</tr>
		</table>
		</p>
		</form>
<?php

		}
	}

?>