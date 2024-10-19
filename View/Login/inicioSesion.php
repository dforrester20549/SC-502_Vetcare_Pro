<?php
    include_once '../../Controller/LoginController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

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
    <!-- Top content -->
    <div class="top_content">
         <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <h1><strong>Inicio de sesión</strong></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 form-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Inicie sesión en nuestra pagina</h3>
                                <p>Ingrese su Correo Electrónico y contraseña:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                            <div class="form-bottom">
                                <form role="form" action="" method="post" class="login-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Correo Electrónico</label>
                                        <input type="text" name="txtCorreo" class="form-control" id="txtCorreo"placeholder="Correo Electrónico">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Contraseña</label>
                                        <input type="password" name="txtContrasenna" placeholder="Contraseña..." class="form-control" id="txtContrasenna">
                                    </div>
                                        <button type="submit" class="btn" id="btnIniciarSesion" name="btnIniciarSesion">Inicie sesión</button>
                                    <div class="d-flex align-items-center justify-content-center" style="margin-top: 20px;"> 
                                        <a class="btn btn-primary w-100 py-8 fs-4 mb-4" href="registrarUsuario.php" style="margin-bottom: 20px;">Crear una cuenta</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <a class="btn btn-primary w-100 py-8 fs-4 mb-4" href="recuperarAcceso.php">Recuperar acceso</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
         </div>
    </div>

    <!-- Footer Start -->
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

    <script src="../root/js/jquery-1.11.1.min.js"></script>
    <script src="../root/bootstrap/js/bootstrap.min.js"></script>

</body>



</html>