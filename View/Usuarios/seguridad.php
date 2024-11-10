<?php
    include_once '../../Controller/UsuariosController.php';

    include('../../View/_Layout_System.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - VetCare Pro</title>
    <link rel="stylesheet" href="../root/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../root/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3><strong>Cambiar Contraseña</strong></h3>
                    </div>
                    <form action="../../Controller/LoginController.php" method="post">
                        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($idUsuario); ?>">

                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña:</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="confirm_password">Confirmar Contraseña:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>

                        <button type="submit" name="btnSeguridad" class="btn btn-primary w-100 mt-3">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <a href="/SC-502_Vetcare_Pro/index.php">
                <img src="../root/img/logo/logo.png" alt="Logo VetCare Pro" width="100">
            </a>
            <p class="text-muted">&copy; <script>document.write(new Date().getFullYear());</script> VetCare Pro. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../root/js/jquery-1.11.1.min.js"></script>
    <script src="../root/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
