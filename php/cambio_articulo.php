<?php
    include 'conexion.php';
    $id = $_POST["id"];
    $estado = $_POST["estado"];
    $codigo = $_POST["codigo"];
    $nombre = $_POST["nombre"];
    $categoria = $_POST["categoria"];
    $talla = $_POST["talla"];
    $color = $_POST["color"];
    $precio_original = $_POST["precio_original"];
    $precio_venta = $_POST["precio_venta"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $fecha_cambios = date('Y-m-d');

    $data['valido'] = true;                                                 // default que si cambio
    $data['mensaje'] = 'El cambio de registro se ha realizado con exito';   // default que si cambio
    $validar = false;

    $conn = OpenCon();
    //Checa si existe el articulo
    $sql = "SELECT articuloid FROM  articulos where articuloid='$id'";
    $result = $conn->query($sql);

    if (($result->num_rows > 0)==false) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'El artículo con el id '.$id.' no existe';
        echo json_encode($data);
        exit;
    }else{
        //validacion color
        //Checa si ya existe la talla seleccionada
        $sql = "SELECT * FROM  colores where colorid='$color'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $validar=true;
        }
        else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo color es invalido';
            echo json_encode($data);
            exit;
        }

        //validacion talla
        //Checa si ya existe la talla seleccionada
        $sql = "SELECT * FROM  tallas where tallaid='$talla'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $validar=true;
        }
        else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo talla es invalido';
            echo json_encode($data);
            exit;
        }

        //validacion categoria
        //Checa si ya existe la categoria seleccionada
        $sql = "SELECT * FROM  categorias where categoriaid='$categoria'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $validar=true;
        }
        else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo categoria es invalido';
            echo json_encode($data);
            exit;
        }
        //validacion estado
        if($estado == "1" || $estado == "0"){
            $validar=true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo estado es invalido';
            echo json_encode($data);
            exit;
        }
        //validacion codigo
        if((strlen($codigo)>0 &&  strlen($codigo)<51)){
            $validar=true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo codigo es invalido';
            echo json_encode($data);
            exit;
        }

        //validacion nombre
        if((strlen($nombre)>0 &&  strlen($nombre)<101)){
            $validar=true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo nombre es invalido';
            echo json_encode($data);
            exit;
        }

        //validacion descripcion
        if((strlen($descripcion)>0 &&  strlen($descripcion)<301)){
            $validar=true;
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo descripcion es invalido';
            echo json_encode($data);
            exit;
        }

        
        //validaciones precios
        if(is_numeric($precio_original) && is_numeric($precio_venta)){
            $precio_or = floatval($precio_original);
            $precio_vent = floatval($precio_venta);
            
            if($precio_or<$precio_vent && $precio_vent<100000){
                $validar=true;
            }else{
                CloseCon($conn);
                $data['valido'] = false;
                $data['mensaje'] = 'Campos Venta es invalido';
                echo json_encode($data);
                exit;
            }
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Campo Venta es invalido';
            echo json_encode($data);
            exit;
        }

        //validaciones cantidad
        if(is_numeric($cantidad)){
            $cant = floatval($cantidad);
            if($cant>0){
                $validar=true;
            }else{
                //CloseCon($conn);
                $data['valido'] = false;
                $data['mensaje'] = 'Campo cantidad es invalido';
                echo json_encode($data);
                exit;
            }
        }else{
            CloseCon($conn);
            $data['valido'] = false;
            $data['mensaje'] = 'Cantidad invalida';
            echo json_encode($data);
            exit;
        }

        
        
        //Validar define que paso por todas las validaciones anteriores
        if($validar){
            $sql = "UPDATE articulos SET estado='$estado',codigo='$codigo',nombreart='$nombre',categoriafk='$categoria',talla='$talla',
            color='$color',precio_original='$precio_original',precio_venta='$precio_venta',cantidad='$cantidad',descripcion='$descripcion',
            fecha_cambios='$fecha_cambios' WHERE articuloid='$id'";
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