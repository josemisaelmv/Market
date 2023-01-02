<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro</title>
        <script type="text/javascript" srce="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.6.0.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
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
                <div class="col-4 align-self-center text-center mt-3 mb-3">
                <form id="form_registro" class="needs-validation mt-2" novalidate>
                    <div>
                        <label for="usuario" class="form-label">Usuario</label>
                        <div class="input-group has-validation">
                        <span class="input-group-text" id="input-usuario">@</span>
                        <input type="text" name="usuario" onchange="checar_usuario(this.value)"class="form-control" id="usuario" aria-describedby="input-usuario" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un nombre de Usuario válido
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group has-validation">
                        <input type="password" name="password" onchange="checar_pass(this.value)"class="form-control" id="password" aria-describedby="input-password" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe una Contraseña válida
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="input-group has-validation">
                        <input type="text" name="nombre" onchange="checar_nombre(this.value)" class="form-control" id="nombre" aria-describedby="input-usuario" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Nombre válido
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="apellido" class="form-label">Apellidos</label>
                        <div class="input-group has-validation">
                        <input type="text" name="apellido" onchange="checar_apellido(this.value)" class="form-control" id="apellido" aria-describedby="input-apellido" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe Apellidos válidos
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <div class="input-group has-validation">
                        <input type="date" name="fecha" min="1900-01-01" max="<?php echo date("Y-m-d")?>"class="form-control" id="fecha_nacimiento" aria-describedby="input-fecha_nacimiento" required>
                        <div class="invalid-feedback">
                            Porfavor, introduce una fecha válida
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="telefono" class="form-label">Numero Telefónico</label>
                        <div class="input-group has-validation">
                        <input type="tel" name="telefono" onchange="checar_telefono(this.value)" class="form-control" id="telefono" aria-describedby="input-telefono" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Telefono válido
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-validation">
                        <input type="email" name="email" onchange="checar_correo(this.value)"class="form-control" id="email" aria-describedby="input-email" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Email válido
                        </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-block mt-3 mb-3">
                        <button class="btn btn-outline-secondary" type="submit">Registrar</button>
                        <a class="btn btn-outline-danger" href="/Market/index.php" type="button">Cancelar</a>
                    </div>
                </form>
                </div>
                <div class="col-4"></div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
<script type="text/javascript">
    $(document).ready(function() {
        $("#footer").load('footer.php');
        $("#header").load('header_limpio.php');
        (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()
    });
    $("#form_registro").on("submit",function(e){
		e.preventDefault();
        var form = $(this).parents("#form_registro");
        var usuario = $("#usuario").val();
        var pass = $("#password").val();
        var nombres = $("#nombre").val();
        var apellido = $("#apellido").val();
        var telefono = $("#telefono").val();
        var fecha = $("#fecha_nacimiento").val();
        var correo = $("#email").val();
		$.post('php/registro_usuario.php',
            {
                pass:pass,
                usuario:usuario,
                nombre:nombres,
                apellido:apellido,
                telefono:telefono,
                fecha:fecha,
                correo:correo
            },
        ).done(function(response) {
                var datos=JSON.parse(response);
                var mensaje = datos.mensaje;
                var valido = datos.valido;
                if(valido){
                    $("#form_registro")[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: mensaje
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje
                    })
                }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al Registrar el Usuario, contacta al administrador'
            })
        });
	});
    //Validación de usuario
    function checar_usuario(var_usuario){
        if(var_usuario.length>50 != var_usuario.length<6){
            Swal.fire({
            icon: 'error',
            title: 'El Usuario no debe ser mayor a 50 caracteres ni menor a 6',
            })
            $("#usuario").val("");
        }else{
            $.ajax({
                url : 'php/validar.php',
                data : { usuario : var_usuario },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                    if(data.status){
                        Swal.fire({
                        icon: 'info',
                        title: 'Usuario ya registrado'
                        })
                        $("#usuario").val("");
                    }
                }
            });
        }
        
    }
    //Validación de password
    function checar_pass(var_pass){
        if(var_pass.length>8 != var_pass.length<6){
            Swal.fire({
            icon: 'error',
            title: 'El Password no debe ser mayor a 8 caracteres ni menor a 6',
            })
            $("#password").val("");
        }
    }
    //Validación de nombre
    function checar_nombre(var_nombre){
        if(var_nombre.length>100){
            Swal.fire({
            icon: 'error',
            title: 'El Nombre no debe ser mayor a 100 caracteres',
            })
            $("#nombre").val("");
        }
    }
    //Validación de apellido
    function checar_apellido(var_apellido){
        if(var_apellido.length>100){
            Swal.fire({
            icon: 'error',
            title: 'El Apellido no debe ser mayor a 100 caracteres',
            })
            $("#apellido").val("");
        }
    }
    //Validación de telefono
    function checar_telefono(var_telefono){
        var check = isNaN(var_telefono)//valida que sea un numero
        if(var_telefono.length>14 != var_telefono.length<10 != check){
            Swal.fire({
            icon: 'error',
            title: 'El Telefono no debe ser mayor a 14 digitos ni menor a 10 y debe ser numérico',
            })
            $("#telefono").val("");
        }else{
            $.ajax({
                url : 'php/validar.php',
                data : { telefono : var_telefono },
                type : 'POST',
                dataType : 'json',
                success : function(data) {
                    if(data.status){
                        Swal.fire({
                        icon: 'info',
                        title: 'Telefono ya registrado'
                        })
                        $("#telefono").val("");
                    }
                }
            });
        }
        
    }
    //Validación de correo
    function checar_correo(var_correo){
        $.ajax({
            url : 'php/validar.php',
            data : { email : var_correo },
            type : 'POST',
            dataType : 'json',
            success : function(data) {
                if(data.status){
                    Swal.fire({
                    icon: 'info',
                    title: 'Email ya registrado'
                    })
                    $("#email").val("");
                }
            }
        });
    }
</script>
</html>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    
</script>
