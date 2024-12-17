<?php
    include_once '../_Layout_Externo.php';
?>

<main>
     <!-- Hero Area Start -->
     <div class="slider-area2 slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center pt-50">
                        <h2>Contacto</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    <!-- ================ Contacto ================ -->
    <section class="contact-section">
        <div class="container">
            <!-- Mapa de Google -->
            <div class="d-none d-sm-block mb-5 pb-4">
                <div id="map" style="height: 480px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.0481089911943!2d-84.09276368469964!3d9.933444992892485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e377b7db8d1d%3A0x26b7133f5d6b98f1!2sVeterinaria%20San%20Pedro!5e0!3m2!1ses!2scr!4v1691244123047!5m2!1ses!2scr" 
                        width="100%" height="480" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!-- Formulario y Datos -->
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Comunícate con Nosotros</h2>
                </div>
                <!-- Formulario -->
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder="Escribe tu mensaje"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Tu nombre">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email" placeholder="Tu correo electrónico">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" placeholder="Asunto">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Enviar</button>
                        </div>
                    </form>
                </div>
                <!-- Información de contacto -->
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>San Pedro, Montes de Oca</h3>
                            <p>Frente a Plaza del Sol, San José, Costa Rica</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>+506 2234-5678</h3>
                            <p>Lunes a Sábado, 8am - 6pm</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>info@veterinariasanpedro.com</h3>
                            <p>¡Envíanos tu consulta en cualquier momento!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contacto End -->
</main>

<?php
    include_once '../_Footer.php';
?>
