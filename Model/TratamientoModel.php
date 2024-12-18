<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    function ConsultarTratamiento()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarmascotatx()";
        $resultado = $enlace -> query($sentencia);

        $tratamiento = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $tratamiento[] = $row;
            }
        }
        return $tratamiento;
    }


    // -------------------------------------- Registrar Tratamientos  ---------------------------------

    function RegistrarTratamientoModel($tMascota_Id, $Fecha_Tratamiento, $Descripcion, $Costo, $Activo, $tMedicamento_id, $IdSession)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = $enlace->prepare("CALL sp_INSERT_registrarTratamiento(?, ?, ?, ?, ?, ?, ?)");

            $sentencia->bind_param(
                "issdiii", 
                $tMascota_Id,       // ID de la mascota (BIGINT)
                $Fecha_Tratamiento, // Fecha del tratamiento (DATE)
                $Descripcion,       // Descripción (TEXT)
                $Costo,             // Costo (DECIMAL)
                $Activo,            // Activo (BIT)
                $tMedicamento_id,   // ID del medicamento (BIGINT)
                $IdSession          // ID del usuario en sesión (INT)
            );

            $resultado = $sentencia->execute();

            CerrarBD($enlace);

            return $resultado; 
        }
        catch (Exception $ex)
        {
            error_log("Error al registrar tratamiento: " . $ex->getMessage());
            return false;
        }
    }

?>