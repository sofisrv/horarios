<?php

//include("tienda\conexion.php");

$host = "localhost";
$user = "root";
$pass = "";
$bd = "tienda";
    $con=mysqli_connect($host,$user,$pass);
    mysqli_select_db($con,$bd);

$id_producto = $_POST['id_producto'];
$id_maquinaria = $_POST['id_maquinaria'];
$orden = $_POST['orden'];
$tiempo = $_POST['tiempo'];
if (empty($id_producto) || empty($id_maquinaria) || empty($orden)|| empty($tiempo)) {
    $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
}
else{
    $insertar = "INSERT INTO procesos (id_producto, id_maquinaria, orden, tiempo) VALUES(
        '$id_producto', 
        '$id_maquinaria', 
        '$orden',
        '$tiempo')";
    
    $query = mysqli_query($con, $insertar);
    
    if ($query) {
        header("location: /tienda/procesos");
        exit();
        }
        else {
    
        }

}
?>

