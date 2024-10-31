<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/UsuariosModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    $DatosActivos = ConsultarUsuarioActivo();
    $DatosInactivos = ConsultarUsuarioInactivo();
    $Roles = ObtenerRol();

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // -------------------------------------- Consultar Usuario ---------------------------------
    
    if (isset($_GET["consultarUsuario"])) 
    {
        $consultar = ConsultarUsuarios();

        $Datos = $consultar;
        
    }

    if (isset($_GET["consultarUsuarioActivo"])) 
    {
        $consultar = ConsultarUsuarioActivo();

        $Datos = $consultar;
        
    }

    if (isset($_GET["consultarUsuarioActivo"])) 
    {
        $consultar = ConsultarUsuarioInactivo();

        $Datos = $consultar;
        
    }


    // -------------------------------------- Registrar Usuario ---------------------------------

    if (isset($_GET["btnRegistrarUsuario"])) {
    
        $agrupados = [];
        foreach ($Roles as $Rol) {
            $key = $Rol['tRol_id'] . '_' . $Rol['NombreRol'];
    
            if (!isset($agrupados[$key])) {
                $agrupados[$key] = $Rol;
            }
        }
    
        $DatosRoles = array_values($agrupados);
        $Datos = $DatosRoles;
    
    }

    if (isset($_POST["btnRegistrarUsuario"])) {
        $Nombre = $_POST["Nombre"];
        $Correo = $_POST["Correo"];
        $Cedula = $_POST["Cedula"];
        $Activo = 1;  
        $Rol = $_POST["NombreRol"];
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = RegistrarUsuarioModel($Nombre, $Correo, $Cedula, $Activo, $Rol, $IdSession);
    
        if ($resultado) { 
            $_SESSION['txtMensaje'] = "Su información se ha registrado correctamente y se ha enviado un correo con su contraseña temporal.";
        } else {
            $_SESSION['txtMensaje'] = "Ocurrió un error al registrar la información.";
        }
        
        header('Location: registrarUsuario.php'); 
        exit();
    }


     // -------------------------------------- Actualizar Usuario ---------------------------------

     if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        
        $actualizarusuario = ConsultarUsuarioPorId($Id);
    
        if ($actualizarusuario) {
            $Datos = $actualizarusuario;
        } else {
            $_SESSION['txtMensaje'] = "Usuario no encontrado.";
            header('Location: consultarUsuarioActivo.php');
            exit();
        }
    }

    if (isset($_POST["btnActualizarUsuario"])) {
        $Id = $_POST["idUsuario"];  
        $Nombre = $_POST["Nombre"];
        $Correo = $_POST["Correo"];
        $Cedula = $_POST["Cedula"];
        $Activo = $_POST["Activo"];
        $Rol = $_POST["NombreRol"];
        $IdSession = $_SESSION['IdSession'];  
        
        $resultado = ActualizarUsuarioModel($Id, $Nombre, $Correo, $Cedula, $Activo, $Rol, $IdSession);
    
        if ($resultado) { 
            $_SESSION['txtMensaje'] = "La información del usuario se ha actualizado correctamente.";
        } else {
            $_SESSION['txtMensaje'] = "Ocurrió un error al actualizar la información.";
        }
        
        header('Location: consultarUsuarioActivo.php');
        exit();
    }


?>