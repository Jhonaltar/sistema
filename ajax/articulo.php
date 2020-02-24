<?php

    require_once "../modelos/Articulo.php";

    $articulo= new Articulo();

    $idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";
    $idcategoria= isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "" ;
    $codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]): "" ;
    $stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]): "" ;
    $descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]): "" ;
    $imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]): "" ;  

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
            {
                $imagen=$_POST["imagenactual"];
            }
            else 
            {
                $ext = explode(".", $_FILES["imagen"]["name"]);
                if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
                {
                    $imagen = round(microtime(true)) . '.' . end($ext);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
                }
            }

            if(empty($idarticulo)){
                $rspta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
                echo $rspta ? "Articulo registrada" : "Articulo no registrada";
            }else{
                $rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
                echo $rspta ? "Articulo Actualizado" : "Articulo no Actualizado" ;
            }
        break;

        case 'desactivar';
            $rspta=$articulo->desactivar($idarticulo);
            echo $rspta ? "Articulo Desactivado" : "Articulo no Desactivado";
        break;

        case 'activar';
            $rspta=$articulo->activar($idarticulo);
            echo $rspta ? "Articulo Activado" : "Articulo no Activado";
        break;

        case 'mostrar';
            $rspta=$articulo->mostrar($idarticulo);
            //codificar el resultado utilizando json
            echo json_encode($rspta);
        break;


        case 'listar';
            $rspta=$articulo->listar();
            //vamos a declarar un array
            $data=Array();

            while($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>($reg->condicion) ? '<button class="btn btn-success" onclick="mostrar('.$reg->idarticulo.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-primary" onclick="desactivar('.$reg->idarticulo.')"> <i class="fa fa-toggle-on"></i></button>' :
                    '<button class="btn btn-success" onclick="mostrar('.$reg->idarticulo.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-warning" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-toggle-off"></i></button>' ,

                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>'<p class="text-center">'.$reg->categoria.'</p>',
                    "3"=>'<p class="text-center">'.$reg->codigo.'</p>',
                    "4"=>'<p class="text-center">'.$reg->stock.'</p>',
                    "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' style='
                    margin-left: 45px;'>",
                    "6"=>($reg->condicion) ?'<span class="badge badge-primary badge-pill" style="margin-left: 70px;">Activado</span>': '<span class="badge badge-warning badge-pill" style="margin-left: 60px;">Desactivado</span>'

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

        case "selectCategoria":
            require_once "../modelos/Categoria.php";
            $categoria= new Categoria();

            $rspta= $categoria->select();

            while ($reg = $rspta->fetch_object()) 
            {
                echo '<option value='.$reg->idcategoria.'>' .$reg->nombre.'</option>';   
            }
        break;



    }



?>