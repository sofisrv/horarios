<?php

//include("tienda\conexion.php");
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "tienda";
    $con=mysqli_connect($host,$user,$pass);
    mysqli_select_db($con,$bd);

$id1 = $_POST['id1'];
$id2 = $_POST['id2'];
$tiempo_campana = $_POST['tiempo_campana'];
if (empty($id1) || empty($id2) || empty($tiempo_campana)) {
    $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
}
else{
    $insertar = "INSERT INTO campanas (id1, id2, tiempo_campana) VALUES(
        '$id1', 
        '$id2', 
        '$tiempo_campana')";
    
    $query = mysqli_query($con, $insertar);
    
    if ($query) {
        header("location: /tienda/campanas");
        exit();
        }
        else {
    
        }

}


?>

