<?php

// Conexion a la base de datos
require_once('bdd.php');

if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['tipo'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$tipo = $_POST['tipo'];
	$id_proceso = 0;
	if ($tipo == '1')
	{
		$color = '#0071c5';
	}
	else if ($tipo == '2')
	{
		$color = '#40E0D0';
	}
	else 
	{
		$color = '#008000';
	}

	$sql = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values ('$title', '$start', '$end', '$color', $id_proceso, $tipo)";
	
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
