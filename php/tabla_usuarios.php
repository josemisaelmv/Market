<?php
    include 'conexion.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM  usuarios";
    $result = $conn->query($sql);
    
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
            $json[] = $registro;
        }
        $lista=array();
        $i=0;

        foreach($json as $list){
            $lista[$i][] = $list[0];
            $lista[$i][] = $list[1];
            $lista[$i][] = $list[3];
            $lista[$i][] = $list[4];
            $lista[$i][] = $list[5];
            $lista[$i][] = $list[6];
            $lista[$i][] = $list[7];
            $lista[$i][] = $list[8];
            $lista[$i][] = rol($list[9]);


            //$lista[$i][] = estado($list[4]);

            $lista[$i]['usuarioid'] = $list[0];
            $lista[$i]['usuario'] = $list[1];
            $lista[$i]['nombres'] = $list[3];
            $lista[$i]['apellidos'] = $list[4];
            $lista[$i]['telefono'] = $list[5];
            $lista[$i]['correo'] = $list[6];
            $lista[$i]['fecha_nacimiento'] = $list[7];
            $lista[$i]['fecha_registro'] = $list[8];
            $lista[$i]['rol'] = $list[9];

            $i++;
        }
        CloseCon($conn);
        echo json_encode($lista);
    
    }else {
        CloseCon($conn);
    }

    function rol($rol){
        switch($rol){
            case '1':
                return  'Usuario';
            break;
            case '2':
                return 'Capturista';
            break;
            case '3':
                return  'Administrador';
            break;
            default:
                return 'Inexistente';
            break;
        }
    }
?>