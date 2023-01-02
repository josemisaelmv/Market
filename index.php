<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VERMAG</title>
        <script type="text/javascript" srce="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.6.0.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    </head>
    <body>
      <div class="container-fluid">
          <div class="row">
              <div class="cover d-flex justify-content-center align-items-center flex-column">
                <h1>VERMAG</h1>
                <p>Dale estilo a tu vida</p>
                <a href="ingreso.php" class="btn btn-outline-light btn-lg fw-bold" type="button">Conocer más</a>
              </div>
          </div>
          <div class="row mb-3 mt-3">
            <div class="col-3 d-flex justify-content-center align-items-center flex-column">
              <div class="card muestra">
                  <div title="hoddie"class="cover cover-small" style="background-image:url(img/hoddie.jpg)"></div>
                  <div class="card-body">
                      <h5 class="card-title">Hoddies</h5>
                      <p class="card-text">Hoddies 100% Algodón</p>
                  </div>
              </div>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center flex-column">
              <div class="card muestra">
                <div  title="t-shirt" class="cover cover-small" style="background-image:url(img/T-shirt.jpg)"></div>
                <div class="card-body">
                    <h5 class="card-title">T-shirts</h5>
                    <p class="card-text">T-shirt 100% Algodón</p>
                </div>
              </div>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center flex-column">
            <div class="card muestra">
              <div  title="cap"class="cover cover-small" style="background-image:url(img/cap.jpg)"></div>
                <div class="card-body">
                    <h5 class="card-title">Caps</h5>
                    <p class="card-text">Cap 100% Acrilico</p>
                </div>
              </div>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center flex-column">
            <div class="card muestra">
              <div  title="glasses"class="cover cover-small" style="background-image:url(img/glasses.jpg)"></div>
              <div class="card-body">
                  <h5 class="card-title">Glasses</h5>
                  <p class="card-text">Armazón 100% Aluminio</p>
              </div>
            </div>
            </div>
          </div>
        <div id="footer"></div>
      </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        $("#footer").load('footer.php');
    });
</script>
<style>
  .cover {
    height: 400px;
    background-image: url("img/image.jpg");
    color: white;
    background-size: cover;
    background-position: center;
    background-color:rgba(0,0,0,.4);
    background-blend-mode:white;
  }
  .muestra{
    width: 18rem;
  }
</style>