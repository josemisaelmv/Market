<?php 
    include 'conexion.php';
    session_start();
    $conn = OpenCon();
    $id = $_POST["id"];
    $cantidad_ingresada = $_POST["cantidad"];
    $sql = "SELECT * FROM  articulos WHERE articuloid='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 
    if(empty($cantidad_ingresada)){
        $cantidad_ingresada=1;
    }else if($cantidad_ingresada>$row['cantidad']){
        $cantidad_ingresada=1;
    }
    if(empty($_SESSION['lista'])){
        $_SESSION['lista']= array();    
    }

    

    
    //Checa si ya el articulo
    $sql = "SELECT * FROM  articulos WHERE articuloid='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();        
        $prueba = search($_SESSION['lista'], 'articuloid', $id);
        $respuesta= array(); 
        if ($prueba!= null) {
            $respuesta= array(); 
            $respuesta['cantidad'] = count($_SESSION['lista']);
            $respuesta['valido'] = '0';
        }else{
            $row_pushed= array(); 
            $row_pushed['articuloid']= $row['articuloid'];
            $row_pushed['nombreart']= $row['nombreart'];
            $row_pushed['cantidad']= $cantidad_ingresada;
            $row_pushed['precio_venta']= $row['precio_venta'];
            array_push( $_SESSION['lista'], $row_pushed);
            $respuesta['cantidad'] = count($_SESSION['lista']);
            $respuesta['valido'] = '1';
            $cantidad = count($_SESSION['lista']);
        }
        //$cantidad = count($_SESSION['lista']);
        //echo $cantidad;
        echo json_encode($respuesta);

        CloseCon($conn);
        exit;
    }else{
        $articulos = count($_SESSION['lista']); // validar que retorne el numero o 0
        echo $articulos;
    }
    //funcion para buscar un un dato en un arreglo
    function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, search($subarray, $key, $value));
            }
        }

        return $results;
    }

?>