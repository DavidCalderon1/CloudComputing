
<html>
	<head>
		<title>subir archivo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="../js/jquery-1.9.0.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.js"></script>
    	
    	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		
		<!--style type="text/css">
		
		.box {
		    font-family: Arial, Helvetica, sans-serif;
		    font-size: 12px;
		    border: 1px solid #000000;
		}
		
		</style-->
	</head>

	<body>
		<?php
			if(isset($_POST['upload'])) {
				
				echo "
				
				<script type='text/javascript'> 
					$(document).ready(function(){			  
							$('body').css({'margin':'0px', 'margin-top': '9px', 'font': '13px Arial, Helvetica, sans-serif','overflow':'hidden'});
					});
				</script>
				
				";
			
			require_once("guardar.php");
					
						subirArchivo();
			
			
			}else{
		?>
				
		<script type="text/javascript">
 
			$(document).ready(function(){
			  
					var uf= '';
					$('#uploadform input:not(#userfile), #textArea').css('display','none');
					$('#uploadform').css('margin','0px');
					$('body').css({'margin':'0px', 'font': '13px Arial, Helvetica, sans-serif','overflow':'hidden'});
					
					/*
					$("#otro").click(function(){
					
					$.get('crear.php?id=3',function(data){
					
					$('#resultado').html(data);
					setTimeout(function(){
					$('#resultado').append('<div width="800px" height="1000px" ><embed width="100%" height="100%" name="plugin" src="'+data+'" type="application/pdf"></div>');
					},5000);
					});					
					});
					*/
					
					
					$('#uploadform #userfile').change(function(){
						
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
					
					$("#upload").click(function(){
					var uf=$('#uploadform #userfile').val();

					if(uf!="")
					{
						$('#uploadform #userfile').css('border','0px dotted red');
					}
					else
					{
						var alertFile = " Agrégue un archivo!";
						$('#uploadform #userfile').css('border','1px dotted red');
						return false;
					}
					});

				
			});
		  
		</script>
		
		<form 
				action="subir.php" 
				method="post" 
				enctype="multipart/form-data" 
				id="uploadform"
				name="uploadform">
			<table 	width="auto" 
					border="0" 
					cellpadding="1" 
					cellspacing="1" 
					class="box">
					
						<tr id="textArea">
							<td width="auto">
								Descripcion	<br>
								<textarea name="descripcion" id="descripcion" rows="10" cols="40"></textarea>
							</td>
						
						</tr>
						
					    <tr> 
							
						    <td width="auto">
								
							
							<?php /*SHOW VARIABLES LIKE  'max_allowed_packet'*/ ?>
								<input 	type=	"hidden"
										id=	"tamanoMaximo"
										name=	"tamanoMaximo" 
										value=	"1048576">

								<input 	type=	"hidden"
										name=	"MAX_FILE_SIZE" 
										value=	"20000000">
								
								<input 	name=	"userfile"
										id=	"userfile"
										type=	"file" 
										class=	"box" 
										id=		"userfile"> <br>
								<input 	name=	"upload" 
										id=	"upload"
										type=	"submit" 
										class=	"box" 
										id=		"upload" 
										value=	"  Enviar  ">
								
										
						    </td>
					    </tr>
						
			</table>
		</form>
		<!--input 	name=	"otro" 
										id=	"otro"
										type=	"button" 
										class=	"box" 
										id=		"upload" 
										value=	"  otro "-->
		<div id="resultado"></div>
<?php
}
?>
	</body>
</html>
