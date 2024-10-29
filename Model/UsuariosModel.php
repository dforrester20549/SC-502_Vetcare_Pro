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

    function ConsultarUsuarioActivo()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuariosActivos()";
        $resultado = $enlace -> query($sentencia);

        $usuariosActivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuariosActivos[] = $row;
            }
        }
        return $usuariosActivos;
    }

    function ConsultarUsuarioInactivo()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarUsuariosInactivos()";
        $resultado = $enlace -> query($sentencia);

        $usuariosInactivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $usuariosInactivos[] = $row;
            }
        }
        return $usuariosInactivos;
    }
?>