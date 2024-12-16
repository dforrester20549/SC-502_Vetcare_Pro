<?php
    include_once 'BaseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Utilidades/Utilidades.php';

    function ConsultarTratamiento()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarmascotatx()";
        $resultado = $enlace -> query($sentencia);

        $tratamiento = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $tratamiento[] = $row;
            }
        }
        return $tratamiento;
    }

    
?>