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
        <div class="overflow-auto"style="width:100%; height:100%;">
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
                    <!-- <th>Usuario</th> -->
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
                    <!-- <th>Usuario</th> -->
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalComprobante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="comprobante_contenido">
        <div class="modal-header">
            <h5 class="modal-title">Comprobante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <select class="form-select mb-2" onchange="cambio_orden()" value="" id="orden_select">
                <option selected>Estado</option>
            </select>
            <div id="imagen"></div>
        </div>
    </div>
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
      <table id="tabla_orden" onerror="errordata()" class="table table-striped" >
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
    var tab='';
    $(document).ready(function() {
        //Obtiene el json para la crear la tabla de articulos
        tab = $("#tabla_ordenes").DataTable({
            "ajax": {
                "url": "php/tabla_ordenes.php",
                "dataSrc": function ( json ) {
                return json;
                }
            },
            order: [[6, 'desc']],
            pageLength : 5,
            lengthMenu: [[3, 5, 10], [3, 5, 10]]
        });
        $("#img_comprobante").on("error", function(event) {
            $(event.target).attr("src", "img/not_img.png");
        });


        //Obtiene el json de tallas
        $.ajax({
            url: 'php/tabla_orden_estado.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombreestado;
                    $("#orden_select").append('<option value="'+response[i].ordenestadoid+'">'+nombre+'</option>');
                }
            }
        });

    });
    function modal_comprobante(ordenid){
        $('#orden_select').val();
        $('#imagen').empty();
        $('#imagen').append('<img id="img_comprobante" onerror="imgError();" src="img/orden/'+ordenid+'/0.jpg" width="100%"><input type="hidden" id="input_ordenid"value="'+ordenid+'">');
    }
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
    function cambio_orden(){
        var seleccion = $('#orden_select').val();
        var ordenid = $('#input_ordenid').val();
        if(seleccion==4){
            Swal.fire({
                title: '¿Seguro que deseas cancelar la orden?',
                text: "Una vez cancelada no se podrá revertir la cancelación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'php/cambio_estado_orden.php',
                        type: 'POST',
                        data:{ordenestadoid:seleccion,
                            ordenid:ordenid},
                        dataType: 'JSON',
                        success: function(response){
                            var mensaje = response.mensaje;
                            var valido = response.valido;
                            if(!valido){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: mensaje
                                })
                                tab.ajax.reload();
                                $('#orden_select').prop('selectedIndex',0);
                            }else{
                                Swal.fire(
                                    'Cancelada',
                                    'La orden ha sido cancelada',
                                    'success'
                                )
                                $('#orden_select').prop('selectedIndex',0);
                                tab.ajax.reload();
                            }
                        }
                    });
                }
            })
        }else{
            $.ajax({
                url: 'php/cambio_estado_orden.php',
                type: 'POST',
                data:{ordenestadoid:seleccion,
                    ordenid:ordenid},
                dataType: 'JSON',
                success: function(response){
                    var mensaje = response.mensaje;
                    var valido = response.valido;
                    if(!valido){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: mensaje
                        })
                        $('#orden_select').prop('selectedIndex',0);
                        tab.ajax.reload();
                    }else{
                        $('#orden_select').prop('selectedIndex',0);
                        tab.ajax.reload();
                    }
                }
            });
        }
    }
    function imgError(){
        $("#img_comprobante").attr( "src", "img/notfoundimg.png" );
        console.clear();
    }
    function errordata(){
        alert('Fallo datatable');
        console.clear();
    }
</script>
<style>
    a {
        color: black;
        text-decoration: none;
    }
</style>