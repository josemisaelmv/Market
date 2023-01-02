<?php
    session_start();
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    for($i=0; $i<=Count($_SESSION['lista']); $i++){
        if($_SESSION['lista'][$i]['articuloid']== $id){
            $encontrado =$_SESSION['lista'][$i]['cantidad']=$cantidad;
        }
    }
?>