<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Registrar Usuario - VetCare Pro</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <header>
        <div class="header-area header-transparent">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="/SC-502_Vetcare_Pro/index.php"><img src="../img/logo/logo.png" alt="Logo VetCare Pro"></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="/SC-502_Vetcare_Pro/View/Login/inicioSesion.php" class="header-btn" style="font-size: 24px; display: flex; align-items: center;">
                                        <i class="bi bi-person" style="margin-right: 5px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <main>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-wrapper bg-light p-5 rounded shadow">
                        <h2 class="text-center mb-4">Registrar Usuario</h2>
                        <form action="procesarRegistro.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese sus apellidos" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="identificacion">Identificación</label>
                                <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Ingrese su identificación" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="telefono">Número Telefónico</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su número telefónico" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="provincia">Provincia</label>
                                <select class="form-control" id="provincia" name="provincia" required>
                                    <option value="" selected disabled>Seleccione una provincia</option>
                                    <option value="San José">San José</option>
                                    <option value="Alajuela">Alajuela</option>
                                    <option value="Cartago">Cartago</option>
                                    <option value="Heredia">Heredia</option>
                                    <option value="Guanacaste">Guanacaste</option>
                                    <option value="Puntarenas">Puntarenas</option>
                                    <option value="Limón">Limón</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="canton">Cantón</label>
                                <input type="text" class="form-control" id="canton" name="canton" placeholder="Ingrese el cantón" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="distrito">Distrito</label>
                                <input type="text" class="form-control" id="distrito" name="distrito" placeholder="Ingrese el distrito" required>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary w-100">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-12">
                            <div class="footer-logo text-center mb-3">
                                <a href="/SC-502_Vetcare_Pro/index.php"><img src="../img/logo/logo.png" alt="Logo VetCare Pro" width="100"></a>
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

    <!-- JS here -->
    <script src="../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>