<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $conn = OpenCon();
    //Checa si existe el usuario
    $sql = "SELECT * FROM  usuarios where usuarioid='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data['valido'] = true;
        $data['mensaje'] = 'Usuario encontrado con exito';
        $row = mysqli_fetch_assoc($result);
        $data['id']=$id;
        $data['usuario'] = $row['usuario'];
        $data['nombres'] = $row['nombres'];
        $data['apellidos'] = $row['apellidos'];
        $data['telefono'] = $row['telefono'];
        $data['correo'] = $row['correo'];
        $data['fecha_nacimiento'] = $row['fecha_nacimiento'];
        $data['fecha_registro'] = $row['fecha_registro'];
        $data['rol'] = $row['rol'];

        CloseCon($conn);
         echo json_encode($data);
        // die();
        exit;
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No exite el usuario con id: '.$id;
        echo json_encode($data);
        exit;
    }
?>