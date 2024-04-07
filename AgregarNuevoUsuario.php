<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'conexion.php';
	
	if(isset($_POST['btnsave']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$cuatri = $_POST['cuatri'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$birthday = $_POST['birthday'];
		$sex = $_POST['sex'];
		$carrera = $_POST['carrera'];
		$rol = $_POST['rol'];
		
		$imgFile = $_FILES['archivo']['name'];
		$tmp_dir = $_FILES['archivo']['tmp_name'];
		$imgSize = $_FILES['archivo']['size'];
		
		
		if(empty($username)){
			$errMSG = "Ingrese Usuario";
		}
		else if(empty($password)){
			$errMSG = "Ingrese Clave";
		}
		else if(empty($email)){
			$errMSG = "Ingrese Email";
		}
		else if(empty($cuatri)){
			$errMSG = "Ingrese Cuatrimestre";
		}
		else if(empty($name)){
			$errMSG = "Ingrese Nombre Completo";
		}
		else if(empty($phone)){
			$errMSG = "Ingrese Teléfono";
		}
		else if(empty($birthday)){
			$errMSG = "Ingrese Fecha de nacimiento";
		}
		else if(empty($sex)){
			$errMSG = "Ingrese Género";
		}
		else if(empty($carrera)){
			$errMSG = "Ingrese Carrera y Área";
		}
		else if(empty($rol)){
			$errMSG = "Ingrese Función";
		}
		else if(empty($imgFile)){
			$errMSG = "Seleccione el archivo.";
		}
		else
		{
			$upload_dir = 'imagenes/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '1MB'
				if($imgSize < 1000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Su archivo es muy grande.";
				}
			}
			else{
				$errMSG = "Solo archivos JPG, JPEG, PNG & GIF son permitidos.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO users(username, password, email, cuatri, name, phone, birthday, sex, carrera, rol, archivo) VALUES(:username, :password, :email, :cuatri, :name, :phone, :birthday, :sex, :carrera, :rol, :archivo)');

			$stmt->bindParam(':username',$username);
			$stmt->bindParam(':password',$password);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':cuatri',$cuatri);
			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':phone',$phone);
			$stmt->bindParam(':birthday',$birthday);
			$stmt->bindParam(':sex',$sex);
			$stmt->bindParam(':carrera',$carrera);
			$stmt->bindParam(':rol',$rol);
			$stmt->bindParam(':archivo',$userpic);

			if($stmt->execute())
			{
				$successMSG = "Nuevo registro insertado correctamente ...";
				header("refresh:2;usuarios.php"); // redirects image view page after 5 seconds.
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

<div class="container">
  <div class="page-header">
     <h1 align="center">Registro de usuario</h1>
     <a class="btn btn-default" href="usuarios.php"><i class="fa fa-users" aria-hidden="true"></i> Mostrar Usuarios </a></h1>
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
        <td><input class="input-group" type="file" name="archivo" title="Foto" accept="image/*"/></td>
      </tr>
      <tr>
        <td><input class="form-control" type="text" name="name" placeholder="Nombre Completo" value="<?php echo $name; ?>" /></td>
      </tr>
      <tr>
        <td><input class="form-control" type="text" name="username" placeholder="Usuario" value="<?php echo $username; ?>" /></td>
      </tr>
      <tr>
        <td><input class="form-control" type="password" name="password" placeholder="Clave" value="<?php echo $password; ?>" /></td>
      </tr>
      <tr>
        <td><input class="form-control" type="text" name="carrera" placeholder="Carrera y Área" value="<?php echo $carrera; ?>" /></td>
      </tr>
      <tr>
        <td><input class="form-control" type="email" name="email" placeholder="example@gmail.com" value="<?php echo $email; ?>" /></td>
      </tr>
      <tr>
        <td><select class="form-control" name="cuatri" value="<?php echo $cuatri; ?>">
		<option selected disabled hidden>Cuatrimestre:</option>
		<option value="1°">1°</option>
		<option value="2°">2°</option>
		<option value="3°">3°</option>
		<option value="4°">4°</option>
		<option value="5°">5°</option>
	    <option value="6°">6°</option>
	    <option value="7°">7°</option>
	    <option value="8°">8°</option>
	    <option value="9°">9°</option>
	    <option value="10°">10°</option>
	    <option value="11°">11°</option>
	    <option value="No Aplica">No Aplica</option></select></td>
      </tr>
       
       <tr>
        <td><input class="form-control" type="number" name="phone" placeholder="Teléfono" value="<?php echo $phone; ?>" /></td>
      </tr>
       <tr>
        <td><input class="form-control" type="date" name="birthday" value="<?php echo $birthday; ?>" /></td>
      </tr>
      <tr>
        <td><select class="form-control" name="rol" value="<?php echo $rol; ?>">
		<option selected disabled hidden>Función:</option>
		<option value="1">1-Direccion TI</option>
		<option value="2">2-Docente</option>
		<option value="3">3-Estudiante</option>
	</select></td>
      </tr>
       <tr>
        <td><select class="form-control"  name="sex" value="<?php echo $sex; ?>">
		<option selected disabled hidden>Género:</option>
		<option value="Hombre">Hombre</option>
		<option value="Mujer">Mujer</option>
	</select></td>
      </tr>
      
      
      <tr>
        <td colspan="6"><div align="center"><button type="submit" name="btnsave" class="btn btn-primary col-lg-6"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar usuario </button></div></td>
      </tr>
    </table>
  </form>

</div>

<!-- Latest compiled and minified JavaScript --> 
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>