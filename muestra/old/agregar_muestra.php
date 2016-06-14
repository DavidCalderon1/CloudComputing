<?php 

		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i']);
		}
		
		include 'procedimientos_muestra.php';
		
	if(isset($_POST['enviar'.$i.''])){

		echo ingreso_muestra($_POST['codigo'],$_POST['sucursal'],$_POST['fecha'],$_POST['numfac'],$_POST['tipomuestra'],$_POST['descripcion']);
		
	}else{
		
		if(isset($_COOKIE['i'])){
			$i=($_COOKIE['i'])+1;
			setcookie("i","".$i."",time()+60*60*24*365,"/");
		}
		
?>

<script type="text/javascript">
 
	$(document).ready(function(){
	  
		$("#enviar<?php echo $i;?>").click(function() {
		  
			var sc=$('#frm_add<?php echo $i;?> #sucursal').val();
			var cod=$('#frm_add<?php echo $i;?> #codigo').val();
			var f=$('#frm_add<?php echo $i;?> #fecha').val();
			var tm=$('#frm_add<?php echo $i;?> #tipomuestra').val();
			var nf=$('#frm_add<?php echo $i;?> #numfac').val();
			var des=$('#frm_add<?php echo $i;?> #descripcion').val();
			
			if(tm=="Seleccione uno...")
			{
				tm.val('');
			}
			if(sc!="" || sc!="Seleccione uno...")
			{
				$.post("muestra/agregar_muestra.php", {enviar<?php echo $i;?>:$('#frm_add<?php echo $i;?> #enviar<?php echo $i;?>').val(), sucursal:sc, codigo:cod, fecha:f, tipomuestra:tm, numfac:nf, descripcion:des}, function(output){
					if(output=="0"){
						alert("Existe un registro con el codigo antiguo!");
					}else if(output=="1"){
						alert("Se ha registrado correctamente la informacion.");
						$("#space .agregar_muestra").load("muestra/agregar_muestra.php").show();
					}
				});
			}
			else
			{
				alert("Existe algun campo vacio!");
			}
		});
		
	});
  
</script>

<form height="100%" id="frm_add<?php echo $i;?>" name="frm_add<?php echo $i;?>" method="post">

<table width="90%" align="center">
	<tr>
		<td>
			<h3>Registro Muestra</h3>
		</td>
	</tr>
</table>

<table align="center">
	<tr>
		<td>
			Cliente
		</td>
		<td>
			<script type="text/javascript">
					$(document).ready(function(){
						
						$("#cliente").change(function(){
							$("#cliente option:selected").each(function(){
								empresa=$(this).val();
								$.post("muestra/procedimientos_muestra.php",{empresa:empresa}, function(data){
									$("#sucursal").html(data);
								});
							});
						});
						
					});
				
			</script>
				<select name="cliente" id="cliente">
					<option id="selectFirst">Seleccione uno...</option>
					<?php
							
							$result=seleccion_cliente();
							
							while($results=mysql_fetch_array($result)){
							
							?>
					
							<option value="<?php echo $results['empresa_id'];?>"><?php echo $results['empresa_razonsocial'];?></option>
					
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
  	<script type="text/javascript">
			$(document).ready(function(){
				setTimeout(function(){
					$("input[name='fecha']").datepicker();//asigna el calendario a este input
				},1000);
				$(".agregar_muestra tr td").css('white-space','nowrap');//evita que al texto se le produzca un salto de linea cuando necesita ajustarse
				$("select").css({'min-width':'10%','max-width':'97%'});
				$("table").css({'width':'90%'});
				$(".agregar_muestra form table:eq(1) tr:first select").css({'max-width':'240px'}).parent().css({'max-width':'240px'});
				$(".agregar_muestra form table:eq(1) tr td").css({'padding-left':'10px'});
				$(".agregar_muestra form table:eq(1) tr ").css({'height':'40px'});
				$(".agregar_muestra form table:eq(3) tr ").css({'text-align':'center'});
				$('input[type="reset"],input[type="button"]').css({'margin':'5px 10px 2px 10px','padding':'5px 10px 5px 10px'});
				
				$("#check").change(function(){				
					if((this.checked)==true){
						$("#codigo").attr('disabled',false);
					}
					if((this.checked)==false){
						$("#codigo").attr('disabled',true);
					}					
				});
				
      });
		</script>
		<td id="checkButtom"> 
			Codigo antiguo
			<input type="checkbox" name="check" id="check">
		</td>
		<td>
			<input type="text" disabled="disabled" name="codigo" id="codigo" value="">
		</td>
		<td>
			Fecha
		</td>
		<td>
			<input type="text" name="fecha" placeholder="D&iacute;a/Mes/A&ntilde;o">
		</td>
	</tr>	
	<tr>
		<td>
			Tipo de muestra
		</td>
		<td>
			<select name="tipomuestra">
				<option id="selectFirst">Seleccione uno...</option>
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
			<input type="text" name="numfac">
		</td>
	</tr>

</table>

<table align="center">		
	<tr>
		<td>
			<fieldset class="forTextArea">
			<legend>Descripci&oacute;n</legend>
				<textarea name="descripcion" cols="60" rows="10"> 
				</textarea>
			</fieldset>
		</td>
	</tr>
</table>

<table align="center">			
	<tr>
		<td>
			<input type="reset" id="cancel" name="cancel" value="Cancelar" />
			<input type="button" id="enviar<?php echo $i;?>" name="enviar<?php echo $i;?>" value="Guardar" />
		</td>
	</tr>
</table>

</form>

<br><br>

<?php 

}

?>