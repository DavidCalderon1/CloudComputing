<?php 

	include 'procedimientos_producto.php';
	
	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}
		
	if(isset($_POST['enviar'.$i.''])){
		
		echo ingreso_producto($_POST['nombre'],$_POST['descripcion'],$_POST['ValorUnit_Producto'],$_POST['idproveedor']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#frm_addagprod<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  	
		  	var thisVal =$(this).val();
		  	
			var nom=$('#frm_addagprod<?php echo $i;?> #nombre').val();
			var desc=$('#frm_addagprod<?php echo $i;?> #descripcion').val();
			var valprod=$('#frm_addagprod<?php echo $i;?> #ValorUnit_Producto').val();
			var idprov=$('#frm_addagprod<?php echo $i;?> #proveedor').val();
			
			if(nom !="" && desc !="" && valprod !="" && idprov !="")
			{ 
				$.post("producto/agregar_producto.php", {enviar<?php echo $i;?>:thisVal, nombre:nom, descripcion:desc, ValorUnit_Producto:valprod, idproveedor:idprov}, function(output){
					
					if(output=="0" || output==0){
						var aler = ("Existe un registro con los mismos datos!");
						frm_addOpenDialogo('#frm_addagprod<?php echo $i;?>', "Registro de datos","Datos duplicados",aler,"","#nombre");
						$('#frm_addagprod<?php echo $i;?> input#nombre').focus();
					}else if(output=="1" || output==1){
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagprod<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#nombre");
						
						var soyYopt =$('#frm_addagprod<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
							$(this).remove();
							beforeClose('');
								$('#temporal').html('');
								reloadPest('Ver_producto',"producto/producto_vista.php");
						});
						cerrarPestana('agregar_producto');
					}
				});
			}
			else
			{
				var aler = ("Existe algun campo vacio o incorrecto!");
				frm_addOpenDialogo('#frm_addagprod<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#nombre");
				$('#frm_addagprod<?php echo $i;?> input#nombre').focus();
			}
		});		
		
		$("#frm_addagprod<?php echo $i;?> table:eq(1) tr td:nth-child(odd)").css({'padding-right':'10px'});
		$("#frm_addagprod<?php echo $i;?> table tr:last ").css({'text-align':'center'});
		$('#frm_addagprod<?php echo $i;?> input[type="reset"],#frm_addagprod<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
		$("#frm_addagprod<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
			$('#frm_addagprod<?php echo $i;?> input#nombre').focus();
		});
		$('#frm_addagprod<?php echo $i;?> input#nombre').focus();
		recorridoDinamico('frm_addagprod<?php echo $i;?>');		
	});
  
</script>
<form id="frm_addagprod<?php echo $i;?>" name="frm_addagprod<?php echo $i;?>" method="post" style=" height: 100%; ">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de productos</h3>
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
			<strong>Descripci&oacute;n</strong>				
		</td>
		<td>
			<fieldset class="forTextArea">
				<textarea name="descripcion" id="descripcion" cols="50" rows="5"></textarea>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Valor unitario</strong>				
		</td>
		<td>
			$<input type="number" id="ValorUnit_Producto" name="ValorUnit_Producto">
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
				$result=seleccion_proveedor();			
				while($results = $result->fetch(PDO::FETCH_ASSOC)){				
				?>        
				<option value="<?php echo $results['IdProveedor'];?>"><?php echo $results['Nom_Proveedor'];?></option>        
				<?php
				}				
				?>
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
