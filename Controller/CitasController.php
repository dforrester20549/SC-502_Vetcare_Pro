<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/CitasModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST["btnAgendarCita"]))
    {
        $idmascota = $_POST["txtidmascota"];
        $fecha = $_POST["txtfecha"];
        $motivo = $_POST["txtMotivo"];
        $idvet = $_POST["txtvetid"];
        $Correo = $_SESSION["Correo"];
        $Nombre = $_SESSION["NombreUsuario"];

        $fechaactual = date("Y-m-d");

        if ($fecha >= $fechaactual) {
            $resultado = RegistrarCita($idmascota,$fecha,$motivo,$idvet,$Correo,$Nombre);
            $_POST["txtMensaje"] = "Su cita se ha registrado correctamente";
            
        }else{   
            $_POST["txtMensaje"] = "la fecha no es valida";
        }
     
        
      
    }

    if(isset($_POST["btnActualizarCita"]))
    {
        $idcita = $_POST["txtidcita"];
        $idmascota = $_POST["txtidmascota"];
        $fecha = $_POST["txtfecha"];
        $motivo = $_POST["txtMotivo"];
        $estado = $_POST["txtestado"];
        $idvet = $_POST["txtvetid"];

      
        $resultado = ActualizarCita($idcita,$idmascota,$fecha, $motivo,$estado,$idvet);
        
            if($resultado == true)
            {
                $_POST["txtMensaje"] = "Su cita se ha actualizado correctamente";
            }
            else
            {
                $_POST["txtMensaje"] = "Su cita no se ha actualizado correctamente";
            }
        
    }

    if(isset($_POST["btnInhabilitarCita"]))
    {
        $idcita = $_POST["txtidcita"];
        
      
        $resultado = InhabilitarCita($idcita);
        
            if($resultado == true)
            {
                $_POST["txtMensaje"] = "Su cita se ha eliminado correctamente";
            }
            else
            {
                $_POST["txtMensaje"] = "Su cita no se ha eliminado correctamente";
            }
        
    }

?>