<?php
include 'conexion.php';
    session_start();
    $usuarioid = $_SESSION['usuarioid'];
    $ordenid = $_POST['ordenid'];
    $conn = OpenCon();
    $sql = "SELECT * FROM orden WHERE ordenid='$ordenid' AND usuarioid='$usuarioid'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
            $json[] = $registro;
        }
        CloseCon($conn);
        echo json_encode($json);
    
    }

?>
