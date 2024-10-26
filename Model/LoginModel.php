<?php
    include_once 'BaseDatos.php';

    function IniciarSesionModel($correo, $contrasenna)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL sp_LOGIN_iniciarSesion('$correo','$contrasenna')";
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
            $sentencia = "CALL sp_LOGIN_insertarUsuario('$Identificacion','$Nombre','$Correo','$Contrasenna')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    function RecuperarAccesoModel($correo)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL sp_LOGIN_recuperarAcceso('$correo')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return null;
        }
    }

    function ActualizarContrasennaModel($Id, $Codigo)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL sp_LOGIN_actualizarContrasenna('$Id', '$Codigo')";
            $resultado = $enlace->query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    function CambiarContrasennaConUsuarioModel($Id, $NuevaContrasenna)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL sp_LOGIN_cambiarContrasenna('$Id', '$NuevaContrasenna')";
            $resultado = $enlace->query($sentencia);

            // Limpiar la marca temporal de la contraseña
            if ($resultado) {
                $sentencia = "UPDATE tUsuarios SET ContrasennaTemporal = FALSE WHERE Id = '$Id'";
                $enlace->query($sentencia);
            }

            CerrarBD($enlace);
            return $resultado;
        }
        catch (Exception $ex)
        {
            return false;
        }
    }

?>