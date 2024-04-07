<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=bd_muro_ti;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}
