<?php
    include_once 'BaseDatos.php';

    // -------------------------------------- Consultar Medicamentos ---------------------------------

    function ConsultarMedicamentosModel()
    {
        $enlace = AbrirBD();

        $sentencia = "CALL sp_ConsultarMedicamentos()";
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
            $sentencia = "CALL sp_InsertarMedicamento('$Nombre', '$Descripcion', '$Dosis', '$IdSession')";
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
            $sentencia = "CALL sp_ConsultarMedicamentos('$Id')";
            $resultado = $enlace->query($sentencia);
        
            $actualizarMedicamento = null;
            if ($resultado && $resultado->num_rows > 0) {
                $actualizarMedicamento = mysqli_fetch_assoc($resultado);
            }
        
            CerrarBD($enlace);
            return $actualizarMedicamento;
        } catch (Exception $ex) {
            return null;
        }
    }

    function ActualizarMedicamentoModel($Id, $Nombre, $Descripcion, $Dosis, $IdSession)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_ActualizarMedicamento('$Id','$Nombre','$Descripcion','$Dosis', '$IdSession')";
            $resultado = $enlace -> query($sentencia);
            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

?>