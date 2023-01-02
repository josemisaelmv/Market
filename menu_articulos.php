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
    <div class="col-12">
        <div class="mb-2">
            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#Modal_registro">
                Registrar Artículo
            </button>
            <button type="button" id="cambiar"class="btn btn-outline-warning me-2">
                Cambiar Artículo
            </button>
            <button type="button" id="borrar" class="btn btn-outline-danger">
                Borrar Artículo
            </button>
        </div>
        <div class="overflow-auto"style="width:100%; height:100%;">
            <table id="tabla_articulos" class="table table-striped" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Precio Original</th>
                        <th>Precio Venta</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Fecha Cambios</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Precio Original</th>
                        <th>Precio Venta</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Fecha Cambios</th>
                        <th>Fecha Registro</th>
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
                <h5 class="modal-title" id="ModalLabel">Registro de Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-registro-articulos" class="mt-2">
                <div class="modal-body">
                    <div>
                        <label for="codigo" class="form-label">Código</label>
                        <div class="input-group">
                            <input type="text" name="codigo" class="form-control" id="codigo" aria-describedby="input-codigo" required>
                        </div>
                    </div>
                    <div>
                        <label for="nombre" class="form-label">Nombre de Artículo</label>
                        <div class="input-group">
                            <input type="text" name="nombre" class="form-control" id="nombre" aria-describedby="input-nombre" required>
                        </div>
                    </div>
                    <div>
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="talla" class="form-label">Talla</label>
                        <select name="talla" id="talla" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="color" class="form-label">Color</label>
                        <select name="color" id="color" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="precio_original" class="form-label">Precio Original</label>
                        <div class="input-group">
                            <input step="any" type="number" name="precio_original" class="form-control" id="precio_original" aria-describedby="input-precio-original" required>
                        </div>
                    </div>
                    <div>
                        <label for="precio_venta" class="form-label">Precio Venta</label>
                        <div class="input-group">
                            <input type="number" step="any" name="precio_venta" class="form-control" id="precio_venta" aria-describedby="input-precio-venta" required>
                        </div>
                    </div>
                    <div>
                        <label for="cantidad" class="form-label">Cantidad de Artículos</label>
                        <div class="input-group ">
                            <input type="number" name="cantidad" class="form-control" id="cantidad" aria-describedby="input-cantidad" required>
                        </div>
                    </div>
                    <div>
                        <label for="descripcion" class="form-label">Descripción de Artículo</label>
                        <div class="input-group ">
                            <textarea type="text" name="descripcion" class="form-control" id="descripcion" aria-describedby="input-descripcion" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit">Registrar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
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
                <h5 class="modal-title" id="ModalLabel">Cambio de Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-cambio-articulos" class="mt-2">
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="idc" name="idc">
                    </div>
                    <div class="form-check form-switch">
                        <label for="estadoc" class="form-label">Estado</label>
                        <input name="estadoc" id="estadoc" class="form-check-input" type="checkbox" checked>
                    </div>
                    <div>
                        <label for="codigoc" class="form-label">Código</label>
                        <div class="input-group">
                            <input type="text" name="codigoc" class="form-control" id="codigoc" aria-describedby="input-codigo" required>
                        </div>
                    </div>
                    <div>
                        <label for="nombrec" class="form-label">Nombre de Artículo</label>
                        <div class="input-group">
                            <input type="text" name="nombrec" class="form-control" id="nombrec" aria-describedby="input-nombre" required>
                        </div>
                    </div>
                    <div>
                        <label for="categoriac" class="form-label">Categoría</label>
                        <select name="categoriac" id="categoriac" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="tallac" class="form-label">Talla</label>
                        <select name="tallac" id="tallac" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="colorc" class="form-label">Color</label>
                        <select name="colorc" id="colorc" class="form-select" aria-label=""></select>
                    </div>
                    <div>
                        <label for="precio_originalc" class="form-label">Precio Original</label>
                        <div class="input-group">
                            <input step="any" type="number" name="precio_originalc" class="form-control" id="precio_originalc" aria-describedby="input-precio-original" required>
                        </div>
                    </div>
                    <div>
                        <label for="precio_ventac" class="form-label">Precio Venta</label>
                        <div class="input-group">
                            <input type="number" step="any" name="precio_ventac" class="form-control" id="precio_ventac" aria-describedby="input-precio-venta" required>
                        </div>
                    </div>
                    <div>
                        <label for="cantidadc" class="form-label">Cantidad de Artículos</label>
                        <div class="input-group ">
                            <input type="number" name="cantidadc" class="form-control" id="cantidadc" aria-describedby="input-cantidad" required>
                        </div>
                    </div>
                    <div>
                        <label for="descripcionc" class="form-label">Descripción de Artículo</label>
                        <div class="input-group ">
                            <textarea type="text" name="descripcionc" class="form-control" id="descripcionc" aria-describedby="input-descripcion" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit">Cambiar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal imagenes -->
<div class="modal fade" id="Modal_imagenes" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Subir Imagenes de Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-subir-imagenes" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type='hidden' id='idfolder' name='idfolder'>
                    <label for="inputimagenes" class="form-label">Subir Imagenes multiples</label>
                    <input class="form-control" name="inputimagenes" accept=".png, .jpg, .jpeg" type="file" id="inputimagenes" multiple>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit">Subir</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
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
        //Obtiene el json para la crear la tabla de articulos
        var tab = $("#tabla_articulos").DataTable({
            "ajax": {
                "url": "php/tabla_articulos.php",
                "dataSrc": function ( json ) {
                return json;
                }
            },
                pageLength : 5,
                lengthMenu: [[5], [5]]
        });

        //Seleccionar un registro
        $('#tabla_articulos tbody').on( 'click', 'tr', function () {
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
                console.log(id);
                $('#Modal_cambios').modal('show');
                $.ajax({
                    url: "php/info_articulo.php",
                    method: "POST",
                    data: { id : id },
                    dataType: "JSON",
                    success: function(response){
                        console.log(response);
                        var mensaje = response.mensaje;
                        var valido = response.valido;
                        if(valido){
                            $("#idc").val(response.id);
                            if(response.estado == "1"){
                                $('#estadoc').attr("checked","checked");
                                $('#estadoc').attr( "checked" )
                                $("#estadoc").val("1");
                            }
                            else{
                                $('#estadoc').removeAttr("checked");
                                $("#estadoc").val("0");
                            }
                            $("#codigoc").val(response.codigo);
                            $("#nombrec").val(response.nombre);
                            $("#categoriac").val(response.categoria);
                            $("#tallac").val(response.talla);
                            $("#colorc").val(response.color);
                            $("#precio_originalc").val(response.precio_original);
                            $("#precio_ventac").val(response.precio_venta);
                            $("#cantidadc").val(response.cantidad);
                            $("#descripcionc").val(response.descripcion);
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
        $('#borrar').click( function () {
            //Guarda el id que se va a borrar.
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
                    url: "php/borrar_articulo.php",
                    method: "POST",
                    data: { id : id },
                    dataType: "JSON",
                    success: function(response){
                        var mensaje = response.mensaje;
                        var valido = response.valido;
                        if(valido){
                            tab.row('.selected').remove().draw( false );
                            Swal.fire({
                                icon: 'success',
                                title: 'Borrado exitoso',
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
        
        //Obtiene el json de categorias
        $.ajax({
            url: 'php/tabla_categorias.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombrecat;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#categoria").append('<option name="categoria" id="categoria" value="'+response[i].categoriaid+'">'+corregido+'</option>');
                    $("#categoriac").append('<option name="categoriac" id="categoriac" value="'+response[i].categoriaid+'">'+corregido+'</option>');
                }
            }
        });
        //Obtiene el json de tallas
        $.ajax({
            url: 'php/tabla_tallas.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombretalla;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#talla").append('<option name="categoria" id="categoria" value="'+response[i].tallaid+'">'+corregido+'</option>');
                    $("#tallac").append('<option name="categoriac" id="categoriac" value="'+response[i].tallaid+'">'+corregido+'</option>');
                }
            }
        });
        //Obtiene el json de colores
        $.ajax({
            url: 'php/tabla_colores.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombrecolor;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#color").append('<option name="color" id="color" value="'+response[i].colorid+'">'+corregido+'</option>');
                    $("#colorc").append('<option name="colorc" id="colorc" value="'+response[i].colorid+'">'+corregido+'</option>');
                }
            }
        });
    });
    //validacion de imagenes
    $(document).on('change','input[type="file"]', function(){
		var sizefile= this.files[0].size;
		var namefile= this.files[0].name;
		if(sizefile>2097000){
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Fallo por que supera el peso permitido de archivo'
			})
			this.value='';
			this.files[0].name='';
		}else{
			var ext=namefile.split('.').pop();
			ext=ext.toLowerCase();
			switch(ext){
				case 'jpg':
				break;
				case 'png':
				break;
				case 'jpeg':
				break;
				default:
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'El archivo '+namefile+' no tiene extensión valida, ya sea jpg, jpeg, o png'
					})
					this.value='';
					//this.files[0].name=''; //comentado por que falla
				break;
			}
		}
	});

	$("#form-registro-articulos").on("submit",function(e){
		e.preventDefault();
        var id = 0;
        var codigo = $("#codigo").val();
        var nombre = $("#nombre").val();
        var categoria = $("#categoria").val();
        var talla = $("#talla").val();
        var color = $("#color").val();
		var precio_original = $("#precio_original").val();
        var precio_venta = $("#precio_venta").val();
        var cantidad = $("#cantidad").val();
        var descripcion = $("#descripcion").val();
		$.post('php/registro_articulos.php',
            {
                codigo:codigo,
                nombre:nombre,
                categoria:categoria,
                talla:talla,
                color:color,
                precio_original:precio_original,
                precio_venta:precio_venta,
                cantidad:cantidad,
                descripcion:descripcion
            },
            function(response){
		    }
        ).done(function(response) {
            var datos=JSON.parse(response);
            var mensaje = datos.mensaje;
            var valido = datos.valido;
            if(valido){
                $("#form-registro-articulos")[0].reset();
                $('#Modal_registro').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: mensaje
                })
                console.log(datos.id);
                $("#idfolder").val(datos.id);
                $('#Modal_imagenes').modal('show');

                var tab = $("#tabla_articulos").DataTable();
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
                text: 'Hubo un error al registrar el artículo, contacta al administrador'
            })
        });
	});
    $("#form-subir-imagenes").on("submit",function(e){
		e.preventDefault();
        $.ajax({
            url: "php/subir_imagenes.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                datos = JSON.parse(response);
                var final = datos.length-1;
                var mensaje = datos[final].mensaje;
                var valido = datos[final].valido;
                if(valido){
                    $("#form-subir-imagenes")[0].reset();
                    $('#Modal_imagenes').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Subida exitosa',
                        text: mensaje
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje
                    })
                }
            },
            error: function(e) 
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error, contacta al administrador'
                })
            }
        });

        
    });
    $("#form-cambio-articulos").on("submit",function(e){
		e.preventDefault();
        var id = $("#idc").val();
        var estado = $("#estadoc").val();
        var codigo = $("#codigoc").val();
        var nombre = $("#nombrec").val();
        var categoria = $("#categoriac").val();
        var talla = $("#tallac").val();
        var color = $("#colorc").val();
		var precio_original = $("#precio_originalc").val();
        var precio_venta = $("#precio_ventac").val();
        var cantidad = $("#cantidadc").val();
        var descripcion = $("#descripcionc").val();
		$.post('php/cambio_articulo.php',
            {
                id:id,
                estado:estado,
                codigo:codigo,
                nombre:nombre,
                categoria:categoria,
                talla:talla,
                color:color,
                precio_original:precio_original,
                precio_venta:precio_venta,
                cantidad:cantidad,
                descripcion:descripcion
            },
            function(response){
		    }
        ).done(function(response) {
                console.log(response);
                var datos=JSON.parse(response);
                var mensaje = datos.mensaje;
                var valido = datos.valido;
                if(valido){
                    $("#form-cambio-articulos")[0].reset();
                    $('#Modal_cambios').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambio exitoso',
                        text: mensaje
                    })
                    var tab = $("#tabla_articulos").DataTable();
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
</script>