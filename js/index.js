
					//se comienza con las funciones de: cargar el contenido de las opciones del menu en la columna blanca con el  div id="space"
						function forInicio(){
							var forInicio = $('<div id="contenedor"></div>').addClass('inicio').attr('name','inicio');
							$("#space").prepend(forInicio);
							$("#space .inicio").load("inicio.php").show();//lee de forma predeterminada el archivo inicio.php
						}						
						
						function imgPrint(){// esta funcion es la que inserta la imagen de la derecha del div#space la cual se encarga de recargar el contenido 
							$("#space #printPage").remove();
							var imgPrint = $('<div id="printPage" title="Imprimir" >&nbsp;</div>');//<a href="" id="printPage" title="Imprimir" target="iframeP">&nbsp;</a>
							$("#space").prepend(imgPrint);
							imprimirPestana();							
						}						
						
						function imgRecarga(){// esta funcion es la que inserta la imagen de la derecha del div#space la cual se encarga de recargar el contenido 
							$("#space #imgRecarga").remove();
							var imgRecarga = $('<div title="Recargar" id="imgRecarga"></div>');
							$("#space").prepend(imgRecarga);
							recargarPestana();							
						}
						
						function imprimirPestana(){
							$("#space #printPage").click(function(){
								var pestActual =$("#pestana #pestHead.pestActiva");
								var pestActualName =pestActual.attr('name');
								var pestActualTitle =pestActual.find('#pestText').text();
								var contActual = $('<h2>CloudSystem: '+pestActualTitle+'</h2>');
								$('body > div').addClass('noprint');
								$('body').prepend(contActual);
								$('body').append($("#space #contenedor."+pestActualName+""));
								window.print();
								$("#space").append($('body > #contenedor'));
								$('body > h2').remove();
								$('body > div').removeClass('noprint');
								contActual ='';
							});
						};
						
						function recargarPestana(){
							$("#space #imgRecarga").click(function(){
								var pestActual =$("#pestana #pestHead.pestActiva").attr('name');
								var contPestActual = $("#space #contenedor."+pestActual+"");
								var urlContPestActual = contPestActual.find('input[name="'+pestActual+'URL"]').val();
								if(urlContPestActual !=undefined || urlContPestActual !='undefined'){
									$('#temporal').html('');
									esperaDiv();
									leerContenido(urlContPestActual,pestActual);
								}
							});
						};
						
						function guardarURL(direccion,aId){
							var Nueva = $('#space').children('.'+ aId +'');
							var buscarNueva = Nueva.size();
							var contURL = $('<input type="hidden" id="'+aId+'URL" name="'+aId+'URL">');
							if(buscarNueva >0){
								Nueva.append(contURL.val(direccion));
							}
						};
						
						function validarPestanas(aId){
							var buscarIguales = $('#space').children('.'+ aId +'').size();
							if(buscarIguales > 0){
								beforeClose(aId);
							}else{
								mostrarSeleccion(aId);//esta funcion se encarga de que todo lo relacionado con el link seleccion se visualice								
							}
						}
						
						function validarPestExternas(aId,direccion){
							var buscarIguales = $('#space').children('.'+ aId +'').size();
							if(buscarIguales > 0){
								mostrarContenedor(aId);
								cambioPestanaName(aId);
								yaEstaAbierta(aId);
							}else{
								insPestana(aId);//llama a la funcion que inserta una nueva pestana
								leerContenido(direccion,aId);
							}
						}
						
						function mostrarSeleccion(aId){								
								insPestana(aId);//llama a la funcion que inserta una nueva pestana
								cargaContenido(aId);//llama a la funcion que carga el contenido esterno
						}
						
						function mostrarNavegacion(){
							var contenidoTemporal = $('#temporal').contents().clone();
							var textoTemp = $('#temporal .divNav').text();
							if(textoTemp == ""){
							}else{
							$('#navegacion').html(contenidoTemporal);
							textoPestana();
							}
						}
						
						function mostrarNavegAdicional(linkAdic){
							var test =linkAdic.indexOf('_');
							if(test>0){								
								linkAdic =linkAdic.replace('_',' ');
							}
							$('#temporal').html('');							
							var idParent = $('.pestActiva #forNavegacion').contents().clone();
							$('#temporal').prepend(idParent);
							$('#temporal').append('<div class="divNav"><img class="nav_flech" src="img/nav_flech.png"><a href="#">'+linkAdic+'</a></div>');
						}
						
						function cargaContenido(aId){//la funcion que carga el contenido de las otras paginas								
							esperaDiv();//funcion que se encarga de colocar la imagen de espera, mientras carga el contenido
							var direccion = '';
							switch(aId){//a partir del id recibido se halla la direccion del documento que se cargara en el div#space
								case('inicio'):
										direccion = 'inicio.php';//lee el archivo inicio.php al darle click en la opcion Inicio
									break;
								case('agregar_cliente'):
										direccion = 'cliente/agregar_cliente.php';//lee el archivo agregar_cliente.php al darle click en la opcion Nuevo Registro dentro de la opcion Cliente
									break;
								case('buscar_cliente'):
										direccion = 'cliente/busqueda_cliente.php';//lee el archivo busqueda_cliente.php al darle click en la opcion Busqueda dentro de la opcion Cliente
									break;
								case('agregar_proveedor'):
										direccion = 'proveedor/agregar_proveedor.php';//lee el archivo agregar_proveedor.php al darle click en la opcion Nuevo Registro dentro de la opcion proveedor
									break;
								case('buscar_proveedor'):
										direccion = 'proveedor/busqueda_proveedor.php';//lee el archivo busqueda_proveedor.php al darle click en la opcion Busqueda dentro de la opcion proveedor
									break;
								case('agregar_usuario'):
										direccion = 'usuario/agregar_usuario.php';//lee el archivo agregar_usuario.php al darle click en la opcion Nuevo Registro dentro de la opcion usuario
									break;
								case('buscar_usuario'):
										direccion = 'usuario/busqueda_usuario.php';//lee el archivo busqueda_usuario.php al darle click en la opcion Busqueda dentro de la opcion usuario
									break;
								case('agregar_producto'):
										direccion = 'producto/agregar_producto.php';//lee el archivo agregar_producto.php al darle click en la opcion Nuevo Registro dentro de la opcion producto
									break;
								case('buscar_producto'):
										direccion = 'producto/busqueda_producto.php';//lee el archivo busqueda_producto.php al darle click en la opcion Busqueda dentro de la opcion producto
									break;
								case('agregar_pedido'):
										direccion = 'pedido/agregar_pedido.php';//lee el archivo agregar_pedido.php al darle click en la opcion Nuevo Registro dentro de la opcion pedido
									break;
								case('buscar_pedido'):
										direccion = 'pedido/busqueda_pedido.php';//lee el archivo busqueda_pedido.php al darle click en la opcion Busqueda dentro de la opcion pedido
									break;
									/*---------------------------------------*/
								case('agregar_muestra'):
										direccion = 'muestra/agregar_muestra.php';//lee el archivo agregar_muestra.php al darle click en la opcion Nuevo Registro dentro de la opcion Muestra
									break;
								case('buscar_muestra'):
										direccion = 'muestra/busqueda_muestra.php';//lee el archivo busqueda_muestra.php al darle click en la opcion Busqueda dentro de la opcion Muestra
									break;
								case('agregar_colaborador'):
										direccion = 'colaborador/agregar_colaborador.php';//lee el archivo agregar_muestra.php al darle click en la opcion Nuevo Registro dentro de la opcion Colaborador
									break;
								case('buscar_colaborador'):
										direccion = 'colaborador/busqueda_colaborador.php';//lee el archivo busqueda_colaborador.php al darle click en la opcion Busqueda dentro de la opcion Colaborador
									break;
								case('vacio'):
										direccion = 'construccion.php';//lee el archivo construccion.php al darle click en la opcion Ver perfil dentro de la opcion Perfil, este es el camino para las secciones incompletas		
									break;										
							}
							if(direccion != ''){
								leerContenido(direccion,aId);
							}else{
								quitarPestana();
								quitarEspera();// quita el front de espera
							}
						}

						function leerContenido(direccion,aId){
							var buscar = $("#space ."+ aId +"").size();
							if(buscar > 0){
								$("#space ."+ aId +"").load(direccion, function(){//lee el contenido externo
										imgRecarga();// llama a la funcion que inserta la imagen de la derecha del div#space la cual se encarga de recargar el contenido 									
										imgPrint();// llama a la funcion que inserta la imagen de la derecha del div#space la cual se encarga de recargar el contenido
										mostrarContenedor(aId);// muestra en contenedor correspondiente con el contenido que se ha cargado									
										mostrarContNaveg(aId);
										quitarEspera();// quita el front de espera									
										mostrarNavegacion();
										runCheckButton('.'+aId+'');
										guardarURL(direccion,aId);
								}).show();
							}else{
								mostrarNavegAdicional(aId);
								validarPestExternas(aId,direccion);
							}
						}
						
						function quitarEspera(){// quita el front de espera
							$('#space').parent('td').find('#espera').remove();
						}
						
						function reloadPest(idPes,urlPes){
							esperaDiv();
							leerContenido(urlPes,idPes);
							cambioPestanaName(idPes);							
						}
					//se finaliza con las funciones de: carga el contenido de las opciones del menu en la columna blanca con el  div id="space"
					
					//se comienza con las funciones de: creacion de la seccion de navegacion
						function esperaDiv(){//se encarga de colocar en frente una division con una imagen de 'loading' mientras el nuevo contenido se carga
							var imgEspera = $('<img src="img/ajax-loader.gif">');
							var divEspera = $('<div id="espera"></div>').css({'width':$("#space").width(),'height':$("#space").height()}).prepend(imgEspera);
							$("#space").parent('td').find("#espera").remove();//se asegura de remover alguna division que tenga el mismo id
							$("#space").parent('td').find('#pestana').after(divEspera);// inserta la division 
						}
							
						function clickNavegacion(){//esta funcion se ejecuta luego de llamar un contenido con el menu de la izquierda, se encarga de validar a que link de la parte de navegacion se le dio click
							$('#navegacion a').click(function(){// esta para que funcione cualquier link de la navegacion
									var thisParent = $(this).parent('div').index();
									$('#navegacion div:gt('+ thisParent +')').remove();//esto funcionara en el caso de que un link intermedio en la linea de navegacion cargue algun documento y esto se encargara de quitar las opciones que esten al lado derecho y dejar el link de primero en sentido de derecha a izquierda
									var aNavId = $(this).attr('id');//recoje el id del link
									
									clickLink(aNavId);//llama a la funcion que carga el contenido externo								
							});
						}
						
						function histotial(){//se encarga de crear un historial de 'navegacion' independiente de las pesta�as
							
						}
						
						function ocultarPestana(){
							$("#pestana").css('display','none');	
							$("#pestana").html('');
							$("#space > #imgRecarga, #space > #printPage").remove();
						}
						
						function quitarContenidos(contName){
							$("#space #contenedor:not([name='"+ contName +"'])").remove();	
							$("#pestana").html('');	
						}
						
						function contNavDefault(){
							$('#navegacion').html('<img class="nav_flech" src="img/nav_flech.png">Inicio');//coloca por default este texto en el div#navegacion
							$("#space .inicio").removeAttr('style');
							$("#space .inicio").css('display','block');
						}
						
						function verificarAccion(item){	
							if($('#pestana #pestHead').size()>0){
								var ifExist = $('body').find('#conteDialog').size();
								var titulo ='Cerrar las pesta&ntilde;as';
								var nombre ='Esta a punto de cerrar todos los formularios';
								var contenido ='Todos los datos que no se hallan guardado se perderan. <br><br> ¿esta seguro que quiere cerrar todas las pestañas y volver a '+item+'?';
								
								if(ifExist >= 1){
									var dialogo = '<div id="dialog-form" title="'+titulo+'"><p> '+nombre+': </p><fieldset>'+contenido+'</fieldset></div>';
									$('body').find('#conteDialog').prepend(dialogo);
								}else{
									var dialogo = '<div id="conteDialog" ><div id="dialog-form" title="'+titulo+'"><p> '+nombre+': </p><fieldset>'+contenido+'</fieldset></div></div>';
									$('body').prepend(dialogo);
								}
								$( "#dialog-form" ).dialog({
							      autoOpen: true,
							      height: 250,
							      width: 350,
							      modal: true,
							      buttons: {
							        "Si": function() {	
							        	contNavDefault();		        	
										ocultarPestana();							
										quitarContenidos(item);
							            $( this ).dialog( "close" );						         
							        },
							        'No': function() {						        	
							          $( this ).dialog( "close" );
							        }
							      },
							      close: function() {
							       	setTimeout(function(){
							       		$('body #conteDialog, body #dialog-form, body .ui-dialog').each(function(){
							       			$(this).remove();
							       		}); 
							       	},1000);
							      }
								});
							}else{
								contNavDefault();
								ocultarPestana();							
								quitarContenidos(item);
							}							
						}
						
						function navDefault(){								
							verificarAccion('inicio');						
						}
						
						function clickLink(aId){								
							validarPestanas(aId);
						}
						
						function menuClick(){
							$('.topnav a').click(function(){//se encarga de validar y enviar los parametros a la funcion que carga los contenidos externos							
								$('#temporal').html('');//vacia el contenido del div#navegacion
								var aId = $(this).attr('id');//recoje el id del link 							
								histotial();//aun no esta construida
								clickLink(aId);//envia los parametros a la funcion que carga los contenidos externos						
							});
							
							
							$('.topnav li').click(function(){//							
								var aTextoClon = $(this).find('a:first').clone();//clona los links de la secuencia de navegacion
								clickLi(aTextoClon);
							});
						}
						
						function clickLi(aTextoClon){
							var nav_flecha = $('<img class="nav_flech" src="img/nav_flech.png">');//division con la imagen de flecha							
                            var divNav = $('<div class="divNav"></div>').prepend(nav_flecha, aTextoClon);//coloca el contenido de las variables dentro del div
							$('#temporal').prepend(divNav);//los inserta al comienzo del div#navegacion
							$('#temporal a').find('span').remove();//quita el <span> que puedan tener: '[-],[+]'
							clickNavegacion();//llama a la funcion para que se pueda llamar documentos a partir de los links del div#navegacion
						}
						
					//se finaliza con las funciones de: creacion de la seccion de navegacion
						
					//se inicia con las funciones de: creacion de la seccion de pesta�as
												
						function insPestana(aId){//se encarga de crear una estructura para las pesta�as e insertarla encima del div#space
							var newPestana = $('<div id="pestHead" class="pestActiva"><div id="pestText"></div><div id="pestClose"></div></div>').attr('name',aId);//estructura base de la pesta�a
							var newContenedor = $('<div id="contenedor"></div>').addClass(aId).attr('name',aId);//estructura base del contenedor
														
							$('#pestana #pestHead').removeClass('pestActiva').addClass('pestInactiva');//coloca a todas las pesta�a como 'inactivas'
							$('#pestana').append(newPestana);//inserta de ultima posicion la nueva pesta�a														
							$('#space').prepend(newContenedor);//inserta de primera posicion el nuevo contenedor																					
							$('#pestana').css('display','block');//en el caso de ser la primera pesta�a tiene que colocar el contenedor de pesta�as visible, ya que por defecto no lo esta
							
							$('#pestana #pestHead').click(function(){//se encarga de colocar 'activa' o 'inactivas' las pesta�as 								
								$('#pestana #pestHead').removeClass('pestActiva').addClass('pestInactiva');//coloca a todas las pesta�a como 'inactivas'
								$(this).removeClass('pestInactiva').addClass('pestActiva');//coloca la pesta�a seleccionada como 'activa'								
								var nameActiva = $(this).attr('name');
								mostrarContenedor(nameActiva);
								mostrarContNaveg(nameActiva);
							});
							
							$('#pestana #pestClose').click(function(){//al darle click en la 'X' la pesta�a se cierra											
								
								$(this).parent().hide(500,function(){
									$(this).remove();									
									beforeClose('');
								});
								var pestName = $(this).parent().attr('name');
								cerrarPestana(pestName);
								//arreglar el problema de los scripts (muchas versiones), este evento no funciona correctamente
								//$(this).parent('#pestHead').hide('slide',500,function(){$(this).remove();});
							});
						}
						
						function textoPestana(){
							var lastLink = $('#navegacion .divNav a:last').text();//toma el texto del ultimo link de la linea de navegacion
							var nombreActiva = $('#pestana #pestHead.pestActiva').attr('name');
							$('#pestana #pestHead.pestActiva #pestText').text(lastLink).parent().attr('title',lastLink);//el texto que tomo lo coloca dentro de la pesta�a
							contenidoNavegacion(nombreActiva);
						}
						
						function mostrarContenedor(nameActiva){													
							$('#space > #contenedor').css('display','none');
							$('#space > .'+ nameActiva).css('display','block');
						}
						
						function mostrarContNaveg(nameActiv){													
							var forNavClon = $('#forNavegacion.'+ nameActiv).contents().clone();
							$('#navegacion').html(forNavClon);
						}
						
						function contenidoNavegacion(nombreActiva){
							var forNavegacion = $('<div id="forNavegacion"></div>').addClass(nombreActiva);							
							var clonNavegacion = $('#navegacion').contents().clone();
							$('#pestana #pestHead.pestActiva').append(forNavegacion);							
							$('#pestana #pestHead.pestActiva #forNavegacion').html(clonNavegacion);							
						}
						
						function quitarPestana(){
							$('#pestana .pestActiva').remove();							
							
							var sizePestana = $('#pestana').children('#pestHead').size();
							if(sizePestana == 0){
								$('#pestana').removeAttr('style');
							}
							
							$('#space #contenedor').each(function(){
								var thisName = $(this).contents().size();
								if(thisName == '0' || thisName == 0){									
									$(this).remove();
								}
							});
						}
						
						function ponerInactiva(){
							$('#pestana #pestHead').removeClass('pestActiva').addClass('pestInactiva');//coloca a todas las pesta�a como 'inactivas'
						}
						
						function cambioPestana(pestIndex){//se encarga de colocar 'activa' o 'inactivas' las pesta�as
							ponerInactiva();
							$('#pestHead:eq('+ pestIndex +')').removeClass('pestInactiva').addClass('pestActiva');//coloca la pesta�a seleccionada como 'activa'
						}
						
						function yaEstaAbierta(pestName) {
					      var Pes = $('#pestHead[name="'+ pestName +'"]');
     				      Pes.effect('pulsate',300);					     
					    }
						
						function cambioPestanaName(pestName){//se encarga de colocar 'activa' o 'inactivas' las pesta�as							
							$('#pestana #pestHead').removeClass('pestActiva').addClass('pestInactiva');//coloca a todas las pesta�a como 'inactivas'
							$('#pestHead[name="'+ pestName +'"]').removeClass('pestInactiva').addClass('pestActiva');//coloca la pesta�a seleccionada como 'activa'
							yaEstaAbierta(pestName);
						}
												
						function cerrarPestana(pestName){//se encarga de que la pesta�a se cierre
							$('#space > div.'+ pestName +'').remove();
						}
						
						function beforeClose(Pest){
									var pesta;
									var paraMostrar = $('#pestana #pestHead[name="'+ Pest +'"]').size();
									var paraMostrarCont = $('#space #contenedor[name="'+ Pest +'"]').size();
									if(Pest != ''){
										pesta = Pest;										
									}else{
										pesta = $('#pestana #pestHead:first').attr('name');
									}									
									if(paraMostrar == 0){
										pesta = $('#pestana #pestHead:first').attr('name');
									}		
									
											mostrarContenedor(pesta);
											mostrarContNaveg(pesta);
											cambioPestanaName(pesta);
										var cantPest = $('#pestana #pestHead').size(); 								
										if(cantPest == 0){									
											navDefault();
											//setTimeout(navDefault,500);
										}
						}

						function pestanaSortable(){//se encarga de colocar 'ordenables' las pesta�as
							$('#pestana').sortable({ 
										forcePlaceholderSize: true, //axis: "x",
										distance: 20,
										forceHelperSize: true,
										forcePlaceholderSize: true,
										helper: 'clone',
										items: 'div#pestHead'
										}).disableSelection();
							
						}
						

					//se finaliza con las funciones de: creacion de la seccion de pesta�as
						
						
						
					//se inicia con las funciones de: creacion de los estilos (css) adicionales
					
						function alineaVertical(){//se encarga de que el contenido se alinie arriba
							$('#space').parent('td').css({'vertical-align':'top'});
						}
					
						
					//se finaliza con las funciones de: creacion de los estilos (css) adicionales
										
					//se inicia con las funciones de: creacion de los estilos para los botones chek y radio
						function labelCheck(t){
							$(''+t+' label#forCheck').keyup(function() {
								var inputTipo =	$(this).parent().find('input').attr('type');
								if(inputTipo =='checkbox'){
									if($(this).parent().attr('class')=='labelNoChecked'){
										$(this).parent().switchClass('labelNoChecked','labelChecked');
									}else{
										$(this).parent().switchClass('labelChecked','labelNoChecked');
									}
								}else{
								  $(this).parent().parent().find('> div > label#forCheck').parent().switchClass('labelChecked','labelNoChecked');
								  $(this).parent().switchClass('labelNoChecked','labelChecked');									
								}							  		
							}).click(function() {		  	  
								var inputTipo =	$(this).parent().find('input').attr('type');
								if(inputTipo =='checkbox'){
									if($(this).parent().attr('class')=='labelNoChecked'){
										$(this).parent().switchClass('labelNoChecked','labelChecked');
									}else{
										$(this).parent().switchClass('labelChecked','labelNoChecked');
									}
								}else{
								  $(this).parent().parent().find('> div > label#forCheck').parent().switchClass('labelChecked','labelNoChecked');
								  $(this).parent().switchClass('labelNoChecked','labelChecked');									
								}
							});
						};
																	
						function runCheckButton(t){
							$('#checkButtom, #radioButtom').each(function(){
								$(this).css('white-space','nowrap');
								var idCheck = $(this).find('> input').attr('id');
								if($(this).children('label').size() >0){									
								}else{
									var labelCheck = $('<label id="forCheck"><span class="ui-button-text">&nbsp;</span></label>').attr('for',idCheck);
									$(this).prepend(labelCheck);
									if($(this).find('> input').attr('checked') =='checked' || ($(this).children().checked)==true){
										$(this).attr('class','labelChecked');
									}else{
										$(this).attr('class','labelNoChecked');
									}									
								}
							});
							labelCheck(t);							
						}
					
					//se finaliza con las funciones de: creacion de los estilos para los botones chek y radio
					
										
				//se inicia con las funciones de: creacion de la validacion del contenido de los formularios
					
					
					function recorridoDinamico(miParent){							
							var tdSize =$('#'+miParent+' table#inputs tr td').size();
							var rec;
							for(rec=1;rec<=tdSize;rec=rec+2){
							var testInputs =$('#'+miParent+' table#inputs tr td:eq('+rec+')').html();
								var thisInputs =$('#'+miParent+' table#inputs tr td:eq('+rec+')');
								if(thisInputs.find('> input')){
									thisInputs.find('> input').attr('inputs',rec);
								}
								if(thisInputs.find('> select')){
									thisInputs.find('> select').attr('inputs',rec);
								}
								if(thisInputs.find('input[type="file"]')){
									thisInputs.find('input[type="file"]').attr('inputs',rec);
								}
								if(thisInputs.parent().find('> input[type="button"]')){
									thisInputs.parent().find('> input[type="button"]').attr('inputs',rec);
								}
							};
						cambioDeFocus(miParent);						
					}
							
					function cambioDeFocus(miParent){
						$('#'+miParent+' table#inputs tr td input[type="text"]').change(function(){
								var miInputC =$(this).attr('inputs');
								miInputC=parseInt(miInputC);
								var nextInpu =miInputC+2;
								if($('#'+miParent+' table#inputs tr td').size() > nextInpu){
									if($('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpu+'"]').size() ==1){
										$('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpu+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find('select[inputs="'+nextInpu+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find('select[inputs="'+nextInpu+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpu+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpu+'"]').focus();
									}									
								}
							});
							
							$('#'+miParent+' table#inputs tr td input[type="text"]').keypress(function(event){
								var existe =$(this).parent().find('div.aviso').size();
								if(existe >0){									
									$(this).parent().find('> div.aviso').stop(true).show('blind',{},1500);
								}else if(existe ==0){
									var aviso ='<div class="aviso"><div class="avisoApuntador"></div><div class="avisoConten"></div></div>';
									var textoConten ='Presione enter para continuar';
									var thisWidth =$(this).width();
									$(this).parent().css('position','relative');
									$(this).parent().append(aviso);
									$(this).parent().find('> div.aviso').attr('style','width:'+thisWidth+'px;left:'+thisWidth+'px;');
									$(this).parent().find('> div.aviso .avisoConten').html(textoConten);	
								}
								tecla = (document.all) ? event.keyCode : event.which;
								if (tecla==13){
									var miInputT =$(this).attr('inputs');
									miInputT=parseInt(miInputT);
									var nextInpuT =miInputT+2;
									if($('#'+miParent+' table#inputs tr td').size() > nextInpuT){
										if($('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuT+'"]').size() ==1){
											$('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuT+'"]').focus();
										}
										if($('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuT+'"]').size() ==1){
											$('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuT+'"]').focus();
										}
										if($('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuT+'"]').size() ==1){
											$('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuT+'"]').focus();
										}									
									}
								};
							});
							
							$('#'+miParent+' table#inputs tr td > input[type="text"]').blur(function(){
							    $(this).parent().find('> div.aviso').hide('blind',{},500,function(){							    	
							    	//$(this).remove();							    	
							    });
							});	
														
							$('#'+miParent+' table#inputs tr td > select').change(function(){								
								var miInputS =$(this).attr('inputs');
								miInputS=parseInt(miInputS);
								var nextInpuS =miInputS+2;
								if($('#'+miParent+' table#inputs tr td').size() > nextInpuS){
									if($('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuS+'"]').size() ==1){
										$('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuS+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuS+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuS+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuS+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuS+'"]').focus();
									}									
								}
							});
							
							$('#'+miParent+' table#inputs tr td:nth-child(even) input[type="file"]').change(function(){
								var miInputF =$(this).attr('inputs');
								miInputF=parseInt(miInputF);
								var nextInpuF =miInputF+2;
								if($('#'+miParent+' table#inputs tr td').size() > nextInpuF){
									if($('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuF+'"]').size() ==1){
										$('#'+miParent+' table#inputs tr td').find('input[inputs="'+nextInpuF+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuF+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find('select[inputs="'+nextInpuF+'"]').focus();
									}
									if($('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuF+'"]').size() ==1){
										$('#'+miParent+' table#inputs').find(':file[inputs="'+nextInpuF+'"]').focus();
									}									
								}																				
							});
					}
												
					function validLongitud(objet,tamaño){
							var x = $(objet).val();
							var longi =x.length;
							if (longi>tamaño){
							  	return "no";
							  }else{
							  	return "si";
							  }
					}
						
					function ValidateEmail(inputText){  
						var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
						if($(inputText).val().match(mailformat)){						  
							return "si";  
						}else{  
							$(inputText).focus();  
							return "no";  
						}  
					} 
					
						function esNumero (n) {
						  return ! isNaN (n-0);
						}
						
						function esFloat (n) {
						  return n===+n && n!==(n|0);
						}
						
						function esMail(inpu){
							var si = true;
							var no = false;
							var x = $(inpu).val();
							var atpos=x.indexOf("@");
							var dotpos=x.lastIndexOf(".");
							if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
							  	return no;
							  }else{
							  	return si;
							  }
						}
					
					/*son parametros de validacion para campos que solo requieran tipos de datos especificos*/
					function validacion(tipo,objeto){
						var valor = $(objeto).val();
						var valid = '';
						switch(tipo){
							case('numero'):							 
								valid = esNumero(valor);
								break;
							case('decimal'): 
								valid = esFloat(valor);
								break;
							case('email'): 
								valid = esMail(valor);
								break;
						}
						
						if(valid==false){
							return 'no';
						}else if(valid==true){
							return 'si';					
						}
					}//var resultValidacion = validacion(tipo,objeto);
					
					/*Ejecuta un 'dialog' con contenido especifico el cual sera el reemplazo del alert*/
					function frm_addOpenDialogo(ident,nombre,titulo,contenido,accion,objet){
						var selectForm = $('#pestana .pestActiva').attr('name');
						var ifExists = $('body').find('#conteDialog').size();
						var objeto = $('#space #contenedor.'+selectForm+' '+ident+'').find(objet);						
						
						if(ifExists >= 1){
							var dialogo = '<div id="dialog-form" title="'+titulo+'"><p> '+nombre+': </p><fieldset>'+contenido+'</fieldset></div>';
							$('#space #contenedor.'+selectForm+' #conteDialog').prepend(dialogo);
						}else{
							var dialogo = '<div id="conteDialog" ><div id="dialog-form" title="'+titulo+'"><p> '+nombre+': </p><fieldset>'+contenido+'</fieldset></div></div>';
							$('#space #contenedor.'+selectForm+'').prepend(dialogo);
						}
						
						$( "#dialog-form" ).dialog({
						      autoOpen: true,
						      height: 250,
						      width: 350,
						      modal: true,
						      buttons: {
						        "Continuar": function() {
						        	objeto.focus();						          
						            objeto.click();
						            $( this ).dialog( "close" );						         
						        },
						        Cancel: function() {						        	
						          $( this ).dialog( "close" );
						          objeto.focus();
						        }
						      },
						      close: function() {
						       	objeto.focus();
						       	setTimeout(function(){$('#space #contenedor.'+selectForm+' #conteDialog, #space #contenedor.'+selectForm+' #dialog-form, .ui-dialog').each(function(){$(this).remove()});},2000);
						      }
						});
						    
						 /*
						    $( "#create-user" )
						      .button()
						      .click(function() {
						        $( "#dialog-form" ).dialog( "open" );
						      });
						  */
					};
					
					/*Muestra una division de espera mientras los datos se estan cargando*/
					function enviandoPeticion(idForm,peticion){
						var divEnviando = '<div id="enviando"><div id="infoEnviando"><div id="infoText">Procesando la informacion...<br> espere un momento por favor</div><div id="imgInfo"></div></div></div>';
						var resp ='';
						
						switch(peticion){
							case('open'):
								resp = $(idForm).prepend(divEnviando);$(idForm).css('position','relative');
								break;
							case('close'):
								resp = $(idForm+' > div#enviando').remove();$(idForm).css('position','');
								break;
						}
						return resp;
					}
					
					function resizeWindow(){
						var htmlWidth =$('html').width();						
						if(htmlWidth >1130 || htmlWidth >'1130'){
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','15%');
						}
						if(htmlWidth <1130 || htmlWidth <'1130'){
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','15%');
						}
						if(htmlWidth <808 || htmlWidth <'808'){
							$('body > div > #navegacion, body > div > #index').css({'width':'99%'});
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','20%');
						}
						if(htmlWidth >808 || htmlWidth >'808'){
							$('body > div > #navegacion, body > div > #index').css({'width':'72%'});
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','15%');
						}
						if(htmlWidth <325 || htmlWidth <'325'){
							$('#contenedor.inicio img:first').css({'width':'68%'});
							$('#contenedor.inicio img:last').css({'width':'100%'});
						}
						if(htmlWidth >325 || htmlWidth >'325'){
							//$('#contenedor.inicio img:first').css({'width':'200px'});
							$('#contenedor.inicio img:first').css({'width':'400px'});
							$('#contenedor.inicio img:last').css({'width':'auto'});
						}						
						if(htmlWidth <870 || htmlWidth <'870'){
							var Conten =$('#contenedor');
							var contenSize =Conten.size();
							var i;
							for(i=0;i<contenSize;i++){
								$('#contenedor > form > table tr').each(function(){
									var thisSize =$(this).find('td').size();
									if(thisSize==4){
										var newTr =$('<tr class="newTr"></tr>');
										$(this).after(newTr.prepend($(this).find('td:gt(1)')));
									}
								});
							}
						}
						if(htmlWidth >870 || htmlWidth >'870'){							
							var Conten =$('#contenedor');
							var contenSize =Conten.size();
							var i;
							for(i=0;i<contenSize;i++){
								$('#contenedor > form > table tr').each(function(){
									var thisClass =$(this).attr('class');
									var tIndex=$(this).index();
									if(thisClass=='newTr'){
										var boforeInd =tIndex-1;
										$(this).parent().find('tr:eq('+boforeInd+')').append($(this).find('td'));
										$(this).remove();
									}
								});								
							}							
						}						
						if(htmlWidth <490 || htmlWidth <'490'){
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','34%');							
						}
						if(htmlWidth >490 || htmlWidth >'490'){							
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','34%');			
						}
						if(htmlWidth <770 || htmlWidth <'770'){
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','34%');							
						}
						if(htmlWidth >770 || htmlWidth >'770'){							
							var pestHeaD =$('#pestana #pestHead');
							pestHeaD.css('width','15%');						
						}
					}
											
				//se finaliza con las funciones de: creacion de la validacion del contenido de los formularios
						
				//se inicia con las funciones de: creacion de formularios para volcado de datos
				var resulta;
				var GeoWindow;
				var extencion;
				function volcarArchivo(ar_ID){
					$.get('archivos/crear.php?id='+ar_ID+'',function(data){
						var resulta =data;
						if(resulta =='0' || resulta ==0 || resulta =='55' || resulta ==55){							
							var altt ="Ha ocurrido un problema con la descarga";
							frm_addOpenDialogo("table", "Abrir archivo","Error en la consulta a la base de datos",altt,"","input");
						}else{
							var extencion = resulta;
						}
						
						var lastInd=extencion.lastIndexOf(".")+1;
						var exten=extencion.substr(lastInd);
						var toUpp=exten.toUpperCase();
						var forArchi;
						
						if(toUpp =='PDF'){
							forArchi ='<div style="width: 100%;height: 764px;" ><embed style="width:100%;height:100%;" name="plugin" src="archivos/'+data+'" type="application/pdf"></div>';
						}else if(toUpp =='JPG' || toUpp =='JPEG' || toUpp =='PNG' || toUpp =='GIF'){
							forArchi ='<div style="width: 100%;height: 764px;" ><img width="100%" name="imagen" src="archivos/'+data+'" alt="'+data+'" title="'+data+'"></div>';
						}
						
						var altoPosible =screen.availHeight -100;
						var anchoPosible =screen.availWidth /4;
						
						function openWin(){
							GeoWindow=window.open('','CloudSystem','width='+anchoPosible*3+',height='+altoPosible+',left=200,top=100,location=no,menubar=no,resizable=no,titlebar=no,fullscreen=no,scrollbars=yes,status=yes,','false');
							GeoWindow.document.write("<!DOCTYPE html><html><head><title>CloudSystem -- Visor de documentos</title><head><body><p>Este es el archivo: "+data+"</p>"+forArchi+"<br><input type='button' value='Cerrar ventana' onclick='window.close();'></body></html>");
							GeoWindow.focus();
						}
						openWin();
						interGeoWindow = window.setInterval(function(){ifGeoClose(ar_ID,extencion)},1000);
						$('#GeoClose').css('display','block');
						$('#GeoClose').parent().find('> input:not(#GeoClose)').css('display','none');
						var GeoClose ='<input type="button" id="GeoClose" value="Cerrar visor de archivos" onclick="closeWin()" />';
					});					
				};
				
					function ifGeoClose(id_arc,nombreArch){
						if(GeoWindow.closed){							
							$.get('archivos/remover.php?id_arch='+id_arc+'',function(data){
								var resp =data;
								if(resp =='0' || resp ==0 || resp =='51' || resp ==51){									
								}else if(resp =='1' || resp ==1){									
									$('#GeoClose').css('display','none');
									$('#GeoClose').parent().find('> input:not(#GeoClose)').css('display','block');									
									window.clearInterval(interGeoWindow);
									interGeoWindow ='';
								}
							});
						}
					}
					
					function closeWin(){
						GeoWindow.close();
						$('#GeoClose').css('display','none');
						$('#GeoClose').parent().find('> input:not(#GeoClose)').css('display','block');
					}
					
					
					
					
					
				
				//se finaliza con las funciones de: creacion de formularios para volcado de datos
				
				//se inicia la funciones para validacion del vavegador y el cliente
					/*

					
					screen.availHeight;//lo que se puede
					screen.availWidth//lo que se puede
					
					screen.height//la resolucion
					screen.width//la resolucion

					document.write("<br>CodeName: " + navigator.appCodeName);
					document.write("<br>appName: " + navigator.appName);
					document.write("<br>appVersion: " + navigator.appVersion);
					document.write("<br>cookieEnabled: " + navigator.cookieEnabled);
					document.write("<br>onLine: " + navigator.onLine);
					document.write("<br>platform: " + navigator.platform);
					document.write("<br>userAgent: " + navigator.userAgent);
					
					appCodeName	Returns the code name of the browser
					appName	Returns the name of the browser
					appVersion	Returns the version information of the browser
					cookieEnabled	Determines whether cookies are enabled in the browser
					onLine	Boolean, returns true if the browser is on line, otherwise false.
					platform	Returns for which platform the browser is compiled
					userAgent
					
					resultado: 
										
						CodeName: Mozilla
						appName: Netscape
						appVersion: 5.0 (X11; Linux i686) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.160 Safari/537.22
						cookieEnabled: true
						onLine: true
						platform: Linux i686
						userAgent: Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.160 Safari/537.22
					*/
				//se finalizan la funciones para validacion del vavegador y el cliente
				
						//<div id="desplazamiento"><div id="despContenido">[]</div><div id="despSubir">^</div><div id="despBajar">d</div></div>
						
						//fin: creacion de la seccion de pesta�as
						
						//funciones posiblemente utiles en un futuro
						
						/*
						
							$('#'+miParent+' table#inputs tr td:nth-child(even) > input[type="text"]').keypress(function(event){								
								tecla = (document.all) ? event.keyCode : event.which;
								if (tecla==13){
									var miParent =$(this).parents('form').attr('id');  //.closest("form")
									var miClass =$(this).attr('class');
									var frmLeng =miParent.length;
									var indeLeng =frmLeng+2;
									var n=miClass.indexOf(miParent);
									if(n==0){
										var t=miClass.substr(n);
									}
									if(n==1){
										var t=miClass.substr(n-1,1);
										t =parseInt(t);
										t =t+1;
									}
									if(n==2){
										var t=miClass.substr(n-2,2);
										t =parseInt(t);
										t =t+1;
									}
									if(n>2){
										var t=miClass.substr(n-2,indeLeng);										
										t =t.replace(' ','');
										var g=t.indexOf(miParent);
										if(g==0){
											var h=t.substr(g);
										}
										if(g==1){
											var h=t.substr(g-1,1);
										}
										if(g==2){
											var h=t.substr(g-2,2);
										}
										t =parseInt(h);
										t =t+1;
									}
									$('#'+miParent+' table#inputs tr td .'+t+miParent+'').focus();										  	 
								}
							});
							
						*/
					