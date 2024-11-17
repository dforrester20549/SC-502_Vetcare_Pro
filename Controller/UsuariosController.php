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
            $_SESSION["Success"] = "Su información se ha registrado correctamente y se ha enviado un correo con su contraseña temporal.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al registrar la información.";
        }
        
        header('Location: ../View/Usuarios/consultarUsuarioActivo.php?consultarUsuarioActivo=1'); 
        exit();
    }


    // -------------------------------------- Actualizar Usuario ---------------------------------

    if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        
        $actualizarusuario = ConsultarUsuarioPorId($Id);
    
        if ($actualizarusuario) {
            $Datos = $actualizarusuario;
        } else {
            $_SESSION["Error"] = "Usuario no encontrado.";
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
            $_SESSION["Success"] = "La información del usuario se ha actualizado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
        }
        
        header('Location: ../View/Usuarios/consultarUsuarioActivo.php?consultarUsuarioActivo=1');
        exit();
    }
    

    // -------------------------------------- Seguridad ---------------------------------
    if (isset($_GET['idseguridad'])) {
        $Id = $_GET['idseguridad'];
        
        $perfil = ConsultarPerfilPorId($Id);
    
        if ($perfil) {
            $Datos = $perfil;
        } else {
            $_SESSION["Error"] = "Error de usuario.";
            header('location: ../View/Usuarios/seguridad.php');
            exit();
        }
    }

    if (isset($_POST["btnSeguridad"])) {
        $idUsuario = $_POST["idUsuario"];
        $contrasennaNueva = $_POST["new_password"];
        $confirmarContrasenna = $_POST["confirm_password"];
    
        if ($contrasennaNueva === $confirmarContrasenna) {
            $resultado = SeguridadModel($idUsuario, $contrasennaNueva);
    
            if ($resultado) {
                $_SESSION["Success"] = "Contraseña cambiada correctamente.";
            } else {
                $_SESSION["Error"] = "Hubo un problema al cambiar su contraseña.";
            }
        } else {
            $_SESSION["Error"] = "Las contraseñas no coinciden.";
        }
    
        header('location: ../View/Usuarios/seguridad.php');
        exit();
    }

    // -------------------------------------- Perfil ---------------------------------
    if (isset($_GET['idperfil'])) {
        $Id = $_GET['idperfil'];
        
        $perfil = ConsultarPerfilPorId($Id);
    
        if ($perfil) {
            $Datos = $perfil;
        } else {
            $_SESSION["Error"] = "Error de usuario.";
            header('location: ../View/Usuarios/perfil.php?idperfil=<?php echo $idUsuario; ?>');
            exit();
        }
    }


    if (isset($_POST["btnPerfil"])) {
        $Id = $_POST["idUsuario"];  
        $Nombre = $_POST["Nombre"];
        $Correo = $_POST["Correo"];
        $Cedula = $_POST["Cedula"];
        $Activo = $_POST["Activo"];
        $Rol = $_POST["NombreRol"];
        $IdSession = $_SESSION['IdSession'];  
        
        $resultado = ActualizarUsuarioModel($Id, $Nombre, $Correo, $Cedula, $Activo, $Rol, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "La información del perfil se ha actualizado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
        }
        
        header('Location: ../View/Usuarios/perfil.php?idperfil=<?php echo $idUsuario; ?>');
        exit();
    }

    // -------------------------------------- Consultar Logs ---------------------------------

    if (isset($_GET["consultarLogs"])) 
    {
        $consultarLogs = consultarLogs();

        $DatosLogs = $consultarLogs;
    }


    // -------------------------------------- Descargar Logs ---------------------------------

    if (isset($_POST['btnDescargarLogs'])) 
    {
        descargarLogsCSV();
    }
    

    // -------------------------------------- Eliminar Logs ---------------------------------

    if (isset($_POST['btnEliminarLogs'])) 
    {
        $IdSession = $_SESSION['IdSession'];  
        eliminarLogs($IdSession);
        $_SESSION["Success"] = "Todos los registros de logs han sido eliminados.";
        header('Location: ../View/Usuarios/consultarLogs.php?consultarLogs=1'); 
        exit();
    }
?>