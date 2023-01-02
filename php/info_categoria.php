<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $conn = OpenCon();
    //Checa si existe el articulo
    $sql = "SELECT * FROM  categorias where categoriaid='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data['valido'] = true;
        $data['mensaje'] = 'Categoria encontrada con exito';
        $row = mysqli_fetch_assoc($result);
        $data['id']=$id;
        $data['categoria'] = $row['nombrecat'];
        CloseCon($conn);
        echo json_encode($data);
        // die();
        exit;
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No exite categoria con id: '.$id;
        echo json_encode($data);
        exit;
    }
?>