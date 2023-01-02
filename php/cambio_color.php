<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $color = $_POST["color"];

    $data['valido'] = true;                                                 // default que si cambio
    $data['mensaje'] = 'El cambio de registro se ha realizado con exito';   // default que si cambio
    $validar = false;

    $conn = OpenCon();
    if(empty($color)){
        $data['valido'] = false;
        $data['mensaje'] = 'Nombre invalido';
        echo json_encode($data);
        exit;
    }
    //Checa si existe el articulo
    $sql = "SELECT * FROM  colores where colorid='$id'";
    $result = $conn->query($sql);

    if (($result->num_rows > 0)==false) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'El color con el id '.$id.' no existe';
        echo json_encode($data);
        exit;
    }else{
        //Validar define que paso por todas las validaciones anteriores
        $sql = "UPDATE colores SET nombrecolor='$color' WHERE colorid='$id'";
        if ($conn->query($sql) === TRUE) {
            CloseCon($conn);
            echo json_encode($data);
            die();
            exit;
        } else {
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Error en SQL';
            echo json_encode($data);
            exit;
        } 
    }
?>