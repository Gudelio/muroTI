<?php
error_reporting( ~E_NOTICE );	
require_once 'conexion.php';

if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
{
	$id = $_GET['edit_id'];
	$stmt_edit = $DB_con->prepare('SELECT titulo, descripcion, archivo, fecha FROM post WHERE post_id =:uid');
	$stmt_edit->execute(array(':uid'=>$id));
	$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
	extract($edit_row);
}
else
{
	header("Location: home.php");
}	

if(isset($_POST['btn_save_updates']))
{
	$titulo = $_POST['titulo'];
	$descripcion = $_POST['descripcion'];
		
	$imgFile = $_FILES['archivo']['name'];
	$tmp_dir = $_FILES['archivo']['tmp_name'];
	$imgSize = $_FILES['archivo']['size'];
				
	if($imgFile)
	{
		$upload_dir = 'imagenes/'; // upload directory	
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'docx'); // valid extensions
		$userpic = rand(1000,1000000).".".$imgExt;
		if(in_array($imgExt, $valid_extensions))
		{			
			if($imgSize < 1000000)
			{
				unlink($upload_dir.$edit_row['archivo']);
				move_uploaded_file($tmp_dir,$upload_dir.$userpic);
			}
			else
			{
				$errMSG = "Su archivo es demasiado grande mayor a 1MB";
			}
		}
		else
		{
			$errMSG = "Solo archivos JPG, JPEG, PNG, GIF, DOC & PDF .";		
		}	
	}
	else
	{
		// if no image selected the old image remain as it is.
		$userpic = $edit_row['archivo']; // old image from database
	}	
					
	
	// if no error occured, continue ....
	if(!isset($errMSG))
	{
		$stmt = $DB_con->prepare('UPDATE post 
									 SET titulo=:titulo, 
										 descripcion=:descripcion, 
										 archivo=:archivo 
								   WHERE post_id=:uid');
		$stmt->bindParam(':titulo',$titulo);
		$stmt->bindParam(':descripcion',$descripcion);
		$stmt->bindParam(':archivo',$userpic);
		$stmt->bindParam(':uid',$id);
			
		if($stmt->execute()){
			?>
<script>
			alert('Publicación editado satisfactoriamente ...');
			window.location.href='home.php';
			</script>
<?php
		}
		else{
			$errMSG = "Los datos no fueron actualizados !";
		}		
	}						
}	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Comunidad Social TI</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

</head>
<body>

<div class="container">
  <div class="page-header">
    <h1 class="center">Actualización De Publicación</h1>
    <a class="btn btn-default" href="home.php"><i class="fa fa-eye" aria-hidden="true"></i> Mostrar todas las publicaciones </a>
  </div>
  <div class="clearfix"></div>
  <form method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php
	if(isset($errMSG)){
		?>
    <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?> </div>
    <?php
	}
	?>
    <table class="table table-bordered table-responsive">
      <tr>
        <td><label class="control-label">Título</label></td>
        <td><input class="form-control" type="text" name="titulo" placeholder="Título" value="<?php echo $titulo; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Descripción</label></td>
        <td><input class="form-control" type="text" name="descripcion" placeholder="Descripción" value="<?php echo $descripcion; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Archivo</label></td>
        <td><p><img src="imagenes/<?php echo $archivo; ?>" alt="Documento Subido" height="150" width="150" /></p>
          <input class="input-group" type="file" name="archivo" /></td>
      </tr>
      <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default"> Actualizar </button>
          <a class="btn btn-default" href="home.php"> cancelar </a></td>
      </tr>
    </table>
  </form>
  
</div>
</body>
</html>