<?php
include_once '../../Controller/DuenosController.php';

$title = "Consultar Dueños";
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
                                    <h3 class="h4 text-gray-900 mb-4">Consultar Dueños</h3>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Dirección</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($Datos)) : ?>
                                                <?php foreach ($Datos as $dueno) : ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($dueno['NombreDuenos']); ?></td>
                                                        <td><?php echo htmlspecialchars($dueno['Telefono']); ?></td>
                                                        <td><?php echo htmlspecialchars($dueno['Email']); ?></td>
                                                        <td><?php echo htmlspecialchars($dueno['Direccion']); ?></td>
                                                        <td><?php echo $dueno['Activo'] ? 'Activo' : 'Inactivo'; ?></td>
                                                        <td>
                                                            <!--<a href="editarDueno.php?id=<?php echo $dueno['Id']; ?>">Editar</a>-->
                                                            <?php if ($dueno['Activo']) : ?>
                                                                <a href="../../Controller/DuenosController.php?desactivarDueno=<?php echo $dueno['Id']; ?>">Desactivar</a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron dueños registrados.</td>
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
