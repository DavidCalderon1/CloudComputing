<?php
   // Edit upload location here
   $destination_path = getcwd().DIRECTORY_SEPARATOR;

?>
<script language="javascript" type="text/javascript">

</script>

<?php
   $result = 0;
   
   $target_path = $destination_path . basename( $_FILES['myfile']['name']);

   if(@move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path)) {
      $result = 1;
	   echo 'si se pudo papa'.$_POST['oculto'];
   }
   if(isset($_POST['oculto'])){
   	echo 'si se pudo'.$_POST['oculto'];
   }
   
   sleep(1);
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);</script>   
