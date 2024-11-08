<?php
    include_once '../../Controller/MedicamentosController.php';


    $title = "Actualizar Usuario";
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
                                    <h3 class="h4 text-gray-900 mb-4">Actualizar Usuario</h3>
                                </div>

                                    <form method="post" action="actualizarmedicamento.php">
                                        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($actualizarmedicamento['Id']); ?>">

                                            <div class="form-group">
                                                <input type="text" name="Nombre" class="form-control form-control-user" placeholder="Nombre" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Nombre']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Cedula" class="form-control form-control-user" placeholder="Cédula" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Identificacion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Descripcion" class="form-control form-control-user" placeholder="Descripcion" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Descripcion']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Precio" class="form-control form-control-user" placeholder="Precio" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Precio']); ?>" required>
                                            </div><br>

                                            <div class="form-group">
                                                <input type="text" name="Cantidad" class="form-control form-control-user" placeholder="Cantidad" 
                                                    value="<?php echo htmlspecialchars($actualizarmedicamento['Cantidad']); ?>" required>
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

