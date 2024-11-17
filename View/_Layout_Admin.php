<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . '/SC-502_Vetcare_Pro/Controller/LoginController.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $idUsuario = $_SESSION['IdSession'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System</title>

  <link rel="stylesheet" href="../root/css/all.min.css">
  <link rel="stylesheet" href="../root/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../root/css/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../root/css/jqvmap.min.css">
  <link rel="stylesheet" href="../root/css/adminlte.min.css">
  <link rel="stylesheet" href="../root/ss/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../root/css/daterangepicker.css">
  <link rel="stylesheet" href="../root/css/summernote-bs4.min.css">
  <link rel="stylesheet" href="../root/css/style4.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="drop2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="user-panel d-flex align-items-center">
          <div class="image">
            <img src="../root/img/admin/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" width="30" height="30">
          </div>
          <div class="info">
            <?php if (isset($_SESSION["NombreUsuario"])): ?>
              <span class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION["NombreUsuario"]); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop2">
        <div class="message-body">
          <?php if (isset($_SESSION["NombreUsuario"])): ?>
            <a href="../Usuarios/perfil.php?idperfil=<?php echo $idUsuario; ?>" class="d-flex align-items-center gap-2 dropdown-item">
              <i class="ti ti-user fs-6"></i>
              <p class="mb-0 fs-3">Mi Perfil</p>
            </a>
            <a href="../Usuarios/seguridad.php?idseguridad=<?php echo $idUsuario; ?>" class="d-flex align-items-center gap-2 dropdown-item">
              <i class="ti ti-list-check fs-6"></i>
              <p class="mb-0 fs-3">Seguridad</p>
            </a>
            <form action="" method="POST">
              <button type="submit" style="width:150px" id="btnCerrarSesion" name="btnCerrarSesion"
                      class="btn btn-outline-primary mx-3 mt-2 d-block">Cerrar Sesión</button>
            </form>
          <?php else: ?>
            <a href="../Login/inicioSesion.php" style="width:150px" class="btn btn-outline-primary mx-3 mt-2 d-block">Iniciar Sesión</a>
          <?php endif; ?>
        </div>
      </div>
    </li>
  </ul>
</nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
      <img src="../root/img/logo/logo.png" alt="VetCare Pro" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">VetCare Pro</span>
    </a>

       <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
               <li class="nav-item">
            <a href="../System/Index_Admin.php" class="nav-link">
            <i class="bi bi-house"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/uplot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>uPlot</p>
                </a>
              </li>
            </ul>
          </li>
      </nav>
    </div>
  </aside>

  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<script src="../root/js/jquery.min.js"></script>
<script src="../root/js/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>


<script src="../root/js/bootstrap.bundle.min.js"></script>
<script src="../root/js/Chart.min.js"></script>
<script src="../root/js/sparkline.js"></script>
<script src="../root/js/jquery.vmap.min.js"></script>
<script src="../root/js/jquery.vmap.usa.js"></script>
<script src="../root/js/jquery.knob.min.js"></script>
<script src="../root/js/moment.min.js"></script>
<script src="../root/js/daterangepicker.js"></script>
<script src="../root/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../root/js/summernote-bs4.min.js"></script>
<script src="../root/js/jquery.overlayScrollbars.min.js"></script>
<script src="../root/js/adminlte.js"></script>
<script src="../root/js/pages/dashboard.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<style>
  body {
    background: url('../root/img/backgrounds/Fondo2.jpg') no-repeat center center fixed;
    background-size: 100% auto;
  }

  .wrapper {
    background: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
    padding: 20px;
    border-radius: 10px; /* Opcional: bordes redondeados */
  }
</style>