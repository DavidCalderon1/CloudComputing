<?php 

	include 'procedimientos_sucursal.php';

	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}
	
	if(isset($_POST['enviar'.$i.''])){
		
		echo ingreso_sucursal($_GET['id'],$_POST['nombre'],$_POST['ciudad'],$_POST['direccion'],$_POST['telefono_1'],$_POST['telefono_2'],$_POST['fax'],$_POST['celular'],$_POST['mail'],$_POST['web'], $_POST['contacto']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
		
		$("#frm_addas<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  
			var name=$('#frm_addas<?php echo $i;?> #nombre').val();
			var city=$('#frm_addas<?php echo $i;?> #ciudad').val();
			var dir=$('#frm_addas<?php echo $i;?> #direccion').val();
			var tel_1=$('#frm_addas<?php echo $i;?> #telefono_1').val();
			var tel_2=$('#frm_addas<?php echo $i;?> #telefono_2').val();
			var fax=$('#frm_addas<?php echo $i;?> #fax').val();
			var cel=$('#frm_addas<?php echo $i;?> #celular').val();
			var web=$('#frm_addas<?php echo $i;?> #web').val();
			var mail=$('#frm_addas<?php echo $i;?> #mail').val();
			var contact=$('#frm_addas<?php echo $i;?> #contacto').val();
			
			if(name!="" && city!="")
			{
				$.post("sucursal/agregar_sucursal.php?id=<?php echo $_GET['id']?>", {enviar<?php echo $i;?>:$('#frm_addas<?php echo $i;?> #enviar<?php echo $i;?>').val(), nombre:name, ciudad:city, direccion:dir, telefono_1:tel_1, telefono_2:tel_2, fax:fax, celular:cel, web:web, mail:mail, contacto:contact}, function(output){
					if(output==0){
						var alerAM = ("Existe un registro con el mismo nombre de sucursal!");
						frm_addOpenDialogo('#frm_addas<?php echo $i;?>', "Registro de datos","Datos no guardados",alerAM,"","#nombre");
					}else if(output==1){
						var alerAM = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addas<?php echo $i;?>', "Registro de datos","Datos guardados",alerAM,"","#nombre");																		
						$('#temporal').html('');
						var soyY =$('#frm_addas<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyY+'"]').hide(500,function(){
							$(this).remove();
							beforeClose("Ver_Cliente");
						});
						cerrarPestana('Agregar_Sucursal');
						$('#temporal').html('');
						reloadPest("Ver_Cliente","cliente/cliente_vista.php?id=<?php echo $_GET['id']?>");						
					}
				});
			}else{
				var alerAM = ("El campo nombre o ciudad esta vacio!");
				frm_addOpenDialogo('#frm_addas<?php echo $i;?>', "Registro de datos","Datos incompletos",alerAM,"","#nombre");	
			}
		});
		
		$(".Agregar_Sucursal form table select").css({'max-width':'161px'}).parent().css({'max-width':'161px'});
		$(".Agregar_Sucursal form").css({'height':'100%'});
		
		
		$(".Agregar_Sucursal form table tr:last ").css({'text-align':'center'});
		$('#frm_addas<?php echo $i;?> input[type="reset"],#frm_addas<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
		$('#frm_addas<?php echo $i;?> input[type="reset"]').click(function(){
			$('#frm_addas<?php echo $i;?> input:first').focus();
		});
		
		recorridoDinamico('frm_addas<?php echo $i;?>');
	});
  
</script>
<form id="frm_addas<?php echo $i;?>" name="frm_addas<?php echo $i;?>" method="post">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de Sucursal</h3>
		</td>
	</tr>
</table>
<p>
<table align="center" width="60%" id="inputs">
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
			<strong>Pais</strong>				
		</td>
		<td>
			<script type="text/javascript">
			
				$(document).ready(function(){
					$("#frm_addas<?php echo $i;?> #pais").change(function(){
						$("#frm_addas<?php echo $i;?> #pais option:selected").each(function(){
							pais=$(this).val();
							$.post("sucursal/procedimientos_sucursal.php",{pais:pais}, function(data){
								$("#frm_addas<?php echo $i;?> #departamento").html(data);
							});
						});
					});
					
					$("#frm_addas<?php echo $i;?> #departamento").change(function(){
						$("#frm_addas<?php echo $i;?> #departamento option:selected").each(function(){
							departamento=$(this).val();
							$.post("sucursal/procedimientos_sucursal.php",{departamento:departamento}, function(data){
								$("#frm_addas<?php echo $i;?> #ciudad").html(data);
							});
						});
					});
					
				});
			
			</script>
			<select name="pais" id="pais">
				<option value=""></option>
				<?php				
				$result=seleccion_pais();				
				while($results=mysql_fetch_array($result)){					
				?>        
				<option value="<?php echo $results['pais_id'];?>"><?php echo $results['pais_nombre'];?></option>        
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
        
      </select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Direccion</strong>				
		</td>
		<td>
			<input type="text" id="direccion" name="direccion">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Telefono 1</strong>				
		</td>
		<td>
			<input type="tel" id="telefono_1" name="telefono_1">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Telefono 2</strong>				
		</td>
		<td>
			<input type="tel" id="telefono_2" name="telefono_2">
		</td>
	</tr>
  <tr>
		<td>
			<strong>Fax</strong>				
		</td>
		<td>
			<input type="tel" id="fax" name="fax">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Celular</strong>				
		</td>
		<td>
			<input type="tel" id="celular" name="celular">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Web</strong>				
		</td>
		<td>
			<input type="text" id="web" name="web">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Mail</strong>				
		</td>
		<td>
			<input type="email" id="mail" name="mail">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Contacto</strong>				
		</td>
		<td>
			<input type="text" id="contacto" name="contacto">
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
