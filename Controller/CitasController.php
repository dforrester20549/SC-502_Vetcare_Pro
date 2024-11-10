<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . '/Model/Citasmodel.php';

    if(isset($_POST["btnAgendarCita"]))
    {
        $idmascota = $_POST["txtidmascota"];
        $fecha = $_POST["txtfecha"];
        $motivo = $_POST["txtMotivo"];
        $idvet = $_POST["txtvetid"];

      
        $resultado = RegistrarCita($idmascota,$fecha,$motivo,$idvet);

        if($resultado == true)
        {
            $_POST["txtMensaje"] = "Su cita se ha registrado correctamente";
        }
        else
        {
            $_POST["txtMensaje"] = "Su cita no se ha registrado correctamente";
        }
    }

?>