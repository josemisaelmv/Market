<?php
    
    include 'conexion.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM  tallas";
    $result = $conn->query($sql);
    
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
    
            $fetchArray[] = $registro;
    
        }
        CloseCon($conn);
        echo json_encode($fetchArray);
    
    }else {
        CloseCon($conn);
        echo json_encode(array("tallaid"=>"no hay datos", "nombretalla"=>"no hay datos"));
    }
?>