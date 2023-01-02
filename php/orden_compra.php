<?php
    include 'conexion.php';
    session_start();
    $conn = OpenCon();
    $usuario = $_SESSION['usuario'];
    $usuarioid = $_SESSION['usuarioid'];
    $envio = $_POST['envio'];
    date_default_timezone_set("America/Chihuahua");
    $fecha = date('Y-m-d H:i:s');
    $lista = $_SESSION['lista'];
    $i=0;
    $subtotal = 0;
    $json = array();
    foreach($lista as $list){
        $cantidad = $list['cantidad'];
        $precio = $list['precio_venta'];
        $subtotal = $subtotal + ($cantidad * $precio);
        $i++;
    }
    //$_SESSION['lista'] = array();
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
        foreach($lista as $list){
            $articulo = $list['articuloid'];
            $cantidad = $list['cantidad'];
            $precio = $list['precio_venta'];
            //checamos que la cantidad de articulos sea valida
            $sql = "SELECT * FROM  articulos where articuloid='$articulo'";//AND cantidad>='$cantidad'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $cantidad_articulos=$row['cantidad'];
            if($cantidad_articulos>=$cantidad){
            //if ($result->num_rows > 0) {
            } else {
                $json['validar'] = '1';
                $json['nombre'] = $list['nombreart'];
                $json['cantidad'] = $row['cantidad'];
                echo json_encode($json);
                //echo 'No habia cantidad suficiente en '.$articulo;
                $conn->rollback();
                exit();
            }

            $cantidad_articulos = $cantidad_articulos-$cantidad;
            if($cantidad_articulos>=0){
                $sql = "UPDATE articulos SET cantidad='$cantidad_articulos',
                fecha_cambios='$fecha' WHERE articuloid='$articulo'";
                if ($conn->query($sql) === TRUE) {

                } else {
                    $json['validar'] = '3';
                    $json['nombre'] = $list['nombreart'];
                    echo json_encode($json);
                    $conn->rollback();
                    exit();
                }
            } else {
                $json['validar'] = '2';
                $json['nombre'] = $list['nombreart'];
                echo json_encode($json);
                $conn->rollback();
                exit();
            }
            
            //Se insertan los articulos a la tabla que lleva el conteo de articulos de orden
            $sql = "INSERT INTO orden_articulos(ordenid,articuloid,cantidad,precio)
            VALUES ('$ordenid','$articulo','$cantidad','$precio')";
            if ($conn->query($sql) === TRUE) {

            } else {
                $json['validar'] = '4';
                $json['nombre'] = $list['nombreart'];
                echo json_encode($json);
                $conn->rollback();
                exit();
            }
        }
        $conn->commit();
        $_SESSION['lista'] = array();
        $json['validar'] = '6';
        echo json_encode($json);
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $json['validar'] = '5';
        echo json_encode($json);
    }
?>