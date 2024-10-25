<?php
    include_once '../../Controller/LoginController.php';

    // Verifica si el token es válido (esto es opcional y depende de cómo manejes el flujo)
    if (!isset($_GET['token']) || empty($_GET['token'])) {
        echo "Token no válido o faltante.";
        exit();
    }

    $token = $_GET['token'];
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-box">
                    <h2>Cambiar Contraseña</h2>
                    <form action="../../Controller/LoginController.php" method="post">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        
                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña:</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirmar Contraseña:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>

                        <button type="submit" name="btnChangePassword" class="btn btn-primary w-100">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../root/js/jquery-1.11.1.min.js"></script>
    <script src="../root/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>