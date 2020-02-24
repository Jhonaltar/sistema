<?php
//incluimos incialmente la conexion a la base de datos

require "../config/Conexion.php";

class Articulo 
{
    // implementamos nuestro constructor
    public function __construct()
    {
        
    }

    //impletaamos un metodo para insertar registro
    public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql = "INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion) VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
        return ejecutarConsulta($sql);
    }

    //impletamos un metodo para editar registro
    public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql=" UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre', stock='$stock', descripcion='$descripcion', imagen='$imagen' WHERE idarticulo='$idarticulo' ";
        return ejecutarConsulta($sql);
    }

    //implementaamos un metodo para desactivar Articulos
    public function desactivar($idarticulo)
    {
        $sql=" UPDATE articulo set condicion='0' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //implementaamos un metodo para activar Articulos
    public function activar($idarticulo)
    {
        $sql=" UPDATE articulo set condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //implementar un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql= " SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // impletamos un metodo para listar los registros
    public function listar()
    {
        $sql=" SELECT a.idarticulo, a.idcategoria, c.nombre AS categoria, a.codigo, a.nombre, a.stock, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
        return ejecutarConsulta($sql);
    }

}


?>