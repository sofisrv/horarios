<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "tienda";
    $con=mysqli_connect($host,$user,$pass);
    mysqli_select_db($con,$bd);
?>