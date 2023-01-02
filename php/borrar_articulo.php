<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $conn = OpenCon();
    //Checa si ya el articulo
    $sql = "SELECT articuloid FROM  articulos where articuloid='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM articulos WHERE articuloid='$id'";
        if ($conn->query($sql) === TRUE) {
            CloseCon($conn);
            $data['valido'] = true;
            $data['mensaje'] = 'Artículo borrado con exito';
            echo json_encode($data);
            die();
            exit;
        } else {
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Error en SQL';
            echo json_encode($data);
            die();
            exit;
        }
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No exite el artículo con id: '.$id;
        echo json_encode($data);
        exit;
    }
?>


