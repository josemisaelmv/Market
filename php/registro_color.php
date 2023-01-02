<?php
    include 'conexion.php';
    $color = $_POST["color"];
    $data['valido'] = true;                                     // default que si registro
    $data['mensaje'] = 'El registro se ha realizado con exito'; // default que si registro
    $conn = OpenCon();
    //Checa si ya el color
    $sql = "SELECT * FROM  colores where nombrecolor='$color'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'El color '.$color.' ya se encuentra registrado';
        echo json_encode($data);
        exit;
    }else{
        $sql = "INSERT INTO colores(nombrecolor) VALUES ('$color')";
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