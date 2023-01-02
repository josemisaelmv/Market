<?php
    session_start();
    include 'conexion.php';
    $id = $_SESSION["usuarioid"];
    $usuario = $_POST["usuario"];
    $pass = $_POST["pass"];
    if(!empty($pass)){
        $passenc = sha1($_POST["pass"]);
    }
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $fecha = $_POST["fecha"];
    $correo = $_POST["correo"];

    $data['valido'] = true;                                                 // default que si cambio
    $data['mensaje'] = 'El cambio de registro se ha realizado con exito';   // default que si cambio
    $validar = false;
    $conn = OpenCon();

    $sql = "SELECT * FROM  usuarios where usuarioid='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //validaciones usuario
        if((strlen($usuario)>5 &&  strlen($usuario)<51)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validacion password
        if(!empty($pass)){
            if((strlen($pass)>5 &&  strlen($pass)<9)){
                $validar = true;
            }else{
                CloseCon($conn);
                $data['valido'] = false;
                $data['mensaje'] = 'Datos Invalidos';
                echo json_encode($data);
                exit;
            }
        }
        //validacion nombre
        if((strlen($nombres)>0 &&  strlen($nombres)<101)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validacion apellidos
        if((strlen($apellidos)>0 &&  strlen($apellidos)<101)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validacion telefono
        if((strlen($telefono)>9 &&  strlen($telefono)<15) && is_numeric($telefono)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validar email
        if((filter_var($correo, FILTER_VALIDATE_EMAIL)) && strlen($correo)<101){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validar fecha
        date_default_timezone_set("America/Chihuahua");
        $end = $fecha;
        $fecha_actual = strtotime(date("Y-m-d"));
        $fecha_nacimiento = strtotime($end);
        $initial = '1899-12-31';
        $fecha_valida = strtotime($initial);
        if(($fecha_actual > $fecha_nacimiento) && ($fecha_nacimiento>$fecha_valida)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos8';
            echo json_encode($data);
            exit;
        }
        //Validar define que paso por todas las validaciones anteriores
        if($validar){
            if(empty($pass)){
                $sql = "UPDATE usuarios SET 
                usuario='$usuario',nombres='$nombres',apellidos='$apellidos',telefono='$telefono',correo='$correo',
                fecha_nacimiento='$fecha' WHERE usuarioid='$id'";
            }else{
                $sql = "UPDATE usuarios SET 
                usuario='$usuario',pass='$pass',nombres='$nombres',apellidos='$apellidos',telefono='$telefono',correo='$correo',
                fecha_nacimiento='$fecha' WHERE usuarioid='$id'";
            }
            if ($conn->query($sql) === TRUE) {
                $_SESSION["usuario"] = $usuario;
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
    }else{
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'El Usuario con'.$id.'no existe';
        echo json_encode($data);
        exit;
    }





    
?>