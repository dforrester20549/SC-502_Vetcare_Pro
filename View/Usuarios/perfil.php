<?php
    include_once '../../Controller/UsuariosController.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $idUsuario = $_SESSION['IdSession'];
    $rolUsuario = $_SESSION['Rol'];

    switch ($rolUsuario) {
        case 1:
            include('../../View/_Layout_System.php');
            break;
        case 2:
            include('../../View/_Layout_Admin.php');
            break;
        case 3:
            include('../../View/_Layout_Veterinario.php');
            break;
        case 4:
            include('../../View/_Layout_Cliente.php');
            break;
        default:
            include('../../View/_Layout_Cliente.php');
    }
?>


<!-- Incluir el contenido específico de la vista -->
<div class="container">
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-3 d-none d-lg-block"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Mi perfil</h3>
                                </div>

                                <?php
                                    if (isset($perfil) && $perfil):
                                ?>
                                    <form action="../../Controller/UsuariosController.php" method="post">
                                        <input type="hidden" name="action" value="actualizarPerfil">
                                        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($perfil['Id']); ?>">
                                        <input type="hidden" name="Activo" value="<?php echo htmlspecialchars($perfil['Activo']); ?>">

                                            <div class="form-group">
                                                <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" 
                                                    value="<?php echo htmlspecialchars($perfil['Nombre']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Cedula" class="form-control form-control-user" placeholder="Cédula" 
                                                    value="<?php echo htmlspecialchars($perfil['Identificacion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="email" name="Correo" class="form-control form-control-user" placeholder="Correo Electrónico" 
                                                    value="<?php echo htmlspecialchars($perfil['Correo']); ?>" required>
                                            </div><br>

                                            <div class="form-group col-md">
                                                <label class="form-label">Rol</label>
                                                <p class="form-control-plaintext"><?php echo htmlspecialchars($perfil['NombreRol']); ?></p>
                                                <input type="hidden" name="NombreRol" value="<?php echo htmlspecialchars($perfil['tRol_id']); ?>">
                                            </div><br>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" 
                                            id="btnPerfil" name="btnPerfil" value="Procesar">
                                    </form>
                                <?php else: ?>
                                    <p></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Carga de scripts para DataTables y SweetAlert -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (isset($_SESSION["Success"])): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                confirmButtonColor: "#D9C65D",
                text: '<?php echo $_SESSION["Success"]; ?>'
            });
            <?php unset($_SESSION["Success"]); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["Error"])): ?>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                confirmButtonColor: "#D9C65D",
                text: '<?php echo $_SESSION["Error"]; ?>'
            });
            <?php unset($_SESSION["Error"]); ?>
        <?php endif; ?>
    });
</script>


</html>
