<?php
    session_start();
    $usuario = $_SESSION['usuario'];
    $rol= $_SESSION['rol'];
    if(!isset($usuario)){
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="barra_navegacion">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                    </li>
                </ul>
                <div class="mx-4" id="boton_bolsa">
                    <button type="button" class="btn btn-outline-warning position-relative" onclick="bolsa()">
                        <!-- <p class="text-end"><img class="rounded float-right" width="10%" height="10%" src="img/bolsa.ico"></p> -->
                        <i class="bi bi-bag"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="badge">
                            0
                            <!-- <span class="visually-hidden">Articulos por comprar</span> -->
                        </span>
                    </button>
                </div>
                <div class="dropdown">
                    <a class="btn btn-outline-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" onclick="ordenes()">Compras</a></li>   
                        <li><a class="dropdown-item" onclick="cambio_usuario()">Configuración Usuario</a></li>
                        <?php
                        if($rol==2 || $rol==3){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="menu_adm.php">Administración</a>
                        </li>
                        <?php
                        }
                        ?>    
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="php/salir.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="row">
    <div class="cover d-flex justify-content-center align-items-center flex-column">
    <h1>VERMAG</h1>
    <p>Dale estilo a tu vida</p>
    </div>
</div>
<script>
     $(document).ready(function() {
        $.ajax({
            url: 'php/tabla_bolsa.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                bolsa_cantidad_badge(response.length);
            }
        });
    });
    function bolsa_cantidad_badge(cantidad){
        $('#badge').empty();
        $('#badge').append(cantidad);
    }
    function bolsa(){
        $("#mostrar").empty();
        $("#mostrar").load('bolsa_articulos.php');
    }
    function ordenes(){
        var url = "compras.php";
        $(location).attr('href',url);
    }
    function cambio_usuario(){
        var url = "cambios_usuario.php";
        $(location).attr('href',url);
    }
</script>
<style>
    .cover {
        height: 200px;
        background-image: url("img/image.jpg");
        color: white;
        background-size: cover;
        background-position: center;
        background-color:rgba(0,0,0,.4);
        background-blend-mode:white;
    }
    .muestra{
        width: 18rem;
    }
</style>
