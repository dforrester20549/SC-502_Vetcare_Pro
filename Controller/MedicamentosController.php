<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/MedicamentosModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

// -------------------------------------- Consultar medicamentos ---------------------------------

    if (isset($_GET["btnconsultarMedicamentos"])) {
    $IdSession = 1;
    $Datos = ConsultarMedicamentosModel();
    }

// -------------------------------------- Eliminar medicamento ---------------------------------

if (isset($_POST["btnInactivarMedicamento"])) {
    $Id = $_POST['idMedicamento'];
    $IdSession = 1;

    $resultado = InactivarMedicamento($Id, $IdSession);

}
// -------------------------------------- Activar medicamento ---------------------------------

if (isset($_POST["btnActivarMedicamento"])) {
    $Id = $_POST['idMedicamento'];
    $IdSession = 1;

    $resultado = ActivarMedicamento($Id, $IdSession);

}

    // -------------------------------------- Registrar Medicamento ---------------------------------

    if (isset($_GET["btnRegistrarMedicamento"])) {
        $Datos = [];
        $IdSession = 1;
    }

    if (isset($_POST["btnRegistrarMedicamento"])) {
        $Nombre = $_POST["Nombre"];
        $Descripcion = $_POST["Descripcion"];
        $Dosis = $_POST["Dosis"];
    
        $resultado = RegistrarMedicamentoModel($Nombre, $Descripcion, $Dosis, $IdSession);
    
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
    $resultado = ConsultarMedicamentoPorId($Id);

    if ($resultado != null && $resultado->num_rows > 0) 
    {
        return mysqli_fetch_assoc($resultado);
    } else
        $_SESSION["Error"] = "Medicamento no encontrado.";
        header('location: ../../View/Medicamentos/consultarMedicamentos.php');
    }

    if (isset($_POST["btnActualizarMedicamento"])) {
        $Id = $_POST["id"];
        $Nombre = $_POST["Nombre"];
        $Descripcion = $_POST["Descripcion"];
        $Dosis = $_POST["Dosis"];
        $IdSession = $_SESSION['IdSession'];

        $resultado = ActualizarMedicamentoModel($Id, $Nombre, $Descripcion, $Dosis, $IdSession);
        if ($resultado == true) {
            header('location: ../../View/Medicamentos/actualizarMedicamentos.php');
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
        }
        exit();
    }
?>