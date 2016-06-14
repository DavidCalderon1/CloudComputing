<?php 

	include 'procedimientos_pedido.php';
	
	if(isset($_COOKIE['i'])){
		$i=($_COOKIE['i']);
	}
		
	if(isset($_POST['enviar'.$i.''])){
		
		echo ingreso_pedido($_POST['fecha_pedido'].' '.$_POST['hora_pedido'],$_POST['idproducto'],$_POST['cantidad_pedido'],$_POST['valor_pedido']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>
<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#frm_addagpe<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {
		  	
		  	var thisVal =$(this).val();
		  	
			var fecha=$('#frm_addagpe<?php echo $i;?> #fecha_pedido').val();
			var hora=$('#frm_addagpe<?php echo $i;?> #hora_pedido').val();
			var prod=$('#frm_addagpe<?php echo $i;?> #producto').val();
			var cant=$('#frm_addagpe<?php echo $i;?> #cantidad_pedido').val();
			var valor=$('#frm_addagpe<?php echo $i;?> #valor_pedido').val();
						
			if(fecha!="" && prod!=""  && cant!=""  && valor!="" )
			{
				$.post("pedido/agregar_pedido.php", {enviar<?php echo $i;?>:thisVal, fecha_pedido:fecha, hora_pedido:hora, idproducto:prod, cantidad_pedido:cant, valor_pedido:valor}, function(output){
					if(output=="0" || output==0){
						var aler = ("Existe un registro con los mismos datos!");
						frm_addOpenDialogo('#frm_addagpe<?php echo $i;?>', "Registro de datos","Datos duplicados",aler,"","#fecha_pedido");
						$('#frm_addagpe<?php echo $i;?> input#producto').focus();
					}else if(output=="1" || output==1){
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo('#frm_addagpe<?php echo $i;?>', "Registro de datos","Datos guardados",aler,"","#fecha_pedido");
						
						var soyYopt =$('#frm_addagpe<?php echo $i;?>').parent('#contenedor').attr('name');
						$('#pestana .pestActiva[name="'+soyYopt+'"]').hide(500,function(){
							$(this).remove();
							beforeClose('');
								$('#temporal').html('');
								reloadPest('Ver_pedido',"pedido/pedido_vista.php");
						});
						cerrarPestana('agregar_pedido');
					}
				});
			}
			else
			{
				var aler = ("Existe algun campo vacio o incorrecto!");
				frm_addOpenDialogo('#frm_addagpe<?php echo $i;?>', "Registro de datos","Datos incompletos",aler,"","#fecha_pedido");
				$('#frm_addagpe<?php echo $i;?> input#producto').focus();
			}
		});
		
		/*modificar el color de los productos deacuerdo al proveedor seleccionado*/
		$("#frm_addagpe<?php echo $i;?> #proveedor").keyup(function(){
			var this_idprov = $(this).val();
			$("#frm_addagpe<?php echo $i;?> #producto option").each(function(){
				var idprov = $(this).attr('idproveedor');
				if(idprov == this_idprov || this_idprov == ''){
					$(this).removeClass('deshabilitado').removeAttr('title');
				}else{
					$(this).addClass('deshabilitado').attr('title','No pertenece al mismo proveedor');
				}
			});
			$("#frm_addagpe<?php echo $i;?> #producto option").removeAttr('selected');
			$("#frm_addagpe<?php echo $i;?> #valorunit").val('');
			$("#frm_addagpe<?php echo $i;?> #cantidad_pedido").keyup();
		}).change(function(){
			var this_idprov = $(this).val();
			$("#frm_addagpe<?php echo $i;?> #producto option").each(function(){
				var idprov = $(this).attr('idproveedor');
				if(idprov == this_idprov || this_idprov == ''){
					$(this).removeClass('deshabilitado').removeAttr('title');
				}else{
					$(this).addClass('deshabilitado').attr('title','No pertenece al mismo proveedor');
				}
			});
			$("#frm_addagpe<?php echo $i;?> #producto option").removeAttr('selected');
			$("#frm_addagpe<?php echo $i;?> #valorunit").val('');
			$("#frm_addagpe<?php echo $i;?> #cantidad_pedido").keyup();
		});
		/*modificar el color de los productos que pertenezcan al mismo proveedor*/
		$("#frm_addagpe<?php echo $i;?> #producto").keyup(function(){
			var this_val = $(this).val();
			var this_idprov = $(this).find("option:selected").attr('idproveedor');	
			var valorunit = $(this).find("option:selected").attr('valorunit');
			$("#frm_addagpe<?php echo $i;?> #valorunit").val(valorunit);
			$("#frm_addagpe<?php echo $i;?> #cantidad_pedido").keyup();
			$("#frm_addagpe<?php echo $i;?> #producto option").each(function(){
				var idprov = $(this).attr('idproveedor');
				if(idprov == this_idprov || this_idprov == ''){
					$(this).removeClass('deshabilitado').removeAttr('title');
				}else{
					$(this).addClass('deshabilitado').attr('title','No pertenece al mismo proveedor');
				}
			});		
			$("#frm_addagpe<?php echo $i;?> #proveedor option[value='"+ this_idprov +"']").prop('selected', true);			
		}).change(function(){
			var this_val = $(this).val();
			var this_idprov = $(this).find("option:selected").attr('idproveedor');	
			var valorunit = $(this).find("option:selected").attr('valorunit');
			$("#frm_addagpe<?php echo $i;?> #valorunit").val(valorunit);
			$("#frm_addagpe<?php echo $i;?> #cantidad_pedido").keyup();
			$("#frm_addagpe<?php echo $i;?> #producto option").each(function(){
				var idprov = $(this).attr('idproveedor');
				if(idprov == this_idprov){
					$(this).removeClass('deshabilitado').removeAttr('title');
				}else{
					$(this).addClass('deshabilitado').attr('title','No pertenece al mismo proveedor');
				}
			});
			$("#frm_addagpe<?php echo $i;?> #proveedor option[value='"+ this_idprov +"']").prop('selected', true);
		});
		/*modificar el valor del pedido deacuerdo con la cantidad de productos*/
		$("#frm_addagpe<?php echo $i;?> #cantidad_pedido").keyup(function(){
			var this_val = $(this).val();
			var valorunit = $("#frm_addagpe<?php echo $i;?> #valorunit").val();
			$("#frm_addagpe<?php echo $i;?> #valor_pedido").val( this_val * valorunit );
		}).change(function(){
			var this_val = $(this).val();
			var valorunit = $("#frm_addagpe<?php echo $i;?> #valorunit").val();
			$("#frm_addagpe<?php echo $i;?> #valor_pedido").val( this_val * valorunit );
		});
		/*-----------*/
		
		$("#frm_addagpe<?php echo $i;?> input[name='fecha_pedido']").datepicker();//asigna el calendario a este input
		$("#frm_addagpe<?php echo $i;?> input[name='fecha_pedido']").datepicker('setDate', new Date());
		setInterval(function() {
			var myDate = new Date();
			//var displayDate = (myDate.getMonth()+1) + '/' + (myDate.getDate()) + '/' + myDate.getFullYear();
			var mostrarHora = myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
			$('.hora').val( mostrarHora );
		}, 1000);
		$("#frm_addagpe<?php echo $i;?> table:eq(1) tr td:nth-child(odd)").css({'padding-right':'10px'});
		$("#frm_addagpe<?php echo $i;?> table tr:last ").css({'text-align':'center'});
		$('#frm_addagpe<?php echo $i;?> input[type="reset"],#frm_addagpe<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px'});
		$("#frm_addagpe<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
			$('#frm_addagpe<?php echo $i;?> input#proveedor').focus();
		});
		$('#frm_addagpe<?php echo $i;?> input#proveedor').focus();
		recorridoDinamico('frm_addagpe<?php echo $i;?>');		
	});
  
</script>
<form id="frm_addagpe<?php echo $i;?>" name="frm_addagpe<?php echo $i;?>" method="post" style=" height: 100%; ">
<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de pedidos</h3>
		</td>
	</tr>
</table>
<p>
<table align="center" id="inputs">
	<tr>
		<td>
			<strong>Fecha</strong>				
		</td>
		<td>
			<input type="text" id="fecha_pedido" name="fecha_pedido" class="medioInput" disabled>
			<input type="text" id="hora_pedido" name="hora_pedido" class="hora medioInput" disabled>
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
			<strong>Producto</strong>				
		</td>
		<td>
			<select name="producto" id="producto">
				<option value=""></option>
				<?php				
				$result=seleccion_producto();			
				while($results = $result->fetch(PDO::FETCH_ASSOC)){				
				?>        
				<option value="<?php echo $results['IdProducto'];?>" idproveedor="<?php echo $results['Producto_IdProveedor'];?>" valorunit="<?php echo $results['ValorUnit_Producto'];?>"><?php echo $results['Nom_Producto'];?></option>        
				<?php
				}				
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Valor unitario</strong>				
		</td>
		<td>
			$<input type="number" id="valorunit" name="valorunit" disabled>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Cantidad</strong>				
		</td>
		<td>
			<input type="number" id="cantidad_pedido" name="cantidad_pedido">
		</td>
	</tr>
	<tr>
		<td>
			<strong>Valor del pedido</strong>				
		</td>
		<td>
			$<input type="number" id="valor_pedido" name="valor_pedido" disabled>
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
