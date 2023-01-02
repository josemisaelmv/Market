<?php
    include "conexion.php";
    $usuario = $_POST["usuario"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $conn = OpenCon();
    try{
    //Checa si ya existe alguno de estos campos unicos 
    $sql = "SELECT usuarioid FROM  usuarios where usuario='$usuario' OR correo='$email' OR telefono='$telefono'";
    $result = $conn->query($sql);//anotacion optimizar consulta

    if ($result->num_rows > 0) {
        $data['status'] = true;
        echo json_encode($data);
    } else {
        $data['status'] = false;
        echo json_encode($data);
    }
    CloseCon($conn);
    }catch(Exception $e){
        $data['status'] = "Error causado por excepcion: "+$e;
        echo json_encode($data);
    }
?>