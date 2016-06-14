<?php

/*
 * 
 * $mysql_host = "mysql13.000webhost.com";
$mysql_database = "a2331316_sipm";
$mysql_user = "a2331316_geouser";
$mysql_password = "Server_252";
 * 
 * 
 * 
 * 
 * 
 * 
 * */


	if(isset($_COOKIE['i'])){
		$iMue=($_COOKIE['i']);
	}

		include 'procedimientos_muestra.php';

	if(isset($_POST['enviar'.$iMue.''])){
	
		echo ingreso_muestra($_POST['clienteId'],$_POST['codigo'],$_POST['fecha'],$_POST['sucursal'],$_POST['numfac'],$_POST['tipoMuestra'],$_POST['referencia'],$_POST['archivoId'],$_POST['descripcion']);
		
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
						
			?>
			
			<?php echo $resultsAM['empresa_id'];?>
			<?php echo $resultsAM['sucursal_id'];?>
			<?php echo $resultsAM['sucursal_nombre'].' '.$resultsAM['ciudad_nombre'];?>
			
			
			
			<?php
			
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
		
		
		
		
?>
			
			
			<script type="text/javascript">
				function frm_updMueColocarValores(){
					var forSelect =$('<option id="selectFirst" value="" ></option>');
					
					var forClienteValue ='<?php echo $empresa_id;?>';
					$("#frm_updMue<?php echo $iMue;?> select#cliente option").each(function(){
						var ThisValue =$(this).attr('value');
						if(ThisValue ==forClienteValue){
							$(this).prependTo($("#frm_updMue<?php echo $iMue;?> select#cliente"));
						}
					});
					
					var forSucursalValue ='<?php echo $sucursal_id;?>';
					var forSucursalVal ='<?php echo $sucursal_nombre;?>';
					var forSucursalName ='<?php echo $cliente_identificador;?>';
					forSelect.attr('value',forSucursalValue).attr('name',forSucursalName).attr('title',forSucursalVal).val(forSucursalVal);
					$("#frm_updMue<?php echo $iMue;?> select#sucursal").prepend(forSelect);
					
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
					
					var forFileSel =$('<select name="forFile" id="forFile"><option id="selectFirst" value="000" >Seleccione uno...</option><option id="look" value="1" >Ver el archivo</option><option id="change" value="2" >Cambiar el archivo</option></select>');
					var forFileButt1 =$('<input type="button" style="display:none;" name="<?php echo $ar_id;?>" id="<?php echo $ar_id;?>" title="<?php echo $ar_name;?>" value="<?php echo $ar_name;?>" />');
					var forFileButt2 =$('<input type="button" id="GeoClose" value="Cerrar visor de archivos" onclick="closeWin()" style="display:none;"/>');
					$("#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?>").css('display','none');
					$("#frm_updMue<?php echo $iMue;?> #frm_updMueArchivo<?php echo $iMue;?>").parent().prepend(forFileButt2).prepend(forFileButt1).prepend(forFileSel);
					
					//<option value="<?php echo $empresa_id;?>" title="<?php echo $empresa_razonsocial;?>"><?php echo $empresa_razonsocial;?></option>
				}
			</script>