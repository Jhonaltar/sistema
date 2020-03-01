<?php
    //incluimos incialmente la conexion a la base de datos
    require "../config/Conexion.php";

    class Persona 
    {
        //implementamos nuestro constructor
        public function __construct()
        {
            
        }

        //implementamos un metodo para insertar registro

        public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email)
        {
            $sql= " INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email) VALUES ('$tipo_persona','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email')";
            return ejecutarConsulta($sql);
        }

        //implemetamos un metodo para editar registro
        public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email)
        {
            $sql= " UPDATE persona SET  tipo_persona= '$tipo_persona', nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', direccion='$direccion', telefono='$telefono',  email='$email' WHERE idpersona= '$idpersona'";
            return ejecutarConsulta($sql);
        }

        //implementaamos un metodo para Eliminar registro

        public function eliminar($idpersona)
        {
            $sql=" DELETE FROM persona WHERE idpersona='$idpersona' ";
            return ejecutarConsulta($sql);
        }

        //implementar un metdod para mostrar los datos de una registro a modificar

        public function mostrar($idpersona)
        {
            $sql= " SELECT * FROM persona WHERE idpersona='$idpersona'";
            return ejecutarConsultaSimpleFila($sql); 
        }

        //implementar un metodo para listar los registros de Persona

        public function listarp()
        {
            $sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
            return ejecutarConsulta($sql);
        }

        //implementar un metodo para listar los registros de Clientes

        public function listarc()
        {
            $sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
            return ejecutarConsulta($sql);
        }


    }
?>