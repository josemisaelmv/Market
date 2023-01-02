<?php
    include 'conexion.php';
    session_start();
    $usuarioid = $_SESSION['usuarioid'];
    if($rol==1){
        header("Location: ingreso.php");
    }
    date_default_timezone_set("America/Chihuahua");
    $fecha=$_POST['fecha'];
    $fecha2=$_POST['fecha2'];
    $parametro_fecha=0;
    if(empty($fecha)){
        $fecha= date('Y-m-d');
    }
    if(empty($fecha2)){
        $parametro_fecha = validacion($fecha);
    }else{
        $parametro_fecha=4;
    }
    
    $conn = OpenCon();
    $sql='';
    switch($parametro_fecha){
        case 1://day
            $sql = "SELECT * FROM  orden WHERE (estado=1 OR estado=2) AND DATE(fecha)='$fecha'";
        break;
        case 2://month
            $timestamp = strtotime($fecha); 
            $Date = date("Y-m-d", $timestamp );
            $sql = "SELECT * FROM orden WHERE (estado=1 OR estado=2) AND MONTH(fecha) = MONTH('$Date') AND YEAR(fecha) = YEAR('$Date')";
        break;
        case 3://year
            $Date = DateTime::createFromFormat('F d, Y', 'Jan 01, '.$fecha);
            $Date = $Date->format('Y-m-d');
            $sql = "SELECT * FROM orden WHERE (estado=1 OR estado=2) AND YEAR(fecha) = YEAR('$Date')";
        break;
        case 4:
            date_default_timezone_set("America/Chihuahua");
            $sql = "SELECT * FROM orden WHERE fecha BETWEEN '$fecha' AND DATE_ADD('$fecha2', INTERVAL 1 DAY) AND (estado=1 OR estado=2)";
        break;
        default:
            $sql = "SELECT * FROM  orden WHERE (estado=1 OR estado=2) AND DATE(fecha)='$fecha'";
        break;
    }
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)!=0){
        while ($registro = mysqli_fetch_array($result)) {
            $json[] = $registro;
        }
        $lista=array();
        $i=0;
        foreach($json as $list){
            $lista[$i][] = $list[0];
            $lista[$i][] = $list[2];
            $lista[$i][] = $list[6];
            $lista[$i][] = $list[4];
            
            //$lista[$i][] = $list[5];
            $lista[$i]['ordenid'] = $list[0];
            //$lista[$i]['envio'] = $list[1];
            $lista[$i]['subtotal'] = $list[2];
            //$lista[$i]['total'] = $list[3];
            $lista[$i]['fecha'] = $list[6];
            $lista[$i]['estado'] = $list[4];
            
            //$lista[$i]['usuarioid'] = $list[5];
            $i++;
        }
        CloseCon($conn);
        echo json_encode($lista);
    }
    function validacion ($var_fecha){
        $valido=0;
        if(validateDate($var_fecha, 'Y')){
            $valido=3;//year
        }elseif(validateDate($var_fecha, 'Y-m')){
            $valido=2;//month
        }elseif(validateDate($var_fecha, 'Y-m-d')){
            $valido=1;//day
        }
        return $valido;
    }
    function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
?>