<?php
    include_once 'BaseDatos.php';

    function InicioSesionModel($Correo, $Contrasenna)
    {
        $enlace = AbrirBD();

        //Ejecutar el procedimiento almacenado

        CerrarBD($enlace);
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