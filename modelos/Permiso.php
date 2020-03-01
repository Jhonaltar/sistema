<?php
    //incluimos iniciamente la conexion a la base de datos 

    require "../config/Conexion.php";

    class Permiso
    {
        public function __construct()
        {
            
        }

        //implementar un metodo para listar los registros
        public function listar()
        {
            $sql="SELECT * FROM permiso";
            return ejecutarConsulta($sql);
        }

    }

?>