<?php
    
    include 'conexion.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM  rol";
    $result = $conn->query($sql);
    
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
    
            $fetchArray[] = $registro;
    
        }
        CloseCon($conn);
        //$result->free();
        //echo json_encode(["fetch"=>$fetchArray]);
        echo json_encode($fetchArray);
    
    }else {
        CloseCon($conn);
        echo json_encode(array("rolid"=>"no hay datos", "nombrerol"=>"no hay datos"));
    }
?>