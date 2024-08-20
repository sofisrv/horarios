<?php
// Conexion a la base de datos
require_once('bdd.php');
if (isset($_POST['delete']) && isset($_POST['id']))
{
	
	
	$id = $_POST['id'];
	
	$sql = "DELETE FROM events WHERE id = $id";
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}
elseif (isset($_POST['title']) && isset($_POST['tipo']) && isset($_POST['id']))
{
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$tipo = $_POST['tipo'];
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
	
	$sql = "UPDATE events SET title = '$title', tipo = '$tipo', id_proceso = '$id_proceso', color = '$color' WHERE id = $id ";

	
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
header('Location: index.php');

	
?>
