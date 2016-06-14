<?php 

		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i']);
		}
		
		include 'procedimientos_muestra.php';
		
	if(isset($_POST['enviar'.$i.''])){
								
		echo ingreso_muestra($_POST['clienteId'],$_POST['codigo'],$_POST['fecha'],$_POST['sucursal'],$_POST['numfac'],$_POST['tipoMuestra'],$_POST['referencia'],$_POST['archivoId'],$_POST['descripcion']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			@setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>

<script type="text/javascript">
 
	$(document).ready(function(){
		
		frm_add<?php echo $i;?>Envio();
		frm_addResetCodigo();
		frm_addValidarCodigo();
		frm_addLlamarSucursal();
		frm_addHabilitarCodigo();
		frm_addValidaciones();
		frm_addMejorarAspecto();
		frm_add<?php echo $i;?>LeerCargaArchivo();
		resizeWindow();
		setTimeout(function(){			
			recorridoDinamico('frm_add<?php echo $i;?>');
		},1000);
		
		labelCheck('#frm_add<?php echo $i;?>');
	});
  
	  
	  /*se encarga de validar el formulario y enviar los datos*/
	function validacion(valid,criterio,redireccion,evento){
		var test = 0;
		var itemsNo = '';
		for (var valor in criterio) {
					var elemento = $("#frm_add<?php echo $i;?> #"+valor+"").val();
					if( elemento ==criterio[valor]){
						itemsNo+= '<li>'+valor+'</li>';
						test++;
					}
				}
				var codigoAnt =$("#frm_add<?php echo $i;?> #Codigo_antiguo").text();
				if(codigoAnt =="!Ya existe!"){
					itemsNo+='<li>Codigo_antiguo</li>';
					test++;
				}
				if(test >0){
					var al ="Esta es la lista de los campos requeridos que estan vacios o son incorrectos:<br><ul>"+ itemsNo +"</ul><br>Por favor ingrese la informaci&oacute;n necesaria";
					frm_addOpenDialogo("#frm_add<?php echo $i;?>", "Registro de datos","Datos incompletos",al,"","#codigo");
				}else{
					switch(evento){
						case('click'):
							redireccion.click();
							break;
						case('remove'):
							redireccion.remove();
							break;
						case('focus'):
							redireccion.focus();
							break;
					}					
				}
	};
	
	function frm_add<?php echo $i;?>Envio(){
		
		$("#frm_add<?php echo $i;?> #enviar<?php echo $i;?>").click(function() {			
			var siguiente = $("#frm_add<?php echo $i;?> #frm_addArchivo<?php echo $i;?> #cargaArchivoBtn");
			var criterios={'cliente':'000','sucursal':null,'Codigo_antiguo':'!Ya existe!','tipo_de_muestra':'000','archivo':''}; 
			validacion('#frm_add<?php echo $i;?>',criterios,siguiente,'click');
		});
		
		$("#frm_add<?php echo $i;?> #frm_add<?php echo $i;?>Enviar").click(function() {
			var thisVal = $(this);			
		  	var frmEnv = $(this).val();
		  	var comprobar = $('#frm_add<?php echo $i;?> #sucursal option').size();
		  			  	
			var ci=$('#frm_add<?php echo $i;?> #sucursal option:selected').attr('name');
			var sc=$('#frm_add<?php echo $i;?> #sucursal').val();
			var cod=$('#frm_add<?php echo $i;?> #codigo').val();
			var fec=$('#frm_add<?php echo $i;?> #fecha').val();
			var tm=$('#frm_add<?php echo $i;?> #tipo_de_muestra').val();
			var nf=$('#frm_add<?php echo $i;?> #numfac').val();
			var ref=$('#frm_add<?php echo $i;?> #referencia').val();
			var arId=$('#frm_add<?php echo $i;?> #frm_addArchivo<?php echo $i;?> input#id').val();
			var des=$('#frm_add<?php echo $i;?> #testarea').val();
			
			
			if(tm=="000")
			{
				tm ='';
			}
			if(sc =="000" || sc =="null" || sc ==null || sc =="" || comprobar ==0){
				var al ="Algun campo requerido esta vacio!";
				frm_addOpenDialogo("#frm_add<?php echo $i;?>", "Registro de datos","Datos incompletos",al,"","#cliente");
			}else{
				var contID = '#frm_add<?php echo $i;?>';
				$.post("muestra/agregar_muestra.php", {enviar<?php echo $i;?>:frmEnv, clienteId:ci, codigo:cod, fecha:fec, sucursal:sc, numfac:nf, tipoMuestra:tm, referencia:ref, archivoId:arId, descripcion:des}, function(output){
					if(output=="1" || output==1){
						
						enviandoPeticion(contID,'close');
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo(contID, "Registro de datos","Datos guardados",aler,"Continuar","#cliente");
						
						$("#frm_add<?php echo $i;?> #cancel<?php echo $i;?>").click();
						$('#temporal').html('');
						reloadPest("Ver_Muestra","muestra/muestra_vista.php");						
					}else if(output=="0" || output==0 || output!=1){
						enviandoPeticion(contID,'close');
						var ale ="Ocurrio un error en el momento de almacenar! <br>"+ output;
						frm_addOpenDialogo(contID, "Registro de datos","Error al guardar",ale,"","#cliente");
					}
				});

			}
		});
	}
		
		/*se encarga de validar el contenido del input #codigo para determinar que no este ya*/
	function frm_addResetCodigo(){
				$("#frm_add<?php echo $i;?> #cancel<?php echo $i;?>").click(function() {
					var reset = '<option id="selectFirst" value="" >Seleccione uno...</option>';
					
					$('#frm_add<?php echo $i;?> select#sucursal').html('');
					$("#frm_add<?php echo $i;?> #codigo").attr('disabled',true);
					$("#frm_add<?php echo $i;?> #Codigo_antiguo").html('');					
					$("#frm_add<?php echo $i;?> #Codigo_antiguo").val('');
					$('#frm_add<?php echo $i;?> #cargaArchivo #cargaArchivoContent #respuesta').removeClass('yesprint').addClass('noprint');
					$('#frm_add<?php echo $i;?> #cargaArchivo #cargaArchivoContent :file').removeClass('noprint');
					$('#frm_add<?php echo $i;?> #cargaArchivo #cargaArchivoContent :file').val('');
					$('#frm_add<?php echo $i;?> #testarea,.Modificar_Muestra textarea').val('');
					$('#frm_add<?php echo $i;?> select#cliente').focus();
				});
	}
		
		/*se encarga de validar el contenido del input #codigo para determinar que no este ya*/
	function frm_addEnvioCodigo(codigoAntig){
				$.post("muestra/procedimientos_muestra.php",{codigoAntiguo:codigoAntig}, function(data){
					var retur = data;
					if(retur==0){						
						$('#frm_add<?php echo $i;?> #Codigo_antiguo').html('!Ya existe!').css('color','red');
						$('#frm_add<?php echo $i;?> #Codigo_antiguo').attr('value','!Ya existe!');						
					}else if(retur==1){
						$('#frm_add<?php echo $i;?> #Codigo_antiguo').html('Ok').css('color','');
						$('#frm_add<?php echo $i;?> #Codigo_antiguo').attr('value','Ok');
					}
				});
	}
	
	function frm_addValidarCodigo(){
		$("#frm_add<?php echo $i;?> #codigo").keyup(function(){
			var codigoAntiguo = $(this).val();
				frm_addEnvioCodigo(codigoAntiguo);
		}).change(function(){
			var codigoAntiguo = $(this).val();
				frm_addEnvioCodigo(codigoAntiguo);
		});
	}
		
		/*se encarga de hacer el llamado para cargar el contenido del select de sucursal segun el cliente que se seleccione*/
	function frm_addLlamarSucursal(){
		$("#frm_add<?php echo $i;?> #cliente").change(function(){
			$("#frm_add<?php echo $i;?> #cliente option:selected").each(function(){
              		empresa=$(this).val();
				$.post("muestra/procedimientos_muestra.php",{empresa:empresa}, function(data){
					$("#frm_add<?php echo $i;?> #sucursal").html(data);
				}).always(function(){
					$("#frm_add<?php echo $i;?> #sucursal option").each(function(){						
						var sucur = $(this);						
						var sucursalId = sucur.val();
						
						$.post("muestra/procedimientos_muestra.php",{'idSucursal':sucursalId}, function(data){
							var res = data;
							var dato = res.replace(/\s+/g,'');
							sucur.attr('name',dato);
						});
					});
				});
            });
		});
	}
		/*habilita o deshabilita el campo de texto del codigo antiguo*/
	function frm_addHabilitarCodigo(){
		$("#frm_add<?php echo $i;?> #check").change(function(){
					
					if((this.checked)==true){
						$("#frm_add<?php echo $i;?> #codigo").attr('disabled',false).val('').focus();
						$("#frm_add<?php echo $i;?> #Codigo_antiguo").html('');
						$("#frm_add<?php echo $i;?> #Codigo_antiguo").val('');						
					}
					if((this.checked)==false){
						$("#frm_add<?php echo $i;?> #codigo").attr('disabled',true).val('');
						$("#frm_add<?php echo $i;?> #Codigo_antiguo").html('');
						$("#frm_add<?php echo $i;?> #Codigo_antiguo").val('');
						$("#frm_add<?php echo $i;?> input#fecha").focus();
					}
				
		});
	}
	
	/*sirve para validaciones y limitaciones de los elementos del formulario*/	
	function frm_addValidaciones(){
		$('#frm_add<?php echo $i;?> textarea[name="descripcion"]').keydown(function(){var numeroMaximo= 65530; var textareaVal= $(this).val(); if(textareaVal.length > numeroMaximo){return false; }});
		$('#frm_add<?php echo $i;?> select[name="cliente"]').focus().show();
		$('#frm_add<?php echo $i;?> input[name="fecha"]').keydown(function(){return false;});
		$('#frm_add<?php echo $i;?> input[type="file"]').change(function(){
			$('#frm_add<?php echo $i;?> textarea#testarea').focus();
		});
	}
	
	/*sirve para leer el contenido para subir archivos*/
		
	function frm_add<?php echo $i;?>LeerCargaArchivo(){
		var inputsArchivo = '<input type="hidden" name="id" id="id" value=""><input type="hidden" name="fileName" id="fileName" value=""><input type="hidden" name="fileSize" id="fileSize" value=""><input type="hidden" name="fileType" id="fileType" value=""><input type="hidden" name="descripcionFile" id="descripcionFile" value="">';
		var identi = "#frm_add<?php echo $i;?> #frm_addArchivo<?php echo $i;?>";
		var conetedorId = "#frm_add<?php echo $i;?>";
		var direcc = "archivos/subir.php";
		$(identi).load(direcc, function(){//lee el contenido externo
			iniciacionCarga(identi,conetedorId);// llama a la funcion que inserta el contenido para subir archivos
			$(identi).append(inputsArchivo);										
		}).show();
	}
	
	/*las siguientes son lineas de codigo para maquetacion de los elementos del formulario (apariencia)*/	
	function frm_addMejorarAspecto(){
				$("#frm_add<?php echo $i;?> input[name='fecha']").datepicker();//asigna el calendario a este input
				$("#frm_add<?php echo $i;?> input[name='fecha']").datepicker('setDate', new Date());
				$("#frm_add<?php echo $i;?> .agregar_muestra tr td").css('white-space','nowrap');//evita que al texto se le produzca un salto de linea cuando necesita ajustarse
				$("#frm_add<?php echo $i;?> select").css({'width':'97%'});
				$("#frm_add<?php echo $i;?> table").css({'width':'90%'});
				$('#frm_add<?php echo $i;?> input[name="codigo"]').css({'float':'left','width':'65% !important','margin-right':'5px'});
				$('#frm_add<?php echo $i;?> #Codigo_antiguo').css('margin-top','5px');
				$('#frm_add<?php echo $i;?> #frm_addArchivo').css({'border': '0px solid white','height': '30px', 'max-width': '240px','margin': '0px','padding': '0px','overflow': 'hidden'});
				$(".agregar_muestra form table:eq(1) tr td:nth-child(odd)").css({'width':'20%','padding-left':'10px'}).children(":not([type='checkbox'])").css({'width':'98%'}).parent().css({'height':'40px'});
				$(".agregar_muestra form table:eq(1) tr td:nth-child(even)").css({'width':'30%','padding-left':'10px'}).children(":not([id='codigo'])").css({'width':'98%'}).parent().css({'height':'40px'});
				$(".agregar_muestra form table:eq(3) tr ").css({'text-align':'center'});
				$('#frm_add<?php echo $i;?> input[type="reset"],#frm_add<?php echo $i;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px','width':'50%'}).parent().attr('colspan','2').parent().attr('align','center');
	}
	
  
</script>

<form id="frm_add<?php echo $i;?>" name="frm_add<?php echo $i;?>" method="post" height="100%">

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro de Muestras</h3>
		</td>
	</tr>
</table>

<table align="center" id="inputs">
	<tr>
		<td>
			Cliente
		</td>
		<td>
			<select name="cliente" id="cliente" autofocus>
				<option id="selectFirst" value="000" >Seleccione uno...</option>
			<?php
				
				$result=seleccion_cliente();
				
				while($results=mysql_fetch_array($result)){
				
				?>
        
				<option value="<?php echo $results['empresa_id'];?>" title="<?php echo $results['empresa_razonsocial'];?>"><?php echo $results['empresa_razonsocial'];?></option>
        
			<?php
				
				}
				
				?>
			</select>
		</td>
		<td>
			Sucursal
		</td>
		<td>
			<select name="sucursal" id="sucursal">			
			</select>
		</td>
	</tr>
	<tr>
		<td id="checkButtom"> 
			Codigo antiguo
			<input type="checkbox" name="check" id="check">
		</td>
		<td>
			<input type="text" disabled="disabled" name="codigo" id="codigo" value="" autocomplete="off">
			<div value="" id="Codigo_antiguo" style="white-space: nowrap;"></div>
		</td>
		<td>
			Fecha
		</td>
		<td>
			<input type="text" name="fecha" id="fecha" placeholder="A&ntilde;o-Mes-D&iacute;a">
		</td>
	</tr>
	<tr>
		<td>
			Tipo de muestra
		</td>
		<td>
			<select name="tipo_de_muestra" id="tipo_de_muestra">
				<option id="selectFirst" value="000" >Seleccione una...</option>
        		<?php
        
					$result=seleccion_tipomuestra();
					
					while($results=mysql_fetch_array($result)){
						
				?>
        
				<option value="<?php echo $results['tipom_id']?>"><?php echo $results['tipo_muestra']?></option>
            
				<?php
						
					}
				
				?>
			</select>
		</td>
		<td>
			Numero de Factura
		</td>
		<td>
			<input type="text" name="numfac" id="numfac">
		</td>
	</tr>
	<tr>
		<td>
			Referencia
		</td>
		<td>
			<input type="text" name="referencia" id="referencia">				
		</td>
		<td>
			Remisi&oacute;n
		</td>
		<td>
			
			<div name="frm_addArchivo<?php echo $i;?>" id="frm_addArchivo<?php echo $i;?>">
				
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<fieldset class="forTextArea">
			<legend>Descripci&oacute;n</legend>
				<textarea name="descripcion" id="testarea" cols="60" rows="10"></textarea>
			</fieldset>
		</td>
		<td>
		</td>
	</tr>	
	<tr>
		<td>
			<input type="reset" id="cancel<?php echo $i;?>" name="cancel" value="Cancelar" />
		</td>
		<td>
			<input type="hidden" id="frm_add<?php echo $i;?>Enviar" name="frm_add<?php echo $i;?>Enviar" value="Guardar" />
			<input type="button" id="enviar<?php echo $i;?>" name="enviar<?php echo $i;?>" value="Guardar" />
		</td>
	</tr>
</table>

</form>

<br><br>

<?php 

}

?>