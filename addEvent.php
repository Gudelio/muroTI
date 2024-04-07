<?php

// Conexion a la base de datos
require_once('conn.php');

if (isset($_POST['title']) && isset($_POST['descripcion']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	
	$title = $_POST['title'];
	$descripcion = $_POST['descripcion'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	$sql = "INSERT INTO events(title, descripcion, start, end, color) values ('$title', '$descripcion', '$start', '$end', '$color')";
	
	echo $sql;
	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>