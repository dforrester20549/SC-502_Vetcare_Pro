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
        $Destacado = $_POST["Destacado"];
        $ImagePath = '';
    
        if (isset($_FILES['ImagePath']) && $_FILES['ImagePath']['error'] == 0) {
            $targetDir = "/SC-502_Vetcare_Pro/View/root/img/veterinario/";
            $fileName = basename($_FILES['ImagePath']['name']);
            $targetFilePath = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES['ImagePath']['tmp_name'], $targetFilePath)) {
                $ImagePath = "/SC-502_Vetcare_Pro/View/root/img/veterinario/" . $fileName;
            } else {
                $_SESSION["Error"] = "Error al subir la imagen.";
                header('Location: ../View/Veterinarios/registrarVeterinarios.php');
                exit();
            }
        } else {
            $ImagePath = "/SC-502_Vetcare_Pro/View/root/img/veterinario/noimage.jpg";
        }
    
        $resultado = RegistrarVeterinarioModel($NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $ImagePath, $Destacado, $IdSession);
    
        if ($resultado) {
            $_SESSION["Success"] = "Veterinario registrado correctamente.";
        } else {
            $_SESSION["Error"] = "Ocurrió un error al registrar el veterinario.";
        }
    
        header('Location: ../SC-502_Vetcare_Pro/View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1');
        exit();
    }
    



    // -------------------------------------- Actualizar Veterinarios ---------------------------------

if (isset($_GET['id'])) {
    $Id = $_GET['id'];

    $actualizarveterinarios = ConsultarVeterinariosPorId($Id);

    if ($actualizarveterinarios) {
        $Datos = $actualizarveterinarios;
    } else {
        $_SESSION["Error"] = "Veterinario no encontrado.";
        header('Location: consultarVeterinarios.php');
        exit();
    }
}

if (isset($_POST["btnActualizarVeterinario"])) {
    $Id = $_POST["Id"];
    $NombreVeterinarios = $_POST["NombreVeterinarios"];
    $Especialidad = $_POST["Especialidad"];
    $Telefono = $_POST["Telefono"];
    $Email = $_POST["Email"];
    $Activo = 1;
    $IdSession = $_SESSION['IdSession'];
    $Destacado = $_POST["Destacado"];
    $ImagePath = $_POST["ImagePath"];

    if (!empty($_FILES["txtImagen"]["name"])) {
        $targetDir = $_SERVER["DOCUMENT_ROOT"] . '/SC-502_Vetcare_Pro/View/root/img/veterinario/';
        $fileName = basename($_FILES["txtImagen"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["txtImagen"]["tmp_name"], $targetFilePath)) {
            $ImagePath = '/SC-502_Vetcare_Pro/View/root/img/veterinario/' . $fileName;
        } else {
            $_SESSION["Error"] = "Error al subir la nueva imagen.";
            header('Location: ../../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1');
            exit();
        }
    }


    $resultado = ActualizarVeterinariosModel($Id, $NombreVeterinarios, $Especialidad, $Telefono, $Email, $Activo, $ImagePath, $Destacado, $IdSession);

    if ($resultado) {
        $_SESSION["Success"] = "Su información se ha actualizado correctamente.";
    } else {
        $_SESSION["Error"] = "Ocurrió un error al actualizar la información.";
    }

    header('Location: ../../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1');
    exit();
}


    // -------------------------------------- Desactivar Veterinarios ---------------------------------

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


    if (isset($_GET['activarVeterinario'])) {
        $Id = $_GET['id'];
        $IdSession = $_SESSION['IdSession'];  
        $resultado = ActivarVeterinario($Id, $IdSession);
    
        if ($resultado) {
            $_SESSION['Success'] = "Veterinario activado correctamente.";
        } else {
            $_SESSION['Error'] = "Ocurrió un error al activar al Veterinario.";
        }
    
        header('Location: ../View/Veterinarios/consultarVeterinarios.php?consultarVeterinarios=1'); 
        exit();
    }


    // -------------------------------------- Consultar Veterinarios ---------------------------------
    if (isset($_GET["consultarVeterinariosDestacados"])) 
    {
        $consultarDestacados = consultarVeterinariosDestacados();
        
        $Destacados = $consultarDestacados;
    }

?>