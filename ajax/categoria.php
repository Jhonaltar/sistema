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
                    "0"=>$reg->idcategoria,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->condicion
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