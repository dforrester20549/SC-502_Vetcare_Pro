<?php
    include_once '../../Controller/UsuariosController.php';


    $title = "Actualizar Usuario";
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
                        <div class="col-lg-3 d-none d-lg-block"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar Usuario</h3>
                                </div>

                                <?php
                                    if (isset($_SESSION["txtMensaje"])) {
                                        echo '<div class="alert alert-info text-center">' . htmlspecialchars($_SESSION["txtMensaje"]) . '</div>';
                                        unset($_SESSION["txtMensaje"]); 
                                    }

                                    if (isset($actualizarusuario) && $actualizarusuario):
                                ?>
                                    <form method="post" action="actualizarUsuario.php">
                                        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($actualizarusuario['Id']); ?>">

                                            <div class="form-group col-md">
                                                <label class="form-label" for="EstadoUsuario">Estado del Usuario</label><br>
                                                <select class="form-control" id="EstadoUsuario" name="Activo" required>
                                                    <option value="1" <?php echo isset($actualizarusuario['Activo']) && intval($actualizarusuario['Activo']) === 1 ? 'selected' : ''; ?>>Habilitado</option>
                                                    <option value="0" <?php echo isset($actualizarusuario['Activo']) && intval($actualizarusuario['Activo']) === 0 ? 'selected' : ''; ?>>Inhabilitado</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" 
                                                    value="<?php echo htmlspecialchars($actualizarusuario['Nombre']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Cedula" class="form-control form-control-user" placeholder="Cédula" 
                                                    value="<?php echo htmlspecialchars($actualizarusuario['Identificacion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="email" name="Correo" class="form-control form-control-user" placeholder="Correo Electrónico" 
                                                    value="<?php echo htmlspecialchars($actualizarusuario['Correo']); ?>" required>
                                            </div><br>

                                            <div class="form-group col-md">
                                                <label class="form-label">Seleccione el Rol</label>
                                                <select name="NombreRol" class="form-control" id="Id" required>
                                                    <option value="">Seleccione el Rol</option>
                                                    <?php foreach ($Roles as $Rol): ?>
                                                        <option value="<?php echo $Rol['Id']; ?>" <?php echo ($Rol['Id'] == $actualizarusuario['tRol_id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($Rol['NombreRol']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div><br>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" 
                                            id="btnActualizarUsuario" name="btnActualizarUsuario" value="Procesar">
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-danger text-center">No se pudo cargar la información del usuario.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
