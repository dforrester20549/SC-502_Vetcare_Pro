<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/TratamientoModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    $DatosActivos = ConsultarUsuarioActivo();
    $DatosInactivos = ConsultarUsuarioInactivo();
    $Roles = ObtenerRol();

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
     
?>