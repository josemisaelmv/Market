<?php
    include 'conexion.php';
    
    $usuario = $_POST["usuario"];
    $password = $_POST["pass"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellido"];
    $fecha = $_POST["fecha"];
    $telefono = $_POST["telefono"];
    $email = $_POST["correo"];
    $fecha_registro =  date('Y-m-d');
    $passen = sha1($password);
    $conn = OpenCon();
    //Checa si ya existe alguno de estos campos unicos 
    $sql = "SELECT usuarioid FROM  usuarios where usuario='$usuario' OR correo='$email' OR telefono='$telefono'";
    $result = $conn->query($sql);//anotacion optimizar consulta

    if ($result->num_rows > 0) {
        CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Usuario Previamente registrado';
            echo json_encode($data);
            exit;
    } else {
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
        if((strlen($password)>5 &&  strlen($password)<9)){
            $validar = true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //validacion nombre
        if((strlen($nombre)>0 &&  strlen($nombre)<101)){
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
        if((filter_var($email, FILTER_VALIDATE_EMAIL)) && strlen($email)<101){
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
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
        //Validar define que paso por todas las validaciones anteriores
        if($validar){
            $sql = "INSERT INTO usuarios(usuario,nombres,apellidos,telefono,pass,correo,fecha_nacimiento,fecha_registro,rol) 
            VALUES ('$usuario','$nombre','$apellidos','$telefono','$passen','$email','$fecha','$fecha_registro',1)";

            if ($conn->query($sql) === TRUE) {
                CloseCon($conn);
                $data['valido'] = true;
                $data['mensaje'] = 'Guardado Satisfactoriamente';
                echo json_encode($data);
                exit;
            } else {
                CloseCon($conn);
                $data['valido'] = false;
                $data['mensaje'] = 'Datos Invalidos';
                echo json_encode($data);
                exit;
            } 
        }
        else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Datos Invalidos';
            echo json_encode($data);
            exit;
        }
    }

    CloseCon($conn);
    
?>