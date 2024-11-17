<?php
    include_once 'BaseDatos.php';

    // -------------------------------------- Consultar Mascotas ---------------------------------
    function ConsultarMascotas()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarMascotas()";
        $resultado = $enlace -> query($sentencia);

        $mascotas = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $mascotas[] = $row;
            }
        }
        return $mascotas;
    }


    function ConsultarMascotasInactivos()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_consultarMascotasInactivos()";
        $resultado = $enlace -> query($sentencia);

        $mascotasInactivos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $mascotasInactivos[] = $row;
            }
        }
        return $mascotasInactivos;
    }


    // -------------------------------------- Registrar Mascotas ---------------------------------

    function ObtenerDueno()
    {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_GET_tDuenos()";
        $resultado = $enlace -> query($sentencia);

        $Duenos = [];
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $Duenos[] = $row;
            }
        }
        return $Duenos;
    }


    function RegistrarMascotaModel($NombreMascotas, $Tipo, $Raza, $Edad, $Peso, $FechaRegistro, $tDueno_Id, $Activo, $IdSession)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = $enlace->prepare("CALL sp_INSERT_RegistrarMascotas(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $sentencia->bind_param(
                "sssidsiii", 
                $NombreMascotas,  // p_NombreMascotas
                $Tipo,            // p_Tipo
                $Raza,            // p_Raza
                $Edad,            // p_Edad
                $Peso,            // p_Peso
                $FechaRegistro,   // p_Fecha_Registro (en formato 'Y-m-d')
                $tDueno_Id,       // p_tDueno_Id
                $Activo,          // p_Activo
                $IdSession        // p_IdSession
            );
            
            $resultado = $sentencia->execute();
            
            CerrarBD($enlace);
            return $resultado;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


    // -------------------------------------- Actualizar Mascotas ---------------------------------
    function ConsultarMascotasPorId($Id)
    {
        try {
            $enlace = AbrirBD();
            $sentencia = "CALL sp_GET_consultarMascotasPorId('$Id')";
            $resultado = $enlace->query($sentencia);
        
            $actualizarmascota = null;
            if ($resultado && $resultado->num_rows > 0) {
                $actualizarmascota = mysqli_fetch_assoc($resultado);
            }
        
            CerrarBD($enlace);
            return $actualizarmascota;
        } catch (Exception $ex) {
            return null;
        }
    }


    function ActualizarMascotaModel($Id, $NombreMascotas, $Tipo, $Raza, $Edad, $Peso, $FechaRegistro, $NombreDueno, $Activo, $IdSession)
    {
        try {
            $enlace = AbrirBD();

            // Ajusta la cantidad de marcadores de posición (10 si necesitas incluir el IdSession en el procedimiento)
            $sentencia = $enlace->prepare("CALL sp_UPDATE_actualizarMascotas(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Asegúrate de que $NombreDueno o $tDueno_Id (según el procedimiento almacenado) esté definido correctamente
            $sentencia->bind_param(
                "issidsiibi", // Corresponde a los tipos esperados en el SP
                $Id,              // p_Id
                $NombreMascotas,  // p_NombreMascotas
                $Tipo,            // p_Tipo
                $Raza,            // p_Raza
                $Edad,            // p_Edad
                $Peso,            // p_Peso
                $FechaRegistro,   // p_Fecha_Registro
                $NombreDueno,     // p_tDueno_Id (revisar si es NombreDueno o tDueno_Id en el procedimiento)
                $Activo,          // p_Activo
                $IdSession        // p_IdSession
            );

            $resultado = $sentencia->execute();
            
            CerrarBD($enlace);
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }


    // -------------------------------------- Eliminar Mascotas ---------------------------------
    function EliminarMascotasPorId($Id, $IdSession) 
    {
        $enlace = AbrirBD();
    
        try {
            $sentencia = $enlace->prepare("CALL sp_DELETE_eliminarMascotasPorId(?, ?)");
            $sentencia->bind_param("ii", $Id, $IdSession);
    
            if ($sentencia->execute()) {
                return true; 
            } else {
                return false; 
            }

        } catch (Exception $e) {
            die("Excepción: " . $e->getMessage());
        } finally {
            CerrarBD($enlace);
        }
    }


    // -------------------------------------- Activar Mascotas ---------------------------------
    function ActivarMascotasPorId($Id, $IdSession) 
    {
        $enlace = AbrirBD();
    
        try {
            $sentencia = $enlace->prepare("CALL sp_UPDATE_activarMascotasPorId(?, ?)");
            $sentencia->bind_param("ii", $Id, $IdSession);
    
            if ($sentencia->execute()) {
                return true; 
            } else {
                return false; 
            }

        } catch (Exception $e) {
            die("Excepción: " . $e->getMessage());
            return false;

        } finally {
            CerrarBD($enlace);
        }
    }
?>