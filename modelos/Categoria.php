<?php
//incluimos incialmente la conexion a la base de datos

require "../config/Conexion.php";

    class Categoria 
    {

        //implementamos nuestro constructor
        public function __construct()
        {
            
        }

        //impletaamos un metodo para insertar registro

        public function insertar($nombre,$descripcion)
        {
            $sql="INSERT INTO categoria (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
            return ejecutarConsulta($sql);
        }

        //impletamos un metodo para editar registro
        public function editar($idcategoria,$nombre,$descripcion)
        {
            $sql= "UPDATE categoria SET nombre='$nombre',descripcion='$descripcion' 
            WHERE idcategoria='$idcategoria'";
            return ejecutarConsulta($sql);
        }
        
        //implementaamos un metodo para desactivar categorias

        public function desactivar($idcategoria)
        {
            $sql=" UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria' ";
            return ejecutarConsulta($sql);
        }

        //implementaamos un metodo para Activar categorias

        public function activar($idcategoria)
        {
            $sql=" UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria' ";
            return ejecutarConsulta($sql);
        }

        //implementar un metodo para mostrar los datos de un registro a modificar

        public function mostrar($idcategoria)
        {
            $sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria' ";
            return ejecutarConsultaSimpleFila($sql);
        }

        // impletamos un metodo para listar los registros

        public function listar()
        {
            $sql="SELECT * FROM categoria";
            return ejecutarConsulta($sql);
        }
    }   

?>