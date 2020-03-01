<?php

    require_once "../modelos/Persona.php";

    $persona= new Persona();

    $idpersona= isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
    $tipo_persona=isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]): "";
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]): "" ; 
    $tipo_documento= isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]): "";
    $num_documento= isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]): "";
    $direccion= isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]): "";
    $telefono=isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]): "";
    $email=isset($_POST["email"]) ? limpiarCadena($_POST["email"]): "";

    switch ($_GET["op"]) 
    {
        case 'guardaryeditar':
            if (empty($idpersona)) {
                $rspta=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
                echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
            }else {
                $rspta=$persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
                echo $rspta ? "Persona Actualizada" : "Persona no se pudo Actualizar";
            }
            break;
        
        case 'eliminar':
            $rspta=$persona->eliminar($idpersona);
            echo $rspta ? 'Persona Eliminada' : 'Persona no se pudo eliminar';
            break;

        case 'mostrar':
            $rspta=$persona->mostrar($idpersona);
            //codificar el resultado utilizando json
            echo json_encode($rspta);
            break;
            
        case 'listarp':
            $rspta=$persona->listarp();
            //vamos a declarar un array
            $data= Array();

            while ($reg=$rspta->fetch_object()) {
                $data[]= array(
                    "0"=>'<button class="btn btn-success" onclick="mostrar('.$reg->idpersona.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"> <i class="fas fa-trash-alt"></i></button>' ,
                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>'<p class="text-center">'.$reg->tipo_documento.'</p>',
                    "3"=>'<p class="text-center">'.$reg->num_documento.'</p>',
                    "4"=>'<p class="text-center">'.$reg->telefono.'</p>',
                    "5"=>'<p class="text-center">'.$reg->email.'</p>',
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

            case 'listarc':
                $rspta=$persona->listarc();
                //vamos a declarar un array
                $data= Array();
    
                while ($reg=$rspta->fetch_object()) {
                    $data[]= array(
                        "0"=>'<button class="btn btn-success" onclick="mostrar('.$reg->idpersona.')">Editar <i class="fa fa-edit"></i></button>'.
                        ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"> <i class="fas fa-trash-alt"></i></button>' ,
                        "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                        "2"=>'<p class="text-center">'.$reg->tipo_documento.'</p>',
                        "3"=>'<p class="text-center">'.$reg->num_documento.'</p>',
                        "4"=>'<p class="text-center">'.$reg->telefono.'</p>',
                        "5"=>'<p class="text-center">'.$reg->email.'</p>',
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