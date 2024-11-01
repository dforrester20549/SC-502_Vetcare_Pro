<?php
    include_once '../../Controller/UsuariosController.php';

    $title = "Consultar Usuarios";
    $content = __FILE__;

    include('../../View/_Layout_System.php');
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
                                    <h3 class="h4 text-gray-900 mb-4">Administrar Usuarios</h3>
                                </div>
                                
                                <!-- Pestañas de Usuarios Activos e Inactivos -->
                                <ul class="nav nav-tabs" id="usuariosTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="usuarios-activos-tab" data-toggle="tab" href="#usuarios-activos" role="tab" aria-controls="usuarios-activos" aria-selected="true">Usuarios Activos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="usuarios-inactivos-tab" data-toggle="tab" href="#usuarios-inactivos" role="tab" aria-controls="usuarios-inactivos" aria-selected="false">Usuarios Inactivos</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="usuariosTabsContent">
                                    <!-- Tabla de Usuarios Activos -->
                                    <div class="tab-pane fade show active" id="usuarios-activos" role="tabpanel" aria-labelledby="usuarios-activos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableActivos" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Identificación</th>
                                                        <th>Nombre</th>
                                                        <th>Correo Electrónico</th>
                                                        <th>Rol</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($DatosActivos)) : ?>
                                                        <?php foreach ($DatosActivos as $usuariosActivos) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($usuariosActivos['Identificacion']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosActivos['Nombre']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosActivos['Correo']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosActivos['NombreRol']); ?></td>
                                                                <td><?php if ($usuariosActivos['tRol_id'] !== '1') : ?>
                                                                        <a href="actualizarUsuario.php?id=<?php echo $usuariosActivos['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-person-gear"></i></a>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">No se encontraron Usuarios Registrados.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tabla de Usuarios Inactivos -->
                                    <div class="tab-pane fade show active" id="usuarios-inactivos" role="tabpanel" aria-labelledby="usuarios-inactivos-tab">
                                        <div class="table-responsive">
                                            <table id="DataTableInactivos" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Identificación</th>
                                                        <th>Nombre</th>
                                                        <th>Correo Electrónico</th>
                                                        <th>Rol</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($DatosInactivos)) : ?>
                                                        <?php foreach ($DatosInactivos as $usuariosInactivos) : ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($usuariosInactivos['Identificacion']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosInactivos['Nombre']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosInactivos['Correo']); ?></td>
                                                                <td><?php echo htmlspecialchars($usuariosInactivos['NombreRol']); ?></td>
                                                                <td><?php if ($usuariosInactivos['tRol_id'] !== '1') : ?>
                                                                        <a href="actualizarUsuario.php?id=<?php echo $usuariosInactivos['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-person-gear"></i></a>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">No se encontraron Usuarios Registrados.</td>
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
