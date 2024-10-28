<?php
    include_once 'BaseDatos.php';

    function ConsultarUsuarios()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuarios()";
        $resultado = $enlace -> query($sentencia);

        $usuarios = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }
?>