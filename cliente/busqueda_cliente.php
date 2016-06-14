    <script type="text/javascript">$.ajaxSetup({ cache: false });</script>
		<script type="text/javascript">
			$(document).ready(function(){
				function focus(){
					$('#frm_sch input#pat').focus();
				};
				focus();
				$('#frm_sch input[name="rd1BC"]').change(function() {
				  focus();
				}).keyup(function() {
				  focus();
				}).click(function() {
				  focus();
				});
				
				$("#frm_sch #pat").keyup(function(){
					$.post('cliente/busqueda-cliente.php', {patRon:$('#frm_sch #pat').val(), opCion:$('#frm_sch input[name="rd1BC"]:checked').val()}, function(result) {
						$(".buscar_cliente #subsp").html(result).show();
					});
				});
				
				labelCheck('#frm_sch');
			});
		</script>
		<table width="90%" align="center">
			<tr>
				<td>
					<h3>Busqueda de clientes</font></h3>
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
						<input type="radio" id="rd2BC" name="rd1BC" value="2">Direcci&oacute;n
					</div>
					<div id="radioButtom">
						<input type="radio" id="rd3BC" name="rd1BC" value="3">Tel&eacute;fono
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Patron de busqueda: </label>
				</td>
				<td>
					<input type="text" id="pat" name="pat" value="">
				</td>
			</tr>
		</table>
		</form>
		<div id="subsp">
		<br>
		</div>
	