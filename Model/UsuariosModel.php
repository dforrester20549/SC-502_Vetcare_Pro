<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    // -------------------------------------- Consultar Usuario ---------------------------------

    function ConsultarUsuarios()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuarios()";
        $resultado = $enlace -> query($sentencia);

        $usuarios = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }

    function ConsultarUsuarioActivo()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuariosActivos()";
        $resultado = $enlace -> query($sentencia);

        $usuariosActivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuariosActivos[] = $row;
            }
        }
        return $usuariosActivos;
    }

    function ConsultarUsuarioInactivo()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuariosInactivos()";
        $resultado = $enlace -> query($sentencia);

        $usuariosInactivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuariosInactivos[] = $row;
            }
        }
        return $usuariosInactivos;
    }


    // -------------------------------------- Registrar Usuario ---------------------------------

    function ObtenerRol()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_tRoles()";
        $resultado = $enlace -> query($sentencia);

        $Roles = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $Roles[] = $row;
            }
        }
        return $Roles;
    }


    function RegistrarUsuarioModel($Nombre, $Correo, $Cedula, $Activo, $Rol, $IdSession)
    {
        try {
            $enlace = AbrirBD();
            
            $Contrasenna = GenerarCodigo();

            $sentencia = "CALL sp_INSERT_registrarUsuario('$Cedula', '$Nombre', '$Correo', '$Contrasenna', '$Activo', '$Rol', '$IdSession')";
            $resultado = $enlace->query($sentencia);

            CerrarBD($enlace);

            if ($resultado) {
                $asunto = "Bienvenido a VetCare Pro - Acceso Temporal";
                $contenido = "<html><body>
                            Hola, $Nombre,<br/><br/>
                            Se ha creado tu cuenta en VetCare Pro. <br/>
                            Tu contraseña temporal es: <b>$Contrasenna</b><br/><br/>
                            Te recomendamos cambiar esta contraseña cuando inicies sesión.<br/><br/>
                            Atentamente,<br/>
                            El equipo de VetCare Pro
                            </body></html>";
                EnviarCorreo($asunto, $contenido, $Correo);
            }

            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }


        // -------------------------------------- Actualizar Usuario ---------------------------------
        function ConsultarUsuarioPorId($Id){
            try {
                $enlace = AbrirBD();
                $sentencia = "CALL sp_GET_UsuarioPorID('$Id')";
                $resultado = $enlace->query($sentencia);
        
                $actualizarusuario = null;
                if ($resultado && $resultado->num_rows > 0) {
                    $actualizarusuario = mysqli_fetch_assoc($resultado);
                }
        
                CerrarBD($enlace);
                return $actualizarusuario;
            } catch (Exception $ex) {
                return null;
            }
        }

        function ActualizarUsuarioModel($Id, $Nombre, $Correo, $Cedula, $Activo, $Rol, $IdSession)
    {
        try
        {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_UPDATE_actualizarUsuario('$Id','$Nombre','$Correo','$Cedula','$Activo','$Rol','$IdSession')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


    // -------------------------------------- Consultar Logs ---------------------------------
    function consultarLogs()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarLogs()";
        $resultado = $enlace -> query($sentencia);

        $consultarLogs = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $consultarLogs[] = $row;
            }
        }
        return $consultarLogs;
    }

    // -------------------------------------- Descargar Logs ---------------------------------
    function descargarLogsCSV() {
        $logs = consultarLogs(); 
        $filename = "logs_" . date("Y-m-d") . ".csv";
    
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");
    
        $output = fopen("php://output", "w");
        fputcsv($output, ["Acción", "Descripción", "Usuario"]);
    
        foreach ($logs as $log) {
            fputcsv($output, $log);
        }
    
        fclose($output);
        exit(); 
    }


    // -------------------------------------- Descargar Logs ---------------------------------
    function eliminarLogs($IdSession) {
            
        $enlace = AbrirBD();
        $sentencia = "CALL sp_TRUNCATE_Logs('$IdSession')";
        $enlace->query($sentencia);
        CerrarBD($enlace);
    }

?>