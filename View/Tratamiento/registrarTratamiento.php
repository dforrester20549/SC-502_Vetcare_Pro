<?php

    include_once '../../Controller/TratamientoController.php';
    include_once '../../Controller/MascotasController.php';

    $tratamiento = ConsultarMascotas();

    $title = "Registrar Tratamiento ";
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
                                    <h3 class="h4 text-gray-900 mb-4">Registrar Tratamiento</h3>
                                </div>

                                <form method="post" action="registrarTratamiento.php">

                                    <!-- Mascota -->
                                    <div class="form-group">
                                            <input type="number" name="tMascota_Id" class="form-control form-control-user" placeholder="tMascota_Id" required>
                                    </div><br>

                                    <!-- Fecha del Tratamiento -->
                                    <div class="form-group">
                                        <label for="Fecha_Tratamiento" class="form-label">Fecha Tratamiento</label>
                                        <input type="text" name="Fecha_Tratamiento" class="form-control form-control-user" 
                                            value="<?php echo date('Y-m-d'); ?>" 
                                            readonly required>
                                    </div><br>

                                    <!-- Descripción -->
                                    <div class="form-group">
                                        <input type="text" name="Descripcion" class="form-control form-control-user" placeholder="Descripcion" required>
                                    </div><br>

                                    <!-- Costo -->
                                    <div class="form-group">
                                        <input type="number" name="Costo" class="form-control form-control-user" placeholder="Costo" required>
                                    </div><br>

                                    <!-- Activo (Oculto) -->
                                    <input type="hidden" name="Activo" value="1">

                                    <!-- ID del Medicamento -->
                                    <div class="form-group">
                                        <input type="number" name="tMedicamento_id" class="form-control form-control-user" placeholder="tMedicamento_id" required>
                                    </div><br>

                                    <!-- Botón de Envío -->
                                    <input type="submit" class="btn btn-primary btn-user btn-block" 
                                        id="btnRegistrarTratamiento" name="btnRegistrarTratamiento" value="Procesar">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

