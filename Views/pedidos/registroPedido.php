<?php

//include("tienda\conexion.php");
$host = "localhost";
$user = "root";
$pass = "";
$bd = "tienda";
$con=mysqli_connect($host,$user,$pass);
mysqli_select_db($con,$bd);

$currentDate = gmdate("Y/m/d H:i:s"); //dia de hoy

$codigo = $_POST['codigo'];
$id_producto = $_POST['id_producto'];
$fecha_creacion = $_POST['fecha_creacion'];
$fecha_entrega = $_POST['fecha_entrega'];

if($consulta = $con->query("SELECT * FROM `productos` WHERE id=$id_producto ;"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $producto = $fila['descripcion'];
        }
    }

if (empty($codigo) || empty($id_producto) || empty($fecha_creacion)|| empty($fecha_entrega)) {
    $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
}
else{

    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Lunes';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_lunes = $fila['hora_ini'];
            $hf_lunes = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_lunes = NULL;
        $hf_lunes = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Martes';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_martes = $fila['hora_ini'];
            $hf_martes = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_martes = NULL;
        $hf_martes = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Miercoles';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_miercoles = $fila['hora_ini'];
            $hf_miercoles = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_miercoles = NULL;
        $hf_miercoles = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Jueves';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_jueves = $fila['hora_ini'];
            $hf_jueves = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_jueves = NULL;
        $hf_jueves = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Viernes';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_viernes = $fila['hora_ini'];
            $hf_viernes = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_viernes = NULL;
        $hf_viernes = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Sabado';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_sabado = $fila['hora_ini'];
            $hf_sabado = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_sabado = NULL;
        $hf_sabado = NULL;
    }
    if($consulta = $con->query("SELECT telefono as hora_ini, direccion as hora_fin FROM clientes WHERE nombre = 'Domingo';"))
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $hi_domingo = $fila['hora_ini'];
            $hf_domingo = $fila['hora_fin'];
        }
    }
    else 
    {
        $hi_domingo = NULL;
        $hf_domingo = NULL;
    }


    if($consulta = $con->query("SELECT precio_venta as lp FROM `productos` WHERE id = $id_producto;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber tiempo limpieza de producto
        {
            $lp = $fila['lp'];
        }
    }
    else 
    {
        $lp = NULL;
    }

    if($consulta = $con->query("SELECT id_maquinaria, tiempo FROM `procesos` WHERE id_producto = $id_producto and orden = 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber maquinaria de proceso 1
        {
            $m1 = $fila['id_maquinaria'];
            $t1 = $fila['tiempo'];
        }
    }
    else 
    {
        $m1 = NULL;
        $t1 = 0;
    }
    if($consulta = $con->query("SELECT id_maquinaria, tiempo FROM `procesos` WHERE id_producto = $id_producto and orden = 2;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber maquinaria de proceso 2
        {
            $m2 = $fila['id_maquinaria'];
            $t2 = $fila['tiempo'];
        }
    }
    else 
    {
        $m2 = NULL;
        $t2 = 0;
    }
    if($consulta = $con->query("SELECT id_maquinaria, tiempo FROM `procesos` WHERE id_producto = $id_producto and orden = 3;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber maquinaria de proceso 3
        {
            $m3 = $fila['id_maquinaria'];
            $t3 = $fila['tiempo'];
        }
    }
    else 
    {
        $m3 = NULL;
        $t3 = 0;
    }

    if($consulta = $con->query("SELECT id_maquinaria, tiempo FROM `procesos` WHERE id_producto = $id_producto and orden = 4;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber maquinaria de proceso 4
        {
            $m4 = $fila['id_maquinaria'];
            $t4 = $fila['tiempo'];
        }
    }
    else 
    {
        $m4 = NULL;
        $t4 = 0;
    }

    if($consulta = $con->query("SELECT id_maquinaria, tiempo FROM `procesos` WHERE id_producto = $id_producto and orden = 5;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber maquinaria de proceso 5
        {
            $m5 = $fila['id_maquinaria'];
            $t5 = $fila['tiempo'];
        }
    }
    else 
    {
        $m5 = NULL;
        $t5 = 0;
    }

    if($consulta = $con->query("SELECT events.end FROM events inner join pedidos on events.title = pedidos.codigo inner join procesos on pedidos.id_producto = procesos.id_producto where pedidos.id_producto = $m1 and end > '2024-06-11 17:23:00' ORDER BY events.end DESC limit 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber ultimo evento disponible hoy en proceso 1
        {
            $hf1= $fila['end'];
        }
    }
    else 
    {
        $hf1 = new DateTime('+1 Minute');
    }
    if($consulta = $con->query("SELECT events.end FROM events inner join pedidos on events.title = pedidos.codigo inner join procesos on pedidos.id_producto = procesos.id_producto where pedidos.id_producto = $m2 and end > '2024-06-11 17:23:00' ORDER BY events.end DESC limit 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber ultimo evento disponible hoy en proceso 2
        {
            $hf2= $fila['end'];
        }
    }
    else 
    {
        $hf2 = '2024-06-14 07:00:00';
    }
    if($consulta = $con->query("SELECT events.end FROM events inner join pedidos on events.title = pedidos.codigo inner join procesos on pedidos.id_producto = procesos.id_producto where pedidos.id_producto = $m3 and end > '2024-06-11 17:23:00' ORDER BY events.end DESC limit 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber ultimo evento disponible hoy en proceso 3
        {
            $hf3= $fila['end'];
        }
    }
    else 
    {
        $hf3 = '2024-06-14 07:00:00';
    }
    if($consulta = $con->query("SELECT events.end FROM events inner join pedidos on events.title = pedidos.codigo inner join procesos on pedidos.id_producto = procesos.id_producto where pedidos.id_producto = $m4 and end > '2024-06-11 17:23:00' ORDER BY events.end DESC limit 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber ultimo evento disponible hoy en proceso 4
        {
            $hf4= $fila['end'];
        }
    }
    else 
    {
        $hf4 == '2024-06-14 07:00:00';
    }
    if($consulta = $con->query("SELECT events.end FROM events inner join pedidos on events.title = pedidos.codigo inner join procesos on pedidos.id_producto = procesos.id_producto where pedidos.id_producto = $m5 and end > '2024-06-11 17:23:00' ORDER BY events.end DESC limit 1;"))
    {
        while ($fila = $consulta->fetch_assoc()) //saber ultimo evento disponible hoy en proceso 5
        {
            $hf5= $fila['end'];
        }
    }
    else 
    {
        $hf5 = '2024-06-14 07:00:00';
    }

    $consultar1=$con->query("SELECT EXISTS (SELECT proveedor.id, procesos.tiempo FROM `procesos` inner join proveedor on proveedor.id = procesos.id_maquinaria WHERE orden = 1 AND id_producto = '$id_producto');");
    $row1 = mysqli_fetch_row($consultar1);


    $ahorita = new DateTime('+1 Day');

    $hip = $hf1;
    
    $time = new DateTime($hip);
    $time->add(new DateInterval('PT' . $t1 . 'M'));
    $hfp = $time->format('Y-m-d H:i');

    $hil = $hfp; 

    $time = new DateTime($hil);
    $time->add(new DateInterval('PT' . $lp . 'M'));
    $hfl = $time->format('Y-m-d H:i');
    $cod = $codigo." Producto : ".$producto." Maquinaria : ".$m1;

    if ($row1[0]=="1") {               
        //Primario
        $insertar1 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hip', 
            '$hfp',  
            '#0071c5',
            '1',
            '1')";

        $query1 = mysqli_query($con, $insertar1);
        //limpieza primario
        $insertar2 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hil', 
            '$hfl',  
            '#40E0D0',
            '1',
            '2')";

        $query2 = mysqli_query($con, $insertar2);
    }

    $consultar2=$con->query("SELECT EXISTS (SELECT proveedor.nombre FROM `procesos` inner join proveedor on proveedor.id = procesos.id_maquinaria WHERE orden = 2 AND id_producto = '$id_producto');");
    $row2 = mysqli_fetch_row($consultar2);

    $hip = $hf2;
    
    $time = new DateTime($hip);
    $time->add(new DateInterval('PT' . $t2 . 'M'));
    $hfp = $time->format('Y-m-d H:i');

    $hil = $hfp; 

    $time = new DateTime($hil);
    $time->add(new DateInterval('PT' . $lp . 'M'));
    $hfl = $time->format('Y-m-d H:i');

    $cod = $codigo." Producto : ".$producto." Maquinaria : ".$m2;

    if ($row2[0]=="1")
    {
       //Secundario
        $insertar3 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hip', 
            '$hfp',  
            '#0071c5',
            '1',
            '1')";

        $query3 = mysqli_query($con, $insertar3);
        //limpieza secundario
        $insertar4 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hil', 
            '$hfl',  
            '#40E0D0',
            '1',
            '2')";

        $query4 = mysqli_query($con, $insertar4);
    }

    $consultar3=$con->query("SELECT EXISTS (SELECT proveedor.nombre FROM `procesos` inner join proveedor on proveedor.id = procesos.id_maquinaria WHERE orden = 3 AND id_producto = '$id_producto');");
    $row3 = mysqli_fetch_row($consultar3);

    $hip = $hf3;
    
    $time = new DateTime($hip);
    $time->add(new DateInterval('PT' . $t3 . 'M'));
    $hfp = $time->format('Y-m-d H:i');

    $hil = $hfp; 

    $time = new DateTime($hil);
    $time->add(new DateInterval('PT' . $lp . 'M'));
    $hfl = $time->format('Y-m-d H:i');

    $cod = $codigo." Producto : ".$producto." Maquinaria : ".$m3;

    if ($row3[0]=="1") 
    {
       //Terciario
        $insertar5 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hip', 
            '$hfp',  
            '#0071c5',
            '1',
            '1')";

        $query5 = mysqli_query($con, $insertar5);
        //limpieza terciario
        $insertar6 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hil', 
            '$hfl',  
            '#40E0D0',
            '1',
            '2')";

        $query6= mysqli_query($con, $insertar6);
    }

    $consultar4=$con->query("SELECT EXISTS (SELECT proveedor.nombre FROM `procesos` inner join proveedor on proveedor.id = procesos.id_maquinaria WHERE orden = 4 AND id_producto = '$id_producto');");
    $row4 = mysqli_fetch_row($consultar4);

    $hip = $hf4;
    
    $time = new DateTime($hip);
    $time->add(new DateInterval('PT' . $t4 . 'M'));
    $hfp = $time->format('Y-m-d H:i');

    $hil = $hfp; 

    $time = new DateTime($hil);
    $time->add(new DateInterval('PT' . $lp . 'M'));
    $hfl = $time->format('Y-m-d H:i');

    $cod = $codigo." Producto : ".$producto." Maquinaria : ".$m4;

    if ($row4[0]=="1") 
    {
        //Surtidora
        $insertar7 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hip', 
            '$hfp',  
            '#0071c5',
            '1',
            '1')";

        $query7 = mysqli_query($con, $insertar7);
        //limpieza surtidora
        $insertar8 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hil', 
            '$hfl',  
            '#40E0D0',
            '2',
            '1')";
    }

    $consultar5 = $con->query("SELECT EXISTS (SELECT proveedor.nombre FROM `procesos` inner join proveedor on proveedor.id = procesos.id_maquinaria WHERE orden = 5 AND id_producto = '$id_producto');");
    $row5 = mysqli_fetch_row($consultar5);

    $hip = $hf5;
    
    $time = new DateTime($hip);
    $time->add(new DateInterval('PT' . $t5 . 'M'));
    $hfp = $time->format('Y-m-d H:i');

    $hil = $hfp; 

    $time = new DateTime($hil);
    $time->add(new DateInterval('PT' . $lp . 'M'));
    $hfl = $time->format('Y-m-d H:i');

    $cod = $codigo." Producto : ".$producto." Maquinaria : ".$m5;

    if ($row5[0]=="1") 
    {
        $query8 = mysqli_query($con, $insertar8);
        //Mezcladora
        $insertar9 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hip', 
            '$hfp',  
            '#0071c5',
            '1',
            '1')";

        $query9 = mysqli_query($con, $insertar9);
        //limpieza mezcladora
        $insertar10 = "INSERT INTO events(title, start, end, color, id_proceso, tipo) values (
            '$cod', 
            '$hil', 
            '$hfl',  
            '#40E0D0',
            '2',
            '1')";
        $query10 = mysqli_query($con, $insertar10);
    }

    
    //Pedidos
    $insertar11 = "INSERT INTO pedidos (codigo, id_producto, fecha_creacion, fecha_entrega) VALUES(
        '$codigo', 
        '$id_producto', 
        '$fecha_creacion',
        '$fecha_entrega')";
    
    $query11= mysqli_query($con, $insertar11);
    
    if ($query11) 
    {
        header("location: /tienda/pedidos");
        exit();
    }
    else 
    {

    }
}
?>

