<?php
    include_once '../../Controller/MascotasController.php';


    $title = "Actualizar Mascotas";
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
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar Mascotas</h3>
                                </div>

                                <?php
                                    if (isset($actualizarmascota) && $actualizarmascota):
                                ?>
                                    <form method="post" action="registrarMascotas.php">

                                    <div class="form-group">
                                    <label for="NombreMascota">Nombre de la Mascota</label>
                                        <input type="text" name="NombreMascota" class="form-control form-control-user" placeholder="Nombre de la Mascota" 
                                        value="<?php echo htmlspecialchars($actualizarmascota['NombreMascotas']); ?>" required>
                                    </div><br>

                                    <div class="form-group">
                                    <label for="NombreMascota">Tipo</label>
                                        <input type="text" name="Tipo" class="form-control form-control-user" placeholder="Tipo" 
                                        value="<?php echo htmlspecialchars($actualizarmascota['Tipo']); ?>" required>
                                    </div><br>

                                    <div class="form-group">
                                    <label for="NombreMascota">Raza</label>
                                        <input type="text" name="Raza" class="form-control form-control-user" placeholder="Raza" 
                                        value="<?php echo htmlspecialchars($actualizarmascota['Raza']); ?>" required>
                                    </div><br>

                                    <div class="form-group">
                                    <label for="NombreMascota">Edad</label>
                                        <input type="text" name="Edad" class="form-control form-control-user" placeholder="Edad" 
                                        value="<?php echo htmlspecialchars($actualizarmascota['Edad']); ?>" required>
                                    </div><br>

                                    <div class="form-group">
                                    <label for="NombreMascota">Peso</label>
                                        <input type="text" name="Peso" class="form-control form-control-user" placeholder="Peso" 
                                        value="<?php echo htmlspecialchars($actualizarmascota['Peso']); ?>" required>
                                    </div><br>

                                    <input type="hidden" name="Activo" value="1">
                                    <input type="hidden" name="Id" value="<?php echo htmlspecialchars($actualizarmascota['Id']); ?>" >
                                    
                                    <div class="form-group col-md">
                                        <label class="form-label">Seleccione el Dueño</label>
                                            <select name="NombreDuenos" class="form-control" id="Id" required>
                                                <option value="">Seleccione el Dueño</option>
                                                    <?php foreach ($Duenos as $Dueno): ?>
                                                        <option value="<?php echo $Dueno['Id']; ?>">
                                                            <?php echo htmlspecialchars($Dueno['NombreDuenos']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                            </select>
                                    </div><br>

                                    <input type="submit" class="btn btn-primary btn-user btn-block" 
                                        id="btnActualizarMascota" name="btnActualizarMascota" value="Procesar">
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

