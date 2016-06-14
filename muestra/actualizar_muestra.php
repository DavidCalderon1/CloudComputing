<?php 

		if(isset($_COOKIE['i'])){
			$iMue=($_COOKIE['i']);
		}
		
		include 'procedimientos_muestra.php';
		
	if(isset($_POST['enviar'.$iMue.''])){
								
		echo actualizar_muestra($_POST['muestraId'],$_POST['clienteId'],$_POST['codigo'],$_POST['fecha'],$_POST['sucursal'],$_POST['numfac'],$_POST['tipoMuestra'],$_POST['referencia'],$_POST['archivoId'],$_POST['descripcion']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$iMue=($_COOKIE['i'])+1;
			setcookie("i","".$iMue."",time()+60*60*24*365,"/");
		}
		
		if(isset($_GET['id'])){		
			$resultAM=(seleccion_muestra($_GET['id']));		
		}else{			
			$resultAM=(seleccion_muestra($_COOKIE['id']));			
		}
		
		while($resultsAM=mysql_fetch_array($resultAM)){
				
			$muestra_id=$resultsAM['muestra_id'];
			$empresa_id=$resultsAM['empresa_id'];
			$sucursal_id=$resultsAM['sucursal_id'];
			$sucursal_nombre=$resultsAM['sucursal_nombre'].' '.$resultsAM['ciudad_nombre'];
			$cliente_identificador=$resultsAM['cliente_identificador'];
			$muestra_previouscode=$resultsAM['muestra_previouscode'];
			$muestra_fecha=$resultsAM['muestra_fecha'];
			$tipom_id=$resultsAM['tipom_id'];
			$muestra_numfactura=$resultsAM['muestra_numfactura'];
			$muestra_referencia=$resultsAM['muestra_referencia'];
			$ar_id=$resultsAM['ar_id'];
			$ar_name=$resultsAM['ar_name'];
			$muestra_descripcion=$resultsAM['muestra_descripcion'];
			
		}
?>

<script type="text/javascript">
 
	$(document).ready(function(){
		
		frm_updMue<?php echo $iMue;?>Envio();
		frm_updMueResetCodigo();
		frm_updMueValidarCodigo();
		frm_updMueLlamarSucursal();
		frm_updMueHabilitarCodigo();
		frm_updMueValidaciones();
		frm_updMueMejorarAspecto();
		frm_updMue<?php echo $iMue;?>LeerCargaArchivo();
		resizeWindow();
		setTimeout(function(){			
			recorridoDinamico('frm_updMue<?php echo $iMue;?>');
		},1000);
		
		frm_updMueColocarValores();
		labelCheck('#frm_updMue<?php echo $iMue;?>');
	});
  
	  
	function frm_updMueColocarValores(){					
					
					var forClienteValue ='<?php echo $empresa_id;?>';
					$("#frm_updMue<?php echo $iMue;?> select#cliente option").each(function(){
						var ThisValue =$(this).attr('value');
						if(ThisValue ==forClienteValue){
							$(this).prependTo($("#frm_updMue<?php echo $iMue;?> select#cliente"));
						}
					});
					
					var forSelect =$('<option id="" value="<?php echo $sucursal_id;?>" name="<?php echo $cliente_identificador;?>" title="<?php echo $sucursal_nombre;?>"><?php echo $sucursal_nombre;?></option>');
					$("#frm_updMue<?php echo $iMue;?> select#sucursal").prepend(forSelect);
					
					$("#frm_updMue<?php echo $iMue;?> #checkMue").attr('checked','checked');
					$("#frm_updMue<?php echo $iMue;?> input#codigo").attr('disabled',false);
					var forCodigoVal ='<?php echo $muestra_previouscode;?>';
					$("#frm_updMue<?php echo $iMue;?> input#codigo").val(forCodigoVal);
					
					var forFechaVal ='<?php echo $muestra_fecha;?>';
					$("#frm_updMue<?php echo $iMue;?> input#fecha").val(forFechaVal);
					
					var forTipomueValue ='<?php echo $tipom_id;?>';
					$("#frm_updMue<?php echo $iMue;?> select#tipo_de_muestra option").each(function(){
						var ThisValueTM =$(this).attr('value');
						if(ThisValueTM ==forTipomueValue){
							$(this).prependTo($("#frm_updMue<?php echo $iMue;?> select#tipo_de_muestra"));
						}
					});
					
					var forNumfactVal ='<?php echo $muestra_numfactura;?>';
					$("#frm_updMue<?php echo $iMue;?> input#numfac").val(forNumfactVal);
					
					var forReferenVal ='<?php echo $muestra_referencia;?>';
					$("#frm_updMue<?php echo $iMue;?> input#referencia").val(forReferenVal);
					
					var forFileSel =$('<select name="forFile" style="width: 100%;" id="forFile"><option id="selectFirst" value="000" >Seleccione uno...</option><option id="look" value="1" >Ver el archivo</option><option id="change" value="2" >Cambiar el archivo</option></select>');
					var forFileButt1 =$('<input type="button" style="display:none;" name="<?php echo $ar_id;?>" id="<?php echo $ar_id;?>" title="<?php echo $ar_name;?>" value="<?php echo $ar_name;?>" onclick="volcarArchivo(<?php echo $ar_id;?>)" />');
					var forFileButt2 =$('<input type="button" id="GeoClose" value="Cerrar visor de archivos" onclick="closeWin()" style="display:none;"/>');
					var forFileButt3 =$('<input type="button" style="display: none; float:left;" name="forFileReturn" id="forFileReturn" title="Regresar al menu de opciones" value="&#8592;">');
					$("#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?>").css('display','none');
					$("#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?>").parent().prepend(forFileButt2).prepend(forFileButt1).prepend(forFileSel).prepend(forFileButt3);
					$('#frm_updMue<?php echo $iMue;?> #forFile').change(function(){
						var forFileVal =$(this).val();
						forFileVal=parseInt(forFileVal);
						var forFileId =$(this).attr('id');
						if(forFileVal==1 || forFileId =='look'){
							$(this).css('display','none').parent().find('> input,> div').css('display','none');
							$(this).parent().find('> input#<?php echo $ar_id;?>,> input#forFileReturn').css('display','block');
						}
						if(forFileVal==2 || forFileId =='change'){							
							$(this).css('display','none').parent().find('> input').css('display','none');
							$(this).parent().find('> div,> input#forFileReturn').css('display','block');
						}
					});
					$('#frm_updMue<?php echo $iMue;?> input#forFileReturn').click(function(){
						$(this).css('display','none').parent().find('> :not(select)').css('display','none').parent().find('> select').css('display','block');
					});
					
					$('#frm_updMue<?php echo $iMue;?> textarea#testarea').val('<?php echo $muestra_descripcion; ?>');
					//
				}
	  
	  /*se encarga de validar el formulario y enviar los datos*/
	function validacion(valid,criterio,redireccion,evento){
		var test = 0;
		var itemsNo = '';
		for (var valor in criterio) {
					var elemento = $("#frm_updMue<?php echo $iMue;?> #"+valor+"").val();
					if( elemento ==criterio[valor]){
						itemsNo+= '<li>'+valor+'</li>';
						test++;
					}
				}
				var codigoAnt =$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").text();
				if(codigoAnt =="!Ya existe!"){
					itemsNo+='<li>Codigo_antiguo</li>';
					test++;
				}
				if(test >0){
					var al ="Esta es la lista de los campos requeridos que estan vacios o son incorrectos:<br><ul>"+ itemsNo +"</ul><br>Por favor ingrese la informaci&oacute;n necesaria";
					frm_addOpenDialogo("#frm_updMue<?php echo $iMue;?>", "Registro de datos","Datos incompletos",al,"","#codigo");
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
	
	function frm_updMue<?php echo $iMue;?>Envio(){
		
		$("#frm_updMue<?php echo $iMue;?> #enviar<?php echo $iMue;?>").click(function() {			
			var siguiente = $("#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?> #cargaArchivoBtn");
			var criterios={'cliente':'000','sucursal':null,'Codigo_antiguo':'!Ya existe!','tipo_de_muestra':'000'}; 
			validacion('#frm_updMue<?php echo $iMue;?>',criterios,siguiente,'click');
		});
		
		$("#frm_updMue<?php echo $iMue;?> #frm_updMue<?php echo $iMue;?>Enviar").click(function() {			
			var thisVal = $(this);			
		  	var frmEnv = $(this).val();
		  	var comprobar = $('#frm_updMue<?php echo $iMue;?> #sucursal option').size();
		  	
		  	var muId=<?php echo $muestra_id;?>;
			var ci=$('#frm_updMue<?php echo $iMue;?> #sucursal option:selected').attr('name');
			var sc=$('#frm_updMue<?php echo $iMue;?> #sucursal').val();
			var cod=$('#frm_updMue<?php echo $iMue;?> #codigo').val();
			var fec=$('#frm_updMue<?php echo $iMue;?> #fecha').val();
			var tm=$('#frm_updMue<?php echo $iMue;?> #tipo_de_muestra').val();
			var nf=$('#frm_updMue<?php echo $iMue;?> #numfac').val();
			var ref=$('#frm_updMue<?php echo $iMue;?> #referencia').val();
			var arId=$('#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?> input#id').val();
			var des=$('#frm_updMue<?php echo $iMue;?> #testarea').val();
			
			if(arId=="0" || arId==0 || arId==""){
				arId ='<?php echo $ar_id;?>';
			}
			if(tm=="000"){
				tm ='';
			}
			if(sc =="000" || sc =="null" || sc ==null || sc =="" || comprobar ==0){
				var al ="Algun campo requerido esta vacio!";
				frm_addOpenDialogo("#frm_updMue<?php echo $iMue;?>", "Registro de datos","Datos incompletos",al,"","#cliente");
			}else{
				var contID = '#frm_updMue<?php echo $iMue;?>';
				$.post("muestra/actualizar_muestra.php", {enviar<?php echo $iMue;?>:frmEnv, muestraId:muId, clienteId:ci, codigo:cod, fecha:fec, sucursal:sc, numfac:nf, tipoMuestra:tm, referencia:ref, archivoId:arId, descripcion:des}, function(output){
					if(output=="1" || output==1){
						
						enviandoPeticion(contID,'close');
						var aler = ("Se ha registrado correctamente la informacion.");
						frm_addOpenDialogo(contID, "Registro de datos","Datos actualizados",aler,"Continuar","#cliente");
						
						$("#frm_updMue<?php echo $iMue;?> #cancel<?php echo $iMue;?>").click();
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
	function frm_updMueResetCodigo(){
				$("#frm_updMue<?php echo $iMue;?> #cancel<?php echo $iMue;?>").click(function() {
					var reset = '<option id="selectFirst" value="" >Seleccione uno...</option>';
					
					$('#frm_updMue<?php echo $iMue;?> select#sucursal').html('');
					$("#frm_updMue<?php echo $iMue;?> #codigo").attr('disabled',true);
					$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").html('');					
					$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").val('');
					$('#frm_updMue<?php echo $iMue;?> #cargaArchivo #cargaArchivoContent #respuesta').removeClass('yesprint').addClass('noprint');
					$('#frm_updMue<?php echo $iMue;?> #cargaArchivo #cargaArchivoContent :file').removeClass('noprint');
					$('#frm_updMue<?php echo $iMue;?> #cargaArchivo #cargaArchivoContent :file').val('');
					$('#frm_updMue<?php echo $iMue;?> #testarea,.Modificar_Muestra textarea').val('');
					$('#frm_updMue<?php echo $iMue;?> select#cliente').focus();
				});
	}
		
		/*se encarga de validar el contenido del input #codigo para determinar que no este ya*/
	function frm_updMueEnvioCodigo(codigoAntig){
				$.post("muestra/procedimientos_muestra.php",{codigoAntiguo:codigoAntig}, function(data){
					var retur = data;
					if(retur==0){						
						$('#frm_updMue<?php echo $iMue;?> #Codigo_antiguo').html('!Ya existe!').css('color','red');
						$('#frm_updMue<?php echo $iMue;?> #Codigo_antiguo').attr('value','!Ya existe!');						
					}else if(retur==1){
						$('#frm_updMue<?php echo $iMue;?> #Codigo_antiguo').html('Ok').css('color','');
						$('#frm_updMue<?php echo $iMue;?> #Codigo_antiguo').attr('value','Ok');
					}
				});
	}
	
	function frm_updMueValidarCodigo(){
		$("#frm_updMue<?php echo $iMue;?> #codigo").keyup(function(){
			var codigoAntiguo = $(this).val();
				frm_updMueEnvioCodigo(codigoAntiguo);
		}).change(function(){
			var codigoAntiguo = $(this).val();
				frm_updMueEnvioCodigo(codigoAntiguo);
		});
	}
		
		/*se encarga de hacer el llamado para cargar el contenido del select de sucursal segun el cliente que se seleccione*/
	function frm_updMueLlamarSucursal(){
		$("#frm_updMue<?php echo $iMue;?> #cliente").change(function(){
			$("#frm_updMue<?php echo $iMue;?> #cliente option:selected").each(function(){
              		empresa=$(this).val();
				$.post("muestra/procedimientos_muestra.php",{empresa:empresa}, function(data){
					$("#frm_updMue<?php echo $iMue;?> #sucursal").html(data);
				}).always(function(){
					$("#frm_updMue<?php echo $iMue;?> #sucursal option").each(function(){						
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
	function frm_updMueHabilitarCodigo(){
		$("#frm_updMue<?php echo $iMue;?> #checkMue").change(function(){
					
					if((this.checked)==true){
						$("#frm_updMue<?php echo $iMue;?> #codigo").attr('disabled',false).val('').focus();
						$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").html('');
						$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").val('');						
					}
					if((this.checked)==false){
						$("#frm_updMue<?php echo $iMue;?> #codigo").attr('disabled',true).val('');
						$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").html('');
						$("#frm_updMue<?php echo $iMue;?> #Codigo_antiguo").val('');
						$("#frm_updMue<?php echo $iMue;?> input#fecha").focus();
					}
				
		});
	}
	
	/*sirve para validaciones y limitaciones de los elementos del formulario*/	
	function frm_updMueValidaciones(){
		$('#frm_updMue<?php echo $iMue;?> textarea[name="descripcion"]').keydown(function(){var numeroMaximo= 65530; var textareaVal= $(this).val(); if(textareaVal.length > numeroMaximo){return false; }});
		$('#frm_updMue<?php echo $iMue;?> select[name="cliente"]').focus().show();
		$('#frm_updMue<?php echo $iMue;?> input[name="fecha"]').keydown(function(){return false;});
		$('#frm_updMue<?php echo $iMue;?> input[type="file"]').change(function(){
			$('#frm_updMue<?php echo $iMue;?> #testarea').focus();
		});
	}
	
	/*sirve para leer el contenido para subir archivos*/
		
	function frm_updMue<?php echo $iMue;?>LeerCargaArchivo(){
		var inputsArchivo = '<input type="hidden" name="id" id="id" value=""><input type="hidden" name="fileName" id="fileName" value=""><input type="hidden" name="fileSize" id="fileSize" value=""><input type="hidden" name="fileType" id="fileType" value=""><input type="hidden" name="descripcionFile" id="descripcionFile" value="">';
		var identi = "#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?>";
		var conetedorId = "#frm_updMue<?php echo $iMue;?>";
		var direcc = "archivos/subir.php";
		$(identi).load(direcc, function(){//lee el contenido externo
			iniciacionCarga(identi,conetedorId);// llama a la funcion que inserta el contenido para subir archivos
			$(identi).append(inputsArchivo);										
		}).show();
	}
	
	/*las siguientes son lineas de codigo para maquetacion de los elementos del formulario (apariencia)*/	
	function frm_updMueMejorarAspecto(){
				$("#frm_updMue<?php echo $iMue;?> input[name='fecha']").datepicker();//asigna el calendario a este input
				$("#frm_updMue<?php echo $iMue;?> input[name='fecha']").datepicker('setDate', new Date());
				$("#frm_updMue<?php echo $iMue;?> .Modificar_Muestra tr td").css('white-space','nowrap');//evita que al texto se le produzca un salto de linea cuando necesita ajustarse
				$("#frm_updMue<?php echo $iMue;?> select").css({'width':'97%'});
				$("#frm_updMue<?php echo $iMue;?> table").css({'width':'90%'});
				$('#frm_updMue<?php echo $iMue;?> input[name="codigo"]').css({'float':'left','width':'65% !important','margin-right':'5px'});
				$('#frm_updMue<?php echo $iMue;?> #Codigo_antiguo').css('margin-top','5px');
				$('#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo').css({'border': '0px solid white','height': '30px', 'max-width': '240px','margin': '0px','padding': '0px','overflow': 'hidden'});
				$(".Modificar_Muestra form table:eq(1) tr td:nth-child(odd)").css({'width':'20%','padding-left':'10px'}).children(":not([type='checkbox'])").css({'width':'98%'}).parent().css({'height':'40px'});
				$(".Modificar_Muestra form table:eq(1) tr td:nth-child(even)").css({'width':'30%','padding-left':'10px'}).children(":not([id='codigo'])").css({'width':'98%'}).parent().css({'height':'40px'});
				$(".Modificar_Muestra form table:eq(3) tr ").css({'text-align':'center'});
				$('#frm_updMue<?php echo $iMue;?> input[type="reset"],#frm_updMue<?php echo $iMue;?> input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px','border-radius':'0px','width':'50%'}).parent().attr('colspan','2').parent().attr('align','center');
	}
	
  
</script>

<form id="frm_updMue<?php echo $iMue;?>" name="frm_updMue<?php echo $iMue;?>" method="post" height="100%">

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Modificar Muestra</h3>
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
			<?php
				
				$resultMue=seleccion_cliente();
				
				while($resultMues=mysql_fetch_array($resultMue)){
				
				?>
        
				<option value="<?php echo $resultMues['empresa_id'];?>" title="<?php echo $resultMues['empresa_razonsocial'];?>"><?php echo $resultMues['empresa_razonsocial'];?></option>
        
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
			<input type="checkbox" name="checkMue" id="checkMue">
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
        		<?php
        
					$resultMue=seleccion_tipomuestra();
					
					while($resultMues=mysql_fetch_array($resultMue)){
						
				?>
        
				<option value="<?php echo $resultMues['tipom_id']?>"><?php echo $resultMues['tipo_muestra']?></option>
            
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
			
			<div name="frm_updMueArchivo<?php echo $iMue;?>" id="frm_updMueArchivo<?php echo $iMue;?>">
				
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
			<input type="reset" id="cancel<?php echo $iMue;?>" name="cancel" value="Cancelar" />
		</td>
		<td>
			<input type="hidden" id="frm_updMue<?php echo $iMue;?>Enviar" name="frm_updMue<?php echo $iMue;?>Enviar" value="Guardar" />
			<input type="button" id="enviar<?php echo $iMue;?>" name="enviar<?php echo $iMue;?>" value="Guardar" />
		</td>
	</tr>
</table>

</form>

<br><br>

<?php 

}

?>