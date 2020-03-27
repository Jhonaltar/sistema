<?php
//incluimos incialmente la conexion a la base de datos

require "../config/Conexion.php";

class Usuario
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //impletaamos un metodo para insertar registro

    //Implementamos un método para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen,$permisos)
    {
        $sql = "INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion)
        VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
        //return ejecutarConsulta($sql);
        
        $idusuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;
        $sw = true;


        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES ('$idusuarionew', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
            
        }

        return $sw;
    }

    //impletamos un metodo para editar registro
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
         
    }

    //implementaamos un metodo para desactivar categorias

    public function desactivar($idusuario)
    {
        $sql = " UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario' ";
        return ejecutarConsulta($sql);
    }

    //implementaamos un metodo para Activar categorias

    public function activar($idusuario)
    {
        $sql = " UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario' ";
        return ejecutarConsulta($sql);
    }

    //implementar un metodo para mostrar los datos de un registro a modificar

    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    // impletamos un metodo para listar los registros
    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }

    //implementar un metodo para listar los permisos marcados
    public function listarmarcados($idusuario)
    {
        $sql= " SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //funcion para vrefocar el acceso al sistema
    public function verificar($login,$clave)
    {
        $sql=" SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave' and condicion='1' ";
        return ejecutarConsulta($sql);
    }
   
    


}

?>