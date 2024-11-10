<?php

    function GenerarCodigo($length = 8) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    
    function EnviarCorreo($asunto,$contenido,$destinatario)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Controller/PHPMailer/src/PHPMailer.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Controller/PHPMailer/src/SMTP.php';

        $correoSalida = "sys.vetcare@gmail.com";
        $contrasennaSalida = "clus depo zudi rexp";

        $mail = new PHPMailer();
        $mail -> CharSet = 'UTF-8';

        $mail -> IsSMTP();
        $mail -> IsHTML(true); 
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPSecure = 'tls';
        $mail -> Port = 587;                      
        $mail -> SMTPAuth = true;
        $mail -> Username = $correoSalida;               
        $mail -> Password = $contrasennaSalida;                                
        
        $mail -> SetFrom($correoSalida);
        $mail -> Subject = $asunto;
        $mail -> MsgHTML($contenido);   
        $mail -> AddAddress($destinatario);

        $mail -> send();
    }
?>