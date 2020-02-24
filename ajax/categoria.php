<?php

    require_once "../modelos/Categoria.php";

    $categoria= new Categoria();

    $idcategoria= isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "" ;
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]): "" ; 
    $descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]): "" ;

    switch ($_GET["op"])
    {
        case 'guardaryeditar';
            if(empty($idcategoria)){
                $rspta=$categoria->insertar($nombre,$descripcion);
                echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
            }
            else{
                $rspta=$categoria->editar($idcategoria,$nombre,$descripcion);
                echo $rspta ? "Categoria Actualizada" : "Categoria no se pudo Actualizar";
            }
        break;

        case 'desactivar';
            $rspta=$categoria->desactivar($idcategoria);
            echo $rspta ? "Categortia Desactivada" : "Categoria no se puede Desactivar";
        break;

        case 'activar';
            $rspta=$categoria->activar($idcategoria);
            echo $rspta ? "Categortia Activada" : "Categoria no se puede Activar";
        break;

        case 'mostrar';
            $rspta=$categoria->mostrar($idcategoria);
            //codificar el resultado utilizando json
            echo json_encode($rspta);
        break;

        case 'listar';
            $rspta=$categoria->listar();
            //vamos a declarar un array 
            $data= Array(); 

            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>($reg->condicion) ? '<button class="btn btn-success" onclick="mostrar('.$reg->idcategoria.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-primary" onclick="desactivar('.$reg->idcategoria.')"> <i class="fa fa-toggle-on"></i></button>' :
                    '<button class="btn btn-success" onclick="mostrar('.$reg->idcategoria.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-warning" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-toggle-off"></i></button>' ,
                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>$reg->descripcion,
                    "3"=>($reg->condicion) ?'<span class="badge badge-primary badge-pill" style="margin-left: 70px;">Activado</span>': '<span class="badge badge-warning badge-pill" style="margin-left: 60px;">Desactivado</span>'
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
