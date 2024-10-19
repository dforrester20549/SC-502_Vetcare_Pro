<?php
    include_once 'BaseDatos.php';

    function IniciarSesionModel($correo, $contrasenna)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL sp_iniciarSesion('$correo','$contrasenna')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return null;
        }
    }

    function RegistrarUsuarioModel($Identificacion,$Nombre,$Correo,$Contrasenna)
    {
        try
        {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_insertar_usuario('$Identificacion','$Nombre','$Correo','$Contrasenna')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    function RecuperarAccesoModel($Correo)
    {
        $enlace = AbrirBD();

        //Ejecutar el procedimiento almacenado

        CerrarBD($enlace);
    }

?>