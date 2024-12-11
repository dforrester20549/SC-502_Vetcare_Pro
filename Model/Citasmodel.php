<?php
    include_once 'BaseDatos.php';

    function RegistrarCita($txtidmascota,$txtfecha,$txtMotivo,$txtvetid,$Correo,$Nombre)
    {
        try
        {
            $enlace = AbrirBD();

            $sentencia = "CALL RegistrarCita('$txtidmascota','$txtfecha','$txtMotivo','$txtvetid')";
            $resultado = $enlace -> query($sentencia);

            CerrarBD($enlace);

            if ($resultado) {
                $asunto = "VetCare Pro - Confirmación de Cita";
                $contenido = "<html>
                    <body>
                        <h2 style='color: #2D89EF;'>¡Cita Registrada con Éxito!</h2>
                        <p>Hola <strong>$Nombre</strong>,</p>
                        <p>Queremos informarte que hemos registrado tu cita en <strong>VetCare Pro</strong>. Aquí están los detalles:</p>
                        <ul>
                            <li><strong>ID de la Mascota:</strong> $txtidmascota</li>
                            <li><strong>Fecha de la Cita:</strong> $txtfecha</li>
                            <li><strong>Motivo:</strong> $txtMotivo</li>
                            <li><strong>ID del Veterinario:</strong> $txtvetid</li>
                        </ul>
                        <p>Por favor, asegúrate de llegar con anticipación y llevar toda la información relevante para el cuidado de tu mascota.</p>
                        <p>Si necesitas más información, no dudes en contactarnos.</p>
                        <br/>
                        <p>Atentamente,</p>
                        <p><strong>El equipo de VetCare Pro</strong></p>
                        <br/>
                        <p style='font-size: 0.9em; color: #555;'>Este es un correo automático, por favor no respondas a este mensaje.</p>
                    </body>
                </html>";
                EnviarCorreo($asunto, $contenido, $Correo);
            }

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