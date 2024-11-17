<?php
    include_once '../../Controller/MascotasController.php';

    $title = "Consultar Mascotas";
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
                                    <h3 class="h4 text-gray-900 mb-4">Administrar Mascotas</h3>
                                </div>

                                <!-- Pestañas de Mascotas Activas e Inactivas -->
                                <ul class="nav nav-tabs" id="mascotasTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="mascotas-activos-tab" data-toggle="tab" href="#mascotas-activos" role="tab" aria-controls="mascotas-activos" aria-selected="true">Mascotas Activas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="mascotas-inactivos-tab" data-toggle="tab" href="#mascotas-inactivos" role="tab" aria-controls="mascotas-inactivos" aria-selected="false">Mascotas Inactivas</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="mascotasTabsContent">
                                    <!-- Tabla de Mascotas Activas -->
                                    <div class="tab-pane fade show active" id="mascotas-activos" role="tabpanel" aria-labelledby="mascotas-activos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableActivos" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Tipo</th>
                                                        <th>Raza</th>
                                                        <th>Edad</th>
                                                        <th>Peso</th>
                                                        <th>Dueño</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($Datos)) : ?>
                                                        <?php foreach ($Datos as $mascota) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($mascota['NombreMascotas']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Tipo']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Raza']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Edad']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Peso']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['NombreDuenos']); ?></td>
                                                                <td>
                                                                    <a href="actualizarMascotas.php?id=<?php echo $mascota['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                                    <a href="../../Controller/MascotasController.php?eliminarMascotas=1&id=<?php echo $mascota['Id']; ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No se encontraron mascotas activas.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tabla de Mascotas Inactivas -->
                                    <div class="tab-pane fade" id="mascotas-inactivos" role="tabpanel" aria-labelledby="mascotas-inactivos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableInactivos" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Tipo</th>
                                                        <th>Raza</th>
                                                        <th>Edad</th>
                                                        <th>Peso</th>
                                                        <th>Dueño</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($DatosInactivos)) : ?>
                                                        <?php foreach ($DatosInactivos as $mascota) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($mascota['NombreMascotas']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Tipo']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Raza']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Edad']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['Peso']); ?></td>
                                                                <td><?php echo htmlspecialchars($mascota['NombreDuenos']); ?></td>
                                                                <td>
                                                                    <a href="actualizarMascotas.php?id=<?php echo $mascota['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                                    <a href="../../Controller/MascotasController.php?activarMascotas=1&id=<?php echo $mascota['Id']; ?>" class="btn btn-success"><i class="bi bi-check-square-fill"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No se encontraron mascotas inactivas.</td>
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
