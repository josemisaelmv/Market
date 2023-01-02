<?php
    include 'conexion.php';
    $categoria = $_POST["categoria"];
    $data['valido'] = true;                                     // default que si registro
    $data['mensaje'] = 'El registro se ha realizado con exito'; // default que si registro
    $conn = OpenCon();
    if(empty($categoria)){
        $data['valido'] = false;
        $data['mensaje'] = 'Nombre invalido';
        echo json_encode($data);
        exit;
    }
    //Checa si ya existe la categoria
    $sql = "SELECT * FROM  categorias where nombrecat='$categoria'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'La categoria con el nombre '.$categoria.' ya se encuentra registrada';
        echo json_encode($data);
        exit;
    }else{
        //Validar define que paso por todas las validaciones anteriores
        $sql = "INSERT INTO categorias(nombrecat) VALUES ('$categoria')";
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