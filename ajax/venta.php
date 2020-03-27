<?php
if (strlen(session_id()) < 1 )
session_start();
    require_once "../modelos/Venta.php";

    $venta= new Venta();

	$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
	$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
	$idusuario=$_SESSION["idusuario"];
	$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
	$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
	$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
	$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
	$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
	$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

    switch ($_GET["op"])
    {
        case 'guardaryeditar':
			if (empty($idventa)){
				$rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
				echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
			}
			else {
			}
		break;

        case 'anular':
			$rspta=$venta->anular($idventa);
			 echo $rspta ? "Venta anulada" : "Venta no se puede anular";
		break;
	
		case 'mostrar':
			$rspta=$venta->mostrar($idventa);
			 //Codificar el resultado utilizando json
			 echo json_encode($rspta);
		break;

        case 'listarDetalle':
                //recibimos el idingreso
                $id=$_GET['id'];
				$rspta=$venta->listarDetalle($id);
				$total=0;
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
                  <td class="text-center">'.$reg->precio_venta.'</td>
                  <td class="text-center">'.$reg->descuento.'</td>
                  <td class="text-center">'.$reg->subtotal.'</td></tr>';
                  $total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
              }
                echo '<tfoot class="table-primary" style="border-collapse: collapse;border-radius: 1em;overflow: hidden;">
                <th class="text-center">
                  <h4><span class="badge badge-warning">TOTAL</span></h4>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center"><h5 id="total">$.'.$total.'</h5><input type="hidden" name="total_venta" id="total_venta"></th>
                <th style="width: 90px;"><button style="margin-left: 12px;"type="button" id="modi" class="btn btn-primary btn-circle" onclick="modificarSubototales()"><i class="fas fa-sync-alt"></i></button></th>
              </tfoot>';
            break;

        case 'listar';
            $rspta=$venta->listar();
            //vamos a declarar un array 
            $data= Array(); 

            while ($reg=$rspta->fetch_object()){

                if ($reg->tipo_comprobante=='Ticket') {
                    $url='../reportes/exTicket.php?id=';
                }else {
                    $url='../reportes/exFactura.php?id=';
                }

                $data[]=array(
                    "0"=>(($reg->estado=='Aceptado') ? '<button class="btn btn-info" onclick="mostrar('.$reg->idventa.')">Ver <i class="far fa-eye"></i></button>'.
                    ' <button class="btn btn-primary" onclick="anular('.$reg->idventa.')"> <i class="fa fa-toggle-on"></i></button>' :
                    ' <button class="btn btn-info" onclick="mostrar('.$reg->idventa.')">Ver <i class="far fa-eye"></i></button>').
                    ' <a href="'.$url.$reg->idventa.'" target="_blank" class="btn btn-secondary"><i class="fas fa-download fa-sm text-white-50"></i></a>',
                    "1"=>'<p class="text-center">'.$reg->fecha.'</p>',
                    "2"=>'<p class="text-center">'.$reg->cliente.'</p>',
                    "3"=>'<p class="text-center">'.$reg->usuario.'</p>',
                    "4"=>'<p class="text-center">'.$reg->tipo_comprobante.'</p>',
                    "5"=>'<p class="text-center">'.$reg->serie_comprobante.'-'.$reg->num_comprobante.'</p>',
                    "6"=>'<p class="text-center">$.'.$reg->total_venta.'</p>',
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

        case 'selectCliente':
            require_once "../modelos/Persona.php";
            $persona= new Persona();

            $rspta=$persona->listarC();

            while ($reg = $rspta->fetch_object()) {
                echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
            }

            break;
            
            case 'listarArticulosVenta':
                require_once "../modelos/Articulo.php";
                $articulo= new Articulo();

                $rspta=$articulo->listarActivosVenta();
            //vamos a declarar un array
            $data=Array();

            while($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>'<button class="btn btn-outline-success" id="desa" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus-circle"></span> Agregar</button>',                    
                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>'<p class="text-center">'.$reg->categoria.'</p>',
                    "3"=>'<p class="text-center">'.$reg->codigo.'</p>',
					"4"=>'<p class="text-center">'.$reg->stock.'</p>',
					"5"=>'<p class="text-center">'.$reg->precio_venta.'</p>',
                    "6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' style='
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
