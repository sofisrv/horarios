<?php

//include("tienda\conexion.php");
$host = "localhost";
$user = "root";
$pass = "";
$bd = "tienda";
    $con=mysqli_connect($host,$user,$pass);
    mysqli_select_db($con,$bd);

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$tiempo_l = $_POST['tiempo_l'];
if (empty($codigo) || empty($nombre) || empty($tiempo_l)) {
    $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
}
else{
    $insertar = "INSERT INTO maquinaria (codigo, nombre, tiempo_l) VALUES(
        '$codigo', 
        '$nombre', 
        '$tiempo_l')";
    
    $query = mysqli_query($con, $insertar);
    
    if ($query) {
        header("location: /tienda/maquinaria");
        exit();
        }
        else {
    
        }

}


?>

