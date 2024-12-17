<?php
    include_once '../../Controller/VeterinariosController.php';

    $title = "Consultar Veterinarios";
    $content = __FILE__;

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
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-xl-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Administrar Veterinarios</h3>
                                </div>

                                <ul class="nav nav-tabs" id="veterinariosTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="veterinarios-activos-tab" data-toggle="tab" href="#veterinarios-activos" role="tab" aria-controls="veterinarios-activos" aria-selected="true">Veterinarios Activos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="veterinarios-inactivos-tab" data-toggle="tab" href="#veterinarios-inactivos" role="tab" aria-controls="veterinarios-inactivos" aria-selected="false">Veterinarios Inactivos</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="veterinariosTabsContent">
                                    <!-- Veterinarios Activos -->
                                    <div class="tab-pane fade show active" id="veterinarios-activos" role="tabpanel" aria-labelledby="veterinarios-activos-tab">
                                        <div class="row">
                                            <?php if (!empty($Datos)) : ?>
                                                <?php foreach ($Datos as $veterinario) : ?>
                                                    <div class="col-md-4">
                                                        <div class="card mb-4 shadow-sm">
                                                            <!-- Contenedor de la imagen -->
                                                            <div class="card-img-top text-center p-3">
                                                                <img 
                                                                    src="<?php echo !empty($veterinario['ImagePath']) ? htmlspecialchars($veterinario['ImagePath']) : '../../View/root/img/veterinario/noimage.jpg'; ?>" 
                                                                    alt="Imagen Veterinario" 
                                                                    class="rounded-circle img-fluid" 
                                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title text-primary">Nombre: <?php echo htmlspecialchars($veterinario['NombreVeterinarios']); ?></h5>
                                                                <p class="card-text"><strong>Especialidad:</strong> <?php echo htmlspecialchars($veterinario['Especialidad']); ?></p>
                                                                <p class="card-text"><strong>Teléfono:</strong> <?php echo htmlspecialchars($veterinario['Telefono']); ?></p>
                                                                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($veterinario['Email']); ?></p>
                                                                <div class="d-flex justify-content-between">
                                                                    <a href="actualizarVeterinarios.php?id=<?php echo $veterinario['Id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                                                    <a href="../../Controller/VeterinariosController.php?desactivarVeterinario=1&id=<?php echo $veterinario['Id']; ?>" class="btn btn-danger btn-sm">Desactivar</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="col-12 text-center">
                                                    <p>No se encontraron veterinarios activos.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Veterinarios Inactivos -->
                                    <div class="tab-pane fade" id="veterinarios-inactivos" role="tabpanel" aria-labelledby="veterinarios-inactivos-tab">
                                        <div class="row">
                                            <?php if (!empty($DatosInactivos)) : ?>
                                                <?php foreach ($DatosInactivos as $veterinario) : ?>
                                                    <div class="col-md-4">
                                                        <div class="card mb-4 shadow-sm">
                                                            <!-- Contenedor de la imagen -->
                                                            <div class="card-img-top text-center p-3">
                                                                <img 
                                                                    src="<?php echo !empty($veterinario['ImagePath']) ? htmlspecialchars($veterinario['ImagePath']) : '../../View/root/img/veterinario/noimage.jpg'; ?>" 
                                                                    alt="Imagen Veterinario" 
                                                                    class="rounded-circle img-fluid" 
                                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title text-secondary">Nombre: <?php echo htmlspecialchars($veterinario['NombreVeterinarios']); ?></h5>
                                                                <p class="card-text"><strong>Especialidad:</strong> <?php echo htmlspecialchars($veterinario['Especialidad']); ?></p>
                                                                <p class="card-text"><strong>Teléfono:</strong> <?php echo htmlspecialchars($veterinario['Telefono']); ?></p>
                                                                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($veterinario['Email']); ?></p>
                                                                <div class="d-flex justify-content-between">
                                                                    <a href="actualizarVeterinarios.php?id=<?php echo $veterinario['Id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                                                    <a href="../../Controller/VeterinariosController.php?activarVeterinario=1&id=<?php echo $veterinario['Id']; ?>" class="btn btn-success btn-sm">Activar</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="col-12 text-center">
                                                    <p>No se encontraron veterinarios inactivos.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Carga de scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (isset($_SESSION["Success"])): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?php echo $_SESSION["Success"]; ?>'
            });
            <?php unset($_SESSION["Success"]); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["Error"])): ?>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '<?php echo $_SESSION["Error"]; ?>'
            });
            <?php unset($_SESSION["Error"]); ?>
        <?php endif; ?>
    });
</script>
