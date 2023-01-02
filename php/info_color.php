<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $conn = OpenCon();
    //Checa si existe el articulo
    $sql = "SELECT * FROM  colores where colorid='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data['valido'] = true;
        $data['mensaje'] = 'Categoria encontrada con exito';
        $row = mysqli_fetch_assoc($result);
        $data['id']=$id;
        $data['color'] = $row['nombrecolor'];
        CloseCon($conn);
        echo json_encode($data);
        // die();
        exit;
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No exite color con id: '.$id;
        echo json_encode($data);
        exit;
    }
?>