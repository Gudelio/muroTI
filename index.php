<?php  
 session_start();  
include("conexion.php");
 try  
 {   
          if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>Todos los campos son requeridos</label>';  
           }  
           else  
           {  
                $query = "SELECT * FROM users WHERE username = :username AND password = :password AND rol = :rol" ;  
                $statement = $DB_con->prepare($query);  
                $statement->execute(  
                     array(  
                          'username'     =>     $_POST["username"],  
                          'password'     =>     $_POST["password"],
                          'rol'     =>     $_POST["rol"]


                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                     $_SESSION["username"] = $_POST["username"]; 
                     $_SESSION["password"] = $_POST["password"];
                     $_SESSION["name"]= $_POST['name'];
      
                     $_SESSION["id"]=$_POST['id'];
                     $_SESSION["rol"]=$_POST['rol'];

                     
                     
                     header("location:home.php");  
                }  
                else  
                {  
                     $message = '<label>Datos incorrectos</label>';  
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 ?>  
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>Comunidad Social TI</title>

<!-- Bootstrap core CSS -->
<link href="assests/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
</head>

<body>

<!-- Begin page content -->

<div class="container">
  <h3 class="mt-5">Comunidad Social TI</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-6"> 
      <!-- Contenido -->
       
           <br />  
                <?php  
                if(isset($message))  
                {  
                     echo '<label class="text-danger">'.$message.'</label>';  
                }  
                ?>  
             
                <form method="post">  
                <div class="form-group">
    <label for="Usuario">Usuario</label>
    <input type="text" name="username" class="form-control" placeholder="Ingrese usuario" />  
				</div>
  
                     <div class="form-group">
    <label for="Contraseña">Clave</label>
     <input type="password" name="password" class="form-control" placeholder="Ingrese Clave" />  
				</div>





         <label class="control-label">Funcion</label>
        <select class="form-control" name="rol">
    <option selected disabled hidden>Función:</option>
    <option value="1">Dirección TI</option>
    <option value="2">Docente</option>
    <option value="3">Estudiante</option></select></td>



                      
                     <br />  
                     <input type="submit" name="login" class="btn btn-info" value="Iniciar Sesion" />  
                </form>  
            
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<!-- Fin container -->
<footer class="footer">
 
</footer>
<script src="assets/jquery-1.12.4-jquery.min.js"></script> 
<script src="assets/jquery.validate.min.js"></script> 
<script src="assets/ValidarRegistro.js"></script> 
<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script> 
<script src="assets/js/vendor/popper.min.js"></script> 
<script src="assests/js/bootstrap.min.js"></script>
</body>
</html>