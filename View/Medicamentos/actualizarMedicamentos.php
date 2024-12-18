<?php
    include_once '../../Controller/MedicamentosController.php';


    $title = "Actualizar medicamento";
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
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar medicamentos</h3>
                                </div>

                                    <form method="post" action="actualizarmedicamento.php">
                                        <input type="hidden" name="idMedicamento" value="<?php echo htmlspecialchars($actualizarmedicamento['Id']); ?>">

                                            <div class="form-group">
                                                <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Nombre']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Descripcion" class="form-control form-control-user" placeholder="Descripcion" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Descripcion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Descripcion" class="form-control form-control-user" placeholder="Descripcion" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Descripcion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Dosis" class="form-control form-control-user" placeholder="Dosis" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Dosis']); ?>" required>
                                            </div><br>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" 
                                            id="btnactualizarmedicamento" name="btnactualizarmedicamento" value="Procesar">
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

