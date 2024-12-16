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

<!-- Incluir el contenido específico de la vista -->
<div class="container">
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Administrar Veterinarios</h3>
                                </div>

                                <!-- Pestañas de Mascotas Activas e Inactivas -->
                                <ul class="nav nav-tabs" id="veterinariosTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="veterinarios-activos-tab" data-toggle="tab" href="#veterinarios-activos" role="tab" aria-controls="veterinarios-activos" aria-selected="true">Veterinarios Activos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="veterinarios-inactivos-tab" data-toggle="tab" href="#veterinarios-inactivos" role="tab" aria-controls="veterinarios-inactivos" aria-selected="false">Veterinarios Inactivas</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="veterinariosTabsContent">
                                    <!-- Tabla de Mascotas Activas -->
                                    <div class="tab-pane fade show active" id="veterinarios-activos" role="tabpanel" aria-labelledby="veterinarios-activos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableActivos" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Especialidad</th>
                                                        <th>Telefono</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($Datos)) : ?>
                                                        <?php foreach ($Datos as $veterinarios) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($veterinarios['NombreVeterinarios']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinarios['Especialidad']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinarios['Telefono']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinarios['Email']); ?></td>
                                                                <td>
                                                                    <a href="actualizarVeterinarios.php?id=<?php echo $veterinarios['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                                    <a href="../../Controller/VeterinariosController.php?desactivarVeterinario=1&id=<?php echo $veterinarios['Id']; ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No se encontraron veterinarios activos.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tabla de Mascotas Inactivas -->
                                    <div class="tab-pane fade" id="veterinarios-inactivos" role="tabpanel" aria-labelledby="veterinarios-inactivos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableInactivos" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                        <th>Nombre</th>
                                                        <th>Especialidad</th>
                                                        <th>Telefono</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($DatosInactivos)) : ?>
                                                        <?php foreach ($DatosInactivos as $veterinariosInactivos) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($veterinariosInactivos['NombreVeterinarios']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinariosInactivos['Especialidad']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinariosInactivos['Telefono']); ?></td>
                                                                <td><?php echo htmlspecialchars($veterinariosInactivos['Email']); ?></td>
                                                                <td>
                                                                    <a href="actualizarVeterinarios.php?id=<?php echo $veterinariosInactivos['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                                    <a href="../../Controller/VeterinariosController.php?activarVeterinarios=1&id=<?php echo $veterinariosInactivos['Id']; ?>" class="btn btn-success"><i class="bi bi-check-square-fill"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No se encontraron veterinarios inactivos.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
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

<!-- Carga de scripts para DataTables y SweetAlert -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-ES.json"></script>

<script>
    $(document).ready(function () {
        $('#DataTableActivos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es-ES.json'
            },
            columnDefs: [
                { type: 'num', targets: 0 }
            ],
            order: [[0, 'desc']]
        });
        $('#DataTableInactivos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es-ES.json'
            },
            columnDefs: [
                { type: 'num', targets: 0 }
            ],
            order: [[0, 'desc']]
        });
    });

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
