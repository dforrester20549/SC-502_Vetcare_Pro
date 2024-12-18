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
  <title>VetCare - Veterinario</title>

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
            <a href="../System/Index_Veterinario.php" class="nav-link">
            <i class="bi bi-house"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <!-- Mascotas -->
          <li class="nav-item">
            <a href="*" class="nav-link">
            <i class="bi bi-bug-fill"></i>
              <p>
                Mascotas
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="../Mascotas/consultarMascotas.php?consultarMascotas=1" class="nav-link">
                <i class="bi bi-person-check"></i>
                  <p>Consultar Mascotas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Mascotas/registrarMascotas.php" class="nav-link">
                <i class="bi bi-person-plus"></i>
                  <p>Registrar Mascotas</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Citas -->
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="bi bi-calendar3"></i>
              <p>Citas</p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Citas/Citas.php?Citas=1" class="nav-link">
                <i class="bi bi-calendar-check-fill"></i>
                  <p>Consultar Citas</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../Citas/ModificaCitas.php?ModificaCitas=1" class="nav-link">
                <i class="bi bi-calendar-plus-fill"></i>
                  <p>Modificar Citas</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Medicamentos -->
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="bi bi-capsule"></i>
              <p>Medicamentos</p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="../Medicamentos/ConsultarMedicamentos.php?consultarMedicamentos=1" class="nav-link">
                <i class="bi bi-prescription2"></i>
                  <p>Consultar Medicamentos</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../Medicamentos/registrarMedicamentos.php?registrarMedicamentos=1" class="nav-link">
                <i class="bi bi-prescription"></i>
                  <p>Registrar Medicamentos</p>
                </a>
              </li>
            </ul>
          </li>

           <!-- Tratamiento -->
           <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="bi bi-hospital"></i>
              <p>Tratamiento</p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Tratamiento/consultarTratamiento.php?consultarTratamiento=1" class="nav-link">
                <i class="bi bi-bandaid"></i>
                  <p>Consultar Tratamiento</p>
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
    background-size: 100%; 
    height: 100vh;
    margin: 0;
    padding: 0;
  }

  .wrapper {
    background: rgba(255, 255, 255, 0.8); 
    padding: 20px;
    border-radius: 10px; 
  }
</style>