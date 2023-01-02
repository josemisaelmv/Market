<?php 
    session_start();
    if(empty($_SESSION['lista'])){
        echo '0';
    }else{
        $json = array();
        $lista = $_SESSION['lista'];
        
        for($i=0;$i<count($lista); $i++){
            $json[$i][]= $lista[$i]['articuloid'];
            $nombre= "<a href='vista_articulo.php?id=".$lista[$i]['articuloid']."'>".$lista[$i]['nombreart']."</a>";
            $json[$i][]= $nombre;
            //$json[$i][]= $lista[$i]['nombreart'];
            //$imagen ="<img width='12%' height='12%' src='img/ropa/".$lista[$i]['articuloid']."/0.jpg'>";
            $imagen ="<div class='mx-2'><img width='30%' height='40%'src='img/ropa/".$lista[$i]['articuloid']."/0.jpg'></div>";
            $json[$i][]= $imagen;
            $cantidad ="<input type='number' min='1' step='1' pattern='\d+  ' class='form-control' onchange='cantidad_articulo(".$lista[$i]['articuloid'].")' value='".$lista[$i]['cantidad']."' id='cantidad_".$lista[$i]['articuloid']."'>";
            $json[$i][]= $cantidad;
            //$json[$i][]= $lista[$i]['cantidad'];
            $json[$i][]= $lista[$i]['precio_venta'];
            $eliminar ="<button type='button' class='btn btn-danger' onclick='eliminar_articulo(".$lista[$i]['articuloid'].")'><i class='bi bi-trash'></i></button>";
            $json[$i][]= $eliminar;
            $json[$i][]= $lista[$i]['cantidad'];

        }
        
        echo json_encode($json);
        
    }
    
?>