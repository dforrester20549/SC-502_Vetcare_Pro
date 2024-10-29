<?php
    include_once 'BaseDatos.php';

    // -------------------------------------- Consultar Usuario ---------------------------------

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


    // -------------------------------------- Registrar Usuario ---------------------------------

    function ObtenerRol()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_tRoles()";
        $resultado = $enlace -> query($sentencia);

        $Roles = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $Roles[] = $row;
            }
        }
        return $Roles;
    }


    function RegistrarUsuarioModel($Nombre,$Correo,$Cedula,$Activo,$Rol)
    {
        try
        {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_INSERT_registrarUsuario('$Nombre','$Correo','$Cedula','$Activo','$Rol')";
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