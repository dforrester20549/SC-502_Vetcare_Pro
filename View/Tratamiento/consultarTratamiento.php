<?php
include_once '../../Controller/TratamientoController.php';

$title = "Consultar Tratamiento";
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
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Mascotas con Cita</h3>
                                </div>

                                <div class="row">
                                    <?php if (!empty($Datos)) : ?>
                                        <?php foreach ($Datos as $tratamiento) : ?>
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <?php echo htmlspecialchars($tratamiento['NombreMascota']); ?>
                                                        </h5>
                                                        <p class="card-text">
                                                            <strong>Tipo:</strong> <?php echo htmlspecialchars($tratamiento['TipoMascota']); ?><br>
                                                            <strong>Edad:</strong> <?php echo htmlspecialchars($tratamiento['Edad']); ?><br>
                                                            <strong>Fecha de Cita:</strong> <?php echo date('d-m-Y', strtotime($tratamiento['FechaCita'])); ?><br>
                                                            <strong>Motivo:</strong> <?php echo htmlspecialchars($tratamiento['MotivoCita']); ?><br>
                                                            <strong>Estado Cita:</strong>
                                                                <span style="
                                                                    <?php 
                                                                    if ($tratamiento['EstadoCita'] == 'pendiente') {
                                                                        echo 'color: #FFA726; font-weight: bold;'; 
                                                                    } elseif ($tratamiento['EstadoCita'] == 'cancelada') {
                                                                        echo 'color: #EF5350; font-weight: bold;'; 
                                                                    } elseif ($tratamiento['EstadoCita'] == 'completada') {
                                                                        echo 'color: #66BB6A; font-weight: bold;'; 
                                                                    }
                                                                ?>
                                                                ">
                                                                    <?php echo htmlspecialchars($tratamiento['EstadoCita']); ?>
                                                                </span><br>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                No se encontraron tratamientos registrados.
                                            </div>
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
