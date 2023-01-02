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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="inicio.php">
                <img src="img/logo.svg" alt="" height="30" width="30" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                </li>
            </ul>
            <div class="mx-4">
                <a class="nav-link active" aria-current="page"href="menu_adm.php">Administración</a>
            </div>
            <text>Usuario: <?php echo $usuario?></text>
            <span class="navbar-text">
                <a class="nav-link active" aria-current="page" href="php/salir.php">Salir</a>
            </span>
            </div>
        </div>
    </nav>
</div>