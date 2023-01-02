<?php
session_start();
$usuario = $_SESSION['usuario'];
    if(isset($usuario)){
        header("Location: inicio.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ingreso</title>
        <script type="text/javascript" srce="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.6.0.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div id="header"></div>
            <div class="row">
                <div class="col-4">
                </div>
                <div class="col-4 align-self-center text-center mt-5 mb-5">
                <form id="form-ingreso" class="needs-validation mt-2" novalidate>
                    <div>
                        <label for="usuario" class="form-label">Usuario</label>
                        <div class="input-group has-validation">
                        <span class="input-group-text" id="input-usuario">@</span>
                        <input type="text" name="usuario" min="6" max="50" class="form-control" id="usuario" aria-describedby="input-usuario" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un nombre de Usuario válido
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group has-validation">
                        <input type="password" name="password"  min="6" max="8" class="form-control" id="password" aria-describedby="input-password" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe una Contraseña válida
                        </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-block mt-3 mb-3">
                        <button class="btn btn-outline-success" type="submit">Ingresar</button>
                        <a class="btn btn-outline-danger" href="index.php" type="button">Cancelar</a>
                    </div>
                    <div>
                        <a href="registro.php">¿No te has registrado?</a>
                    </div>
                </form>
                </div>
                <div class="col-4"></div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function() {
        $("#footer").load('footer.php');
        $("#header").load('header_limpio.php');
    });
    $("#form-ingreso").on( "submit",function(event){
        event.preventDefault();
        var usuario = $("input[name=usuario]").val();
        var pass = $("input[name=password]").val();
        $.post('php/ingreso_usuario.php', {usuario:usuario, password:pass}, function(respuesta){
            switch(respuesta){
                case "0":
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Introduce un usuario válido'
                    });
                break;
                case "1":
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Introduce un password válido'
                    });
                break;
                case "2":
                    var url = "inicio.php";
                    $(location).attr('href',url);
                break;
                case "3":
                    var url = "menu_adm.php";
                    $(location).attr('href',url);
                break;
                case "4":
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario o Password no coinciden',
                        text: 'Introduce valores válidos'
                    });
                break;
            }
        });
    });
</script>