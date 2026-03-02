<?php
// includes/footer.php
/* ========================================
   footer para todos los archivos php
   ligados al index.php
======================================== */
?>
</main>

<!-- Footer Elegante -->
<footer class="footer">
    <div class="container">

        <!-- Footer Principal -->
        <div class="row g-4">
            <!-- Columna 1: Info (igual) -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="footer-info">
                    <h4 class="footer-logo">
                        <span class="brand-icon">✦</span>
                        Cristina Gallo
                    </h4>
                    <p class="footer-description">
                        Transformamos cada evento en una experiencia única y memorable. 
                        Profesionalismo, creatividad y pasión en cada detalle.
                    </p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/PlannerCristinaGallo/" target="_blank" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/cristinagallo_planner/" target="_blank" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/mar%C3%ADa-cristina-gallo-medina-020328191/" target="_blank" aria-label="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send/?phone=524497698371" target="_blank" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Columna 3: Contacto (original) -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <h5 class="footer-subtitle">Contacto</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="bi bi-telephone"></i>
                        <a href="tel:+524497698371">+52 449 769 8371</a>
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:cristinagallo.planner@gmail.com">cristinagallo.planner@gmail.com</a>
                    </li>
                    <p class="footer-description small">
                        <i class="bi bi-geo-alt-fill" style="color: var(--color-primary);"></i>
                        Enrique C Rebsamen 405, Bulevares, Aguascalientes
                    </p>
                </ul>
            </div>

            <!-- Columna 2: Ubicación (NUEVA) -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-subtitle">Ubicación</h5>
                <div class="map-container" style="border-radius: 12px; overflow: hidden; border: 2px solid var(--color-primary); box-shadow: 0 5px 15px rgba(0,0,0,0.3); margin-bottom: 1rem;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.506789624638!2d-102.29893768457715!3d21.88253258554442!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ee6d8c8b1c8d%3A0x8c7b8c8c8c8c8c8c!2sEnrique%20C%20Rebsamen%20405%2C%20Bulevares%201a%20Secci%C3%B3n%2C%2020120%20Aguascalientes%2C%20Ags.!5e0!3m2!1ses!2smx!4v1620000000000!5m2!1ses!2smx" 
                        width="100%" 
                        height="200" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Footer Bottom (igual) -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        &copy; <?= date('Y') ?> Cristina Gallo Planner. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="politica-privacidad.php" class="footer-link">Política de Privacidad</a>
                    <span class="separator">|</span>
                    <a href="terminos-condiciones.php" class="footer-link">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <button id="backToTop" class="back-to-top" aria-label="Volver arriba">
        <i class="bi bi-arrow-up"></i>
    </button>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/index.js"></script>
<script src="assets/js/galeria.js"></script>
<script src="assets/js/legal.js"></script>
<script src="assets/js/registro.js"></script>

<!-- Inicialización de AOS -->
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>

</body>
</html>