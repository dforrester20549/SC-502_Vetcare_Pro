<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/SC-502_Vetcare_Pro/Model/LoginModel.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST["btnIniciarSesion"]))
    {
        $correo = $_POST["txtCorreo"];
        $contrasenna = $_POST["txtContrasenna"];

        $resultado = IniciarSesionModel($correo, $contrasenna);


        if($resultado != null && $resultado -> num_rows > 0)
        {
            $datos = mysqli_fetch_array($resultado);
            $_SESSION["NombreUsuario"] = $datos["Nombre"];

            header('location: ../../View/System/home.php');
        }
        else
        {
            session_destroy();
            $_POST["txtMensaje"] = "Su información no se ha validado correctamente";
        }
    }

    if(isset($_POST["btnRegistrarUsuario"]))
    {
        $Identificacion = $_POST["txtIdentificacion"];
        $Nombre = $_POST["txtNombre"];
        $Correo = $_POST["txtCorreo"];
        $Contrasenna = $_POST["txtContrasenna"];

        $resultado = RegistrarUsuarioModel($Identificacion,$Nombre,$Correo,$Contrasenna);

        if($resultado == true)
        {
            header('location: ../../View/Login/inicioSesion.php');
            $_POST["txtMensaje"] = "Su información se ha registrado correctamente";
        }
        else
        {
            $_POST["txtMensaje"] = "Su información no se ha registrado correctamente";
        }
    }

    if(isset($_POST["btnRecuperar"]))
    {
        $correo = $_POST["txtCorreo"];

        $resultado = RecuperarAccesoModel($correo);

        if($resultado != null && $resultado -> num_rows > 0)
        {
            $datos = mysqli_fetch_array($resultado);
            $codigo = GenerarCodigo();

            ActualizarContrasennaModel($datos["Id"], $codigo);

            $contenido = "<html><body>
            Estimado(a) " . $datos["Nombre"] . "<br/><br/>
            Se ha generado el siguiente código de seguridad: <b>" . $codigo . "</b><br/>
            Recuerde realizar el cambio de contraseña una vez que ingrese a nuestro sistrema<br/><br/>
            Muchas gracias.

            </body></html>";

            EnviarCorreo("Acceso al sistema", $contenido, $correo);

            header('location: ../View/Login/inicioSesion.php');
        }
        else
        {
            $_POST["txtMensaje"] = "Su información no se ha validado correctamente";
            header('location: ../View/Login/inicioSesion.php');
        }
    }


    function GenerarCodigo() {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }


    function EnviarCorreo($asunto,$contenido,$destinatario)
    {
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

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