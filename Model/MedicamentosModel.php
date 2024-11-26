<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    // -------------------------------------- Consultar Medicamentos ---------------------------------

    function ConsultarMedicamentosModel()
    {
        $enlace = AbrirBD();

        $sentencia = "CALL sp_GET_consultarMedicamentos()";
        $resultado = $enlace -> query($sentencia);

        $medicamentos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $medicamentos[] = $row;
            }
        }
        CerrarBD($enlace);
        return $medicamentos;
    }
    // -------------------------------------- Registrar Medicamento ---------------------------------

    function RegistrarMedicamentoModel($Nombre, $Descripcion, $Dosis, $IdSession)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_INSERT_insertarMedicamento('$Nombre', '$Descripcion', '$Dosis', '$IdSession')";
            $resultado = $enlace->query($sentencia);
            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

    // -------------------------------------- Actualizar Medicamento ---------------------------------
    function ConsultarMedicamentoPorId($Id)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_GET_MedicamentoPorID($Id)";
            $resultado = $enlace->query($sentencia);
        
            CerrarBD($enlace);
            return $resultado;
        } 
        catch (Exception $ex) 
        {
            return null;
        }
    }

    function ActualizarMedicamentoModel($Id, $Nombre, $Descripcion, $Dosis, $IdSession)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_UPDATE_actualizarMedicamento('$Id','$Nombre','$Descripcion','$Dosis', '$IdSession')";
            $resultado = $enlace -> query($sentencia);
            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

// -------------------------------------- Inactivar medicamento ---------------------------------
    function InactivarMedicamento($Id, $IdSession)
    {
    try {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_UPDATE_inactivarMedicamento('$Id', '$IdSession')";
        $resultado = $enlace->query($sentencia);
        CerrarBD($enlace);
        return $resultado;
    } catch (Exception $ex) {
        return false;
    }
    }
    
// -------------------------------------- Activar medicamento ---------------------------------
    function ActivarMedicamento($Id, $IdSession)
    {
        try {
        $enlace = AbrirBD();      
        $sentencia = "CALL sp_UPDATE_activarMedicamento('$Id', '$IdSession')";
        $resultado = $enlace->query($sentencia);
        CerrarBD($enlace);
        return $resultado;
    } catch (Exception $ex) {
        return false;
    }
    }
?>