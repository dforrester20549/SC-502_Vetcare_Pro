<?php
include_once 'BaseDatos.php';

function ConsultarDuenos()
{
    $enlace = AbrirBD();
    $sentencia = "SELECT * FROM tDuenos";
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
        $sentencia = "UPDATE tDuenos SET Activo = 0 WHERE Id = ?";
        $stmt = $enlace->prepare($sentencia);
        $stmt->bind_param("i", $Id);
        $resultado = $stmt->execute();

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
        $sentencia = "CALL spRegistrarDueno(?, ?, ?, ?, 1)";
        $stmt = $enlace->prepare($sentencia);
        $stmt->bind_param("ssss", $nombre, $telefono, $email, $direccion);
        $resultado = $stmt->execute();

        CerrarBD($enlace);
        return $resultado;
    } catch (Exception $ex) {
        return false;
    }
}

?>
