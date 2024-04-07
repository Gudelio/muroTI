<?php   //home.php  
 session_start(); 
?>

<?php
// Archivo de conexion con la base de datos
require_once 'conexion.php';
// Condicional para validar el borrado de la imagen
if(isset($_GET['delete_id']))
{
  // Selecciona imagen a borrar
  $stmt_select = $DB_con->prepare('SELECT archivo FROM post WHERE post_id =:uid');
  $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
  $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  // Ruta de la imagen
  unlink("imagenes/".$imgRow['archivo']);
  
  // Consulta para eliminar el registro de la base de datos
  $stmt_delete = $DB_con->prepare('DELETE FROM post WHERE post_id =:uid');
  $stmt_delete->bindParam(':uid',$_GET['delete_id']);
  $stmt_delete->execute();
  // Redireccioa al inicio
  header("Location: home.php");
}

?>

<?php 
require_once 'includes/header.php'; 
?>

<!Doctype html>
<head>
<meta charset="utf-8">
<title>Comunidad Social TI</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<script src="bootstrap/js/jquery.min.js"></script>
</head>

<body>



    <div class="col-md-12" align="center"> 
      <!-- Contenido -->
<?php 
 if(isset($_SESSION["username"]))  
 {  
      echo '<h3>Bienvenido '.$_SESSION["username"].'</h3>';   
 }  
 else  
 {  
      header("location:index.php");  
 }  
 ?>        
</div>

<div class="container">


<?php 

   
 if ($_SESSION["rol"] == 1)
 {  
      echo '<a class="btn btn-default" href="AgregarNuevo.php"> <span class="glyphicon glyphicon-plus"></span> Agregar Nueva Publicación</a>';
            }else{

                    } 
                    ?> 






  <div class="page-header">
     
</div>
   


  <div class="row">
    <?php
  
  $stmt = $DB_con->prepare('SELECT post_id, titulo, descripcion, archivo, fecha FROM post ORDER BY post_id DESC');
  $stmt->execute();
  
  if($stmt->rowCount() > 0)
  {
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
      extract($row);
      ?>

    
      <div class="container col-md-8">
      <p style="font-size: 16px"><strong><?php echo $titulo; ?></strong></p>

      <p style="font-size: 16px"><?php echo $descripcion; ?></p>
      <p style="color: #929292;font-size: 10px"><span class='posted-at'> <i><?php echo $row['fecha']; ?></i></span></p>
      <img src="imagenes/<?php echo $row['archivo']; ?>" class="img-rounded" alt="Documento digital, pulse el icono de descarga" width="300px" height="300px"/>
     <a title="Descargar archivo" href="imagenes/<?php echo $row['archivo']; ?>" download="<?php echo $row['archivo']; ?>" style="color: blue; font-size:30px;"> <i class="fa fa-cloud-download" aria-hidden="true"></i>


<p class="page-header"> <span> <a class="btn btn-info" href="EditarPost.php?edit_id=<?php echo $row['post_id']; ?>" title="Editar Publicación-Solo Administrador" onclick="return confirm('Esta Seguro De Editar La Publicación ?')"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
        <a class="btn btn-danger" href="?delete_id=<?php echo $row['post_id']; ?>" title="Borrar Publicación-Solo Administrador" onclick="return confirm('Esta Seguro De Eliminar La Publicación?')"><span class="glyphicon glyphicon-remove-circle"></span> Borrar</a> </span> </p>
    </div>

    <?php
    }
  }
  else
  {
    ?>
    <div class="col-md-12">
      <div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Hay Publicaciones ... </div>
    </div>
    <?php
  }
  
?>
  </div>         
</div>

<script src="assets/jquery-1.12.4-jquery.min.js"></script> 
<script src="assets/jquery.validate.min.js"></script> 
<script src="assets/ValidarRegistro.js"></script> 
<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script> 
<script src="assets/js/vendor/popper.min.js"></script> 
<script src="assests/js/bootstrap.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>