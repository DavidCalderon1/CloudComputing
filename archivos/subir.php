
<div id="cargaArchivo">	
		
	<script language="javascript" type="text/javascript" id="principal">
	<!--
	
	$(document).ready(function(){
		paraMostrar('');		
	});
	
	var findParent = '';
		function iniciacionCarga(ide,contenID){
			var findParent = ide;       
	   		$(""+findParent+" #oculto").val(findParent);
				$(''+findParent+' #cargaArchivo #cargaArchivoContent #archivo').change(function(){
							
								$(this).css('border','0px dotted red');
								var thisName=this.files[0].name.length;
								var thisSize=this.files[0].size;
								var thisType=this.files[0].type;
								var longitudArch = 100;
								var tamano = 1048576;
								var alerta ='';
								if(thisName > longitudArch){
									alerta+=' El nombre del archivo es muy largo, reduzcalo a '+longitudArch+' caracteres ';
								}
								if(thisType == "image/png" || thisType == "image/jpeg" || thisType == "image/gif" || thisType == "application/pdf"){
									
								}else{
									alerta+=' El tipo de archivo no es permitido, se aceptan imagenes png, jpg, jpeg, gif o PDF ';
								}
								if(thisSize > tamano){
									alerta+=' El peso del archivo es mayor al permitido, reduzca el peso a '+tamano+'Bytes o intente subir uno mas liviano';
								}
								setTimeout(function(){
									if(alerta!=''){									
										window.top.window.frm_addOpenDialogo(findParent, "seleccionar archivo","Archivo incorrecto",alerta,"",":file");									
										//alert(alerta);									
									}
								},2000);
							//$("#uploadform #upload").click();						
						});
		
		
			$(""+findParent+" #cargaArchivoBtn").click( function () {         
		            
		            enviandoPeticion(contenID,'open');
		                 
		            var fd = new FormData();
		
		            fd.append( "tamanoMaximo", $(""+findParent+" #tamanoMaximo").val());
		            fd.append( "MAX_FILE_SIZE", $(""+findParent+" #MAX_FILE_SIZE").val());
		            fd.append( "archivo", $(""+findParent+" #archivo")[0].files[0]);            
		            fd.append( "oculto", $(""+findParent+" #oculto").val());
		            fd.append( "descripcion", $(""+findParent+" #descripcion").val());
		            
		            $.ajax({
		                url: 'archivos/guardar.php',
		                type: 'POST',
		                cache: false,
		                data: fd,
		                processData: false,
		                contentType: false,
		                beforeSend: function () {
		                	despuesDeEnviar(findParent,'cargando');
		                    $(""+findParent+" #output").html("Cargando, por favor espere..");
		                },
		                success: function (data) {
		                    $(""+findParent+" #output").html("Carga exitosa.");
		                	$(""+findParent+" #respuesta").html(data); 
		                },
		                complete: function () {
		                    $(""+findParent+" #output").html("Carga completa.");
		                    $(""+contenID+" "+contenID+"Enviar").click();
		                    setTimeout(function(){despuesDeEnviar(findParent,'completo');},1000);
		                },
		                error: function () {                	
		                	despuesDeEnviar(findParent,'error');
		                    var alerta = "ERROR en la carga del archivo";
		                	frm_addOpenDialogo(findParent, "seleccionar archivo","Archivo incorrecto",alerta,"",":file");
		                }
		            });
		    });
	    }
	
	function paraMostrar(findParentAct){
		var uf= '';
		$(''+findParentAct+' #cargaArchivo input:not(#archivo), '+findParentAct+' #cargaArchivo #textArea, '+findParentAct+' #cargaArchivo #output, '+findParentAct+' #cargaArchivo #respuesta').css('display','none');
		$(''+findParentAct+' #cargaArchivo #output, '+findParentAct+' #cargaArchivo #respuesta').css({'top': '7px','position': 'relative'});
		$(''+findParentAct+' #cargaArchivo').css({'margin':'0px', 'font': '13px Arial, Helvetica, sans-serif','overflow':'hidden'});	
	}
	
	function despuesDeEnviar(ident, valor){
		var mostrar = '';
		var ocultar = '';
		switch(valor){
			case('cargando'):
				mostrar = '#output';
				ocultar = '#archivo';
				break;
			case('error'):		
				mostrar = '#archivo';
				ocultar = '#output';
				$(''+ident+' #cargaArchivo #cargaArchivoContent '+mostrar+'').val('');
				break;
			case('completo'):		
				mostrar = '#respuesta';
				ocultar = '#output';				
				break;
		}
		$(''+ident+' #cargaArchivo #cargaArchivoContent '+mostrar+'').removeClass('noprint').addClass('yesprint');
		$(''+ident+' #cargaArchivo #cargaArchivoContent '+ocultar+'').removeClass('yesprint').addClass('noprint');
	}
	
	//-->
	</script>   

            <div id="cargaArchivoContent">
            	<div width="auto">							
					<input type="hidden" id="tamanoMaximo" name="tamanoMaximo" value="1048576">
					<input type="hidden" id="oculto" name="oculto" value="valordeoculto">
					<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="20000000">
					<div id="output">
									
					</div>
					<div id="respuesta">
						sin respuesta!
					</div>
					<input name="archivo" id="archivo" type="file" style="width: 98%"> <br>
					<input name="cargaArchivoBtn" id="cargaArchivoBtn" type="button" class="cargaArchivoBtn" value="  Enviar  ">																
				</div>
				<div id="textArea">
					<div width="auto">
						Descripcion	<br>
						<textarea name="descripcion" id="descripcion" rows="10" cols="40"></textarea>
					</div>						
				</div>                         
            </div>       
                 
</div>   