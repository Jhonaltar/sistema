<?php
if (strlen(session_id()) < 1 )
session_start();
    require_once "../modelos/Ingreso.php";

    $ingreso= new Ingreso();

    $idingreso= isset($_POST["idingreso"]) ? limpiarCadena($_POST["idingreso"]) : "" ;
    $idproveedor= isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "" ;
    $idusuario = $_SESSION["idusuario"];
    $tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]): "" ;
    $serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]): "" ;
    $num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]): "" ;
    $fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]): "" ;
    $impuesto = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]): "" ;
    $total_compra = isset($_POST["total_compra"]) ? limpiarCadena($_POST["total_compra"]): "" ;

    

    switch ($_GET["op"])
    {
        case 'guardaryeditar';
            if(empty($idingreso)){
                $rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
                echo $rspta ? "Ingreso registrada" : "No se pudo registrar todos los datos del ingreso";
            }
            else{
            }
        break;

        case 'anular';
            $rspta=$ingreso->anular($idingreso);
            echo $rspta ? "Ingreso Anulado" : "Ingreso no se puede Anular";
        break;

        case 'mostrar';
            $rspta=$ingreso->mostrar($idingreso);
            //codificar el resultado utilizando json
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
                //recibimos el idingreso
                $id=$_GET['id'];
                $rspta=$ingreso->listarDetalle($id);
                echo '<thead class="thead-dark">
                <th class="text-center" style="width: 140px;">Opciones</th>
                <th class="text-center">Articulo</th>
                <th class="text-center" style="width: 250px;">Cantidad</th>
                <th class="text-center" style="width: 250px;">Precio de Compra</th>
                <th class="text-center" style="width: 250px;">Precio de Venta</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center"></th>
              </thead>';
              while ($reg = $rspta->fetch_object())
              {
                  echo '<tr class="filas"><td></td>
                  <td class="text-center">'.$reg->nombre.'</td>
                  <td class="text-center">'.$reg->cantidad.'</td>
                  <td class="text-center">'.$reg->precio_compra.'</td>
                  <td class="text-center">'.$reg->precio_venta.'</td>
                  <td class="text-center">'.$reg->precio_compra*$reg->cantidad.'</td></tr>';
                  $total=$total+($reg->precio_compra*$reg->cantidad);
              }
                echo '<tfoot class="table-primary" style="border-collapse: collapse;border-radius: 1em;overflow: hidden;">
                <th class="text-center">
                  <h4><span class="badge badge-warning">TOTAL</span></h4>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center"><h5 id="total">$.'.$total.'</h5><input type="hidden" name="total_compra" id="total_compra"></th>
                <th style="width: 90px;"><button style="margin-left: 12px;"type="button" id="modi" class="btn btn-primary btn-circle" onclick="modificarSubototales()"><i class="fas fa-sync-alt"></i></button></th>
              </tfoot>';
            break;

        case 'listar';
            $rspta=$ingreso->listar();
            //vamos a declarar un array 
            $data= Array(); 

            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>($reg->estado=='Aceptado') ? '<button class="btn btn-info" onclick="mostrar('.$reg->idingreso.')">Ver <i class="far fa-eye"></i></button>'.
                    ' <button class="btn btn-primary" onclick="anular('.$reg->idingreso.')"> <i class="fa fa-toggle-on"></i></button>' :
                    '<button class="btn btn-info" onclick="mostrar('.$reg->idingreso.')">Ver <i class="far fa-eye"></i></button>',
                    "1"=>'<p class="text-center">'.$reg->fecha.'</p>',
                    "2"=>'<p class="text-center">'.$reg->proveedor.'</p>',
                    "3"=>'<p class="text-center">'.$reg->usuario.'</p>',
                    "4"=>'<p class="text-center">'.$reg->tipo_comprobante.'</p>',
                    "5"=>'<p class="text-center">'.$reg->serie_comprobante.'-'.$reg->num_comprobante.'</p>',
                    "6"=>'<p class="text-center">$.'.$reg->total_compra.'</p>',
                    "7"=>($reg->estado=='Aceptado') ?'<span class="badge badge-success badge-pill" style="margin-left: 70px;">Aceptado</span>': '<span class="badge badge-danger badge-pill" style="margin-left: 75px;">Anulado</span>'
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

        case 'selectProveedor':
            require_once "../modelos/Persona.php";
            $persona= new Persona();

            $rspta=$persona->listarp();

            while ($reg = $rspta->fetch_object()) {
                echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
            }

            break;
            
            case 'listarArticulos':
                require_once "../modelos/Articulo.php";
                $articulo= new Articulo();

                $rspta=$articulo->listarActivos();
            //vamos a declarar un array
            $data=Array();

            while($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>'<button class="btn btn-outline-success" id="desa" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\')"><span class="fa fa-plus-circle"></span> Agregar</button>',                    
                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>'<p class="text-center">'.$reg->categoria.'</p>',
                    "3"=>'<p class="text-center">'.$reg->codigo.'</p>',
                    "4"=>'<p class="text-center">'.$reg->stock.'</p>',
                    "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' style='
                    margin-left: 10px;'>"

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
