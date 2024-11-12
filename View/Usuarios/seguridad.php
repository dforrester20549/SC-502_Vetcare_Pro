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



    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3><strong>Cambiar Contraseña</strong></h3>
                    </div>
                    <form action="../../Controller/UsuariosController.php" method="post">
                        <input type="hidden" name="action" value="seguridad">
                        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($idUsuario); ?>">

                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña:</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="confirm_password">Confirmar Contraseña:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>

                        <button type="submit"  id="btnSeguridad" name="btnSeguridad" class="btn btn-primary w-100 mt-3">Cambiar Contraseña</button>
                    </form>
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
