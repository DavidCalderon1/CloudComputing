<?php

	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}

	include 'procedimientos_usuario.php';

	if(isset($_POST['enviar'.$i.''])){
	
		echo actualizar_usuario($_GET['id'],$_POST['nombre'],$_POST['password'],$_POST['tipou'],$_POST['estau']);
		
	}else{	
	
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}

		if(isset($_GET['id'])){
		
			$result=(seleccion_usuario($_GET['id']));
		
		}else{
			
			$result=(seleccion_usuario($_COOKIE['id']));
			
		}
		
		foreach ($result as $results) {
		
?>
		<script type="text/javascript">
		 
			$(document).ready(function(){
			  
				$("#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
					var ThisVal =$('#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>').val();
					
					var nom=$('#frm_upd<?php echo $i;?> #nombre').val();
					var pass=$('#frm_upd<?php echo $i;?> #password').val();
					var passVal=$('#frm_upd<?php echo $i;?> #password2').val();
					var tipou=$('#frm_upd<?php echo $i;?> #tipo_usuario').val();
					var estau=$('#frm_upd<?php echo $i;?> #estado_usuario').val();
					
					if(nom!="" && pass!="" && pass == passVal && tipou!="" && estau!="")
					{
						
						$.post("usuario/actualizar_usuario.php?id=<?php echo $results['Idusuario'];?>", {enviar<?php echo $i;?>:ThisVal, nombre:nom, password:pass, tipou:tipou, estau:estau}, function(output){
							
							if(output=="1" || output==1){
								var aler = ("Se ha registrado correctamente la informacion.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
								
								var soyYop =$('#frm_upd<?php echo $i;?>').parent('#contenedor').attr('name');
								$('#pestana .pestActiva[name="'+soyYop+'"]').hide(500,function(){
										$(this).remove();
										beforeClose('Ver_usuario');
								});
								cerrarPestana('Modificar_usuario');
								$('#temporal').html('');
								reloadPest("Ver_usuario","usuario/usuario_vista.php?id=<?php echo $results['Idusuario'];?>");													 
							}else if(output=="0" || output==0){
								var aler = ("Existe un registro con los mismos datos o identificador se restableceran los campos.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos no validos",aler,"","#nombre");
							 	$('#temporal').html('');
							 	reloadPest("Ver_usuario","usuario/usuario_vista.php?id=<?php echo $results['Idusuario'];?>");													 
							}
							//alert(output);
							//$("#frm_upd<?php echo $i;?>").text("<div>" + output + "</div>");
							//$("#space").load("search_client.php").show();
						});
					}
					else
					{
						var aler = ("Existe algun campo vacio o incorrecto!");
						frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#nombre");
						$('#frm_upd<?php echo $i;?> input#nombre').focus();
					}
				});
			  
				$("#frm_upd<?php echo $i;?> #cancel").click(function() {					
					var soyYopt =$('#frm_upd<?php echo $i;?>').parent('#contenedor').attr('name');
					$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
						$(this).remove();
						beforeClose('buscar_usuario');
					});
					cerrarPestana('Modificar_usuario');					
				});
				
				/*compara los password y muestra el resultado*/
				function registroValidarPassword(dato){
					var passVal = $("#frm_upd<?php echo $i;?> input#password").val();
					if( dato != passVal ){
						$('#frm_upd<?php echo $i;?> #password2').parents('td').find('.text_help').html('!Incorrecto&#33;').css('color','red');
					}else{
						$('#frm_upd<?php echo $i;?> #password2').parents('td').find('.text_help').html('Ok').css('color','');
					}
				}
				//validar la confirmacion del password
				$('#frm_upd<?php echo $i;?> #password2').keyup(function(){
					var dato = $(this).val();
					registroValidarPassword(dato);
				}).change(function(){
					var dato = $(this).val();
					registroValidarPassword(dato);
				});
				
				$('#frm_upd<?php echo $i;?>').css('height','100%');
				$(".Modificar_usuario form tr:last ").css({'text-align':'center'});
				$('#frm_upd<?php echo $i;?> input[type="reset"],#frm_upd<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
					
				recorridoDinamico('frm_upd<?php echo $i;?>');							
			});
		  
		</script>
		
		<form id="frm_upd<?php echo $i;?>" style="height:100%;" name="frm_upd<?php echo $i;?>" method="post">
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Modificar usuario</h3>
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
					<input type="text" id="nombre" name="nombre" value="<?php echo $results['usuario_nombre'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Contrase&ntilde;a</strong>				
				</td>
				<td>
					<input type="password" id="password" name="password" value="<?php echo $results['usuario_password'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Confirmar contrase&ntilde;a</strong>				
				</td>
				<td>
					<input type="password" id="password2" name="password2" value="<?php echo $results['usuario_password'];?>">
					<span class="text_help"></span>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Tipo de usuario</strong>				
				</td>
				<td>
					<select name="tipo_usuario" id="tipo_usuario">
						<option value=""></option>
						<?php				
						$result_tipou=seleccion_tipo_usuario();			
						while($results_tipou = $result_tipou->fetch(PDO::FETCH_ASSOC)){				
							if($results_tipou['IdTipo_Usuario'] == $results['Usuario_IdTipo_Usuario']){
								echo "<option value=".$results_tipou['IdTipo_Usuario']." selected='selected' >".$results_tipou['Nom_Tipo_Usuario']."</option>";
							}else{
								echo "<option value=".$results_tipou['IdTipo_Usuario'].">".$results_tipou['Nom_Tipo_Usuario']."</option>";
							}
						}				
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Estado del usuario</strong>				
				</td>
				<td>
					<select name="estado_usuario" id="estado_usuario">
						<option value="1" <?php if($results['Estado_Usuario']==1){ echo "selected='selected'"; }; ?> >Activo</option>
						<option value="2" <?php if($results['Estado_Usuario']==2){ echo "selected='selected'"; }; ?> >Inactivo</option>
					</select>
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