<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/TratamientoModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/MascotasModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/CitasModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }



    if (isset($_GET["consultarTratamiento"])) 
    {
        $consultar = ConsultarTratamiento();

        $Datos = $consultar;
    }
     

    // -------------------------------------- Registrar Tratamiento ---------------------------------

    if (isset($_POST["btnRegistrarTratamiento"])) {
        $tMascota_Id = $_POST["tMascota_Id"];
        $Fecha_Tratamiento = $_POST["Fecha_Tratamiento"];
        $Descripcion = $_POST["Descripcion"];
        $Costo = $_POST["Costo"];
        $Activo = $_POST["Activo"];
        $tMedicamento_id = $_POST["tMedicamento_id"]; 
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = RegistrarTratamientoModel($tMascota_Id, $Fecha_Tratamiento, $Descripcion, $Costo, $Activo, $tMedicamento_id, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "Su información se ha actualizar correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
        }
        
        header('Location: ../Tratamiento/consultarTratamiento.php?consultarTratamiento=1'); 
        exit();
    }
?>