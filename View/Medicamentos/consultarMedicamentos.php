<?php
include_once '../../Controller/MedicamentosController.php';

$title = "Consultar medicamentos";
include('../../View/_Layout_Admin.php');
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
                                    <h3 class="h4 text-gray-900 mb-4">Consultar medicamentos</h3>
                                </div>

                                <!-- Formulario para el botón de consultar -->
                                <form method="get" action="">
                                    <input type="hidden" name="btnconsultarMedicamentos" value="true">
                                    <button type="submit" class="btn btn-primary">Refrescar</button>
                                </form>

                                <div class="table-responsive" style="margin-top: 20px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Identificación</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Dosis</th>
                                                <th>Activo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($Datos)) : ?>
                                                <?php foreach ($Datos as $medicamento) : ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($medicamento['Id']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['Nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['Descripcion']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['Dosis']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['Activo']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No se encontraron medicamentos registrados.</td>
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