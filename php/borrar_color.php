<?php
    include 'conexion.php';
    $id = $_POST["id"];

    $data['valido'] = true;                                                 // default que si cambio
    $data['mensaje'] = 'Se borro el registro con exito';   // default que si cambio
    $validar = false;

    $conn = OpenCon();
    $sql = "SELECT * FROM  articulos where color='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'No es posible borrar este color, por que hay articulos que la necesitan';
        echo json_encode($data);
        exit;
    }
    //Checa si existe la categoria 
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
        $sql = "DELETE FROM colores WHERE colorid='$id'";
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