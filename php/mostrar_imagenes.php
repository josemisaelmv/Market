<?php
//$id =$_POST["id"];
$data=array();
$folder="../img/ropa/mostrar/";//".$id;
$i=0;
try{
    
    if ($handler = opendir($folder)) {
        while (false !== ($file = readdir($handler))) {
                if(!($file=='.' || $file=='..' || $file=='.DS_Store')){
                    $data[$i]['imagen'] = $file;
                    $i++;
                }
                
        }
        closedir($handler);
    }else{
        $data[0]['valido'] = false;
        $data[0]['mensaje'] = 'Ha ocurrido un error al buscar las imagenes';
        echo json_encode($data);
        exit;
    }
    echo json_encode($data);
    exit;
}catch(Exception $e){
    $data[0]['valido'] = false;
    $data[0]['mensaje'] = 'Ha ocurrido un error al buscar las imagenes :'.$e;
    echo json_encode($data);
    exit;
}


//mostrar carrusel con imagenes, seleccionar si se desea eliminar o darles un orden;
?>