<?php
    include 'conexion.php';
    $conn = OpenCon();
    $data=array();
    $valido = true;
    $id = $_POST["idfolder"];
    //Checa si existe el articulo
    $sql = "SELECT * FROM  orden where ordenid='$id'";
    $result = $conn->query($sql);

    if (!($result->num_rows > 0)) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'La orden a la que quieres subir el comprobante no existe';
        echo json_encode($data);
        exit;
    }else{
        CloseCon($conn);        
        if (!empty($_FILES['inputimagenes']['name'])) {
            $allowImg = array('png','jpeg','jpg');
            $fileExnt = explode('.', $_FILES['inputimagenes']['name']);
            $size = $_FILES['inputimagenes']['size'];
            $error = $_FILES['inputimagenes']['error'];
            if($error == 0){
                if (in_array($fileExnt[1], $allowImg)) {
                    if ($size > 0) {
                        if($size < 2097152){
                        }
                        else{
                            $valido = false;
                        }
                    }else{
                        $valido = false;
                    }
                }else{
                    $valido = false;
                }
            }else{
                $valido = false;
            }
        }else{
            $valido = false;
        }
        //valido es la variable que dice que esta correcto el arreglo de imagenes
        if($valido){
            //crea la carpeta donde se guardaran las imagenes
            $path = '../img/orden/'.$id;
            unlink($path);
            mkdir($path, 0777, true);
            chmod($path, 0777);//posible a eliminar
            //aqui se guardaran despues de corroborar que pasaron todas las validaciones
                $fileExnt = explode('.', $_FILES['inputimagenes']['name']);
                $fileTmp = $_FILES['inputimagenes']['tmp_name'];
                $newFile = '0'. '.'. $fileExnt[1];
                $target_dir = $path.'/'.$newFile;
                if (move_uploaded_file($fileTmp, $target_dir)) {
                    $data['valido'] = true;
                    $data['mensaje'] = 'Guardada satisfactoriamente';
                    if($_FILES['inputimagenes']['type'] == "image/jpeg"){
                        $imagen_saliente = $path.'/0.jpg';
                        rename($target_dir, $imagen_saliente);
                    }
                    if($_FILES['inputimagenes']['type'] == "image/png"){
                        $imagen = imagecreatefrompng($target_dir);
                        $imagen_saliente = $path.'/0.jpg';
                        imagejpeg($imagen, $imagen_saliente, 100);
                        unlink($target_dir);
                    }
                }else{
                    $data['valido'] = false;
                    $data['mensaje'] = 'No se cargo la imagen';
                    echo json_encode($data);
                    exit;
                }
        }else{
            $data['valido'] = false;
            $data['mensaje'] = 'Hubo error al cargar la imagen';
            echo json_encode($data);
            exit;
        }
        echo json_encode($data);
        exit;
    }

?>