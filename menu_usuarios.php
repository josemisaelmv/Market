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
    if($rol==2){
        header("Location: menu_adm.php");
    }
?>
<div class="row">
    <div class="col-12">
        <div class="mb-2">
            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal_registro">
                Registrar Usuario
            </button>
            <button type="button" id="cambiar"class="btn btn-outline-warning me-2">
                Cambiar Usuarios
            </button>
        </div>
        <div class="overflow-auto"style="width:100%; height:100%;">
            <table id="tabla_usuarios" class="table table-striped" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Fecha Nacimiento</th>
                        <th>Fecha Registro</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Fecha Nacimiento</th>
                        <th>Fecha Registro</th>
                        <th>Rol</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Modal_registro" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Registro de Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_registro_usuarios" class="needs-validation" novalidate>
            <div class="modal-body">
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
                        <input type="password" name="password" onchange="checar_pass(this.value)"class="form-control" id="password">
                        <div class="invalid-feedback">
                            Porfavor, escribe un Password válido
                        </div>
                    </div>
                </div>
                <div>
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group has-validation">
                        <input type="text" name="nombre" onchange="checar_nombre(this.value)" class="form-control" id="nombre" aria-describedby="input-nombre" required>
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
                <div>
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" id="rol" class="form-select" aria-label=""></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Cambios-->
<div class="modal fade" id="Modal_cambios" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Cambio Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cambios_usuario" class="needs-validation" novalidate>
            <div class="modal-body">
            <input type="hidden" id="idc">
                <div>
                    <label for="usuarioc" class="form-label">Usuario</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="input-usuarioc">@</span>
                        <input type="text" name="usuarioc" onchange="checar_usuario(this.value)"class="form-control" id="usuarioc" aria-describedby="input-usuarioc" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un nombre de Usuario válido
                        </div>
                    </div>
                </div>
                <div>
                    <label for="passwordc" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="passwordc" onchange="checar_pass(this.value)"class="form-control" id="passwordc">
                    </div>
                </div>
                <div>
                    <label for="nombrec" class="form-label">Nombre</label>
                    <div class="input-group has-validation">
                        <input type="text" name="nombrec" onchange="checar_nombre(this.value)" class="form-control" id="nombrec" aria-describedby="input-nombre" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Nombre válido
                        </div>
                    </div>
                </div>
                <div>
                    <label for="apellidoc" class="form-label">Apellidos</label>
                    <div class="input-group has-validation">
                        <input type="text" name="apellidoc" onchange="checar_apellido(this.value)" class="form-control" id="apellidoc" aria-describedby="input-apellidoc" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe Apellidos válidos
                        </div>
                    </div>
                </div>
                <div>
                    <label for="fecha_nacimientoc" class="form-label">Fecha de Nacimiento</label>
                    <div class="input-group has-validation">
                        <input type="date" name="fechac" min="1900-01-01" max="<?php echo date("Y-m-d")?>"class="form-control" id="fecha_nacimientoc" aria-describedby="input-fecha_nacimientoc" required>
                        <div class="invalid-feedback">
                            Porfavor, introduce una fecha válida
                        </div>
                    </div>
                </div>
                <div>
                    <label for="telefonoc" class="form-label">Numero Telefónico</label>
                    <div class="input-group has-validation">
                        <input type="tel" name="telefonoc" onchange="checar_telefono(this.value)" class="form-control" id="telefonoc" aria-describedby="input-telefonoc" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Telefono válido
                        </div>
                    </div>
                </div>
                <div>
                    <label for="emailc" class="form-label">Email</label>
                    <div class="input-group has-validation">
                        <input type="email" name="emailc" onchange="checar_correo(this.value)"class="form-control" id="emailc" aria-describedby="input-emailc" required>
                        <div class="invalid-feedback">
                            Porfavor, escribe un Email válido
                        </div>
                    </div>
                </div>
                <div>
                    <label for="rolc" class="form-label">Rol</label>
                    <select name="rolc" id="rolc" class="form-select" aria-label=""></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //Cambia el valor de estado del input estado de cambios
        $('#estadoc').change(function() {
            var estado = $("#estadoc").val();
            if(estado == "1"){
                $("#estadoc").val("0");
            }else{
                $("#estadoc").val("1");
            }
        });
        //Obtiene el json para la crear la tabla de usuarios
        var tab = $("#tabla_usuarios").DataTable({
            "ajax": {
                "url": "php/tabla_usuarios.php",
                "dataSrc": function ( json ) {
                return json;
                }
            },
                pageLength : 5,
                lengthMenu: [[5, 10], [5, 10]]
        });

        //Seleccionar un registro
        $('#tabla_usuarios tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                tab.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        // setInterval( function () {
        //     tab.ajax.reload();
        // }, 30000 );

        $('#cambiar').click( function () {
            //Guarda el id que se va a cambiar.
            var valor = tab.row('.selected').data();
            //Valida si hay una seleccion
            if(valor === undefined){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No has seleccionado ningun registro'
                })
            }else{
                var id = valor[0];
                $.ajax({
                    url: "php/info_usuario.php",
                    method: "POST",
                    data: { id : id },
                    dataType: "JSON",
                    success: function(response){
                        console.log(response);
                        var mensaje = response.mensaje;
                        var valido = response.valido;
                        if(valido){
                            $("#idc").val(response.id);
                            // if(response.estado == "1"){
                            //     $('#estadoc').attr("checked","checked");
                            //     $('#estadoc').attr( "checked" )
                            //     $("#estadoc").val("1");
                            // }
                            // else{
                            //     $('#estadoc').removeAttr("checked");
                            //     $("#estadoc").val("0");
                            // }
                            $("#idc").val(response.id);
                            $("#usuarioc").val(response.usuario);
                            $("#nombrec").val(response.nombres);
                            $("#apellidoc").val(response.apellidos);
                            $("#telefonoc").val(response.telefono);
                            $("#fecha_nacimientoc").val(response.fecha_nacimiento);
                            $("#emailc").val(response.correo);
                            $("#rolc").val(response.rol);
                            $('#Modal_cambios').modal('show');
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: mensaje
                            })
                        }
                    }
                });
                
            }
        });
        //Muestra los roles
        $.ajax({
        url: 'php/rol.php',
        type: 'get',
        dataType: 'JSON',
        success: function(response){
            for(i=0; i<response.length; i++) {
                var nombre = response[i].nombrerol;
                var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                $("#rol").append('<option name="rol" id="rol" value="'+response[i].rolid+'">'+corregido+'</option>');
                $("#rolc").append('<option name="rol" id="rol" value="'+response[i].rolid+'">'+corregido+'</option>');

            }
        }
        });
    });
    $("#form_registro_usuarios").on("submit",function(e){
		e.preventDefault();
        var usuario = $("#usuario").val();
        var pass = $("#password").val();
        var nombres = $("#nombre").val();
        var apellidos = $("#apellido").val();
        var telefono = $("#telefono").val();
        var fecha = $("#fecha_nacimiento").val();
        var correo = $("#email").val();
        var rol = $("#rol").val();
		$.post('php/registro_usuario_adm.php',
            {
                pass:pass,
                usuario:usuario,
                nombres:nombres,
                apellidos:apellidos,
                telefono:telefono,
                fecha:fecha,
                correo:correo,
                rol:rol
            },
        ).done(function(response) {
                var datos=JSON.parse(response);
                var mensaje = datos.mensaje;
                var valido = datos.valido;
                if(valido){
                    $("#form_registro_usuarios")[0].reset();
                    $('#Modal_registro').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: mensaje
                    })
                    var tab = $("#tabla_usuarios").DataTable();
                    tab.ajax.reload();
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

    $("#cambios_usuario").on("submit",function(e){
		e.preventDefault();
        var id = $("#idc").val();
        var usuario = $("#usuarioc").val();
        var pass = $("#passwordc").val();
        var nombres = $("#nombrec").val();
        var apellidos = $("#apellidoc").val();
        var telefono = $("#telefonoc").val();
        var fecha = $("#fecha_nacimientoc").val();
        var correo = $("#emailc").val();
        var rol = $("#rolc").val();
		$.post('php/cambio_usuario.php',
            {
                id:id,
                pass:pass,
                usuario:usuario,
                nombres:nombres,
                apellidos:apellidos,
                telefono:telefono,
                fecha:fecha,
                correo:correo,
                rol:rol
            },
            function(response){
		    }
        ).done(function(response) {
                console.log('Cambio');
                console.log(response);
                var datos=JSON.parse(response);
                var mensaje = datos.mensaje;
                var valido = datos.valido;
                if(valido){
                    $("#cambios_usuario")[0].reset();
                    $('#Modal_cambios').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambio exitoso',
                        text: mensaje
                    })
                    var tab = $("#tabla_usuarios").DataTable();
                    tab.ajax.reload();
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
                text: 'Hubo un error al cambiar el artículo, contacta al administrador'
            })
        });
	});
    //Validar
    function checar_usuario(var_usuario){
        if(var_usuario.length>50 != var_usuario.length<6){
            Swal.fire({
            icon: 'error',
            title: 'El Usuario no debe ser mayor a 50 caracteres ni menor a 6',
            })
            $("#usuario").val("");
            $("#usuarioc").val("");
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
            $("#passwordc").val("");
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
            $("#nombrec").val("");
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
            $("#apellidoc").val("");
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
            $("#telefonoc").val("");
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
                        $("#telefonoc").val("");
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
                    $("#emailc").val("");
                }
            }
        });
    }
</script>