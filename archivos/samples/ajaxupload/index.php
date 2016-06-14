
<div id="cargaArchivo">	
		
	<script language="javascript" type="text/javascript" id="principal">
	<!--
	
	$(document).ready(function(){
		//paraMostrar();
		var findParent = '';
		function iniciacionCarga(ide){
			var findParent = ide;       
	   
				$(''+findParent+' #cargaArchivo #cargaArchivoContent #userfile').change(function(){
							
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
										window.top.window.frm_addOpenDialogo("seleccionar archivo","Archivo incorrecto",alerta,"Seleccionar uno nuevo");									
										//alert(alerta);									
									}
								},2000);
							//$("#uploadform #upload").click();						
						});
		
		
			$(""+findParent+" #cargaArchivoBtn").click( function () {
		         alert('lo cogio');         
		                 
		            var fd = new FormData();
		
		            fd.append( "tamanoMaximo", $(""+findParent+" #tamanoMaximo").val());
		            fd.append( "MAX_FILE_SIZE", $(""+findParent+" #MAX_FILE_SIZE").val());
		            fd.append( "userfile", $(""+findParent+" #userfile")[0].files[0]);            
		            fd.append( "oculto", $(""+findParent+" #oculto").val());
		            fd.append( "descripcion", $(""+findParent+" #descripcion").val());
		            
		            $.ajax({
		                url: '../../guardar.php',
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
		                },
		                error: function () {                	
		                	despuesDeEnviar(findParent,'error');
		                    alert("ERROR en la carga");
		                }
		            });
		    });
	    }
	});
	
	function paraMostrar(){
		var uf= '';
		$('#cargaArchivo #cargaArchivoContent input:not(#userfile), #textArea, #output').css('display','none');
		$('#cargaArchivo').css({'margin':'0px', 'font': '13px Arial, Helvetica, sans-serif','overflow':'hidden'});	
	}
	
	function despuesDeEnviar(ident, valor){
		var mostrar = '';
		var ocultar = '';
		switch(valor){
			case('cargando'):
				mostrar = '#output';
				ocultar = '#userfile';
				break;
			case('error'):		
				mostrar = '#userfile';
				ocultar = '#output';
				$(''+ident+' #cargaArchivo #cargaArchivoContent '+mostrar+'').val('');
				break;
		}
		$(''+ident+' #cargaArchivo #cargaArchivoContent '+mostrar+'').css('display','block');
		$(''+ident+' #cargaArchivo #cargaArchivoContent '+ocultar+'').css('display','none');
	}
	
	//-->
	</script>   

            <div id="cargaArchivoContent">
            	<table 	width="auto" 
					border="0" 
					cellpadding="1" 
					cellspacing="1" 
					>												
					    <tr>							
						    <td width="auto">							
								<?php /*SHOW VARIABLES LIKE  'max_allowed_packet'*/ ?>
								<input 	type=	"hidden"
										id=	"tamanoMaximo"
										name=	"tamanoMaximo" 
										value=	"1048576">
								<input 	type=	"hidden"
										id=	"oculto"
										name=	"oculto" 
										value="valordeoculto" >
								<input 	type=	"hidden"
										id=	"MAX_FILE_SIZE"
										name=	"MAX_FILE_SIZE" 
										value=	"20000000">
								<div id="output">nada!</div>
								<div id="respuesta">sin respuesta!</div>
								<input 	name=	"userfile"
										id=	"userfile"
										type=	"file" 
										class=	"box" 
										id=		"userfile"> <br>
								<input 	name=	"cargaArchivoBtn" 
										id=	"cargaArchivoBtn"
										type=	"button" 
										class=	"cargaArchivoBtn"  
										value=	"  Enviar  ">																
						    </td>
					    </tr>
					    <tr id="textArea">
							<td width="auto">
								Descripcion	<br>
								<textarea name="descripcion" id="descripcion" rows="10" cols="40"></textarea>
							</td>						
						</tr>						
				</table>                         
            </div>       
                 
</div>   