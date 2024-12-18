<?php
    include_once '../../Controller/UsuariosController.php';

    $title = "Consultar Logs";
    $content = __FILE__;

    include('../../View/_Layout_System.php');
?>

<div class="container">
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Logs</h3>
                                </div>
                                
                                <div class="mb-3">
                                    <form action="../../Controller/UsuariosController.php" method="post" style="display:inline;">
                                        <button type="submit" id="btnDescargarLogs" name="btnDescargarLogs" class="btn btn-primary"><i class="bi bi-download"></i> Descargar</button>
                                    </form>
                                    <button id="btnEliminarLogs" class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Eliminar</button>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="DataTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Acción</th>
                                                <th>Descripción</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($DatosLogs)) : ?>
                                                <?php foreach ($DatosLogs as $consultarLogs) : ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars(isset($consultarLogs['accion']) ? $consultarLogs['accion'] : ''); ?></td>
                                                        <td><?php echo htmlspecialchars(isset($consultarLogs['descripcion']) ? $consultarLogs['descripcion'] : ''); ?></td>
                                                        <td><?php echo htmlspecialchars(isset($consultarLogs['usuario_id']) ? $consultarLogs['usuario_id'] : ''); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No se encontraron logs registrados.</td>
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

<!-- Scripts para SweetAlert y DataTables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-ES.json"></script>

<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es-ES.json'
            },
            columnDefs: [
                { type: 'num', targets: 0 }
            ],
            order: [[0, 'desc']]
        });

        // Asignar SweetAlert al botón de eliminación
        $('#btnEliminarLogs').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../Controller/UsuariosController.php',
                        type: 'POST',
                        data: { btnEliminarLogs: true },
                        success: function (response) {
                            Swal.fire(
                                'Eliminado!',
                                'Todos los registros de logs han sido eliminados.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al eliminar los registros.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    // Mostrar mensajes de éxito o error
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
