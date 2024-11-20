<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/DuenosModel.php';

if (isset($_GET['consultarDuenos'])) {
    $Datos = ConsultarDuenos();
}

if (isset($_GET['desactivarDueno'])) {
    $Id = $_GET['desactivarDueno'];
    $resultado = DesactivarDueno($Id);

    if ($resultado) {
        $_SESSION['Success'] = "Dueño desactivado correctamente.";
    } else {
        $_SESSION['Error'] = "Ocurrió un error al desactivar al dueño.";
    }

    header('Location: ../View/Duenos/consultarDuenos.php?consultarDuenos=1');
    exit();
}

if (isset($_POST['registrarDueno'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    $resultado = RegistrarDueno($nombre, $telefono, $email, $direccion);

    if ($resultado) {
        $_SESSION['Success'] = "Dueño registrado correctamente.";
    } else {
        $_SESSION['Error'] = "Ocurrió un error al registrar al dueño.";
    }

    header('Location: ../View/Duenos/consultarDuenos.php?consultarDuenos=1');
    exit();
}

?>
