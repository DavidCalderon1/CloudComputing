<?php 

	include 'procedimientos_usuario.php';
	
	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}
		
	if(isset($_POST['enviar'.$i.''])){
		
		echo ingreso_usuario($_POST['nombre'],$_POST['password'],$_POST['tipou'],$_POST['estau']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#frm_addagus<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  	
		  	var thisVal =$(this).val();
		  	
			var nom=$('#frm_addagus<?php echo $i;?> #nombre').val();
			var pass=$('#frm_addagus<?php echo $i;?> #password').val();
			var passVal=$('#frm_addagus<?php echo $i;?> #password2').val();
			var tipou=$('#frm_addagus<?php echo $i;?> #tipo_usuario').val();
			var estau=$('#frm_addagus<?php echo $i;?> #estado_usuario').val();
			
			if(nom!="" && pass!="" && pass == passVal && tipou!="" && estau!="")
			{
				$.post("usuario/agregar_usuario.php", {enviar<?php echo $i;?>:thisVal, nombre:nom, password:pass, tipou:tipou, estau:estau}, function(output){
					if(output=="0" || output==0){
						var aler = ("Existe un registro con los mismos datos!");
						frm_addOpenDialogo('#frm_addagus<?php echo $i;?>', "Registro de datos","Datos duplicados",aler,"","#nombre");
						$('#frm_addagus<?php echo $i;?> input#nombre').focus();
					}else if(output=="1" || output==1){
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagus<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
						
						var soyYopt =$('#frm_addagus<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
							$(this).remove();
							beforeClose('');
								$('#temporal').html('');
								reloadPest('Ver_usuario',"usuario/usuario_vista.php");
						});
						cerrarPestana('agregar_usuario');
					}
				});
			}
			else
			{
				var aler = ("Existe algun campo vacio o incorrecto!");
				frm_addOpenDialogo('#frm_addagus<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#nombre");
				$('#frm_addagus<?php echo $i;?> input#nombre').focus();
			}
		});
		/*compara los password y muestra el resultado*/
		function registroValidarPassword(dato){
			var passVal = $("#frm_addagus<?php echo $i;?> input#password").val();
			if( dato != passVal ){
				$('#frm_addagus<?php echo $i;?> #password2').parents('td').find('.text_help').html('!Incorrecto&#33;').css('color','red');
			}else{
				$('#frm_addagus<?php echo $i;?> #password2').parents('td').find('.text_help').html('Ok').css('color','');
			}
		}
		//validar la confirmacion del password
		$('#frm_addagus<?php echo $i;?> #password2').keyup(function(){
			var dato = $(this).val();
			registroValidarPassword(dato);
		}).change(function(){
			var dato = $(this).val();
			registroValidarPassword(dato);
		});
		
		
		$("#frm_addagus<?php echo $i;?> table:eq(1) tr td:nth-child(odd)").css({'padding-right':'10px'});
		$("#frm_addagus<?php echo $i;?> table tr:last ").css({'text-align':'center'});
		$('#frm_addagus<?php echo $i;?> input[type="reset"],#frm_addagus<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
		$("#frm_addagus<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
			$('#frm_addagus<?php echo $i;?> input#nombre').focus();
		});
		$('#frm_addagus<?php echo $i;?> input#nombre').focus();
		recorridoDinamico('frm_addagus<?php echo $i;?>');		
	});
  
</script>
<form id="frm_addagus<?php echo $i;?>" name="frm_addagus<?php echo $i;?>" method="post" style=" height: 100%; ">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de usuarios</h3>
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
			<input type="text" id="nombre" name="nombre">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Contrase&ntilde;a</strong>				
		</td>
		<td>
			<input type="password" id="password" name="password">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Confirmar contrase&ntilde;a</strong>				
		</td>
		<td>
			<input type="password" id="password2" name="password2">
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
				$result=seleccion_tipo_usuario();			
				while($results = $result->fetch(PDO::FETCH_ASSOC)){				
				?>        
				<option value="<?php echo $results['IdTipo_Usuario'];?>"><?php echo $results['Nom_Tipo_Usuario'];?></option>        
				<?php
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
				<option value="1" selected='selected' >Activo</option>
				<option value="2">Inactivo</option>
			</select>
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

?>
