<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Acceso - VetCare Pro</title>
    <link rel="stylesheet" href="../root/css/all.min.css"> <!-- Asegúrate de tener la hoja de estilos FontAwesome -->
    <link rel="stylesheet" href="../root/css/adminlte.min.css"> <!-- Asegúrate de tener la hoja de estilos AdminLTE -->
    <link rel="stylesheet" href="../root/css/style.css"> <!-- Asegúrate de tener esta hoja de estilos -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="recovery-container">
            <img src="../root/img/logo/logo.png" alt="VetCare Pro" class="logo">
            <h1>Recupera tu Contraseña</h1>
            <p class="description">¿Olvidaste tu contraseña? No te preocupes, te ayudaremos a recuperarla.</p>
            <form class="recovery-form">
                <div class="form-group">
                    <label for="email">Ingresa tu correo electrónico:</label>
                    <input type="email" id="email" placeholder="tu-email@ejemplo.com" required>
                </div>
                <button type="submit" class="btn-recover">Recuperar Contraseña</button>
            </form>
            <p class="back-link"><a href="/SC-502_Vetcare_Pro/Index.php">Volver al inicio de sesión</a></p>
        </div>
    </div>

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif; /* Cambiado a la fuente de la plantilla */
            background-color: #f4f6f9; /* Color de fondo similar al de la plantilla */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .recovery-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        h1 {
            color: #4CAF50; /* Color verde para dar sensación de cuidado */
            font-size: 1.5em; /* Tamaño de fuente similar al de la plantilla */
        }
        .description {
            margin: 10px 0 20px;
            font-size: 1.1em;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold; /* Negrita para etiquetas */
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-recover {
            background-color: #4CAF50; /* Botón verde */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
            width: 100%; /* Asegurarse de que el botón ocupe todo el ancho */
        }
        .btn-recover:hover {
            background-color: #45a049; /* Color más oscuro al pasar el ratón */
        }
        .back-link {
            margin-top: 20px;
        }
        .back-link a {
            color: #007BFF; /* Color azul para el enlace */
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline; /* Subrayar al pasar el ratón */
        }
    </style>
</body>
</html>
