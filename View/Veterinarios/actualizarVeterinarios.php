<?php
    include_once '../../Controller/VeterinariosController.php';

    $title = "Actualizar Veterinario";
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
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar Veterinario</h3>
                                </div>

                                <?php
                                    if (isset($actualizarveterinarios) && $actualizarveterinarios):
                                ?>
                                    <form method="post" action="actualizarVeterinarios.php" enctype="multipart/form-data">
                                        <input type="hidden" name="Id" value="<?php echo htmlspecialchars($actualizarveterinarios['Id']); ?>">

                                        <div class="form-group">
                                            <label for="ImagePath" class="form-label">Nombre del Veterinario</label>
                                                <input type="text" name="NombreVeterinarios" class="form-control form-control-user" placeholder="Nombre del Veterinario" 
                                                    value="<?php echo htmlspecialchars($actualizarveterinarios['NombreVeterinarios']); ?>" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="ImagePath" class="form-label">Teléfono</label>
                                                <input type="text" name="Telefono" class="form-control form-control-user" placeholder="Teléfono" 
                                                    value="<?php echo htmlspecialchars($actualizarveterinarios['Telefono']); ?>" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="ImagePath" class="form-label">Correo Electrónico</label>
                                                <input type="email" name="Email" class="form-control form-control-user" placeholder="Correo Electrónico" 
                                                    value="<?php echo htmlspecialchars($actualizarveterinarios['Email']); ?>" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="ImagePath" class="form-label">Especialidad</label>
                                                <input type="text" name="Especialidad" class="form-control form-control-user" placeholder="Especialidad" 
                                                    value="<?php echo htmlspecialchars($actualizarveterinarios['Especialidad']); ?>" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="ImagePath" class="form-label">Imagen del Veterinario</label>
                                            <input type="file" name="txtImagen" class="form-control">
                                            <?php if (!empty($actualizarveterinarios['ImagePath'])): ?>
                                                <img src="<?php echo htmlspecialchars($actualizarveterinarios['ImagePath']); ?>" alt="Imagen del Veterinario" class="img-fluid mt-2" style="max-width: 100px;">
                                                <input type="hidden" name="ImagePath" value="<?php echo htmlspecialchars($actualizarveterinarios['ImagePath']); ?>">
                                            <?php endif; ?>
                                        </div><br>

                                        <div class="form-group col-md">
                                            <label class="form-label">Destacado</label>
                                            <select name="Destacado" class="form-control" required>
                                                <option value="0" <?php echo $actualizarveterinarios['Destacado'] == 0 ? 'selected' : ''; ?>>No</option>
                                                <option value="1" <?php echo $actualizarveterinarios['Destacado'] == 1 ? 'selected' : ''; ?>>Sí</option>
                                            </select>
                                        </div><br>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" 
                                            id="btnActualizarVeterinario" name="btnActualizarVeterinario" value="Procesar">
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-danger text-center">No se pudo cargar la información del veterinario.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
