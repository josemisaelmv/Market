<?php 
session_start();
$usuario = $_SESSION['usuario'];
$rol= $_SESSION['rol'];
    if(!isset($usuario)){
        header("Location: ingreso.php");
    }
    
    if(empty($_SESSION['lista'])>0){
        ?>
        
        <h1 class="text-danger text-center">No hay articulos en la bolsa</h1>
        <script>
        $('#header').load('header_cover_nav.php');
        </script>
        <?php
    }
    else{
?>
<div class="container-fluid" id="bolsa_div">
    <div class="row mt-5 mb-5">
        <div class="col-9">
            <table id="tabla_bolsa" class="table table-striped" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Eliminar</th>
                    </tr>
                </tfoot>
            </table>
        </div>
            <div class="col-3">
            <div class="d-grid gap-2">
                <h2 class="fw-bold">Resumen del pedido</h2>
                <h3 class=" fw-bold">Subtotal</h3>
                <h3 id='sub_total'></h3>
                <h3 class=" fw-bold">Envios</h3>
                <div class="form-check">
                    <div> 
                        <input class="form-check-input " type="radio" name="envio" id="regular" onchange="envio(0)" checked aria-label="...">
                        <label class="form-check-label" for="envio">Regular $89</label>
                    </div>
                    <div>
                        <input class="form-check-input " type="radio" name="envio" id="express" onchange="envio(1)" value="" aria-label="...">
                        <label class="form-check-label " for="envio">Express $119</label>
                    </div>
                </div>
                <h3 class=" fw-bold">Total</h3>
                <h3 class=" fw-bold" id='total'></h3>
                <button class="btn btn-outline-success btn-lg  fw-bold" onclick="pago()" type="button" >Pagar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var total = 0;
    var tab = '';
    $(document).ready(function() {
        //$('#header').append('holi');
        //$('#header').load('header_cover_nav.php');
        tab = $("#tabla_bolsa").DataTable({
            "ajax": {
                "url": "php/tabla_bolsa.php",
                "dataSrc": function ( json ) {
                return json;
                }
            },
            pageLength : 3,
            lengthMenu: [[3, 5], [3, 5]]
        });
        load_pedido();
    });
    function cantidad_articulo (id){
        var cantidad = $('#cantidad_'+id).val();
        if(cantidad>0){
            $.ajax({
                url: "php/cantidad_articulo_bolsa.php",
                type: "POST",
                data: {id:id, cantidad:cantidad},
                //dataType: "JSON",
                success: function(response){
                    load_pedido();
                }
            });
        }else{
            tab.ajax.reload();
            load_pedido();
            Swal.fire({
                icon: 'error',
                title: 'No es posible ingresar la cantidad:'+cantidad,
                showConfirmButton: false,
            })
        }
    }
    function load_pedido(){
        $.ajax({
            url: "php/tabla_bolsa.php",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                var cantidad =0, precio=0;
                total = 0;
                for(i=0; i<response.length; i++) {
                    cantidad= response[i][6];
                    precio = response[i][4];
                    total = total + (cantidad*precio);
                }
                var check = $("#regular").is(':checked');
                if(check) {
                    envio(0);
                }
                else{
                    envio(1);
                }
            }
        });
    }
    function eliminar_articulo (id){
        $.ajax({
            url: "php/eliminar_articulo_bolsa.php",
            type: "POST",
            data: {id:id},
            //dataType: "JSON",
            success: function(response){
                var data =JSON.parse(response);
                if(data.cantidad==0){
                    bolsa_cantidad_badge(data.cantidad);
                    Swal.fire({
                        icon: 'error',
                        title: 'Vacío',
                        text: 'La bolsa esta vacía, regresa a inicio para agregar artículos',
                    })
                    $("#bolsa_div").empty();
                    $("#bolsa_div").append("<h1 class='text-danger text-center'>No hay articulos en la bolsa</h1>");
                }else{
                    bolsa_cantidad_badge(data.cantidad);
                    tab.ajax.reload();
                    load_pedido();
                }
            }
        });
    }
    function envio (envio){
        if(envio==0){
            $('#sub_total').empty();
            $('#sub_total').append('$'+total);
            $('#total').empty();
            $('#total').append('$'+(total+89));
        }else{
            $('#sub_total').empty();
            $('#sub_total').append('$'+total);
            $('#total').empty();
            $('#total').append('$'+(total+119));
        }
    }
    function pago (){
        var check = $("#regular").is(':checked');
        var envio =0;
        if(!check){
            envio=1;
        }
        $.ajax({
            url: "php/orden_compra.php",
            type: "POST",
            data: {envio:envio},
            dataType: "JSON",
            success: function(response){
                switch(response.validar){
                    case '0':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada'
                        })
                    break;
                    case '1':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'No habia cantidad suficiente en '+response.nombre+', debe ser '+response.cantidad+' o menos, o es invalido el articulo'
                        })
                    break;
                    case '2':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Nos quedamos sin el articulo'+response.nombre+', ingresa una cantidad menor o elimina el artículo'
                        })
                    break;
                    case '3':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada por el articulo'+response.nombre
                        })
                    break;
                    case '4':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada por el articulo'+response.nombre
                        })
                    break;
                    case '5':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada'
                        })
                    break;
                    case '6':
                        var url = "compras.php";
                        $(location).attr('href',url);
                    break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada'
                        })
                    break;
                }
                $('#header').load('header_cover_nav.php');
            }
        });
    }
</script>
<style>
    a {
        color: black;
        text-decoration: none;
    }
</style>
<?php
}
?>