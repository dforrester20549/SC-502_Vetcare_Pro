<?php
include_once '../../Controller/MedicamentosController.php';


$title = "Registrar medicamentos ";
$content = __FILE__;

include('../../View/_Layout_Admin.php');
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
                                    <h3 class="h4 text-gray-900 mb-4">Registrar medicamentos</h3>
                                </div>

                                <?php
                                if (isset($_POST["txtMensaje"])) {
                                    echo '<div class="alert alert-info Centrado">' . $_POST["txtMensaje"] . '</div>';
                                }
                                ?>

                                <form method="post" action="registrarMedicamentos.php">
                                    <div class="form-group">
                                        <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" name="Descripcion" class="form-control form-control-user" placeholder="Descripcion" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" name="Precio" class="form-control form-control-user" placeholder="Precio" required>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="text" name="Cantidad" class="form-control form-control-user" placeholder="Cantidad" required>
                                    </div><br>

                                    <input type="submit" class="btn btn-primary btn-user btn-block"
                                        id="btnRegistrarMedicamento" name="btnRegistrarMedicamento" value="Procesar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>