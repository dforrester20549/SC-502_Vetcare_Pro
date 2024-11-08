<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    // -------------------------------------- Consultar Medicamentos ---------------------------------

    function ConsultarMedicamentos()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_Medicamentos()";
        $resultado = $enlace -> query($sentencia);

        $medicamentos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $medicamentos[] = $row;
            }
        }
        return $medicamentos;
    }

    function ConsultarMedicamentosConStock()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_MedicamentosConStock()";
        $resultado = $enlace -> query($sentencia);

        $medicamentosConStock = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $medicamentosConStock[] = $row;
            }
        }
        return $medicamentosConStock;
    }

    function ConsultarMedicamentosSinStock()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarMedicamentosSinStock()";
        $resultado = $enlace -> query($sentencia);

        $medicamentosSinStock = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $medicamentosSinStock[] = $row;
            }
        }
        return $medicamentosSinStock;
    }

    // -------------------------------------- Registrar Medicamento ---------------------------------

    function RegistrarMedicamentoModel($Nombre, $Descripcion, $Precio, $Cantidad)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_INSERT_Medicamento('$Nombre', '$Descripcion', '$Precio', '$Cantidad')";
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
            $sentencia = "CALL sp_GET_MedicamentoPorID('$Id')";
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

    function ActualizarMedicamentoModel($Id, $Nombre, $Descripcion, $Precio, $Cantidad)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_UPDATE_Medicamento('$Id','$Nombre','$Descripcion','$Precio','$Cantidad')";
            $resultado = $enlace -> query($sentencia);
            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

?>