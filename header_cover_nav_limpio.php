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
                <?php
                if($rol==2 || $rol==3){
                ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="menu_adm.php">Administración</a>
                </li>
                <?php
                }
                ?>
            </ul>
            <text>Usuario: <?php echo $usuario?></text>
            
            <span class="navbar-text">
                <a class="nav-link active" aria-current="page" href="php/salir.php">Salir</a>
            </span>
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
