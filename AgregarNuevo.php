<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'conexion.php';
	
	if(isset($_POST['btnsave']))
	{
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		
		$imgFile = $_FILES['archivo']['name'];
		$tmp_dir = $_FILES['archivo']['tmp_name'];
		$imgSize = $_FILES['archivo']['size'];
		
		
		if(empty($titulo)){
			$errMSG = "Ingrese el título.";
		}
		else if(empty($descripcion)){
			$errMSG = "Ingrese la descripción.";
		}
		else if(empty($imgFile)){
			$errMSG = "Seleccione el archivo.";
		}
		else
		{
			$upload_dir = 'imagenes/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'docx'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,10000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '1MB'
				if($imgSize < 10000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Su archivo es muy grande.";
				}
			}
			else{
				$errMSG = "Solo archivos JPG, JPEG, PNG, GIF, DOC & PDF son permitidos.";		
			}
		}
		
		


		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO post(titulo, descripcion, archivo, fecha) VALUES(:titulo, :descripcion, :archivo, now())');

			$stmt->bindParam(':titulo',$titulo);
			$stmt->bindParam(':descripcion',$descripcion);
			$stmt->bindParam(':archivo',$userpic);
			
			
			if($stmt->execute())
			{
				$successMSG = "Publicación subida ...";
				header("refresh:2;home.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "Error al insertar ...";
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Comunidad Social TI</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/jquery.min.js"></script>
<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
</head>
<body>
	
	<br>
 
<div class="container">
  <div class="page-header">
  	<div align="center"><img src="images/img/publicar.jpg"> </div>
     <a class="btn btn-default" href="home.php"><i class="fa fa-eye" aria-hidden="true"></i> Mostrar publicaciones </a>
  </div>
  <?php
	if(isset($errMSG)){
			?>
  <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> </div>
  <?php
	}
	else if(isset($successMSG)){
		?>
  <div class="alert alert-success"> <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong> </div>
  <?php
	}
	?>
  <form method="post" enctype="multipart/form-data" class="form-horizontal">
    <table class="table table-bordered table-responsive">
      <tr>
      <td><label class="control-label">Título</label></td>
      <td><input class="form-control" type="text" name="titulo" placeholder="Título" value="<?php echo $titulo; ?>" /></td>
      </tr>
      <tr>
      <td><label class="control-label">Descripción</label></td>
      <td><input class="form-control" type="text" name="descripcion" placeholder="Descripción" value="<?php echo $descripcion; ?>" /></td>
      </tr>
      <tr>
      <td><label class="control-label">Archivo</label></td>
      <td><input class="input-group" type="file" name="archivo" title="Seleccione un archivo" /></td>
      </tr>
      <tr>
      <td colspan="2"><button type="submit" name="btnsave" class="btn btn-primary col-md-6" ><i class="fa fa-share" aria-hidden="true"></i> Compartir </button></td>
      </tr>
    </table>
  </form>

</div>

<!-- Latest compiled and minified JavaScript --> 
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>