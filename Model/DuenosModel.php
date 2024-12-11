<?php
include_once 'BaseDatos.php';

function ConsultarDuenos()
{
    $enlace = AbrirBD();
    $sentencia = "CALL sp_GET_consultarDuenos()";
    $resultado = $enlace->query($sentencia);

    $duenos = [];
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $duenos[] = $row;
        }
    }

    CerrarBD($enlace);
    return $duenos;
}

function DesactivarDueno($Id)
{
    try {
        $enlace = AbrirBD(); 
        $sentencia = $enlace->prepare("CALL sp_UPDATE_desactivarDueno(?)");
        $sentencia->bind_param("i", $Id);
        $resultado = $sentencia->execute();

        $sentencia->close();
        CerrarBD($enlace);
        return $resultado; 

    } catch (Exception $ex) {
        return false; 
    }
}

function RegistrarDueno($nombre, $telefono, $email, $direccion)
{
    try {
        $enlace = AbrirBD();
        $sentencia = "CALL sp_INSERT_registrarDueno(?, ?, ?, ?, ?)";
        $stmt = $enlace->prepare($sentencia);
        $activo = 1; 
        $stmt->bind_param("ssssi", $nombre, $telefono, $email, $direccion, $activo);

        $resultado = $stmt->execute();
        CerrarBD($enlace);
        return $resultado;

    } catch (Exception $ex) {
        return false;
    }
}

?>
