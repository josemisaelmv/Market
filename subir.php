<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejemplo</title>
        <script src="js/jquery-3.6.0.js"></script>

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div id="header"></div>
            <div class="row">
                <ul class="list-group list-group-numbered" id="lista" >
                    <li class="list-group-item" id="0">Cero</li>
                    <li class="list-group-item" id="1">Uno</li>
                    <li class="list-group-item" id="2">Dos</li>
                    <li class="list-group-item" id="3">Tres</li>
                    <li class="list-group-item" id="4">Cuatro</li>
                </ul>
                <button class="btn btn-outline-light" type="button" onclick="ordenactual()">Alerta</button>
            </div>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4"id="imagenes">
                    <div class="mb-2">
                        <button class="btn btn-outline-light" type="button">Reordenar</button>
                    </div>
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators"></div>
                        <div class="carousel-inner">
                            <button class="btn btn-outline-dark btnro mx-2 mt-2" type="button">Reordenar</button>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>
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

        $.ajax({
            url: 'php/mostrar_imagenes.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                var addindicator='';
                var addinner='';
                function sortResults(prop, asc) {
                    response = response.sort(function(a, b) {
                        if (asc) {
                            return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
                        } else {
                            return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
                        }
                    });
                }
                sortResults('imagen', true);
                for(i=0; i<response.length; i++) {
                    if(i==0){
                        addindicator = 'class="active" aria-current="true"';
                        addinner = 'active';
                    }else{
                        addindicator='';
                        addinner='';
                    }
                    $( ".carousel-indicators" ).append( '<button value="'+i+'"type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'+i+'" '+addindicator+' aria-label="Slide '+(i+1)+'"></button>');
                    $( ".carousel-inner" ).append('<div class="carousel-item '+addinner+'"><img src="img/ropa/mostrar/'+response[i].imagen+'" class="d-block w-100" alt=""></div>'  );
                }
            }
        });


        //inicial
        var orden=0;
        //ready
        var $sortableList = $("#lista");

        $sortableList.sortable({
            stop: function( event, ui ) {
                var idsInOrder = $("#lista").sortable("toArray");
                console.log(idsInOrder);
                orden=idsInOrder;
            } 
        });
        //funcion que obtiene el orden
        function ordenactual() {
            alert("Orden actual:"+ orden);
        } 

    });
</script>
</html>


<style>
    .btnro {
        position: absolute; 
        right: 0px;
        top: 0px;
        z-index: 2;
    }
</style>