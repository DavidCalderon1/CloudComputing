    <?php 
		include 'procedimientos_producto.php';
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
							$('#frm_sch #forpat_desc').css('display','none');
							$('#frm_sch #pat_val').css('display','none');
							$('#frm_sch select#pat_proveedor').css('display','none');
							$('#frm_sch input#pat_nom').focus();
							break;
						case "2":
							$('#frm_sch input#pat_nom').css('display','none');
							$('#frm_sch #forpat_desc').css('display','block');
							$('#frm_sch #pat_val').css('display','none');
							$('#frm_sch select#pat_proveedor').css('display','none');
							$('#frm_sch #pat_desc').focus();
							break;
						case "3":
							$('#frm_sch input#pat_nom').css('display','none');
							$('#frm_sch #forpat_desc').css('display','none');
							$('#frm_sch #pat_val').css('display','block');
							$('#frm_sch select#pat_proveedor').css('display','none');
							$('#frm_sch input#pat_val').focus();
							break;
						case "4":
							$('#frm_sch input#pat_nom').css('display','none');
							$('#frm_sch #forpat_desc').css('display','none');
							$('#frm_sch #pat_val').css('display','none');
							$('#frm_sch select#pat_proveedor').css('display','block');
							$('#frm_sch select#pat_proveedor').focus();
							break;
					}
				}
				
				$("#frm_sch #pat_nom").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				$("#frm_sch #pat_desc").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				$("#frm_sch #pat_val").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				$("#frm_sch #pat_proveedor").keyup(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				}).change(function(){
					$('#frm_sch input#pat').val( $(this).val() ).keyup();
				});
				
				$("#frm_sch #pat").keyup(function(){
					$.post('producto/busqueda-producto.php', {patRon:$('#frm_sch #pat').val(), opCion:$('#frm_sch input[name="rd1BC"]:checked').val()}, function(result) {
						$(".buscar_producto #subsp").html(result).show();
					});
				}).change(function(){
					$.post('producto/busqueda-producto.php', {patRon:$('#frm_sch #pat').val(), opCion:$('#frm_sch input[name="rd1BC"]:checked').val()}, function(result) {
						$(".buscar_producto #subsp").html(result).show();
					});
				});
				
				labelCheck('#frm_sch');
			});
		</script>
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Busqueda de productos</font></h3>
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
						<input type="radio" id="rd2BC" name="rd1BC" value="2">Descripci&oacute;n
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd3BC" name="rd1BC" value="3">Valor unitario
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd4BC" name="rd1BC" value="4">Proveedor
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Patron de busqueda: </label>
				</td>
				<script type="text/javascript">
			
					$(document).ready(function(){
						$("#frm_sch #pat_proveedor").change(function(){
							$("#frm_sch #pat_proveedor option:selected").each(function(){
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
					<fieldset class="forTextArea" id="forpat_desc">
						<textarea name="pat_desc" id="pat_desc" cols="50" rows="5"></textarea>
					</fieldset>
					<input type="number" id="pat_val" name="pat_val" value="">	
					<select name="pat_proveedor" id="pat_proveedor" style=" display: none; ">
						<option value=""></option>
						<?php				
						$result_tipou=seleccion_proveedor();			
						while($results_tipou = $result_tipou->fetch(PDO::FETCH_ASSOC)){				
						?>        
						<option value="<?php echo $results_tipou['IdProveedor'];?>"><?php echo $results_tipou['Nom_Proveedor'];?></option>        
						<?php
						}				
						?>
					</select>
				</td>
			</tr>
		</table>
		</form>
		<div id="subsp">
		<br>
		</div>
	