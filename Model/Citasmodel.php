<?php
    include_once 'BaseDatos.php';

    function RegistrarCita($txtidmascota,$txtfecha,$txtMotivo,$txtvetid)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL RegistrarCita('$txtidmascota','$txtfecha','$txtMotivo','$txtvetid')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    function ActualizarCita($idcita,$idmascota,$fecha, $motivo,$estado,$idvet)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL ActualizarCita('$idcita','$idmascota','$fecha','$motivo','$estado','$idvet')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }
    function InhabilitarCita($idcita)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL InhabilitarCita('$idcita')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


?>