<?php
    include_once '../../Model/LoginModel.php';

    if(isset($_POST["btnIniciarSesion"]))
    {
        $correo = $_POST["txtCorreo"];
        $contrasenna = $_POST["txtContrasenna"];

        IniciarSesionModel($correo, $contrasenna);
    }

    if(isset($_POST["btnRegistrarUsuario"]))
    {
        $Identificacion = $_POST["txtIdentificacion"];
        $Nombre = $_POST["txtNombre"];
        $Correo = $_POST["txtCorreo"];
        $Contrasenna = $_POST["txtContrasenna"];

        $resultado = RegistrarUsuarioModel($Identificacion,$Nombre,$Correo,$Contrasenna);

        if($resultado == true)
        {
            header('location: ../../Login/inicioSesion.php');
        }
        else
        {
            $_POST["txtMensaje"] = "Su información no se ha registrado correctamente";
        }
    }

    if(isset($_POST["btnRecuperarAcceso"]))
    {
        $correo = $_POST["txtCorreo"];

        RecuperarAccesoModel($correo);
    }
?>