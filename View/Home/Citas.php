<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . '/Controller/CitasController.php';
    include_once '../_Layout_Externo.php';
    
?>

<main> 
<!-- Hero Area Start -->
    <div class="slider-area2 slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center pt-50">
                                <h2>Agendar cita</h2>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</main>
<!-- Hero Area End -->
<Body>
<br></br>
<br></br>
<br></br>
<!-- FORM -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">

                <form action="" method="POST">

                <br></br>
                <h2>Para agendar su cita por favor llenar el formulario</h2>
                <br></br>
                <?php
                                    if(isset($_POST["txtMensaje"]))
                                    {
                                        echo '<div class="alert alert-info Centrado">' . $_POST["txtMensaje"] . '</div>';
                                    }
                                ?>

                    <div class="form-group">
                        <label for="form-label">Ingrese el ID de su mascota</label>
                        <input type="text" class="form-control" id="txtidmascota" name="txtidmascota" aria-describedby="emailHelp" placeholder="ID">
                    </div>
                    <br></br>
                    <div class="form-group">
                        <label for="form-label">Fecha de la cita</label>
                        <input type="text" class="form-control" id="txtfecha" name="txtfecha" placeholder="Año-Mes-Dia">
                    </div>
                    <br></br>
                    <div class="form-group">
                        <label for="form-label">Motivo por el consulta la cita</label>
                        <input type="text" class="form-control" id="txtMotivo" name="txtMotivo" placeholder="Motivo">
                    </div>
                    <br></br>
                    <div class="form-group">
                        <label for="form-label">Id del veterinario que atiende a su mascota</label>
                        <input type="text" class="form-control" id="txtvetid" name="txtvetid" placeholder="ID vet">
                    </div>
                    <br></br>
                    <button type="submit" class="btn btn-primary" id="btnAgendarCita" name="btnAgendarCita">Procesar</button>
                </form>
        </div>
    </div>
</body>
<!-- FORM -->
<?php
        include_once '../_Footer.php';
    ?> 

</html>