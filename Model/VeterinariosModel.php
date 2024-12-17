<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    // -------------------------------------- Consultar Mascotas ---------------------------------
    function consultarVeterinarios()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarVeterinarios()";
        $resultado = $enlace -> query($sentencia);

        $veterinarios = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $veterinarios[] = $row;
            }
        }
        return $veterinarios;
    }


    function consultarVeterinariosInactivos()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarVeterinariosInactivos()";
        $resultado = $enlace -> query($sentencia);

        $veterinariosInactivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $veterinariosInactivos[] = $row;
            }
        }
        return $veterinariosInactivos;
    }


    // -------------------------------------- Registrar Veterinarios ---------------------------------

    function RegistrarVeterinarioModel($NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $IdSession)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = $enlace->prepare("CALL sp_INSERT_registrarVeterinarios(?, ?, ?, ?, ?, ?)");
            
            $sentencia->bind_param(
                "ssssii", 
                $NombreVeterinarios,  // p_NombreVeterinarios
                $Especialidad,        // p_Especialidad
                $Telefono,            // p_Telefono
                $Email,               // p_Email
                $Activo,              // p_Activo
                $IdSession            // p_IdSession
            );
            
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();

            $Correo = $fila['Correo'];
            $ContrasennaTemporal = $fila['ContrasennaTemporal'];
            
            CerrarBD($enlace);

            if ($ContrasennaTemporal) {
                $asunto = "Bienvenido a VetCare Pro - Acceso Temporal";
                $contenido = "<html><body>
                            Hola, $NombreVeterinarios,<br/><br/>
                            Se ha creado tu cuenta en VetCare Pro. <br/>
                            Tu contraseña temporal es: <b>$ContrasennaTemporal</b><br/><br/>
                            Te recomendamos cambiar esta contraseña cuando inicies sesión.<br/><br/>
                            Atentamente,<br/>
                            El equipo de VetCare Pro
                            </body></html>";
                EnviarCorreo($asunto, $contenido, $Email);
            }
            
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


    // -------------------------------------- Actualizar Veterinarios ---------------------------------
    function ConsultarVeterinariosPorId($Id)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_GET_consultarVeterinariosPorId('$Id')";
            $resultado = $enlace->query($sentencia);
        
            $actualizarveterinarios = null;
            if ($resultado && $resultado->num_rows > 0) {
                $actualizarveterinarios = mysqli_fetch_assoc($resultado);
            }
        
            CerrarBD($enlace);
            return $actualizarveterinarios;
        } catch (Exception $ex) {
            return null;
        }
    }


    function ActualizarVeterinariosModel($Id, $NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $IdSession)
{
    try {
        $enlace = AbrirBD();

        // Preparar la consulta para el procedimiento almacenado
        $sentencia = $enlace->prepare("CALL sp_UPDATE_actualizarVeterinarios(?, ?, ?, ?, ?, ?, ?)");

        // Vincular los parámetros
        $sentencia->bind_param(
            "issssii", // Tipos de datos correspondientes a los parámetros
            $Id,                  // p_Id (INT/BIGINT)
            $NombreVeterinarios,  // p_NombreVeterinarios (STRING)
            $Especialidad,        // p_Especialidad (STRING)
            $Telefono,            // p_Telefono (STRING)
            $Email,               // p_Email (STRING)
            $Activo,              // p_Activo (INT)
            $IdSession            // p_IdSession (INT)
        );

        // Ejecutar la consulta
        $resultado = $sentencia->execute();

        // Cerrar la conexión
        CerrarBD($enlace);

        return $resultado;
    } catch (Exception $ex) {
        return false;
    }
}

?>