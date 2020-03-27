<?php
//incluimos incialmente la conexion a la base de datos

require "../config/Conexion.php";

class Ingreso
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //impletaamos un metodo para insertar registro

    //Implementamos un método para insertar registros
    public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
    {
        $sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
        VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
        //return ejecutarConsulta($sql);
        
        $idingresonew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;
        $sw = true;


        while ($num_elementos < count($idarticulo)) {
            $sql_detalle = "INSERT INTO detalle_ingreso (idingreso,idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
            
        }

        return $sw;
    }

    //impletamos un metodo para editar registro
    /*
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen,$permisos)
    {
        $sql = "UPDATE usuario SET nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', direccion='$direccion', telefono='$telefono',  email='$email', cargo='$cargo', login='$login', clave='$clave', imagen='$imagen' 
            WHERE idusuario='$idusuario'";
         ejecutarConsulta($sql);

         //eliminamos todos los permisos asignados para volverlos a registrar
         $sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
         ejecutarConsulta($sqldel);
         
         $num_elementos = 0;
         $sw = true;
 
 
         while ($num_elementos < count($permisos)) {
             $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES ('$idusuario', '$permisos[$num_elementos]')";
             ejecutarConsulta($sql_detalle) or $sw = false;
             $num_elementos = $num_elementos + 1;
             
         }
 
         return $sw;
         
    }*/

    //implementaamos un metodo para desactivar categorias

    public function anular($idingreso)
    {
        $sql = " UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso' ";
        return ejecutarConsulta($sql);
    }


    //implementar un metodo para mostrar los datos de un registro a modificar

    public function mostrar($idingreso)
    {
        $sql = "SELECT i.idingreso,DATE(i.fecha_hora) as Fecha, i.idproveedor,p.nombre as proveedor, u.idusuario,u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto, i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idingreso)
	{
		$sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

    // impletamos un metodo para listar los registros
    public function listar()
    {
        $sql = "SELECT i.idingreso,DATE(i.fecha_hora) as fecha, i.idproveedor,p.nombre as proveedor, u.idusuario,u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto, i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso desc";
        return ejecutarConsulta($sql);
    }

    


}

?>