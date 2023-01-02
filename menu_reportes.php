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
    <div class="col-2 mb-2">
        <select id="seleccion_fecha" onchange="elegir_periodo()" class="form-select">
            <option selected>Fecha a elegir</option>
            <option value="4">Periodo</option>
            <option value="3">Dia</option>
            <option value="2">Mes</option>
            <option value="1">Año</option>
        </select>
    </div>
    <div class="col-4">
        <h1>Reportes de Periodo</h1>
    </div>
    <div class="col-4">
        <h1 id="ganancia"></h1>
    </div>
</div>
<div class="row">
    <div class="col-2 mb-2" id="div_fecha">
        <label class="form-label" for="fechainput">Fecha de Reporte</label>
        <input type="date" class="form-control" value="<?php date_default_timezone_set("America/Chihuahua"); echo date('Y-m-d');?>"  id="fechainput">
    </div>
</div>
<div class="col-2 mb-2">
    <button type="button"onclick="cambiarfecha()"  class="btn btn-primary">Mostrar</button>
</div>
<div class="row">
    <div class="col-12">
        <div class="overflow-auto"style="width:100%; height:100%;">
        <table id="tabla_ventas" class="table table-striped" >
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Subtotal</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>Orden</th>
                    <th>Subtotal</th>
                    <th>Fecha</th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>




<script>
    var tab='';
    $(document).ready(function() {
        
        //Obtiene el json para la crear la tabla de articulos
        tab = $("#tabla_ventas").DataTable({
            "ajax": {
                "url": "php/tabla_ventas.php",
                "error": function(jqXHR, textStatus, errorThrown){
                    // Note: You can use "textStatus" to describe the error.
                    // Custom
                    switch(jqXHR.status)
                    {
                        case 404:
                            Swal.fire({
                                icon: 'error',
                                title: 'Error 404',
                                text: 'No hubo respuesta'
                            })
                        break;
                        case 500:
                            Swal.fire({
                                icon: 'error',
                                title: 'Error 500',
                                text: 'Hubo un error en el servidor'
                            })
                        break;
                        default:
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Error de consulta',
                            //     text: 'No hay registros'
                            // })
                        break;
                    }
                    
                    // // Global
                    // if (jqXHR.status != 0)
                    // {
                    //     alert('Hubo un error en el sistema, contacta al administrador');
                    //     // Or you can invoke modal bootstrap rather than a java alert.   
                    // }
                },
                "dataSrc": function ( json ) {
                return json;
                }
            },
            order: [[2, 'desc']],
            pageLength : 10,
            lengthMenu: [[5, 10, 25], [5, 10, 25]]
        });
        ganancia_bruta();
    });
    function cambiarfecha(){
        var var_fecha=$('#fechainput').val();
        var var_fecha2=$('#fechainput2').val();
        ganancia_bruta();
        $("#tabla_ventas").dataTable().fnDestroy();
        tab = $("#tabla_ventas").DataTable({
            "ajax": {
                "url": "php/tabla_ventas.php",
                "type": 'POST',
                "data": {
                    fecha:var_fecha,
                    fecha2:var_fecha2
                },
                "error": function(jqXHR, textStatus, errorThrown){
                    // Note: You can use "textStatus" to describe the error.
                    // Custom
                    switch(jqXHR.status)
                    {
                        case 404:
                            Swal.fire({
                                icon: 'error',
                                title: 'Error 404',
                                text: 'No hubo respuesta'
                            })
                        break;
                        case 500:
                            Swal.fire({
                                icon: 'error',
                                title: 'Error 500',
                                text: 'Hubo un error en el servidor'
                            })
                        break;
                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de consulta',
                                text: 'No hay registros'
                            })
                            $('#ganancia').empty();
                        break;
                    }
                    // Global
                    if (jqXHR.status != 0)
                    {
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: 'Error',
                        //     text: 'No hay registros'
                        // })
                    }
                },
                "dataSrc": function ( json ) {
                return json;
                }
            },
            order: [[2, 'desc']],
            pageLength : 10,
            lengthMenu: [[5, 10, 25], [5, 10, 25]]
        });
    }
    function ganancia_bruta(){
        var var_fecha=$('#fechainput').val();
        var var_fecha2=$('#fechainput2').val();
        $.ajax({
            url: "php/tabla_ventas.php",
            method: "POST",
            data: { 
                fecha:var_fecha,
                fecha2:var_fecha2
            },
            dataType: "JSON",
            success: function(data){
                var ganancia=0;
                for(var i=0; i<data.length; i++){
                    ganancia=ganancia+parseInt(data[i].subtotal, 10);;
                }
                $('#ganancia').empty();
                $('#ganancia').append('Ganancia Bruta $'+ganancia);
            }
        });
        
    }
    function elegir_periodo(){
        var seleccion= $('#seleccion_fecha').val();
        switch(seleccion){
            case '1':
                $('#div_fecha').empty();
                $('#div_fecha').append('<label class="form-label" for="fechainput">Año de Reporte</label><input type="number" class="form-control" placeholder="yyyy" min="1900" max="2100" value="<?php echo date('Y');?>" id="fechainput" >');
            break;
            case '2':
                $('#div_fecha').empty();
                $('#div_fecha').append('<label class="form-label" for="fechainput">Mes de Reporte</label><input type="month"  class="form-control" value="<?php echo date('Y-m');?>"  id="fechainput">');
            break;
            case '3':
                $('#div_fecha').empty();
                $('#div_fecha').append('<label class="form-label" for="fechainput">Día de Reporte</label><input type="date" class="form-control" value="<?php echo date('Y-m-d');?>"  id="fechainput">');
            break;
            case '4':
                $('#div_fecha').empty();
                $('#div_fecha').append('<label class="form-label" for="fechainput">Fecha de Reporte Inicial</label><input type="date" class="form-control" value="<?php echo date('Y-m-d');?>"  id="fechainput"><label class="form-label" for="fechainput2">Fecha de Reporte Final</label><input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" id="fechainput2">');
            break;
            default:
                $('#div_fecha').empty();
                $('#div_fecha').append('<label class="form-label" for="fechainput">Fecha de Reporte</label><input type="date" class="form-control" value="<?php date_default_timezone_set("America/Chihuahua"); echo date('Y-m-d');?>" id="fechainput">');
            break;
        }
    }
</script>
<style>
    a {
        color: black;
        text-decoration: none;
    }
</style>