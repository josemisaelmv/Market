<?php
    include 'conexion.php';
    $talla = $_POST["talla"];
    $data['valido'] = true;                                     // default que si registro
    $data['mensaje'] = 'El registro se ha realizado con exito'; // default que si registro
    $conn = OpenCon();
    //Checa si ya existe la talla
    $sql = "SELECT * FROM  tallas where nombretalla='$talla'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'La talla '.$talla.' ya se encuentra registrada';
        echo json_encode($data);
        exit;
    }else{
        $sql = "INSERT INTO tallas(nombretalla) VALUES ('$talla')";
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