<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/UsuariosModel.php';
    include_once $_SERVER["DOCUMENT_ROOT"] . '/SC-502_Vetcare_Pro/Controller/LoginController.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_GET["ConsultarUsuario"])) 
    {
        $consultar = ConsultarUsuarios();

        $Datos = $consultar;
        
    }

    if (isset($_GET["ConsultarUsuarioActivo"])) 
    {
        $consultar = ConsultarUsuarioActivo();

        $Datos = $consultar;
        
    }

    if (isset($_GET["ConsultarUsuarioInactivo"])) 
    {
        $consultar = ConsultarUsuarioInactivo();

        $Datos = $consultar;
        
    }

    

?>