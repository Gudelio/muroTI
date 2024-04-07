<?php require_once 'core.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap core CSS -->
<link href="assests/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

  <title>Comunidad Social TI</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
  <!-- bootstrap theme-->
  <link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

  <!-- jquery -->
  <script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
  <script src="assests/bootstrap/js/bootstrap.min.js"></script>

<!-- Alertify -->
  <script src="assests/alertify/js/alertify.min.js"></script>
  <link rel="stylesheet" href="assests/alertify/themes/alertify.core.css">
  <link rel="stylesheet" href="assests/alertify/themes/alertify.default.css">


<!-- head styles-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
  <link type="text/css" href="css/theme.css" rel="stylesheet">
  <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>


<body>
  
<div class="navbar navbar-default">
    
      <div class="container">

 <a class="brand" href="home.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i></a>

          <h1>Social TI</h1>
        
          <ul class="nav pull-right">
            
            <li class="nav-user dropdown">
              <a href="perfil.php"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i>

                </a>
              
              <ul class="dropdown-menu">
               
                <?php 
 if(isset($_SESSION["username"]))  
 {  
      echo '<p>'.$_SESSION["username"].'</p>';   
 }  
 
 ?>   

     
<?php
                    if ($_SESSION['rol'] == 1) {
                      #code...
                       echo '<li><a href="usuarios.php"><i class="fa fa-users" aria-hidden="true"></i> Administración de usuarios</a></li>';
                
                }else{

                    }
                    ?>

      
      <li><a href="calendario.php"><i class="fa fa-calendar" aria-hidden="true"></i> Calendario de eventos</a></li>
                    <?php 
 if(isset($_SESSION["username"]))  
 {  
      echo '<li id="topNavLogout"><a href="cerrarSesion.php"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>';  
 }  
 else  
 {  
      header("location:index.php");  
 }  
 ?>     

                
              </ul>
            </li>
          </ul>
       
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->
 