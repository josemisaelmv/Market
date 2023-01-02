<?php

    function OpenCon()
    {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "market";

        // Crea conexion
        $conn = new mysqli($servername, $username, $password, $dbname)or die("Conexion fallida: %s\n". $conn -> error);
    
        return $conn;
    }
    
    function CloseCon($conn)
    {
        $conn -> close();
    }
   
?>