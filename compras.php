<?php
    session_start();
    $usuario = $_SESSION['usuario'];
    if(!isset($usuario)){
        header("Location: ingreso.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VERMAG</title>
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
            <div id="mostrar">
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <table id="tabla_ordenes" class="table table-striped" >
                            <thead>
                                <tr>
                                    <th>Orden</th>
                                    <th>Envio</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Comprobante</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Orden</th>
                                    <th>Envio</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Comprobante</th>
                                    <th>Fecha</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="footer"></div>
      </div>
    </body>
</html>
<div class="modal fade" id="ModalComprobante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="comprobante_contenido">
    </div>
  </div>
</div>
<div class="modal fade" id="ModalOrden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitulo">Orden</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table id="tabla_orden" class="table table-striped" >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
        </tfoot>
    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
    var tab = '';
    var tab_orden = '';
    $(document).ready(function() {
        $("#header").load('header_cover_nav.php');
        $("#footer").load('footer.php');
        $.ajax({
            url: "php/ordenes_usuario.php",
            method: 'GET',
            success: function (data){
                if(data.length>0){
                    tab = $("#tabla_ordenes").DataTable({
                        "ajax": {
                            "url": "php/ordenes_usuario.php",
                            "dataSrc": function ( json ) {
                            return json;
                            }
                        },
                        order: [[6, 'desc']]
                    });
                }else{
                    $("#mostrar").empty();
                    $("#mostrar").append('<h1 class="text-danger text-center">No hay compras realizadas</h1>');
                }
            }
        });
        

        $(document).on("click", "#button_submit", function(ev){
            ev.preventDefault();
            var formData=new FormData($('#subir_comprobante')[0]);
            $.ajax({
                url:'php/subir_comprobante.php',
                data:formData,
                contentType: false,
                processData: false,
                type:'POST',
                success: function(response){
                    var data = JSON.parse(response);
                    var mensaje = data.mensaje;
                    var valido = data.valido;
                    if(valido){
                        $("#subir_comprobante")[0].reset();
                        $('#ModalComprobante').modal('hide');
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
                }
            });
        });
    });
    function lista_orden(ordenid){
        $("#tabla_orden").dataTable().fnDestroy();
        tab_orden = $("#tabla_orden").DataTable({
            "ajax": {
                "url": "php/info_orden.php",
                "type": 'POST',
                "data": {ordenid:ordenid},
                "dataSrc": function ( json ) {
                return json;
                }
            },
            pageLength : 3,
            lengthMenu: [[3, 5, 10], [3, 5, 10]]
        });
    }
    function modal_comprobante(ordenid){
        $.ajax({
            url: "php/info_pago.php",
            type: 'POST',
            data: {ordenid:ordenid},
            datatype: "JSON",
            success: function (json){
                var data =JSON.parse(json);
                $('#comprobante_contenido').empty();
                $('#comprobante_contenido').append('<form id="subir_comprobante" enctype="multipart/form-data" novalidate><div class="modal-header"><h5 class="modal-title">Comprobante</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><h5>Total $'+data[0].total+'</h5><h5>CUENTA BBVA</h5><h5>5555 5555 5555 5555</h5><h5>Pago de  #'+data[0].ordenid+'</h5><div><h5>Sube el comprobante</h5><input class="form-control" type="file" accept=".png, .jpg, .jpeg" name="inputimagenes" id="inputimagenes"><input class="form-control" name="idfolder" id="idfolder"type="hidden" value="'+data[0].ordenid+'"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button><button type="submit" id="button_submit"class="btn btn-primary">Subir</button></div></form>');
            }
        })
    }
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
    
</script>
<style>
    a {
        color: black;
        text-decoration: none;
    }
</style>