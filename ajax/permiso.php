<?php

    require_once "../modelos/Permiso.php";

    $permiso= new Permiso();

    $idpermiso= isset($_POST["idpermiso"]) ? limpiarCadena($_POST["idpermiso"]) : "" ;
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]): "" ; 

    switch ($_GET["op"]) {
        case 'listar':
           
            $rspta=$permiso->listar();
            $data= Array();

            while ($reg=$rspta->fetch_object()) {
                $data[]=array(
                    "0"=>'<p class="text-center">'.$reg->nombre.'</p>',
                );
            }

            $results= array(
                "sEcho"=>1, //informacion para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registro al datatables
                "iTotalDisplayRecords"=>count($data), //enviamos el total registro a visualizar
                "aaData"=>$data
            );
            echo json_encode($results);
            break;
        
       
    }

?>