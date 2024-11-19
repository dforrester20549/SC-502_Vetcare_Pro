<?php
    include_once '../../Controller/UsuariosController.php';


    $title = "Consultar Usuarios Inactivos";
    $content = __FILE__;

    $rolUsuario = $_SESSION['Rol']; 

    switch ($rolUsuario) {
        case 1:
            include('../../View/_Layout_System.php');
            break;
        case 2:
            include('../../View/_Layout_Admin.php');
            break;
        default:
            include('../../View/_Layout_Admin.php');
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
                                    <h3 class="h4 text-gray-900 mb-4">Consultar Usuarios Inactivos</h3>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
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
                                            <?php if (!empty($Datos)) : ?>
                                                <?php foreach ($Datos as $usuariosInactivos) : ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($usuariosInactivos['Identificacion']); ?></td>
                                                        <td><?php echo htmlspecialchars($usuariosInactivos['Nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($usuariosInactivos['Correo']); ?></td>
                                                        <td><?php echo htmlspecialchars($usuariosInactivos['NombreRol']); ?></td>
                                                        <td><?php if ($usuariosActivos['tRol_id'] !== '1') : ?>
                                                                <a href="actualizarUsuario.php?id=<?php echo $usuariosActivos['Id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-person-gear"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron Usuarios Registrados.</td>
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
