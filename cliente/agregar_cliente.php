<?php 

		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i']);
		}
		
	if(isset($_POST['enviar'.$i.''])){

		include 'procedimientos_cliente.php';
		
		echo ingreso_cliente($_POST['nombre'],$_POST['direccion'],$_POST['telefono']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#frm_addagcl<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  	
		  	var thisVal =$(this).val();
		  	
			var nom=$('#frm_addagcl<?php echo $i;?> #nombre').val();
			var dir=$('#frm_addagcl<?php echo $i;?> #direccion').val();
			var tel=$('#frm_addagcl<?php echo $i;?> #telefono').val();
			
			if(nom!="" && dir!="" && tel!="")
			{
				$.post("cliente/agregar_cliente.php", {enviar<?php echo $i;?>:thisVal, nombre:nom, direccion:dir, telefono:tel}, function(output){
					if(output=="0" || output==0){
						var aler = ("Existe un registro con el mismo NIT o identificador!");
						frm_addOpenDialogo('#frm_addagcl<?php echo $i;?>', "Registro de datos","Datos duplicados",aler,"","#nombre");
						$('#frm_addagcl<?php echo $i;?> input#nombre').focus();
					}else if(output=="1" || output==1){
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagcl<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
						
						var soyYopt =$('#frm_addagcl<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
							$(this).remove();
							beforeClose('');
								$('#temporal').html('');
								reloadPest('Ver_Cliente',"cliente/cliente_vista.php");
						});
						cerrarPestana('agregar_cliente');
					}
				});
			}
			else
			{
				var aler = ("Existe algun campo vacio!");
				frm_addOpenDialogo('#frm_addagcl<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#nombre");
				$('#frm_addagcl<?php echo $i;?> input#nombre').focus();
			}
		});
				
		$("#frm_addagcl<?php echo $i;?> table:eq(1) tr td:nth-child(odd)").css({'padding-right':'10px'});
		$("#frm_addagcl<?php echo $i;?> table tr:last ").css({'text-align':'center'});
		$('#frm_addagcl<?php echo $i;?> input[type="reset"],#frm_addagcl<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
		$("#frm_addagcl<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
			$('#frm_addagcl<?php echo $i;?> input#nombre').focus();
		});
		$('#frm_addagcl<?php echo $i;?> input#nombre').focus();
		recorridoDinamico('frm_addagcl<?php echo $i;?>');		
	});
  
</script>
<form id="frm_addagcl<?php echo $i;?>" name="frm_addagcl<?php echo $i;?>" method="post" style=" height: 100%; ">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de clientes</h3>
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
			<strong>Direcci&oacute;n</strong>				
		</td>
		<td>
			<input type="text" id="direccion" name="direccion">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Tel&eacute;fono</strong>				
		</td>
		<td>
			<input type="text" id="telefono" name="telefono">
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
