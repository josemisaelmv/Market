<?php
    include 'conexion.php';
    $codigo = $_POST["codigo"];
    $nombre = $_POST["nombre"];
    $categoria = intval($_POST["categoria"]);
    $talla = intval($_POST["talla"]);
    $color = intval($_POST["color"]);
    $precio_original = $_POST["precio_original"];
    $precio_venta = $_POST["precio_venta"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $estado = true;
    $fecha_cambios = date('Y-m-d');
    $fecha_registro =  date('Y-m-d');
    $data['valido'] = true;                                     // default que si registro
    $data['mensaje'] = 'El registro se ha realizado con exito'; // default que si registro
    //$data['id'] = 1;// este id se retornara para que sepa en que carpeta se guardaran las imagenes
    $validar = false;

    $conn = OpenCon();
    //Checa si ya el articulo
    $sql = "SELECT articuloid FROM  articulos where codigo='$codigo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        CloseCon($conn);
        $data['valido'] = false;
        $data['mensaje'] = 'El artículo con el código '.$codigo.' ya se encuentra registrado';
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
            $sql = "INSERT INTO articulos(codigo,nombreart,categoriafk,estado,precio_original,precio_venta,cantidad,descripcion,talla,color,fecha_cambios,fecha_registro) 
            VALUES ('$codigo','$nombre','$categoria','$estado','$precio_original','$precio_venta','$cantidad','$descripcion','$talla','$color','$fecha_cambios','$fecha_registro')";
            if ($conn->query($sql) === TRUE) {
                $data['id'] = $conn->insert_id; //Obtenemos el id para posteriormente crear la carpeta en la que se guardaran las imagenes
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