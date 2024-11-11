<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/MedicamentosModel.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    $mensaje = "";
    }

    // -------------------------------------- Consultar Medicamentos ---------------------------------
    
    if (isset($_GET["consultarMedicamentos"])) 
    {
        $consultar = ConsultarMedicamentosModel();
        $Datos = $consultar;
    }

    // -------------------------------------- Registrar Medicamento ---------------------------------

    if (isset($_GET["btnRegistrarMedicamento"])) {
        $Datos = []; 
    }

    if (isset($_POST["btnRegistrarMedicamento"])) {
        $Nombre = $_POST["Nombre"];
        $Descripcion = $_POST["Descripcion"];
        $Precio = $_POST["Precio"];
        $Cantidad = $_POST["Cantidad"];
    
        $resultado = RegistrarMedicamentoModel($Nombre, $Descripcion, $Precio, $Cantidad);
    
        if ($resultado) {
            $mensaje = "El medicamento se ha registrado correctamente.";
        } else {
            $mensaje = "Ocurrió un error al registrar el medicamento.";
        }
        
        header('Location: registrarMedicamentos.php'); 
        exit();
    }

    // -------------------------------------- Actualizar Medicamento ---------------------------------

    if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        
        $actualizarMedicamento = ConsultarMedicamentoPorId($Id);

    if ($actualizarMedicamento == true) {
        header('location: ../../View/Medicamentos/actualizarMedicamentos.php');
        $_POST["txtMensaje"] = "Medicamento encontrado.";
    } else {
        $_POST["txtMensaje"] = "Medicamento no encontrado.";
        exit();
    }
    
    }

    if (isset($_POST["btnActualizarMedicamento"])) {
        $Id = $_POST["idMedicamento"];  
        $Nombre = $_POST["Nombre"];
        $Descripcion = $_POST["Descripcion"];
        $Precio = $_POST["Precio"];
        $Cantidad = $_POST["Cantidad"];
        
        $resultado = ActualizarMedicamentoModel($Id, $Nombre, $Descripcion, $Precio, $Cantidad);

    if ($resultado == true) {
        header('location: ../../View/Medicamentos/actualizarMedicamentos.php');
        $_POST["txtMensaje"] = "La información del medicamento se ha actualizado correctamente.";
    } else {
        $_POST["txtMensaje"] = "Ocurrió un error al actualizar la información.";
    }
        exit();
    }
?>