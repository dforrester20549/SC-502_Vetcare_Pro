<?php
    include_once '../../Controller/CitasController.php';

    $title = "Citas";
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
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="h4 text-gray-900 mb-4">Agendar Cita</h3>
                                </div>

                                <!-- Formulario de Agendar Cita -->
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="txtidmascota">Ingrese el ID de su mascota</label>
                                        <input type="text" class="form-control" id="txtidmascota" name="txtidmascota" placeholder="ID">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="txtfecha">Fecha de la cita</label>
                                        <input type="text" class="form-control" id="txtfecha" name="txtfecha" placeholder="Año-Mes-Día">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="txtMotivo">Motivo por el que solicita la cita</label>
                                        <input type="text" class="form-control" id="txtMotivo" name="txtMotivo" placeholder="Motivo">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="txtvetid">ID del veterinario que atiende a su mascota</label>
                                        <input type="text" class="form-control" id="txtvetid" name="txtvetid" placeholder="ID vet">
                                    </div>
                                    <div class="mt-4 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" id="btnAgendarCita" name="btnAgendarCita">Procesar</button>
                                        <a href="ModificarCitas.php" class="btn btn-secondary">Modificar</a>
                                    </div>
                                </form>

                                <!-- Mostrar mensaje si existe -->
                                <?php if (isset($_POST["txtMensaje"])) : ?>
                                    <div class="alert alert-info text-center mt-4">
                                        <?php echo htmlspecialchars($_POST["txtMensaje"]); ?>
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
