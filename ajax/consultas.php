<?php

    require_once "../modelos/Consultas.php";

    $consulta= new Consultas();

    

    switch ($_GET["op"])
    {
        case 'comprasfecha';
            $fecha_inicio=$_REQUEST["fecha_inicio"];
            $fecha_fin=$_REQUEST["fecha_fin"];
            $rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin);
            //vamos a declarar un array 
            $data= Array(); 
            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>'<p class="text-center">'.$reg->fecha.'</p>',
                    "1"=>'<p class="text-center">'.$reg->usuario.'</p>',
                    "2"=>'<p class="text-center">'.$reg->proveedor.'</p>',
                    "3"=>'<p class="text-center">'.$reg->tipo_comprobante.'</p>',
                    "4"=>'<p class="text-center">'.$reg->serie_comprobante.' '.$reg->num_comprobante.'</p>',
                    "5"=>'<p class="text-center">'.$reg->total_compra.'</p>',
                    "6"=>'<p class="text-center">'.$reg->impuesto.'</p>',
                    "7"=>($reg->estado=='Aceptado') ?'<span class="badge badge-primary badge-pill" style="margin-left: 70px;">Aceptado</span>': '<span class="badge badge-warning badge-pill" style="margin-left: 72px;">Anulado</span>'
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

        case 'ventasfechascliente';
        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];
        $idcliente=$_REQUEST["idcliente"];
        $rspta=$consulta->ventasfechascliente($fecha_inicio,$fecha_fin,$idcliente);
        //vamos a declarar un array 
        $data= Array(); 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<p class="text-center">'.$reg->fecha.'</p>',
                "1"=>'<p class="text-center">'.$reg->usuario.'</p>',
                "2"=>'<p class="text-center">'.$reg->cliente.'</p>',
                "3"=>'<p class="text-center">'.$reg->tipo_comprobante.'</p>',
                "4"=>'<p class="text-center">'.$reg->serie_comprobante.' '.$reg->num_comprobante.'</p>',
                "5"=>'<p class="text-center">'.$reg->total_venta.'</p>',
                "6"=>'<p class="text-center">'.$reg->impuesto.'</p>',
                "7"=>($reg->estado=='Aceptado') ?'<span class="badge badge-primary badge-pill" style="margin-left: 70px;">Aceptado</span>': '<span class="badge badge-warning badge-pill" style="margin-left: 72px;">Anulado</span>'
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
