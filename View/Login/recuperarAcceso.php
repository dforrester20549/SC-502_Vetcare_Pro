<?php
    include_once '../../Controller/LoginController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Acceso - VetCare Pro</title>

    <!-- Importamos los estilos de la primera vista -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../root/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../root/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../root/css/form-elements1.css">
    <link rel="stylesheet" href="../root/css/style.css">
    <link rel="stylesheet" href="../root/css/style1.css">
    <link rel="stylesheet" href="../root/css/style2.css">
    <link rel="shortcut icon" href="../root/img/favicon.ico">
</head>
<body>
    <div class="top_content">
        <div class="container">

            <?php
                if(isset($_POST["txtMensaje"]))
                {
                echo '<div class="alert alert-info Centrado">' . $_POST["txtMensaje"] . '</div>';
                }
            ?>
            
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Recupera tu Contraseña</strong></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Recuperación de acceso</h3>
                            <p>Ingrese su correo electrónico para recuperar la contraseña:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="../../Controller/LoginController.php" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="email">Correo Electrónico</label>
                                <input type="email" name="txtCorreo" class="form-control" id="txtCorreo" placeholder="Correo Electrónico" required>
                            </div>
                            <button type="submit" class="btn" id="btnRecuperar" name="btnRecuperar">Recuperar Contraseña</button>
                        </form>
                        <div class="d-flex align-items-center justify-content-center" style="margin-top: 20px;">
                            <a class="btn btn-primary w-100 py-8 fs-4 mb-4" href="../Login/inicioSesion.php" style="margin-bottom: 20px;">Volver al inicio de sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-12">
                            <div class="footer-logo text-center mb-3">
                                <a href="/SC-502_Vetcare_Pro/index.php"><img src="../root/img/logo/logo.png" alt="Logo VetCare Pro" width="100"></a>
                            </div>
                            <div class="footer-copy-right text-center">
                                <p>&copy; <script>document.write(new Date().getFullYear());</script> VetCare Pro. Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../root/js/jquery-1.11.1.min.js"></script>
    <script src="../root/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
