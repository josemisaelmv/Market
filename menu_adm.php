<?php
    session_start();
    $usuario = $_SESSION['usuario'];
    $rol= $_SESSION['rol'];
    if(!isset($usuario)){
        header("Location: ingreso.php");
    }
    if($rol==1){
        header("Location: ingreso.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Admin</title>
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="DataTables/datatables.min.js" defer></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="DataTables/datatables.min.css">
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div id="header"></div>
            <div class="mt-5 mb-5"id="menu"></div>
            <div id="footer"></div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#header").load('header_menu_adm.php');
        $("#menu").load('menu_default.php'); //original
        //$("#menu").load('menu_articulos.php'); //mostrar el menu de articulos temporalmente
        //$("#menu").load('menu_filtros.php'); //mostrar el menu de filtros temporalmente
        $("#footer").load('footer.php');
    });
</script>