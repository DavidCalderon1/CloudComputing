<?php

	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}

	include 'procedimientos_producto.php';

	if(isset($_POST['enviar'.$i.''])){
	
		echo actualizar_producto($_GET['id'],$_POST['nombre'],$_POST['descripcion'],$_POST['ValorUnit_Producto'],$_POST['proveedor']);
		
	}else{	
	
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}

		if(isset($_GET['id'])){
		
			$result=(seleccion_producto($_GET['id']));
		
		}else{
			
			$result=(seleccion_producto($_COOKIE['id']));
			
		}
		
		foreach ($result as $results) {
		
?>
		<script type="text/javascript">
		 
			$(document).ready(function(){
			  
				$("#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
					var ThisVal =$('#frm_upd<?php echo $i;?> #enviar<?php echo $i;?>').val();
					
					var nom=$('#frm_upd<?php echo $i;?> #nombre').val();
					var desc=$('#frm_upd<?php echo $i;?> #descripcion').val();
					var valprod=$('#frm_upd<?php echo $i;?> #ValorUnit_Producto').val();
					var prov=$('#frm_upd<?php echo $i;?> #proveedor').val();
					
					if(nom!="" && desc!="" && valprod!="" && prov!="" )
					{
						
						$.post("producto/actualizar_producto.php?id=<?php echo $results['Idproducto'];?>", {enviar<?php echo $i;?>:ThisVal, nombre:nom, descripcion:desc, ValorUnit_Producto:valprod, proveedor:prov}, function(output){
							
							if(output=="1" || output==1){
								var aler = ("Se ha registrado correctamente la informacion.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
								
								var soyYop =$('#frm_upd<?php echo $i;?>').parent('#contenedor').attr('name');
								$('#pestana .pestActiva[name="'+soyYop+'"]').hide(500,function(){
										$(this).remove();
										beforeClose('Ver_producto');
								});
								cerrarPestana('Modificar_producto');
								$('#temporal').html('');
								reloadPest("Ver_producto","producto/producto_vista.php?id=<?php echo $results['Idproducto'];?>");													 
							}else if(output=="0" || output==0){
								var aler = ("Existe un registro con los mismos datos o identificador se restableceran los campos.");
								frm_addOpenDialogo('#frm_upd<?php echo $i;?>', "Registro de datos","Datos no validos",aler,"","#nombre");
							 	$('#temporal').html('');
							 	reloadPest("Ver_producto","producto/producto_vista.php?id=<?php echo $results['Idproducto'];?>");													 
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
						beforeClose('buscar_producto');
					});
					cerrarPestana('Modificar_producto');					
				});
								
				$('#frm_upd<?php echo $i;?>').css('height','100%');
				$(".Modificar_producto form tr:last ").css({'text-align':'center'});
				$('#frm_upd<?php echo $i;?> input[type="reset"],#frm_upd<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
					
				recorridoDinamico('frm_upd<?php echo $i;?>');							
			});
		  
		</script>
		
		<form id="frm_upd<?php echo $i;?>" style="height:100%;" name="frm_upd<?php echo $i;?>" method="post">
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Modificar producto</h3>
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
					<input type="text" id="nombre" name="nombre" value="<?php echo $results['nom_producto'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Descripci&oacute;n</strong>				
				</td>
				<td>
					<fieldset class="forTextArea" id="forTextArea">
						<textarea name="descripcion" id="descripcion" cols="50" rows="5"><?php echo $results['desc_producto'];?></textarea>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Valor unitario</strong>				
				</td>
				<td>
					$<input type="number" id="ValorUnit_Producto" name="ValorUnit_Producto" value="<?php echo $results['ValorUnit_Producto'];?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Proveedor</strong>				
				</td>
				<td>
					<select name="proveedor" id="proveedor">
						<option value=""></option>
						<?php				
						$result_tipou=seleccion_proveedor();			
						while($results_tipou = $result_tipou->fetch(PDO::FETCH_ASSOC)){				
							if($results_tipou['IdProveedor'] == $results['producto_IdProveedor']){
								echo "<option value=".$results_tipou['IdProveedor']." selected='selected' >".$results_tipou['Nom_Proveedor']."</option>";
							}else{
								echo "<option value=".$results_tipou['IdProveedor'].">".$results_tipou['Nom_Proveedor']."</option>";
							}
						}				
						?>
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