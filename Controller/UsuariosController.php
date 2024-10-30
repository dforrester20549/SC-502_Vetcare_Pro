<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/UsuariosModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    $Roles = ObtenerRol();

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // -------------------------------------- Consultar Usuario ---------------------------------
    
    if (isset($_GET["ConsultarUsuario"])) 
    {
        $consultar = ConsultarUsuarios();

        $Datos = $consultar;
        
    }

    if (isset($_GET["ConsultarUsuarioActivo"])) 
    {
        $consultar = ConsultarUsuarioActivo();

        $Datos = $consultar;
        
    }

    if (isset($_GET["ConsultarUsuarioInactivo"])) 
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

?>