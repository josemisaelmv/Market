<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $conn = OpenCon();
    //Checa si existe el articulo
    $sql = "SELECT * FROM  articulos where articuloid='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data['valido'] = true;
        $data['mensaje'] = 'Artículo encontrado con exito';
        $row = mysqli_fetch_assoc($result);
        $data['id']=$id;
        $data['estado'] = $row['estado'];
        $data['codigo'] = $row['codigo'];
        $data['nombre'] = $row['nombreart'];
        $data['categoria'] = $row['categoriafk'];
        $data['talla'] = $row['talla'];
        $data['color'] = $row['color'];
        $data['precio_original'] = $row['precio_original'];
        $data['precio_venta'] = $row['precio_venta'];
        $data['cantidad'] = $row['cantidad'];
        $data['descripcion'] = $row['descripcion'];
        CloseCon($conn);
         echo json_encode($data);
        // die();
        exit;
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No exite el artículo con id: '.$id;
        echo json_encode($data);
        exit;
    }
?>