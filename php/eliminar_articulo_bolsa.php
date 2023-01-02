<?php

    session_start();
    $id = $_POST["id"];
    
    $prueba = search($_SESSION['lista'], 'articuloid', $id);
    $respuesta= array(); 
    if ($prueba!= null) {
        $i = 0;
        foreach($_SESSION['lista'] as $lista){
            if($lista['articuloid'] == $id){
                unset($_SESSION['lista'][$i]);
                //El siguiente algoritmo elimina los vacios de la lista y posteriormente los reordenamos
                $_SESSION['lista'] = array_filter($_SESSION['lista'], function($item){
                    $notEmpty=count($item) == count(array_filter(array_map('trim', $item)));
                    return $notEmpty;
                });
                sort($_SESSION['lista']);
            }
            $i++;
        }
        //unset($_SESSION['lista']['articuloid'][$id]);
        $respuesta['cantidad'] = count($_SESSION['lista']);
        $respuesta['valido'] = '0';
    }else{
        $respuesta['cantidad'] = count($_SESSION['lista']);
        $respuesta['valido'] = '1';
    }
    echo json_encode($respuesta);
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