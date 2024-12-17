<?php
    include_once '../../Controller/UsuariosController.php';


    $title = "Registrar Usuarios ";
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

<!-- Incluir el contenido específico de la vista -->
<div class="container">
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-3 d-none d-lg-block"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Registrar Usuarios</h3>
                                </div>

                                <form method="post" action="registrarUsuario.php">
                                    <div class="form-group">
                                        <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" name="Cedula" class="form-control form-control-user" placeholder="Cédula" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="email" name="Correo" class="form-control form-control-user" placeholder="Correo Electrónico" required>
                                    </div><br>

                                    <input type="hidden" name="Activo" value="1">
                                    
                                    <div class="form-group col-md">
                                        <label class="form-label">Seleccione el Rol</label>
                                            <select name="NombreRol" class="form-control" id="Id" required>
                                                <option value="">Seleccione el Rol</option>
                                                    <?php foreach ($Roles as $Rol): ?>
                                                        <option value="<?php echo $Rol['Id']; ?>">
                                                            <?php echo htmlspecialchars($Rol['NombreRol']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                            </select>
                                    </div><br>

                                    <input type="submit" class="btn btn-primary btn-user btn-block" 
                                        id="btnRegistrarUsuario" name="btnRegistrarUsuario" value="Procesar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

