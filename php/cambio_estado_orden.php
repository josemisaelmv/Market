<?php
    include 'conexion.php';
    $id = $_POST["ordenid"];
    $estado = $_POST["ordenestadoid"];
    if(empty($estado)){
        $data['valido'] = false;
        $data['mensaje'] = 'No hay estado a cambiar';
        echo json_encode($data);
        exit;
    }
    $data['valido'] = true;                                                 // default que si cambio
    $data['mensaje'] = 'El cambio de estado se ha realizado con exito';   // default que si cambio

    $conn = OpenCon();
    //Checa si existe el articulo
    $sql = "SELECT * FROM  orden where ordenid='$id'";
    $result = $conn->query($sql);

    if (($result->num_rows > 0)==false) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'La orden con '.$id.' no existe';
        echo json_encode($data);
        exit;
    }else{
        $sql = "SELECT * FROM  orden where ordenid='$id' AND estado=4";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'La orden esta cancelada, no es posible cambiar su estado';
            echo json_encode($data);
            exit;
        }else{
            //Validar define que paso por todas las validaciones anteriores
            $sql = "UPDATE orden SET estado='$estado' WHERE ordenid='$id'";
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
    }
?>