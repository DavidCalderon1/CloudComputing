    <script type="text/javascript">$.ajaxSetup({ cache: false });</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#frm_schMue input[name='rd1BM']").change(function(){
					$("#frm_schMue #patr").focus();
				});
				
				$("#frm_schMue #patr").keyup(function(){
					$.post('muestra/busqueda-muestra.php', {patronMu:$('#frm_schMue #patr').val(), opcionMu:$('#frm_schMue input[name="rd1BM"]:checked').val()}, function(result) {
						$(".buscar_muestra #res_SchMue").html(result).show();
					});
				});
				$("#frm_schMue #patr").focus();
				
				labelCheck('#frm_schMu');
			});
		</script>
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Busqueda de muestras</font></h3>
				</td>
			</tr>
		</table>
		<form id="frm_schMue" name="frm_schMue">
		<table width="90%" align="center">
			<tr>
				<td>
					<label>Buscar por:</label>
				</td>
				<td align="center">
					<div id="radioButtom">
						<input type="radio" id="rd1BM" name="rd1BM" value="1" checked>Tipo de muestra
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd2BM" name="rd1BM" value="2">Cliente
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd3BM" name="rd1BM" value="3">Codigo antiguo
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd4BM" name="rd1BM" value="4">No. de factura
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd5BM" name="rd1BM" value="5">Fecha
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd6BM" name="rd1BM" value="6">Referencia
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Patron de busqueda: </label>
				</td>
				<td>
					<input type="text" id="patr" name="patr" value="">
				</td>
			</tr>
		</table>
		</form>
		<div id="res_SchMue">
		<br>
		</div>
	