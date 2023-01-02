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
    <div class="col-4 text-center align-self-center">
        <div class="text-center align-self-center"><h1>Filtros</h1></div>
        <h1>Categorias</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(0)" type="button">Tabla Categorias</button>
        </div>
        <h1>Colores</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(1)" type="button">Tabla Colores</button>
        </div>
        <h1>Tallas</h1>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary" onclick="seleccion(2)" type="button">Tabla Tallas</button>
        </div>
    </div>
    <div class="col-8 text-center align-self-center" id="filtro1">
        <h3>Categorias</h3>
        <div class="text-start mb-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Modal_categoria">Registrar</button>
            <button type="button" class="btn btn-outline-warning" id="cambiar_categoria">Cambiar</button>
            <button type="button" class="btn btn-outline-danger" id="borrar_categoria">Borrar</button>
        </div>
        <table id="tabla_filtros_1" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-8 text-center align-self-center" id="filtro2">
        <h3>Colores</h3>
        <div class="text-start mb-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Modal_color">Registrar</button>
            <button type="button" class="btn btn-outline-warning" id="cambiar_color">Cambiar</button>
            <button type="button" class="btn btn-outline-danger" id="borrar_color">Borrar</button>
        </div>
        <table id="tabla_filtros_2" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-8 text-center align-self-center" id="filtro3">
        <h3>Tallas</h3>
        <div class="text-start mb-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Modal_talla">Registrar</button>
            <button type="button" class="btn btn-outline-warning" id="cambiar_talla">Cambiar</button>
            <button type="button" class="btn btn-outline-danger" id="borrar_talla">Borrar</button>
        </div>
        <table id="tabla_filtros_3" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- Modales de Cambio -->
<div class="modal fade" id="Modal_categoria_cambios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambios de Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="cambio_categoria">
      <div class="modal-body">
        <div>
            <input type="hidden" class="form-control" id="idcategoriac">
            <label for="categoriac" class="form-label">Ingresa el cambio en la categoria</label>
            <input type="text" class="form-control" id="categoriac">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit"class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="Modal_color_cambios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambios de Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="cambio_color">
      <div class="modal-body">
        <div>
            <input type="hidden" class="form-control" id="idcolorc">
            <label for="colorc" class="form-label">Ingresa el cambio de color</label>
            <input type="text" class="form-control" id="colorc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="Modal_talla_cambios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambios de Talla</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="cambio_talla">
      <div class="modal-body">
        <div>
            <input type="hidden" class="form-control" id="idtallac">
            <label for="tallac" class="form-label">Ingresa el cambio en talla</label>
            <input type="text" class="form-control" id="tallac">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modales de Registro -->
<div class="modal fade" id="Modal_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Categorias</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="registro_categoria">
      <div class="modal-body">
        <div>
            <label for="categoria" class="form-label">Ingresa un nueva categoria</label>
            <input type="text" class="form-control" id="categoria">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit"class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="Modal_color" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Colores</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="registro_color">
      <div class="modal-body">
        <div>
            <label for="color" class="form-label">Ingresa un nuevo color</label>
            <input type="text" class="form-control" id="color">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="Modal_talla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Tallas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="registro_talla">
      <div class="modal-body">
        <div>
            <label for="talla" class="form-label">Ingresa un nueva talla</label>
            <input type="text" class="form-control" id="talla">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    var tab1 = '';
    var tab2 = '';
    var tab3 = '';
$(document).ready(function() {
    tab1 = $("#tabla_filtros_1").DataTable({
        "ajax": {
            "url": "php/tabla_categorias.php",
            "dataSrc": function ( json ) {
            return json;
            }
        },
            pageLength : 5,
            lengthMenu: [[5], [5]]
    });
    tab2 = $("#tabla_filtros_2").DataTable({
        "ajax": {
            "url": "php/tabla_colores.php",
            "dataSrc": function ( json ) {
            return json;
            }
        },
            pageLength : 5,
            lengthMenu: [[5], [5]]
    });
    tab3 = $("#tabla_filtros_3").DataTable({
        "ajax": {
            "url": "php/tabla_tallas.php",
            "dataSrc": function ( json ) {
            return json;
            }
        },
            pageLength : 5,
            lengthMenu: [[5], [5]]
    });
    $("#filtro1").hide();
    $("#filtro2").hide();
    $("#filtro3").hide();
});
    //Seleccion de tabla de filtros
    function seleccion(seleccion){
        switch(seleccion){
            case 0:
                $("#filtro1").show();
                $("#filtro2").hide();
                $("#filtro3").hide();
            break;
            case 1:
                $("#filtro1").hide();
                $("#filtro2").show();
                $("#filtro3").hide();
            break;
            case 2:
                $("#filtro1").hide();
                $("#filtro2").hide();
                $("#filtro3").show();
            break;
        }
    }
    //Seleccion de filtro tabla 1
    $('#tabla_filtros_1 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tab1.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    //Seleccion de filtro tabla 2
    $('#tabla_filtros_2 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tab2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    //Seleccion de filtro tabla 3
    $('#tabla_filtros_3 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tab3.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    $("#registro_categoria").on("submit",function(e){
		e.preventDefault();
        var categoria = $("#categoria").val();
        if(categoria.length > 0){
        $.post('php/registro_categoria.php',
        {
            categoria:categoria
        }
        ).done(function(response) {
            var datos=JSON.parse(response);
            var mensaje = datos.mensaje;
            var valido = datos.valido;
            if(valido){
                $("#registro_categoria")[0].reset();
                $('#Modal_categoria').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: mensaje
                })
                $("#tabla_filtros_1").DataTable().ajax.reload();
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
                text: 'Hubo un error al registrar la categoria, contacta al administrador'
            })
        });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Nombre invalido'
            })
        }
		
	});
    $("#registro_color").on("submit",function(e){
		e.preventDefault();
        var color = $("#color").val();
		$.post('php/registro_color.php',
            {
                color:color
            }
        ).done(function(response) {
            var datos=JSON.parse(response);
            var mensaje = datos.mensaje;
            var valido = datos.valido;
            if(valido){
                $("#registro_color")[0].reset();
                $('#Modal_color').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: mensaje
                })
                $("#tabla_filtros_2").DataTable().ajax.reload();
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
                text: 'Hubo un error al registrar el color, contacta al administrador'
            })
        });
	});
    $("#registro_talla").on("submit",function(e){
		e.preventDefault();
        var talla = $("#talla").val();
		$.post('php/registro_talla.php',
            {
                talla:talla
            }
        ).done(function(response) {
            var datos=JSON.parse(response);
            var mensaje = datos.mensaje;
            var valido = datos.valido;
            if(valido){
                $("#registro_talla")[0].reset();
                $('#Modal_talla').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: mensaje
                })
                $("#tabla_filtros_3").DataTable().ajax.reload();
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
                text: 'Hubo un error al registrar la talla, contacta al administrador'
            })
        });
	});
    $('#cambiar_categoria').click( function () {
        //Guarda el id que se va a cambiar.
        var valor = tab1.row('.selected').data();
        //Valida si hay una seleccion
        if(valor === undefined){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No has seleccionado ningun registro'
            })
        }else{
            var id = valor[0];
            $('#Modal_categoria_cambios').modal('show');
            $.ajax({
                url: "php/info_categoria.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#idcategoriac").val(response.id);
                        $("#categoriac").val(response.categoria);
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
    $('#cambiar_color').click( function () {
        //Guarda el id que se va a cambiar.
        var valor = tab2.row('.selected').data();
        //Valida si hay una seleccion
        if(valor === undefined){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No has seleccionado ningun registro'
            })
        }else{
            var id = valor[0];
            $('#Modal_color_cambios').modal('show');
            $.ajax({
                url: "php/info_color.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#idcolorc").val(response.id);
                        $("#colorc").val(response.color);
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
    $('#cambiar_talla').click( function () {
        //Guarda el id que se va a cambiar.
        var valor = tab3.row('.selected').data();
        //Valida si hay una seleccion
        if(valor === undefined){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No has seleccionado ningun registro'
            })
        }else{
            var id = valor[0];
            $('#Modal_talla_cambios').modal('show');
            $.ajax({
                url: "php/info_talla.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#idtallac").val(response.id);
                        $("#tallac").val(response.talla);
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
    $("#cambio_categoria").on("submit",function(e){
		e.preventDefault();
        var id = $("#idcategoriac").val();
        var categoria = $("#categoriac").val();
        if(categoria.length>0){
            $.post('php/cambio_categoria.php',
            {
                id:id,
                categoria:categoria
            }
            ).done(function(response) {
                    console.log(response);
                    var datos=JSON.parse(response);
                    var mensaje = datos.mensaje;
                    var valido = datos.valido;
                    if(valido){
                        $("#cambio_categoria")[0].reset();
                        $('#Modal_categoria_cambios').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Cambio exitoso',
                            text: mensaje
                        })
                        tab1.ajax.reload();
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
                    text: 'Hubo un error al cambiar el registro, contacta al administrador'
                })
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Nombre invalido'
            })
        }
	});
    $("#cambio_color").on("submit",function(e){
		e.preventDefault();
        var id = $("#idcolorc").val();
        var color = $("#colorc").val();
        if(color.length>0){
            $.post('php/cambio_color.php',
            {
                id:id,
                color:color
            }
            ).done(function(response) {
                    console.log(response);
                    var datos=JSON.parse(response);
                    var mensaje = datos.mensaje;
                    var valido = datos.valido;
                    if(valido){
                        $("#cambio_color")[0].reset();
                        $('#Modal_color_cambios').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Cambio exitoso',
                            text: mensaje
                        })
                        tab2.ajax.reload();
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
                    text: 'Hubo un error al cambiar el registro, contacta al administrador'
                })
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Nombre invalido'
            })
        }
	});
    $("#cambio_talla").on("submit",function(e){
		e.preventDefault();
        var id = $("#idtallac").val();
        var talla = $("#tallac").val();
        if(talla.length>0){
            $.post('php/cambio_talla.php',
            {
                id:id,
                talla:talla
            }
            ).done(function(response) {
                    console.log(response);
                    var datos=JSON.parse(response);
                    var mensaje = datos.mensaje;
                    var valido = datos.valido;
                    if(valido){
                        $("#cambio_talla")[0].reset();
                        $('#Modal_talla_cambios').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Cambio exitoso',
                            text: mensaje
                        })
                        tab3.ajax.reload();
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
                    text: 'Hubo un error al cambiar el registro, contacta al administrador'
                })
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Nombre invalido'
            })
        }
	});
    $('#borrar_categoria').click( function () {
        //Guarda el id que se va a borrar.
        var valor = tab1.row('.selected').data();
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
                url: "php/borrar_categoria.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#tabla_filtros_1").DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Borrado',
                            text: mensaje
                        })
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
    $('#borrar_color').click( function () {
        //Guarda el id que se va a borrar.
        var valor = tab2.row('.selected').data();
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
                url: "php/borrar_color.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#tabla_filtros_2").DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Borrado',
                            text: mensaje
                        })
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
    $('#borrar_talla').click( function () {
        //Guarda el id que se va a borrar.
        var valor = tab2.row('.selected').data();
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
                url: "php/borrar_talla.php",
                method: "POST",
                data: { id : id },
                dataType: "JSON",
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(valido){
                        $("#tabla_filtros_3").DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Borrado',
                            text: mensaje
                        })
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
</script>