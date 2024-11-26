<?php
include_once '../../Controller/MedicamentosController.php';

$title = "Actualizar medicamento";
$content = __FILE__;

$rolUsuario = $_SESSION['Rol'];
$idUsuario = $_SESSION["IdSession"];

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
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar medicamentos</h3>
                                </div>

                                <form action="" method="POST">

                                    <div class="form-group">
                                        <input type="text" id="id" name="id" class="form-control form-control-user" placeholder="Id del medicamento" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" id="Nombre" name="Nombre" class="form-control form-control-user" placeholder="Ingrese el nuevo nombre" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-user" placeholder="Ingrese la nueva descripcion" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" id="Dosis" name="Dosis" class="form-control form-control-user" placeholder="Ingrese la nueva dosis" required>
                                    </div><br>
                                    <input type="hidden" name="IdSession" value="<?php echo  htmlspecialchars($idUsuario); ?>">

                                    <input type="submit" class="btn btn-primary btn-user btn-block"
                                        id="btnActualizarMedicamento" name="btnActualizarMedicamento" value="Procesar">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>