<?php
    include_once '../_Layout_Externo.php';
?>

<main> 
    <!-- Slider Area Start -->
    <div class="slider-area">
        <div class="slider-active dot-style">
            <!-- Slider Single -->
            <div class="single-slider d-flex align-items-center slider-height">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-8 col-md-10">
                            <div class="hero__caption">
                                <span data-animation="fadeInUp" data-delay=".3s">Clínica Veterinaria San Pedro</span>
                                <h1 data-animation="fadeInUp" data-delay=".3s">Cuidamos a tus mascotas con amor</h1>
                                <p data-animation="fadeInUp" data-delay=".6s">Brindamos atención integral y especializada para tu mascota. Contacta con nosotros para más información.</p>
                                <a href="#contacto" class="hero-btn" data-animation="fadeInLeft" data-delay=".3s">Agendar Cita<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
    <!-- Slider Area End -->

    <!-- About Area Start -->
    <div class="about-area fix">
        <!-- Left Contents -->
        <div class="about-details">
            <div class="right-caption">
                <!-- Section Tittle -->
                <div class="section-tittle mb-50">
                    <h2>Comprometidos con el bienestar de tus mascotas</h2>
                </div>
                <div class="about-more">
                    <p class="pera-top">Nuestra clínica cuenta con más de 10 años de experiencia en el cuidado de animales. Ofrecemos servicios de cirugía, consultas, vacunación y emergencias 24/7.</p>
                    <p class="mb-65 pera-bottom">Ubicada en San Pedro, trabajamos con los mejores veterinarios certificados para asegurar la salud y el bienestar de tus amigos peludos.</p>
                    <a href="#servicios" class="btn">Conoce nuestros servicios</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About Area End -->

    <!-- Gallery Area Start -->
    <div class="gallery-area section-padding30">
        <div class="container fix">
            <div class="row justify-content-sm-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="section-tittle text-center mb-70">
                        <span>Momentos Especiales</span>
                        <h2>Galería de nuestras mascotas</h2>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-gallery mb-30">
                        <div class="gallery-img size-img" style="background-image: url('../../View/root/img/gallery/gallery2.png');"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-gallery mb-30">
                        <div class="gallery-img size-img" style="background-image: url('../../View/root/img/gallery/gallery4.png');"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-gallery mb-30">
                        <div class="gallery-img size-img" style="background-image: url('../../View/root/img/gallery/blog2.png');"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Area End -->

    <!-- Testimonial Start -->
    <div class="testimonial-area testimonial-padding section-bg" data-background="../../View/root/img/gallery/section_bg03.png">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10">
                    <div class="h1-testimonial-active dot-style">
                        <!-- Single Testimonial -->
                        <div class="single-testimonial text-center">
                            <div class="testimonial-caption">
                                <div class="testimonial-founder">
                                    <div class="founder-img mb-40">
                                        <img src="../../View/root/img/gallery/testi-logo.png" alt="">
                                        <span>Juan Pérez</span>
                                        <p>Cliente Satisfecho</p>
                                    </div>
                                </div>
                                <div class="testimonial-top-cap">
                                    <p>"La clínica San Pedro ha sido un salvavidas para mi perro Max. Atención rápida y profesional. Recomendadísimos!"</p>
                                </div>
                            </div>
                        </div>
                        <!-- Single Testimonial -->
                        <div class="single-testimonial text-center">
                            <div class="testimonial-caption">
                                <div class="testimonial-founder">
                                    <div class="founder-img mb-40">
                                        <img src="../../View/root/img/gallery/testi-logo.png" alt="">
                                        <span>María González</span>
                                        <p>Cliente Satisfecha</p>
                                    </div>
                                </div>
                                <div class="testimonial-top-cap">
                                    <p>"Atención de primera, el equipo médico cuidó de mi gato como si fuera suyo. Estoy muy agradecida!"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Contact Section -->
    <div id="contacto" class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 text-center">
                    <h2>Contáctanos</h2>
                    <p>Visítanos en nuestra clínica ubicada en San Pedro o llámanos para agendar una cita.</p>
                    <ul class="list-unstyled">
                        <li><strong>Teléfono:</strong> 8888-1234</li>
                        <li><strong>Email:</strong> contacto@clinicavetsanpedro.com</li>
                        <li><strong>Dirección:</strong> Avenida Central, San Pedro, Costa Rica</li>
                    </ul>
                    <a href="mailto:contacto@clinicavetsanpedro.com" class="btn btn-primary">Enviar Correo</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    include_once '../_Footer.php';
?>
