<?php 

		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i']);
		}
		
	if(isset($_POST['enviar'.$i.''])){

		include 'procedimientos_proveedor.php';
		
		echo ingreso_proveedor($_POST['nombre'],$_POST['direccion'],$_POST['telefono']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#frm_addagprov<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  	
		  	var thisVal =$(this).val();
		  	
			var nom=$('#frm_addagprov<?php echo $i;?> #nombre').val();
			var dir=$('#frm_addagprov<?php echo $i;?> #direccion').val();
			var tel=$('#frm_addagprov<?php echo $i;?> #telefono').val();
			
			if(nom!="" && dir!="" && tel!="")
			{
				$.post("proveedor/agregar_proveedor.php", {enviar<?php echo $i;?>:thisVal, nombre:nom, direccion:dir, telefono:tel}, function(output){
					if(output=="0" || output==0){
						var aler = ("Existe un registro con el mismo NIT o identificador!");
						frm_addOpenDialogo('#frm_addagprov<?php echo $i;?>', "Registro de datos","Datos duplicados",aler,"","#nombre");
						$('#frm_addagprov<?php echo $i;?> input#nombre').focus();
					}else if(output=="1" || output==1){
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagprov<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
						
						var soyYopt =$('#frm_addagprov<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
							$(this).remove();
							beforeClose('');
								$('#temporal').html('');
								reloadPest('Ver_Proveedor',"proveedor/proveedor_vista.php");
						});
						cerrarPestana('agregar_proveedor');
					}
				});
			}
			else
			{
				var aler = ("Existe algun campo vacio!");
				frm_addOpenDialogo('#frm_addagprov<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#nombre");
				$('#frm_addagprov<?php echo $i;?> input#nombre').focus();
			}
		});
				
		$("#frm_addagprov<?php echo $i;?> table:eq(1) tr td:nth-child(odd)").css({'padding-right':'10px'});
		$("#frm_addagprov<?php echo $i;?> table tr:last ").css({'text-align':'center'});
		$('#frm_addagprov<?php echo $i;?> input[type="reset"],#frm_addagprov<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
		$("#frm_addagprov<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
			$('#frm_addagprov<?php echo $i;?> input#nombre').focus();
		});
		$('#frm_addagprov<?php echo $i;?> input#nombre').focus();
		recorridoDinamico('frm_addagprov<?php echo $i;?>');		
	});
  
</script>
<form id="frm_addagprov<?php echo $i;?>" name="frm_addagprov<?php echo $i;?>" method="post" style=" height: 100%; ">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de proveedores</h3>
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
