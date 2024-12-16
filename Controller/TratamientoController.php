<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/TratamientoModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/MascotasModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    

    if (isset($_GET["consultarTratamiento"])) 
    {
        $consultar = ConsultarTratamiento();

        $Datos = $consultar;
    }
     

    // -------------------------------------- Actualizar Tratamiento ---------------------------------

    if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        
        $actualizarmascota = ConsultarMascotasPorId($Id);
    
        if ($actualizarmascota) {
            $Datos = $actualizarmascota;
        } else {
            $_SESSION["Error"] = "Mascota no encontrada.";
            header('Location: consultarMascotas.php');
            exit();
        }
    }

    if (isset($_POST["btnActualizarTratamiento"])) {
        $Id = $_POST["Id"];
        $NombreMascotas = $_POST["NombreMascota"];
        $Tipo = $_POST["Tipo"];
        $Raza = $_POST["Raza"];
        $Edad = $_POST["Edad"];
        $Peso = $_POST["Peso"];
        $FechaRegistro = date('d-m-Y'); 
        $NombreDueno = $_POST["NombreDuenos"];
        $Activo = 1;  
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = ActualizarMascotaModel($Id, $NombreMascotas, $Tipo, $Raza, $Edad, $Peso, $FechaRegistro, $NombreDueno, $Activo, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "Su información se ha actualizar correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
        }
        
        header('Location: ../View/Mascotas/consultarMascotas.php?consultarMascotas=1'); 
        exit();
    }
?>