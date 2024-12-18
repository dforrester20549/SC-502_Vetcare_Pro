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

    function RegistrarVeterinarioModel($NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $ImagePath, $Destacado, $IdSession)
    {
        try {
            $enlace = AbrirBD();

            $sentencia = $enlace->prepare("CALL sp_INSERT_registrarVeterinarios(?, ?, ?, ?, ?, ?, ?, ?)");

            $sentencia->bind_param(
                "ssssissi", 
                $NombreVeterinarios,  // p_NombreVeterinarios
                $Especialidad,        // p_Especialidad
                $Telefono,            // p_Telefono
                $Email,               // p_Email
                $Activo,              // p_Activo
                $ImagePath,           // p_ImagePath
                $Destacado,           // p_Destacado
                $IdSession            // p_IdSession
            );

            $sentencia->execute();
            $resultado = $sentencia->get_result();

            if ($resultado && $resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $Correo = $fila['Correo'];
                $ContrasennaTemporal = $fila['ContrasennaTemporal'];

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
            }

            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }


    // -------------------------------------- Consultar Veterinarios Por ID ---------------------------------

    function ConsultarVeterinariosPorId($Id)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_GET_consultarVeterinariosPorId(?)";
            $stmt = $enlace->prepare($sentencia);
            $stmt->bind_param("i", $Id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $actualizarveterinarios = null;
            if ($resultado && $resultado->num_rows > 0) {
                $actualizarveterinarios = $resultado->fetch_assoc();
            }

            CerrarBD($enlace);
            return $actualizarveterinarios;
        } catch (Exception $ex) {
            return null;
        }
    }

    // -------------------------------------- Actualizar Veterinarios ---------------------------------

    function ActualizarVeterinariosModel($Id, $NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $ImagePath, $Destacado, $IdSession)
    {
        try {
            $enlace = AbrirBD();

            $sentencia = $enlace->prepare("CALL sp_UPDATE_actualizarVeterinarios(?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $sentencia->bind_param(
                "issssisii", // Tipos de datos correspondientes a los parámetros
                $Id,                  // p_Id (BIGINT)
                $NombreVeterinarios,  // p_NombreVeterinarios (STRING)
                $Especialidad,        // p_Especialidad (STRING)
                $Telefono,            // p_Telefono (STRING)
                $Email,               // p_Email (STRING)
                $Activo,              // p_Activo (INT)
                $ImagePath,           // p_Imagen (STRING)
                $Destacado,           // p_Destacado (INT)
                $IdSession            // p_IdSession (INT)
            );

            $resultado = $sentencia->execute();

            CerrarBD($enlace);

            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }


    // -------------------------------------- Eliminar Mascotas ---------------------------------
    function DesactivarVeterinario($Id, $IdSession) 
    {
        $enlace = AbrirBD();

        try {
            $sentencia = $enlace->prepare("CALL sp_DELETE_eliminarVeterinarioPorId(?, ?)");
            $sentencia->bind_param("ii", $Id, $IdSession);

            if ($sentencia->execute()) {
                return true; 
            } else {
                return false; 
            }

        } catch (Exception $e) {
            die("Excepción: " . $e->getMessage());
        } finally {
            CerrarBD($enlace);
        }
    }


     // -------------------------------------- Consultar Mascotas ---------------------------------
     function consultarVeterinariosDestacados()
     {
         $enlace = AbrirBD();
         $sentencia = "CALL sp_GET_consultarVeterinariosDestacados()";
         $resultado = $enlace -> query($sentencia);
 
         $destacados = [];
         if ($resultado) {
             while ($row = mysqli_fetch_assoc($resultado)) {
                 $destacados[] = $row;
             }
         }
         return $destacados;
     }


     // -------------------------------------- Activar Mascotas ---------------------------------
    function ActivarVeterinario($Id, $IdSession) 
    {
        $enlace = AbrirBD();

        try {
            $sentencia = $enlace->prepare("CALL sp_UPDATE_activarVeterinarioPorId(?, ?)");
            $sentencia->bind_param("ii", $Id, $IdSession);

            if ($sentencia->execute()) {
                return true; 
            } else {
                return false; 
            }

        } catch (Exception $e) {
            die("Excepción: " . $e->getMessage());
        } finally {
            CerrarBD($enlace);
        }
    }

?>