<?php

session_start();
    require_once "../modelos/Usuario.php";

    $usuario= new Usuario();

    $idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]): "" ;
    $tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]): "" ;
    $num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]): "" ;
    $direccion= isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]): "";
    $telefono=isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]): "";
    $email= isset($_POST["email"]) ? limpiarCadena($_POST["email"]): "";
    $cargo=isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]): "";
    $login= isset($_POST["login"]) ? limpiarCadena($_POST["login"]): "";
    $clave=isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]): "";
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
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
                }
            }

            //Hash SHA256 en la contraseña
            $clavehash=hash("SHA256",$clave);

            if(empty($idusuario)){
                $rspta=$usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen,$_POST['permiso']);
                echo $rspta ? "Usuario registrado" : "No se Pudieron registrar todos los datos del usuario";
            }else{
                $rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
                echo $rspta ? "Usuario Actualizado" : "Usuario no Actualizado" ;
            }
        break;

        case 'desactivar';
            $rspta=$usuario->desactivar($idusuario);
            echo $rspta ? "Usuario Desactivado" : "Usuario no Desactivado";
        break;

        case 'activar';
            $rspta=$usuario->activar($idusuario);
            echo $rspta ? "Usuario Activado" : "Usuario no Activado";
        break;

        case 'mostrar';
            $rspta=$usuario->mostrar($idusuario);
            //codificar el resultado utilizando json
            echo json_encode($rspta);
        break;


        case 'listar';
            $rspta=$usuario->listar();
            //vamos a declarar un array
            $data=Array();

            while($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>($reg->condicion) ? '<button class="btn btn-success" onclick="mostrar('.$reg->idusuario.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-primary" onclick="desactivar('.$reg->idusuario.')"> <i class="fa fa-toggle-on"></i></button>' :
                    '<button class="btn btn-success" onclick="mostrar('.$reg->idusuario.')">Editar <i class="fa fa-edit"></i></button>'.
                    ' <button class="btn btn-warning" onclick="activar('.$reg->idusuario.')"><i class="fa fa-toggle-off"></i></button>' ,

                    "1"=>'<p class="text-center">'.$reg->nombre.'</p>',
                    "2"=>'<p class="text-center">'.$reg->tipo_documento.'</p>',
                    "3"=>'<p class="text-center">'.$reg->num_documento.'</p>',
                    "4"=>'<p class="text-center">'.$reg->telefono.'</p>',
                    "5"=>'<p class="text-center">'.$reg->email.'</p>',
                    "6"=>'<p class="text-center">'.$reg->login.'</p>',
                    "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' style='
                    margin-left: 45px;'>",
                    "8"=>($reg->condicion) ?'<span class="badge badge-primary badge-pill" style="margin-left: 70px;">Activado</span>': '<span class="badge badge-warning badge-pill" style="margin-left: 60px;">Desactivado</span>'

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

        
        case 'permisos':
            //Obtener Todos los permisos dela tabla permisos
            require_once "../modelos/Permiso.php";
            $permiso= new Permiso();
            $rspta=$permiso->listar();

            //obtener los permisos al usuario
            $id=$_GET['id'];
            $marcados= $usuario->listarmarcados($id);
            //declaramos el array para almacenar todos los permisos marcados
            $valores=array();
            //almacenar los permisos asignados al usuario en el array
            while($per = $marcados->fetch_object())
            {   
                array_push($valores, $per->idpermiso);
            }
            //Mostrar la lista de permisos en la vista y si estan o no marcados
            while ($reg= $rspta->fetch_object()) 
            {
                $sw=in_array($reg->idpermiso,$valores) ? 'checked' : '';
                echo '<li> <input  type="checkbox"  '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">' .$reg->nombre.'</li>';
            }

            break;

            case 'verificar':
                $logina=$_POST['logina'];
                $clavea=$_POST['clavea'];
         
                //Hash SHA256 en la contraseña
                $clavehash=hash("SHA256",$clavea);
         
                $rspta=$usuario->verificar($logina, $clavehash);
         
                $fetch=$rspta->fetch_object();
         
                if (isset($fetch))
                {
                    //Declaramos las variables de sesión
                    $_SESSION['idusuario']=$fetch->idusuario;
                    $_SESSION['nombre']=$fetch->nombre;
                    $_SESSION['imagen']=$fetch->imagen;
                    $_SESSION['login']=$fetch->login;
         
                    //Obtenemos los permisos del usuario
                    $marcados = $usuario->listarmarcados($fetch->idusuario);
         
                    //Declaramos el array para almacenar todos los permisos marcados
                    $valores=array();
         
                    //Almacenamos los permisos marcados en el array
                    while ($per = $marcados->fetch_object())
                        {
                            array_push($valores, $per->idpermiso);
                        }
         
                    //Determinamos los accesos del usuario
                    in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
                    in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
                    in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
                    in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
                    in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
                    in_array(6,$valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
                    in_array(7,$valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
         
                }
                echo json_encode($fetch);
            break;

           
         
            case 'salir':
                //Limpiamos las variables de sesión   
                session_unset();
                //Destruìmos la sesión
                session_destroy();
                //Redireccionamos al login
                header("Location: ../index.php");
         
            break;

           

    }

?>