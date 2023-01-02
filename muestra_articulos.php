<div class="row mb-5">

</div>
<div class="row">
    <div class="col-3">
        <div class="mx-3 mb-3">
            <h1 id="categoria_titulo">General</h1>
        </div>
        <div class="mx-3" id="colores">
            <h2>Colores</h1>
        </div>
        <div class="mx-3" id="tallas">
            <h2>Tallas</h1>
        </div>
    </div>
    <div class="col-9">
        <div class="container-fluid">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <select id="orden_precio" onchange="orden()"class="form-select form-select-md mb-3" aria-label=".form-select-lg example">
                        <option selected>Ordenar por</option>
                        <option value="0">Predeterminado</option>
                        <option value="1">Menor a mayor</option>
                        <option value="2">Mayor a menor</option>
                    </select>
                </div>
            </div>
            <div class="row" id="row_0"></div>
            <div class="row" id="row_1"></div>
            <div class="row" id="row_2"></div>
        </div>
    </div>
</div>
<div class="row mt-5">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>
<script>
    var lista_articulos = [];//declarando la variable global de lista de articulos
    var pagina=1;
    var color='';
    var talla='';
    var categoria = '';
    $(document).ready(function() {
        $.ajax({
            url: 'php/tabla_colores.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombrecolor;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#colores").append('<div class="form-check"><input onChange="colores('+response[i].colorid+')"class="form-check-input" value="'+response[i].colorid+'" type="radio" name="color_radio" id="color_radio'+response[i].colorid+'"><label class="form-check-label fs-5" for="color_radio'+response[i].colorid+''+response[i].colorid+'">'+corregido+'</label></div>');    
                }
            }
        });
        $.ajax({
            url: 'php/tabla_tallas.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombretalla;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#tallas").append('<div class="form-check"><input onChange="tallas('+response[i].tallaid+')"class="form-check-input" value="'+response[i].tallaid+'" type="radio" name="talla_radio" id="talla_radio'+response[i].tallaid+'"><label class="form-check-label fs-5" for="talla_radio'+response[i].tallaid+'">'+corregido+'</label></div>');    
                }
            }
        });
        $.ajax({
            url: 'php/tabla_categorias.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                for(i=0; i<response.length; i++) {
                    var nombre = response[i].nombrecat;
                    var corregido = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                    $("#barra_navegacion").append('<li class="nav-item"><a aria-current="page" href="#" class="nav-link active" title="'+corregido+'"id="categoria'+response[i].categoriaid+'" onclick="categorias('+response[i].categoriaid+')">'+corregido+'</a></li>');
                }
            }
        });
        reload_lista();

    });
    function tallas(id){
        talla=id;
        reload_lista_filtros(color,talla,categoria);
    }
    function colores(id){
        color=id;
        reload_lista_filtros(color,talla,categoria);
    }
    function categorias(id){
        categoria=id;
        $('#talla_radio'+talla).prop('checked', false);
        $('#color_radio'+color).prop('checked', false);
        var cat= $('#categoria'+categoria).attr("title");
        $("#categoria_titulo").empty();
        $("#categoria_titulo").append(cat);
        color='';
        talla='';
        reload_lista_filtros(color,talla,categoria);
    }
    //lista inicial
    function reload_lista(){
        $("#row_0").empty();
        $("#row_1").empty();
        $("#row_2").empty();
        $("#pagination").empty();
        $.ajax({
            url: 'php/tabla_articulos.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                var j=0;
                for(i=0; i<response.length; i++) {
                    if(!(response[i].estado==0 || response[i].precio_venta<=0 || response[i].cantidad<=0)){
                        lista_articulos[j]=response[i];
                        j++;
                    }
                }
                var paginado = lista_articulos.length;
                paginado = paginado/9;
                paginado_paginacion = parseInt(paginado);
                if(paginado>paginado_paginacion){
                    paginado_paginacion++;
                }
                var articulos_validos = 0;
                var row =0;
                for(i=0; i<lista_articulos.length; i++) {
                    if(articulos_validos==3){
                        row++;
                        articulos_validos=0;
                    }
                    if(!(row==3)){
                        $("#row_"+row).append('<div class="col-4 d-flex justify-content-center align-items-center mb-1 mt-1"><div class="card" style="width: 18rem;"><div class="cover cover-small" style="background-image:url(img/ropa/'+lista_articulos[i].articuloid+'/0.jpg)"><div class="fixed-top"></div></div><div class="card-body"><h5 class="card-title" onclick="visualizar_articulo('+lista_articulos[i].articuloid+')">'+lista_articulos[i].nombreart+'</h5><div><p class="card-text">$'+lista_articulos[i].precio_venta+'</p></div><div><p class="text-end"><button class="btn btn-outline-dark" onclick="agregar_bolsa('+lista_articulos[i].articuloid+')">Agregar a Bolsa</button></p></div></div></div></div>');
                        articulos_validos++;
                    }
                }
                if(lista_articulos.length > 0){
                    $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(false)">Anterior</a></li>');
                }
                for(i=0; i<paginado_paginacion; i++){
                    if(i==0){
                        $("#pagination").append('<li class="page-item active"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                    }else{
                        $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                    }
                }
                if(lista_articulos.length > 0){
                    $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(true)">Siguiente</a></li>');
                }
            }
        });
    }
    function reload_lista_filtros(var_color,var_talla, var_categoria){
        lista_articulos = [];
        $("#row_0").empty();
        $("#row_1").empty();
        $("#row_2").empty();
        $("#pagination").empty();
        $.ajax({
            url: 'php/tabla_articulos.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                var j=0;
                for(i=0; i<response.length; i++) {
                    if(!(response[i].estado==0 || response[i].precio_venta<=0 || response[i].cantidad<=0)){
                        if(var_categoria==''){
                            if(var_color!='' && var_talla!=''){
                                if(response[i].talla==var_talla && response[i].color==var_color){//talla y color
                                    lista_articulos[j]=response[i];
                                    j++;
                                }
                            }else{
                                if(var_color==''){//talla
                                    if(response[i].talla==var_talla){
                                        lista_articulos[j]=response[i];
                                        j++;
                                    }
                                }
                                if(var_talla==''){//color
                                    if(response[i].color==var_color){
                                        lista_articulos[j]=response[i];
                                        j++;
                                    }
                                }
                            }
                            
                        }else{
                            if(var_color!='' && var_talla!=''){//categoria, color, talla
                                if(response[i].talla==var_talla && response[i].color==var_color && response[i].categoriafk==var_categoria){
                                    lista_articulos[j]=response[i];
                                    j++;
                                }
                            }else{
                                if(var_color=='' && var_talla==''){//categoria
                                    if(response[i].categoriafk==var_categoria){
                                        lista_articulos[j]=response[i];
                                        j++;
                                    }
                                }else{
                                    if(var_color==''){//Categoria y talla
                                        if(response[i].talla==var_talla && response[i].categoriafk==var_categoria){
                                            lista_articulos[j]=response[i];
                                            j++;
                                        }
                                    }
                                    if(var_talla==''){//Categoria y color
                                        if(response[i].color==var_color && response[i].categoriafk==var_categoria){
                                            lista_articulos[j]=response[i];
                                            j++;
                                        }
                                    }
                                }
                                
                            }
                        }
                    }
                }
                var paginado = lista_articulos.length;
                paginado = paginado/9;
                paginado_paginacion = parseInt(paginado);
                if(paginado>paginado_paginacion){
                    paginado_paginacion++;
                }
                var articulos_validos = 0;
                var row =0;
                for(i=0; i<lista_articulos.length; i++) {
                    if(articulos_validos==3){
                        row++;
                        articulos_validos=0;
                    }
                    if(!(row==3)){
                        $("#row_"+row).append('<div class="col-4 d-flex justify-content-center align-items-center mb-1 mt-1"><div class="card" style="width: 18rem;"><div class="cover cover-small" style="background-image:url(img/ropa/'+lista_articulos[i].articuloid+'/0.jpg)"><div class="fixed-top"></div></div><div class="card-body"><h5 class="card-title" onclick="visualizar_articulo('+lista_articulos[i].articuloid+')">'+lista_articulos[i].nombreart+'</h5><div><p class="card-text">$'+lista_articulos[i].precio_venta+'</p></div><div><p class="text-end"><button class="btn btn-outline-dark" onclick="agregar_bolsa('+lista_articulos[i].articuloid+')">Agregar a Bolsa</button></p></div></div></div></div>');
                        // $("#row_"+row).append('<div class="col-4 d-flex justify-content-center align-items-center mb-1 mt-1"><div class="card" style="width: 18rem;"><div class="cover cover-small" style="background-image:url(img/ropa/'+lista_articulos[i].articuloid+'/0.jpg)"></div><div class="card-body"><h5 class="card-title">'+lista_articulos[i].nombreart+'</h5><p class="card-text">$'+lista_articulos[i].precio_venta+'</p></div></div></div>');
                        articulos_validos++;
                    }
                }
                if(lista_articulos.length <= 0){
                    $("#row_1").append('<div class="col-12 d-flex justify-content-center align-items-center mt-5"><h1 class="text-danger">Sin resultados, prueba con otra categoría, talla o color.</h1></div>');
                }
                if(lista_articulos.length > 0){
                    $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(false)">Anterior</a></li>');
                }
                for(i=0; i<paginado_paginacion; i++){
                    if(i==0){
                        $("#pagination").append('<li class="page-item active"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                    }else{
                        $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                    }
                }
                if(lista_articulos.length > 0){
                    $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(true)">Siguiente</a></li>');
                }
            }
        });
    }
    function paginar(var_pagina){
        pagina=var_pagina;// se le da valor a la variable global para mantener orden de la pagina actual
        if(var_pagina){
            $("#row_0").empty();
            $("#row_1").empty();
            $("#row_2").empty();
            $("#pagination").empty();
            var paginado = lista_articulos.length;
            paginado = paginado/9;
            paginado_paginacion = parseInt(paginado);
            if(paginado>paginado_paginacion){
                paginado_paginacion++;
            }
            var articulos_validos = 0;
            var row =0;
            for(i=((var_pagina-1)*9); i<lista_articulos.length; i++) {
                if(articulos_validos==3){
                    row++;
                    articulos_validos=0;
                }
                if(!(row==3)){
                    $("#row_"+row).append('<div class="col-4 d-flex justify-content-center align-items-center mb-1 mt-1"><div class="card" style="width: 18rem;"><div class="cover cover-small" style="background-image:url(img/ropa/'+lista_articulos[i].articuloid+'/0.jpg)"><div class="fixed-top"></div></div><div class="card-body"><h5 class="card-title" onclick="visualizar_articulo('+lista_articulos[i].articuloid+')">'+lista_articulos[i].nombreart+'</h5><div><p class="card-text">$'+lista_articulos[i].precio_venta+'</p></div><div><p class="text-end"><button class="btn btn-outline-dark" onclick="agregar_bolsa('+lista_articulos[i].articuloid+')">Agregar a Bolsa</button></p></div></div></div></div>');
                    // $("#row_"+row).append('<div class="col-4 d-flex justify-content-center align-items-center mb-1 mt-1"><div class="card" style="width: 18rem;"><div class="cover cover-small" style="background-image:url(img/ropa/'+lista_articulos[i].articuloid+'/0.jpg)"></div><div class="card-body"><h5 class="card-title">'+lista_articulos[i].nombreart+'</h5><p class="card-text">$'+lista_articulos[i].precio_venta+'</p></div></div></div>');
                    articulos_validos++;
                }
            }
            if(lista_articulos.length <= 0){
                $("#row_1").append('<div class="col-12 d-flex justify-content-center align-items-center mt-5"><h1 class="text-danger">Sin resultados, prueba con otra categoría, talla o color.</h1></div>');
            }
            if(lista_articulos.length > 0){
                $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(false)">Anterior</a></li>');
            }
            for(i=0; i<paginado_paginacion; i++){
                if((i+1)==var_pagina){
                    $("#pagination").append('<li class="page-item active"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                }else{
                    $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar('+(i+1)+')">'+(i+1)+'</a></li>');
                }
            }
            if(lista_articulos.length > 0){
                $("#pagination").append('<li class="page-item"><a class="page-link" onclick="paginar_atras_adelante(true)">Siguiente</a></li>');
            }
        }
    }

    function paginar_atras_adelante(response){
        var paginado = lista_articulos.length;
        paginado = paginado/9;
        paginado_paginacion = parseInt(paginado);
        if(paginado>paginado_paginacion){
            paginado_paginacion++;
        }

        if(response && pagina<paginado_paginacion){
            pagina=pagina+1;
            paginar(pagina);
        }else if(!response && pagina>1){
            pagina=pagina-1;
            paginar(pagina);
        }
        
    }
    function orden(){
        var orden = $("#orden_precio").val();
        if(orden==1){
            orden='asc';
            var json = sortJSON(lista_articulos, 'precio_venta', orden);
            lista_articulos=json;
            paginar(pagina);
        }else if(orden==2){
            orden='desc';
            var json = sortJSON(lista_articulos, 'precio_venta', orden);
            lista_articulos=json;
            paginar(pagina);
        }else{
            if(categoria=='' && color=='' && talla==''){
                reload_lista();
            }else{
                reload_lista_filtros(color,talla,categoria);

            }
        }
    }
    function sortJSON(data, key, orden) {
        return data.sort(function (a, b) {
            var x = a[key],
            y = b[key];

            if (orden === 'asc') {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            }

            if (orden === 'desc') {
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            }
        });
    }
    function visualizar_articulo(id){
        url= 'vista_articulo.php?id='+id;
        $(location).attr('href',url);
    }
    function agregar_bolsa(id){
        $.ajax({
            url: "php/agregar_bolsa.php",
            type: "POST",
            data:  {id:id},
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
    }
</script>