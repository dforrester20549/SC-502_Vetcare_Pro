<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/MascotasModel.php';
 

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $Duenos = ObtenerDueno();

    // -------------------------------------- Consultar Mascotas ---------------------------------
    if (isset($_GET["consultarMascotas"])) 
    {
        $consultar = ConsultarMascotas();
        $consultarInactivos = ConsultarMascotasInactivos();
        
        $Datos = $consultar;
        $DatosInactivos = $consultarInactivos;
    }

    // -------------------------------------- Registrar Mascotas ---------------------------------

    if (isset($_GET["btnRegistrarMascota"])) {
    
        $agrupados = [];
        foreach ($Duenos as $Dueno) {
            $key = $Dueno['tDueno_id'] . '_' . $Rol['NombreDueno'];
    
            if (!isset($agrupados[$key])) {
                $agrupados[$key] = $Dueno;
            }
        }
    
        $DatosDuenos = array_values($agrupados);
        $Datos = $DatosDuenos;
    
    }

    if (isset($_POST["btnRegistrarMascota"])) {
        $NombreMascotas = $_POST["NombreMascota"];
        $Tipo = $_POST["Tipo"];
        $Raza = $_POST["Raza"];
        $Edad = $_POST["Edad"];
        $Peso = $_POST["Peso"];
        $FechaRegistro = date('d-m-Y'); 
        $NombreDueno = $_POST["NombreDuenos"];
        $Activo = 1;  
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = RegistrarMascotaModel($NombreMascotas, $Tipo, $Raza, $Edad, $Peso, $FechaRegistro, $NombreDueno, $Activo, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "Su información se ha registrado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al registrar la información.";
        }
        
        header('Location: ../Mascotas/consultarMascotas.php?consultarMascotas=1'); 
        exit();
    }



    // -------------------------------------- Actualizar Mascotas ---------------------------------

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

    if (isset($_POST["btnActualizarMascota"])) {
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
        
        header('Location: ../Mascotas/consultarMascotas.php?consultarMascotas=1'); 
        exit();
    }


    // -------------------------------------- Eliminar Mascotas ---------------------------------

    if (isset($_GET['eliminarMascotas']) && $_GET['eliminarMascotas'] == 1) 
    {
        $Id = $_GET['id'];
        $IdSession = $_SESSION['IdSession'];
        
        $resultado = EliminarMascotasPorId($Id, $IdSession);
        
        if ($resultado) {
            $_SESSION["Success"] = "Mascota Inactivado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al inactivar la mascota.";
        }
        
        header('Location: ../Mascotas/consultarMascotas.php?consultarMascotas=1');
        exit();
    }


    // -------------------------------------- Activar Mascotas ---------------------------------

    if (isset($_GET['activarMascotas']) && $_GET['activarMascotas'] == 1) 
    {
        $Id = $_GET['id'];
        $IdSession = $_SESSION['IdSession'];
        
        $resultado = ActivarMascotasPorId($Id, $IdSession);
        
        if ($resultado) {
            $_SESSION["Success"] = "Mascota Activado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al inactivar la mascota.";
        }
        
        header('Location: ../Mascotas/consultarMascotas.php?consultarMascotas=1');
        exit();
    }
?>