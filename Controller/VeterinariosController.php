<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/VeterinariosModel.php';
 

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }



    // -------------------------------------- Consultar Veterinarios ---------------------------------
    if (isset($_GET["consultarVeterinarios"])) 
    {
        $consultar = consultarVeterinarios();
        $consultarInactivos = consultarVeterinariosInactivos();
        
        $Datos = $consultar;
        $DatosInactivos = $consultarInactivos;
    }



    // -------------------------------------- Registrar Veterinarios ---------------------------------

    if (isset($_POST["btnRegistrarVeterinario"])) {
        $NombreVeterinarios = $_POST["NombreVeterinarios"];
        $Especialidad = $_POST["Especialidad"];
        $Telefono = $_POST["Telefono"];
        $Email = $_POST["Email"];
        $Activo = 1;  
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = RegistrarVeterinarioModel($NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "Su información se ha registrado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al registrar la información.";
        }
        
        header('Location: ../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1'); 
        exit();
    }



    // -------------------------------------- Actualizar Veterinarios ---------------------------------

    if (isset($_GET['id'])) {
        $Id = $_GET['id'];
        
        $actualizarveterinarios = ConsultarVeterinariosPorId($Id);
    
        if ($actualizarveterinarios) {
            $Datos = $actualizarveterinarios;
        } else {
            $_SESSION["Error"] = "Mascota no encontrada.";
            header('Location: consultarMascotas.php');
            exit();
        }
    }

    if (isset($_POST["btnActualizarVeterinarios"])) {
        $Id = $_POST["Id"];
        $NombreVeterinarios = $_POST["NombreVeterinarios"];
        $Especialidad = $_POST["Especialidad"];
        $Telefono = $_POST["Telefono"];
        $Email = $_POST["Email"];
        $Activo = 1;  
        $IdSession = $_SESSION['IdSession'];  
    
        $resultado = ActualizarVeterinariosModel($Id, $NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $IdSession);
    
        if ($resultado) { 
            $_SESSION["Success"] = "Su información se ha actualizado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al actualizado la información.";
        }
        
        header('Location: ../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1'); 
        exit();
    }


    // -------------------------------------- Eliminar Veterinarios ---------------------------------

    if (isset($_GET['desactivarVeterinario'])) {
        $Id = $_GET['id'];
        $IdSession = $_SESSION['IdSession'];  
        $resultado = DesactivarVeterinario($Id, $IdSession);
    
        if ($resultado) {
            $_SESSION['Success'] = "Veterinario desactivado correctamente.";
        } else {
            $_SESSION['Error'] = "Ocurrió un error al desactivar al Veterinario.";
        }
    
        header('Location: ../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1'); 
        exit();
    }
?>