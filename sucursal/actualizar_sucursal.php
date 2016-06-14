<?php 

	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}

	include 'procedimientos_sucursal.php';

	if(isset($_POST['enviar'.$i.''])){
	
		echo actualizar_sucursal($_GET['id'],$_POST['nombre'],$_POST['ciudad'],$_POST['direccion'],$_POST['telefono_1'],$_POST['telefono_2'],$_POST['fax'],$_POST['celular'],$_POST['mail'],$_POST['web'], $_POST['contacto']);
		
	}else{	
	
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}

		if(isset($_GET['id'])){
		
			$result=(seleccion_sucursal($_GET['id']));
		
		}
		
		while($results=mysql_fetch_array($result)){
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
		
		$("#enviar<?php echo $i;?>").click(function() {
		  
			var name=$('#frm_addacs<?php echo $i;?> #nombre').val();
			var city=$('#frm_addacs<?php echo $i;?> #ciudad').val();
			var dir=$('#frm_addacs<?php echo $i;?> #direccion').val();
			var tel_1=$('#frm_addacs<?php echo $i;?> #telefono_1').val();
			var tel_2=$('#frm_addacs<?php echo $i;?> #telefono_2').val();
			var fax=$('#frm_addacs<?php echo $i;?> #fax').val();
			var cel=$('#frm_addacs<?php echo $i;?> #celular').val();
			var web=$('#frm_addacs<?php echo $i;?> #web').val();
			var mail=$('#frm_addacs<?php echo $i;?> #mail').val();
			var contact=$('#frm_addacs<?php echo $i;?> #contacto').val();
			
			if(name != "" && city != "")
			{
				$.post("sucursal/actualizar_sucursal.php?id=<?php echo $_GET['id']?>", {enviar<?php echo $i;?>:$('#frm_addacs<?php echo $i;?> #enviar<?php echo $i;?>').val(), nombre:name, ciudad:city, direccion:dir, telefono_1:tel_1, telefono_2:tel_2, fax:fax, celular:cel, web:web, mail:mail, contacto:contact}, function(output){
					if(output==0){						
						var ale ="Ocurrio un error en el momento de almacenar! <br> Posiblemente se deba a que existe un registro con el mismo nombre de sucursal!";
						frm_addOpenDialogo('#frm_addacs<?php echo $i;?>', "Registro de datos","Error al guardar",ale,"","#nombre");
						
					}else if(output==1){
						var aler="Se ha actualizado correctamente la informacion.";
						frm_addOpenDialogo('#frm_addacs<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"Continuar","#nombre");												
						var soyYY =$('#frm_addacs<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYY+'"]').hide(500,function(){
							$(this).remove();
							beforeClose("Ver_Sucursal");
						});
						cerrarPestana('Actualizar_Sucursal');
						$('#temporal').html('');
						reloadPest("Ver_Sucursal","sucursal/sucursal_vista.php?id=<?php echo $_GET['id']?>");						
					}
				});
			}
			else
			{
				var alerta="Se ha actualizado correctamente la informacion.";
				frm_addOpenDialogo('#frm_addacs<?php echo $i;?>', "Registro de datos","Error al guardar",alerta,"Continuar","#nombre");				
			}
		});
		
		$("#cancel").click(function() {
			$('#pestana .pestActiva').hide(500,function(){
				$(this).remove();
				beforeClose('Ver_Cliente');
			});
			cerrarPestana('Actualizar_Sucursal');			
		});	
		
		$(".Actualizar_Sucursal form table tr:last ").css({'text-align':'center'});
		$('input[type="reset"],input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
				
		
	});
  
</script>
<form id="frm_addacs<?php echo $i;?>" name="frm_addacs<?php echo $i;?>" method="post">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Actualizar Sucursal</h3>
		</td>
	</tr>
</table>
<p>
<table align="center" style="width:60%;" id="inputs">
	<tr>
		<td>
			<strong>Nombre</strong>				
		</td>
		<td>
			<input type="text" id="nombre" name="nombre" title="<?php echo $results['sucursal_nombre'];?>" value="<?php echo $results['sucursal_nombre'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Pais</strong>				
		</td>
		<td>
    	<script type="text/javascript">
			
			$(document).ready(function(){
				$("#frm_addacs<?php echo $i;?> #pais").change(function(){
					$("#frm_addacs<?php echo $i;?> #pais option:selected").each(function(){
						pais=$(this).val();
						$.post("sucursal/procedimientos_sucursal.php",{pais:pais}, function(data){
							$("#frm_addacs<?php echo $i;?> #departamento").html(data);
						});
					});
				});
					
				$("#frm_addacs<?php echo $i;?> #departamento").change(function(){
					$("#frm_addacs<?php echo $i;?> #departamento option:selected").each(function(){
						departamento=$(this).val();
						$.post("sucursal/procedimientos_sucursal.php",{departamento:departamento}, function(data){
							$("#frm_addacs<?php echo $i;?> #ciudad").html(data);
						});
					});
				});
				
				$(".Actualizar_Sucursal form table select").css({'max-width':'161px'}).parent().css({'max-width':'161px'});
				$(".Actualizar_Sucursal form").css({'height':'100%'});
			});
			
			</script>
			<select name="pais" id="pais">
				<option value=""></option>
				<?php
				
					$resulta=seleccion_pais();
					
					while($resultsa=mysql_fetch_array($resulta)){
					
				?>
        
					<option value="<?php echo $resultsa['pais_id'];?>"><?php echo $resultsa['pais_nombre'];?></option>
        
				<?php
					
					}
				
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Departamento</strong>				
		</td>
		<td>
    	<select name="departamento" id="departamento">
        
      </select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Ciudad</strong>				
		</td>
		<td>
    	<select name="ciudad" id="ciudad">
			<option  value="<?php echo $results['ciudad_id'];?>"><?php echo $results['ciudad_nombre'];?></option>
      </select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Direccion</strong>				
		</td>
		<td>
			<input type="text" id="direccion" name="direccion" title="<?php echo $results['sucursal_direccion'];?>" value="<?php echo $results['sucursal_direccion'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Telefono 1</strong>				
		</td>
		<td>
			<input type="tel" id="telefono_1" name="telefono_1" value="<?php echo $results['sucursal_telefono_1'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Telefono 2</strong>				
		</td>
		<td>
			<input type="tel" id="telefono_2" name="telefono_2" value="<?php echo $results['sucursal_telefono_2'];?>">
		</td>
	</tr>
  <tr>
		<td>
			<strong>Fax</strong>				
		</td>
		<td>
			<input type="tel" id="fax" name="fax" value="<?php echo $results['sucursal_fax'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Celular</strong>				
		</td>
		<td>
			<input type="tel" id="celular" name="celular" value="<?php echo $results['sucursal_celular'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Web</strong>				
		</td>
		<td>
			<input type="text" id="web" name="web" value="<?php echo $results['sucursal_web'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Mail</strong>				
		</td>
		<td>
			<input type="email" id="mail" name="mail" value="<?php echo $results['sucursal_mail'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Contacto</strong>				
		</td>
		<td>
			<input type="text" id="contacto" name="contacto" value="<?php echo $results['sucursal_contacto'];?>">
		</td>
	</tr>
	<tr>
		<td>
			<br>
			<input type="reset" id="cancel" name="cancel" value="Cancelar" />
		</td>
		<td>
			<br>
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