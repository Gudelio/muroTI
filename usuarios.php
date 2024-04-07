<?php
// Archivo de conexion con la base de datos
require_once 'conexion.php';

// Condicional para validar el borrado de la imagen
if(isset($_GET['delete_id']))
{
	// Selecciona imagen a borrar
	$stmt_select = $DB_con->prepare('SELECT archivo FROM users WHERE id =:uid');
	$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
	$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
	// Ruta de la imagen
	unlink("imagenes/".$imgRow['archivo']);
	
	// Consulta para eliminar el registro de la base de datos
	$stmt_delete = $DB_con->prepare('DELETE FROM users WHERE id =:uid');
	$stmt_delete->bindParam(':uid',$_GET['delete_id']);
	$stmt_delete->execute();
	// Redireccioa al inicio
	header("Location: usuarios.php");
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes" />
<title>Comunidad Social TI</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
<script src="bootstrap/js/jquery.min.js"></script>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    text-align: left;
    padding: 4px;
}
tr:nth-child(even){background-color: #f2f2f2}
th {
    background-color: #4CAF50;
    color: white;
}
hr {
    margin-top: 5px;
    margin-bottom: 5px;
    border: 0;
    border-top: 1px solid #eee;
}
h1{
	font-size:20px;
	}
</style>
</head>

<body>
	<br>

<div align="center"><h1 style="font-size: 30px">Administración de usuarios</h1></div>

<div class="container">
  <div class="page-header">
  	<a class="btn btn-success" href="home.php" title="Regresar a home"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
     <a class="btn btn-primary" href="AgregarNuevoUsuario.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Nuevo Usuario</a>
  </div>
  <br />
  <div class="row">
    
<?php
	
	$stmt = $DB_con->prepare('SELECT id, username, password,email, cuatri, name, phone, birthday, sex, carrera, rol, archivo FROM users ORDER BY id DESC');
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
 
    	<table class="table table-bordered table-responsive">
    		
    		
	<tr>

		<th>Foto</th>
		<th>Nombre Completo</th>
		<th>Usuario</th>
		<th>Clave</th>
		<th>Carrera y Área</th>
		<th>Email</th>
		<th>Cuatrimestre</th>
		<th>Teléfono</th>
		<th>Fecha de nacimiento</th>
		<th><font size="1px">Función(1-Admin,2-Docentes,3-Estudiantes)</font></th>
		<th>Género</th>
		<th>Opcion</th>

	</tr>


	<tr>
		<td><img src="imagenes/<?php echo $row['archivo']; ?>" class="img-rounded" width="50px" height="50px"/></td>
		<td><?php echo $name; ?></td>
		<td><?php echo $username; ?></td>
		<td><?php echo $password; ?></td>
		<td><?php echo $carrera; ?></td>
		<td><?php echo $email; ?></td>
		<td><?php echo $cuatri; ?></td>
		<td><?php echo $phone; ?></td>
		<td><?php echo $birthday; ?></td>
		<td><?php echo $rol; ?></td>
		<td><?php echo $sex; ?></td>  
     <td><a class="btn btn-info" href="EditarUsuario.php?edit_id=<?php echo $row['id']; ?>" title="Editar" onclick="return confirm('Esta seguro de editar el usuario ?')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
     	<a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="Eliminar" onclick="return confirm('Esta seguro de eliminar el usuario?')"><i class="fa fa-times" aria-hidden="true"></i></a></td>
    </tr>

    </table>


    <?php
		}
	}
	else
	{
		?>
    <div class="col-xs-12">
      <div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Datos no encontrados ... </div>
    </div>
    <?php
	}
	
?>
  </div>
  
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>