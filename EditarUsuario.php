<?php
error_reporting( ~E_NOTICE );	
require_once 'conexion.php';

if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
{
	$id = $_GET['edit_id'];
	$stmt_edit = $DB_con->prepare('SELECT username, password, email, cuatri, name, phone, birthday, sex, carrera, rol, archivo FROM users WHERE id =:uid');
	$stmt_edit->execute(array(':uid'=>$id));
	$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
	extract($edit_row);
}
else
{
	header("Location: Usuarios.php");
}	

if(isset($_POST['btn_save_updates']))
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
				
	if($imgFile)
	{
		$upload_dir = 'imagenes/'; // upload directory	
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc'); // valid extensions
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
			$errMSG = "Solo archivos JPG, JPEG, PNG & GIF .";		
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
		$stmt = $DB_con->prepare('UPDATE users 
									 SET username=:username, 
										 password=:password,
										 email=:email, 
										 cuatri=:cuatri, 
										 name=:name, 
										 phone=:phone,  
										 birthday=:birthday, 
										 sex=:sex,
										 carrera=:carrera, 
										 rol=:rol,  
										 archivo=:archivo 
								   WHERE id=:uid');
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
		$stmt->bindParam(':uid',$id);
			
		if($stmt->execute()){
			?>
<script>
			alert('Usuario editado satisfactoriamente ...');
			window.location.href='Usuarios.php';
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

<!-- Latest compiled and minified JavaScript -->
<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

</head>
<body>

<div class="container">
  <div class="page-header">
    <h1 class="center">Actualización De Usuario</h1>
    <a class="btn btn-default" href="usuarios.php"><i class="fa fa-users" aria-hidden="true"></i>
 Mostrar todos los usuarios </a>
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
        <td><label class="control-label">Foto</label></td>
        <td><p><img src="imagenes/<?php echo $archivo; ?>" height="150" width="150" /></p>
          <input class="input-group" type="file" name="archivo" /></td>
      </tr>
      <tr>
        <td><label class="control-label">Nombre</label></td>
        <td><input class="form-control" type="text" name="name" placeholder="Nombre Completo" value="<?php echo $name; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Usuario</label></td>
        <td><input class="form-control" type="text" name="username" placeholder="Usuario" value="<?php echo $username; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Clave</label></td>
        <td><input class="form-control" type="password" name="password" placeholder="Clave" value="<?php echo $password; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Carrera</label></td>
        <td><input class="form-control" type="text" name="carrera" placeholder="Carrera" value="<?php echo $carrera; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Email</label></td>
        <td><input class="form-control" type="email" name="email" placeholder="example@gmail.com" value="<?php echo $email; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Cuatrimestre</label></td>
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
        <td><label class="control-label">Telefono</label></td>
        <td><input class="form-control" type="number" name="phone" placeholder="Telefono" value="<?php echo $phone; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Fecha de nacimiento</label></td>
        <td><input class="form-control" type="date" name="birthday" value="<?php echo $birthday; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Funcion</label></td>
        <td><select class="form-control" name="rol" value="<?php echo $rol; ?>">
		<option selected disabled hidden>Función:</option>
		<option value="1">1-Dirección TI</option>
		<option value="2">1-Docente</option>
		<option value="3">3-Estudiante</option></select></td>
      </tr>
      <tr>
        <td><label class="control-label">Genero</label></td>
        <td><select class="form-control"  name="sex" value="<?php echo $sex; ?>">
		<option selected disabled hidden>Género:</option>
		<option value="Hombre">Hombre</option>
		<option value="Mujer">Mujer</option></select></td>
      </tr>
      <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default"> Actualizar </button>
          <a class="btn btn-default" href="usuarios.php"> cancelar </a></td>
      </tr>
    </table>
  </form>
  
</div>
</body>
</html>