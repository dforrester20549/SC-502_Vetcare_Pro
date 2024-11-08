<?php
include_once '../../Controller/MedicamentosController.php';


$title = "Consultar medicamentos";
$content = __FILE__;

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

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Identificación</th>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($Datos)) : ?>
                                                <?php foreach ($Datos as $medicamentos) : ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($medicamentos['Identificacion']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamentos['Nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamentos['Descripcion']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamentos['Precio']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamentos['Cantidad']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron medicamentos registrados.</td>
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