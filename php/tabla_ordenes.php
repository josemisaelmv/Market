<?php
    include 'conexion.php';
    session_start();
    $usuarioid = $_SESSION['usuarioid'];
    if($rol==1){
        header("Location: ingreso.php");
    }
    if($rol==2){
        header("Location: menu_adm.php");
    }
    $conn = OpenCon();
    $sql = "SELECT * FROM  orden";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)!=0){

        while ($registro = mysqli_fetch_array($result)) {
            $json[] = $registro;
        }
        $lista=array();
        $i=0;

        foreach($json as $list){
            $lista[$i][] = "<div class='d-grid gap-2'><button type='button' data-bs-toggle='modal' data-bs-target='#ModalOrden' onclick='lista_orden(".$list[0].")'class='btn btn-secondary'>Orden ".$list[0]."</button></div>";
            $lista[$i][] = $list[1];
            $lista[$i][] = $list[2];
            $lista[$i][] = $list[3];
            $lista[$i][] = estado($list[4]);
            $lista[$i][] = "<div class='d-grid gap-2'><button type='button' data-bs-toggle='modal' data-bs-target='#ModalComprobante' onclick='modal_comprobante(".$list[0].")'class='btn btn-success'>Mostrar</button></div>";
            $lista[$i][] = $list[6];
            //$lista[$i][] = $list[5];
            $lista[$i]['ordenid'] = $list[0];
            $lista[$i]['envio'] = $list[1];
            $lista[$i]['subtotal'] = $list[2];
            $lista[$i]['total'] = $list[3];
            $lista[$i]['estado'] = $list[4];
            $lista[$i]['fecha'] = $list[6];
            $lista[$i]['usuarioid'] = $list[5];
            $i++;
        }
        CloseCon($conn);
        echo json_encode($lista);
    
    }
    
    
    function estado($estado){
        switch($estado){
            case '1':
                return  'Enviado';
            break;
            case '2':
                return 'Pagado';
            break;
            case '3':
                return  'Pendiente';
            break;
            case '4':
                return  'Cancelado';
            break;
            default:
                return 'Inexistente';
            break;
        }
    }
?>