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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../root/img/logo/logo.png" alt="VetCare Pro" height="60" width="60">
  </div>

  <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <div class="user-panel d-flex align-items-center">
          <div class="image">
            <img src="../root/img/admin/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" width="30" height="30">
          </div>
          <div class="info">
            <span class="d-none d-md-inline">System</span>
          </div>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="profile.html" class="dropdown-item">
          <i class="fas fa-user-circle mr-2"></i> Perfil
        </a>
        <a href="change-password.html" class="dropdown-item">
          <i class="fas fa-lock mr-2"></i> Cambiar Contraseña
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.html" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
        </a>
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
            <a href="../Admin/home.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Home
                <i class="right fas fa-angle-left"></i>
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

</body>

</html>
