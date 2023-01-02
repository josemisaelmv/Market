<?php
    session_start();
    $usuario = $_SESSION['usuario'];
    $rol= $_SESSION['rol'];
    $id = $_GET['id'];
    if(!isset($usuario) ){
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
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-icons/bootstrap-icons.css">
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
        <script src="DataTables/datatables.min.js" defer></script>
        <link rel="stylesheet" href="DataTables/datatables.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div id="header"></div>
            <div id="mostrar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-6" id="imagen_articulo">
                        </div>
                        <div class="col-4 mt-5">
                            <div>
                                <h1 class="mb-2" id="nombre_articulo"></h1>
                                <h3 id="precio_articulo">$</h3>
                                <h4 id="cantidad_articulo">Piezas disponibles: </h4>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text cantidad fw-bold">Cantidad</span>
                                <input type="number" onchange="cambio_cantidad(this.value)" class="form-control cantidad" min="1" step="1" id="input_cantidad" value="1"name="input_cantidad" placeholder="0">
                            </div>
                            <h4>Envios</h4>
                            <div class="form-check">
                                <div> 
                                    <input class="form-check-input " type="radio" name="envio" id="regular" onchange="envio_seleccion(0)" checked aria-label="...">
                                    <label class="form-check-label" for="envio">Regular $89</label>
                                </div>
                                <div>
                                    <input class="form-check-input " type="radio" name="envio" id="express" onchange="envio_seleccion(1)" value="" aria-label="...">
                                    <label class="form-check-label " for="envio">Express $119</label>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary btn-lg  fw-bold" id="boton_comprar">Comprar</button>
                                <button type="button" class="btn btn-outline-success btn-lg fw-bold" id="boton_agregar">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer"></div>
      </div>
    </body>
</html>
<script>
    var cantidad='';
    var id='<?php echo $id; ?>';
    var envio=0;
    $(document).ready(function() {
        $("#header").load('header_cover_nav.php');
        $("#footer").load('footer.php');
        $.ajax({
            url: 'php/info_articulo.php',
            type: 'POST',
            data:{id:id},
            dataType: 'JSON',
            success: function(response){
                console.log(response);
                if(response.estado=='1'){
                    $("#nombre_articulo").append(response.nombre);
                    $("#cantidad_articulo").append(response.cantidad);
                    $("#precio_articulo").append(response.precio_venta);
                    //$("#talla_articulo").append(response.cantidad);
                    //$("#descripcion_articulo").append(response.cantidad);
                    $("#imagen_articulo").append('<img src="img/ropa/'+response.id+'/0.jpg" class="img-fluid" alt="...">')
                }else if(response.cantidad==null){
                    //mostrar error de articulo no encontrado
                    $("#mostrar").empty();
                    $("#mostrar").append('<h1 class="text-danger text-center align-items-center justify-content-center mb-5 mt-5">No hay artículo para mostrar</h1>');
                }
            }
        });

        
    });
    function envio_seleccion (envio_var){
        if(envio_var==0){
            envio=0;
        }else{
            envio=1;
        }
    }
    function cambio_cantidad (cantidad_var) {
        //var cantidad_var =$('#input_cantidad').val();
        if(cantidad_var<=0){
            $('#input_cantidad').val(1);
        }else{
            $.ajax({
                url: 'php/info_articulo.php',
                type: 'POST',
                data:{id:id},
                dataType: 'JSON',
                success: function(response){
                    cantidad = response.cantidad;
                    $("#cantidad_articulo").empty();
                    $("#cantidad_articulo").append('Piezas disponibles: '+response.cantidad);
                    cantidad_var = parseInt(cantidad_var, 10);
                    if(cantidad_var>cantidad){
                        $('#input_cantidad').val(1);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No hay suficiente cantidad del articulo'
                        })
                    }
                }
            });
        }
    }
    $("#boton_agregar").click(function(){
        cantidad= $('#input_cantidad').val();
        $.ajax({
            url: "php/agregar_bolsa.php",
            type: "POST",
            data:  {id:id,cantidad:cantidad},
            success: function(response)
            {
                response = JSON.parse(response);
                bolsa_cantidad_badge(response.cantidad);
                if(response.valido == "0"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Ya se había agregado a la bolsa'
                    })
                }else{
                    Swal.fire({
                        icon: 'success',
                        title: 'Agregado a la bolsa'
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
    $("#boton_comprar").click(function(){
        cantidad= $('#input_cantidad').val();
        $.ajax({
            url: "php/orden_compra_individual.php",
            type: "POST",
            data:  {id:id,cantidad:cantidad,envio:envio},
            dataType: "JSON",
            success: function(response)
            {
                console.log(response);
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
                            text: 'Nos quedamos sin el articulo '+response.nombre+', ingresa una cantidad menor o elimina el artículo'
                        })
                    break;
                    case '3':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada por el articulo '+response.nombre
                        })
                    break;
                    case '4':
                        Swal.fire({
                            icon: 'error',
                            title: 'Fallo',
                            text: 'Contacte al administrador, su orden no fue procesada por el articulo '+response.nombre
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
</script>
<style>
    .cover{
        height:100px;
    } 
</style>