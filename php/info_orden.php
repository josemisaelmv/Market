<?php
include 'conexion.php';
    session_start();
    $usuarioid = $_SESSION['usuarioid'];
    $ordenid = $_POST['ordenid'];
    $conn = OpenCon();
    $sql = "SELECT * FROM info_orden WHERE ordenid='$ordenid'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
            $json[] = $registro;
        }
        $lista=array();
        $i=0;
        foreach($json as $list){
            $nombre = "<a href='vista_articulo.php?id=".$list[2]."'>".$list[1]."</a>";
            $lista[$i][] = $nombre;
            $imagen ="<img width='100%' height='40%'src='img/ropa/".$list[2]."/0.jpg'>";
            $lista[$i][] = $imagen;
            $lista[$i][] = $list[3];
            $lista[$i][] = $list[4];
            $lista[$i]['ordenid'] = $list[0];
            $lista[$i]['nombre'] = $list[1];
            $lista[$i]['articulo'] = $list[2];
            $lista[$i]['precio'] = $list[3];
            $lista[$i]['cantidad'] = $list[4];
            $lista[$i]['usuario'] = $list[5];
            $i++;
        }
        CloseCon($conn);
        echo json_encode($lista);
    
    }

?>
