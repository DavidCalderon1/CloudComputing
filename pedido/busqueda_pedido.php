    <?php 
		include 'procedimientos_usuario.php';
	?>
	<script type="text/javascript">$.ajaxSetup({ cache: false });</script>
		<script type="text/javascript">
			$(document).ready(function(){
				function focus(){
					$('#frm_sch input#pat').focus();
					cambiarPats();
				};
				focus();
				$('#frm_sch input[name="rd1BC"]').change(function() {
				  focus();
				}).keyup(function() {
				  focus();
				}).click(function() {
				  focus();
				});
				
				function cambiarPats(){
					var patsVal = $('#frm_sch input[name="rd1BC"]:checked').val();
					switch(patsVal){
						case "1":
							$('#frm_sch input#pat_nom').css('display','block');
							$('#frm_sch select#pat_tipou').css('display','none');
							$('#frm_sch select#pat_estau').css('display','none');
							$('#frm_sch input#pat_nom').focus();
							break;
						case "2":
							$('#frm_sch input#pat_nom').css('display','none');
							$('#frm_sch select#pat_tipou').css('display','block');
							$('#frm_sch select#pat_estau').css('display','none');
							$('#frm_sch select#pat_tipou').focus();
							break;
						case "3":
							$('#frm_sch input#pat_nom').css('display','none');
							$('#frm_sch select#pat_tipou').css('display','none');
							$('#frm_sch select#pat_estau').css('display','block');
							$('#frm_sch select#pat_estau').focus();
							break;
					}
				}
				
				$("#frm_sch #pat_nom").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				$("#frm_sch #pat_tipou").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				$("#frm_sch #pat_estau").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				
				$("#frm_sch #pat").keyup(function(){
					$.post('usuario/busqueda-usuario.php', {patRon:$('#frm_sch #pat').val(), opCion:$('#frm_sch input[name="rd1BC"]:checked').val()}, function(result) {
						$(".buscar_usuario #subsp").html(result).show();
					});
				}).change(function(){
					$.post('usuario/busqueda-usuario.php', {patRon:$('#frm_sch #pat').val(), opCion:$('#frm_sch input[name="rd1BC"]:checked').val()}, function(result) {
						$(".buscar_usuario #subsp").html(result).show();
					});
				});
				
				labelCheck('#frm_sch');
			});
		</script>
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Busqueda de usuarios</font></h3>
				</td>
			</tr>
		</table>
		<form id="frm_sch" name="frm_sch">
		<table width="60%" align="center">
			<tr>
				<td>
					<label>Buscar por:</label>
				</td>
				<td align="center">
					<div id="radioButtom">
						<input type="radio" id="rd1BC" name="rd1BC" value="1" checked>Nombre
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd2BC" name="rd1BC" value="2">Tipo
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd3BC" name="rd1BC" value="3">Estado
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Patron de busqueda: </label>
				</td>
				<script type="text/javascript">
			
					$(document).ready(function(){
						$("#frm_sch #pat_tipou").change(function(){
							$("#frm_sch #pat_tipou option:selected").each(function(){
								$("#frm_sch #pat").val($(this).val());
							});
						});
						
						$("#frm_sch #pat_estau").change(function(){
							$("#frm_sch #pat_estau option:selected").each(function(){
								$("#frm_sch #pat").val($(this).val());
							});
						});
						
					});
				
				</script>
				<td>
					<input type="hidden" id="pat" name="pat" value="" >
					<input type="text" id="pat_nom" name="pat_nom" value="" style=" display: block; ">
					<select name="pat_tipou" id="pat_tipou" style=" display: none; ">
						<option value=""></option>
						<?php				
						$result_tipou=seleccion_tipo_usuario();			
						while($results_tipou = $result_tipou->fetch(PDO::FETCH_ASSOC)){				
						?>        
						<option value="<?php echo $results_tipou['IdTipo_Usuario'];?>"><?php echo $results_tipou['Nom_Tipo_Usuario'];?></option>        
						<?php
						}				
						?>
					</select>
					<select name="pat_estau" id="pat_estau" style=" display: none; ">
						<option value=""></option>
						<option value="1" selected='selected' >Activo</option>
						<option value="2">Inactivo</option>
					</select>
				</td>
			</tr>
		</table>
		</form>
		<div id="subsp">
		<br>
		</div>
	