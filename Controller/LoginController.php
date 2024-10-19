<?php
    include_once '../../Model/LoginModel.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST["btnIniciarSesion"]))
    {
        $correo = $_POST["txtCorreo"];
        $contrasenna = $_POST["txtContrasenna"];

        $resultado = IniciarSesionModel($correo, $contrasenna);


        if($resultado != null && $resultado -> num_rows > 0)
        {
            $datos = mysqli_fetch_array($resultado);
            $_SESSION["NombreUsuario"] = $datos["Nombre"];

            header('location: ../../View/System/home.php');
        }
        else
        {
            session_destroy();
            $_POST["txtMensaje"] = "Su información no se ha validado correctamente";
        }
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
            header('location: ../Login/inicioSesion.php');
            $_POST["txtMensaje"] = "Su información se ha registrado correctamente";
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