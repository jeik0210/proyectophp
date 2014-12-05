<?php
	session_start();
	include_once('php_conexion.php'); 
	include_once('Class/funciones.php'); 
	include_once('Class/class_alumnos.php');
	
	if($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='s'){
	}else{
		header('location:error.php');
	}
	
	$id_curso=$_POST['curso'];
	if($_POST['curso']<>'X'){
	$obj_curso=new Consultar_Salones($id_curso);
		$nombre_curso=$obj_curso->consultar('nombre');
		$descri_curso=$obj_curso->consultar('curso');
	}else{
		$nombre_curso='Todos';
		$descri_curso='';
	}
	header("Content-Disposition: attachment; filename=Alumnos_".$nombre_curso.".xls"); 
	header("Pragma: no-cache");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte Alumnos</title>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td colspan="7">
    	<center><strong><?php echo $nombre_curso.' | '.$descri_curso; ?></strong></center>
    </td>
  </tr>
  <tr>
    <td width="5%"><center><strong>No.</strong></center></td>
    <td width="29%"><strong>Apellido y Nombre del Alumno</strong></td>
    <td width="19%"><center><strong>Nit</strong></center></td>
    <td width="14%"><center><strong>Telefono</strong></center></td>
    <td width="11%"><center><strong>Estado</strong></center></td>
    <td width="11%"><center><strong>Salon o Curso</strong></center></td>
    <td width="11%"><center><strong>Folio</strong></center></td>
  </tr>
  <?php
  	$n=0;
  	if($_POST['curso']<>'X'){
  		$sql="SELECT * FROM alumnos WHERE curso='$id_curso' and estado='s'";		  	
	}else{
		$sql="SELECT * FROM alumnos WHERE estado='s'";		  	
	}
	$can=mysql_query($sql);
	while($dato=mysql_fetch_array($can)){
		$n++;
		$salones = new Consultar_Salones($dato['curso']);
  ?>
  <tr>
    <td><center><strong><?php echo $n; ?></strong></center></td>
    <td><?php echo trim($dato['apellido']).' '.trim($dato['nombre']); ?></td>
    <td><center><?php echo $dato['nit']; ?></center></td>
    <td><center><?php echo $dato['telefono']; ?></center></td>
    <td><center><?php echo estado($dato['estado']); ?></center></td>
    <td><center><?php echo $salones->consultar('nombre'); ?></center></td>
    <td><center><?php echo $dato['folio']; ?></center></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>