<?php
    include 'conexion.php';
    session_start();
    $conn = OpenCon();
    $id = $_POST['id'];
    $usuario = $_SESSION['usuario'];
    $usuarioid = $_SESSION['usuarioid'];
    $cantidad_ingresada = $_POST['cantidad'];
    $envio = $_POST['envio'];
    date_default_timezone_set("America/Chihuahua");
    $fecha = date('Y-m-d H:i:s');
    //
    $sql = "SELECT * FROM  articulos WHERE articuloid='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 
    if(empty($cantidad_ingresada)){
        $cantidad_ingresada=1;
    }else if($cantidad_ingresada>$row['cantidad']){
        $cantidad_ingresada=1;
    }
    $nombre= $row['nombreart'];
    $precio= $row['precio_venta'];
    //
    $subtotal = 0;
    $json = array();
    $subtotal = $subtotal + ($cantidad_ingresada * $precio);
    $envio_precio=0;
    switch($envio){
        case 0:
            $envio_precio = 89;
        break;
        case 1:
            $envio_precio = 119;
        break;
        default:
            $envio_precio = 89;
        break;
    }


    $conn->autocommit(false);
    try {
        $ordenid=0;
        // insertar orden
        $sql ="INSERT INTO orden(envio,subtotal,usuarioid,fecha) 
        VALUES ('$envio_precio','$subtotal','$usuarioid','$fecha')";
        if ($conn->query($sql) === TRUE) {
            $ordenid = mysqli_insert_id($conn);
        } else {
            $json['validar'] = '0';
            echo json_encode($json);
            //echo 'No se inserto orden';
            $conn->rollback();
            exit();
        }
        //insertar en ordenarticulos y actulizar la cantidad de articulo
        //checamos que la cantidad de articulos sea valida
        $sql = "SELECT * FROM  articulos WHERE articuloid='$id'";//AND cantidad>='$cantidad'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        $cantidad_articulos=$row['cantidad'];
        if($cantidad_articulos>=$cantidad_ingresada){
        } else {
            $json['validar'] = '1';
            $json['nombre'] = $nombre;
            $json['cantidad'] = $cantidad_articulos;
            echo json_encode($json);
            //echo 'No habia cantidad suficiente en '.$articulo;
            $conn->rollback();
            exit();
        }

        $cantidad_articulos = $cantidad_articulos-$cantidad_ingresada;
        if($cantidad_articulos>=0){
            $sql = "UPDATE articulos SET cantidad='$cantidad_articulos',
            fecha_cambios='$fecha' WHERE articuloid='$id'";
            if ($conn->query($sql) === TRUE) {

            } else {
                $json['validar'] = '3';
                $json['nombre'] = $nombre;
                echo json_encode($json);
                $conn->rollback();
                exit();
            }
        } else {
            $json['validar'] = '2';
            $json['nombre'] = $nombre;
            echo json_encode($json);
            $conn->rollback();
            exit();
        }
        
        //Se insertan los articulos a la tabla que lleva el conteo de articulos de orden
        $sql = "INSERT INTO orden_articulos(ordenid,articuloid,cantidad,precio)
        VALUES ('$ordenid','$id','$cantidad_ingresada','$precio')";
        if ($conn->query($sql) === TRUE) {

        } else {
            $json['validar'] = '4';
            $json['nombre'] = $nombre;
            $json['falla'] = $ordenid;
            echo json_encode($json);
            $conn->rollback();
            exit();
        }
        $conn->commit();
        $json['validar'] = '6';
        echo json_encode($json);
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $json['validar'] = '5';
        echo json_encode($json);
    }
?>