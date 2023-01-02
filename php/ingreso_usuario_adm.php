<?php
    include 'conexion.php';
    
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $passen = sha1($password);
    $conn = OpenCon();
    //validaciones usuario
    if((strlen($usuario)>5 &&  strlen($usuario)<51)){
        $validar = true;
    }else{
        //echo $usuario." usuario Fallo <br>";
        header('Location:' . getenv('HTTP_REFERER'));
    }
    //validacion password
    if((strlen($password)>5 &&  strlen($password)<9)){
        $validar = true;
    }else{
        //echo $password." password Fallo <br>";
        header('Location:' . getenv('HTTP_REFERER'));
    }
    //Checa si ya existe alguno de estos campos unicos 
    $sql = "SELECT * FROM  usuarios where usuario='$usuario' AND pass='$passen' AND rol != 1";
    $result = $conn->query($sql);//anotacion optimizar consulta

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['usuarioid']=$row['usuarioid'];
        $_SESSION['usuario']=$usuario;
        $_SESSION['rol']=$row['rol'];
        CloseCon($conn);
        echo "Has ingresado correctamente a administracion";
    } else {
        CloseCon($conn);
        header('Location:' . getenv('HTTP_REFERER'));
    }
?>