<?php

    include_once '../../Controller/VeterinariosController.php';
    include_once '../_Layout_Externo.php';

    $destacados = consultarVeterinariosDestacados();

?>
<main> 
    <!-- Hero Area Start -->
    <div class="slider-area2 slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center pt-50">
                        <h2>Sobre Nosotros</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->

    <!-- About Details Start -->
    <div class="about-details section-padding30">
        <div class="container">
            <div class="row">
                <div class="offset-xl-1 col-lg-8">
                    <div class="about-details-cap mb-50">
                        <h4>Nuestra Misión</h4>
                        <p>En <strong>Veterinaria San Pedro</strong>, nuestra misión es proporcionar atención médica de la más alta calidad para sus mascotas, garantizando su bienestar y felicidad. Nos comprometemos a ofrecer servicios profesionales y personalizados en un ambiente cálido y amigable.</p>
                    </div>

                    <div class="about-details-cap mb-50">
                        <h4>Nuestra Visión</h4>
                        <p>Ser la clínica veterinaria de referencia en Costa Rica, reconocida por nuestro profesionalismo, compromiso con la salud animal y nuestra relación de confianza con los dueños de mascotas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Details End -->

    <!-- Professional Team Start -->
    <div class="team-area section-padding30">
        <div class="container">
            <div class="row justify-content-sm-center">
                <div class="cl-xl-7 col-lg-8 col-md-10">
                    <!-- Section Title -->
                    <div class="section-tittle text-center mb-70">
                        <span>Nuestros Profesionales</span>
                        <h2>Conoce a nuestro equipo</h2>
                    </div> 
                </div>
            </div>

                <!-- Veterinarios Activos -->
                <div class="tab-pane fade show active" id="veterinarios-activos" role="tabpanel" aria-labelledby="veterinarios-activos-tab">
                    <div class="row">
                        <?php if (!empty($destacados)) : ?>
                            <?php foreach ($destacados as $destacado) : ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <!-- Contenedor de la imagen -->
                                        <div class="card-img-top text-center p-3">
                                            <img 
                                                src="<?php echo !empty($destacado['ImagePath']) ? htmlspecialchars($destacado['ImagePath']) : '/SC-502_Vetcare_Pro/View/root/img/veterinario/noimage.jpg'; ?>" 
                                                alt="Imagen Veterinario" 
                                                class="rounded-circle img-fluid" 
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-text"><strong><?php echo htmlspecialchars($destacado['Nombre'] ?? 'Sin Nombre'); ?></strong></h5>
                                            <p class="card-text"><strong>Especialidad:</strong> <?php echo htmlspecialchars($destacado['Especialidad'] ?? 'No disponible'); ?></p>
                                            <p class="card-text"><strong>Teléfono:</strong> <?php echo htmlspecialchars($destacado['Telefono'] ?? 'No disponible'); ?></p>
                                            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($destacado['Email'] ?? 'No disponible'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <p>No se encontraron veterinarios activos.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

        </div>
    </div>
    <!-- Professional Team End -->

</main>

<?php
    include_once '../_Footer.php';
?> 
</html>
