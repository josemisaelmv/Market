<?php
    include 'conexion.php';

    session_start();
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $passen = sha1($password);
    $conn = OpenCon();
    //validaciones usuario
    if((strlen($usuario)>5 &&  strlen($usuario)<51)){
        $validar = true;
    }else{
        //retornar que usuario es invalido 0
        echo "0";
        exit;
        //header('Location:' . getenv('HTTP_REFERER'));
    }
    //validacion password
    if((strlen($password)>5 &&  strlen($password)<9)){
        $validar = true;
    }else{
        //retornar que pass es invalido 1
        echo "1";
        exit;
        //header('Location:' . getenv('HTTP_REFERER'));
    }
    //Checa si ya existe alguno de estos campos unicos 
    $sql = "SELECT * FROM  usuarios where usuario='$usuario' AND pass='$passen'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $row = mysqli_fetch_array($result);
        $_SESSION['usuarioid']=$row['usuarioid'];
        $_SESSION['usuario']=$usuario;
        $_SESSION['rol']=$row['rol'];
        if($row['rol']==1){
            //redirigir a inicio 2
            echo "2";
            exit;
            //header('Location: ../inicio.php' );
        }else{
            //redirigir a menuadm 3
            echo "3";
            exit;
            //header('Location: ../menu_adm.php' );
        }
    } else {
        CloseCon($conn);
        //retornar que el usuario o pass son invalidos 4
        echo "4";
        exit;
        //header('Location: ../ingreso.php');
    }

    
?>