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
<div class="row">
    <div class="col-2"></div>
    <div class="col-8 text-center align-self-center">
        <h1>Artículos</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(0)" type="button">Artículos</button>
        </div>
        <h1>Ordenes</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(1)" type="button">Ordenes</button>
        </div>
        <?php
        if($rol==3){
        ?>
        <h1>Usuarios</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(2)" type="button">Usuarios</button>
        </div>
        <?php
        }
        ?>
        <h1>Reportes</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(3)" type="button">Reportes</button>
        </div>
        <h1>Filtros</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(4)" type="button">Filtros</button>
        </div>
    </div>
    <div class="col-2"></div>   
</div>
<script>
    function seleccion(seleccion){
        switch(seleccion){
            case 0:
                $("#menu").load('menu_articulos.php');
            break;
            case 1:
                $("#menu").load('menu_ordenes.php');
            break;
            case 2:
                $("#menu").load('menu_usuarios.php');
            break;
            case 3:
                $("#menu").load('menu_reportes.php');
            break;
            case 4:
                $("#menu").load('menu_filtros.php');
            break;
        }
    }
</script>