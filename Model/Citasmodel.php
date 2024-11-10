<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . '/Model/BaseDatos.php';

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

?>