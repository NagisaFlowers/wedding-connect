<?php
// index.php - Página principal
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-slider">
        <div class="hero-slide active" style="background-image: url('assets/images/index.png');"><!-- fondo index -->
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="hero-content" data-aos="fade-up">
                    <span class="hero-subtitle">Wedding & Event Planner</span>
                    
                    <!-- Logo principal -->
                    <img src="assets/images/herocg.png" alt="Cristina Gallo Planner" class="hero-logo">
                    
                    <!-- Texto con fuentes especiales -->
                    <h2 class="hero-title-fancy">EVENT PLANNER</h2>
                    <h3 class="hero-subtitle-fancy">Profesionalismo y precisión en cada evento</h3>
                    
                    <div class="hero-buttons">
                        <a href="#servicios" class="btn-primary">Descubrir servicios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="hero-scroll">
        <a href="#conoceme" class="scroll-down">
            <span>Descubre más</span>
            <i class="bi bi-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Sección Conóceme -->
<section id="conoceme" class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image">
                    <img src="assets/images/cristina.jpg" alt="Cristina Gallo" class="img-fluid">
                    <div class="experience-badge">
                        <span class="years">10+</span>
                        <span class="text">Años de experiencia</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-tag">Conóceme</span>
                    <h2 class="section-title">Detrás de cada gran evento</h2>
                    <p class="about-text">
                        Soy Cristina Gallo, y mi pasión es crear momentos que perduren para siempre. 
                        Cada evento es único y merece una atención personalizada, donde los detalles 
                        marcan la diferencia entre un buen evento y una experiencia inolvidable.
                    </p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>500+ Bodas realizadas</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>70+ Eventos anuales</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Red de proveedores exclusivos</span>
                        </div>
                    </div>
                    
                    <div class="about-quote">
                        <i class="bi bi-quote"></i>
                        <p>"Hacer tu evento realidad es mi mayor satisfacción. Cada proyecto es un nuevo desafío que abrazo con la misma ilusión que el primero."</p>
                    </div>
                    
                    <a href="nosotros.php" class="btn-link">Conoce más sobre mí <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección Servicios -->
<section id="servicios" class="services-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Lo que hacemos</span>
            <h2 class="section-title">Servicios Profesionales</h2>
            <p class="section-description">Diseñamos y coordinamos eventos con la más alta calidad y atención al detalle</p>
        </div>
        
        <div class="row g-4">
            <!-- Servicio 1: Bodas -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h3 class="service-title">Bodas</h3>
                    <p class="service-description">Diseño y coordinación completa de bodas de ensueño, desde la planeación hasta el último detalle.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Diseño de espacios</li>
                        <li><i class="bi bi-check-lg"></i> Iluminación especial</li>
                        <li><i class="bi bi-check-lg"></i> Centros de mesa</li>
                        <li><i class="bi bi-check-lg"></i> Coordinación completa</li>
                    </ul>
                </div>
            </div>
            
            <!-- Servicio 2: XV Años -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h3 class="service-title">XV Años</h3>
                    <p class="service-description">Celebraciones únicas para un momento tan especial. Hacemos realidad el sueño de la quinceañera.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Organización de ceremonia</li>
                        <li><i class="bi bi-check-lg"></i> Diseño de espacios</li>
                        <li><i class="bi bi-check-lg"></i> Banquete especial</li>
                        <li><i class="bi bi-check-lg"></i> Souvenirs personalizados</li>
                    </ul>
                </div>
            </div>
            
            <!-- Servicio 3: Baby Shower -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-balloon-heart"></i>
                    </div>
                    <h3 class="service-title">Baby Shower</h3>
                    <p class="service-description">Celebra la llegada del bebé con una fiesta íntima y llena de amor, con todos los detalles cuidados.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Decoración temática</li>
                        <li><i class="bi bi-check-lg"></i> Juegos y dinámicas</li>
                        <li><i class="bi bi-check-lg"></i> Buffet</li>
                        <li><i class="bi bi-check-lg"></i> Mesa de regalos</li>
                    </ul>
                </div>
            </div>
            
            <!-- Servicio 4: Empresariales -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h3 class="service-title">Empresariales</h3>
                    <p class="service-description">Eventos corporativos que reflejan la identidad de tu marca y cumplen con los objetivos de negocio.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Conferencias y convenciones</li>
                        <li><i class="bi bi-check-lg"></i> Coffee breaks / Brunch empresarial</li>
                        <li><i class="bi bi-check-lg"></i> Inauguraciones y celebraciones</li>
                        <li><i class="bi bi-check-lg"></i> Aniversarios empresariales</li>
                    </ul>
                </div>
            </div>

            <!-- Servicio 5:  Gubernamentales  -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3 class="service-title">Gubernamentales</h3>
                    <p class="service-description">Coordinación de eventos institucionales con la más alta calidad y protocolo.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Ferias y exposiciones</li>
                        <li><i class="bi bi-check-lg"></i> Festivales culturales</li>
                        <li><i class="bi bi-check-lg"></i> Conmemoraciones oficiales</li>
                        <li><i class="bi bi-check-lg"></i> Eventos de gobierno</li>
                    </ul>
                </div>
            </div>
            
            <!-- Servicio 5:  Eventos personalizados -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <h3 class="service-title">Personalizados</h3>
                    <p class="service-description">Celebraciones especiales que se te puedan ocurrir, las hacemos realidad.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Lo que tengas en mente lo realizaremos</li>
                        <li><i class="bi bi-check-lg"></i> Activaciones de marca</li>
                        <li><i class="bi bi-check-lg"></i> Halloween y posadas</li>
                        <li><i class="bi bi-check-lg"></i> Kick-offs</li>
                        <li><i class="bi bi-check-lg"></i> Los años 90s</li>
                    </ul>
                </div>
            </div>

            <!-- Servicio 6:  con que cuentan -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="service-title">¿Con que contamos?</h3>
                    <p class="service-description">Contamos con los estandares de alta calidad.</p>
                    <ul class="service-list">
                        <li><i class="bi bi-check-lg"></i> Event planning</li>
                        <li><i class="bi bi-check-lg"></i> Diseño de evento</li>
                        <li><i class="bi bi-check-lg"></i> Logística</li>
                        <li><i class="bi bi-check-lg"></i> Coordinación</li>
                        <li><i class="bi bi-check-lg"></i> Elección de proveedores</li>
                        <li><i class="bi bi-check-lg"></i> Scouting de venues / salones</li>
                        <li><i class="bi bi-check-lg"></i> Mobiliario & Loza</li>
                        <li><i class="bi bi-check-lg"></i> Entretenimientos y bebidas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección Galería -->
<section id="galeria" class="gallery-preview">
    <div class="container-fluid p-0">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Momentos inolvidables</span>
            <h2 class="section-title">Galería de Eventos</h2>
            <p class="section-description">Algunos de los momentos que hemos creado para nuestros clientes</p>
        </div>
        
        <div class="row g-0">
            <div class="col-lg-3 col-md-6" data-aos="zoom-in">
                <div class="gallery-item">
                    <img src="assets/images/bodas/01.jpg" alt="Boda de ensueño" class="img-fluid">
                    <div class="gallery-overlay">
                        <div class="gallery-content">
                            <h4>Boda Claudia & Carlos</h4>
                            <span>Gran Reserva Sabinos Residencial</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="gallery-item">
                    <img src="assets/images/xv/08.jpg" alt="XV Años" class="img-fluid">
                    <div class="gallery-overlay">
                        <div class="gallery-content">
                            <h4>XV Años - Aruba</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="gallery-item">
                    <img src="assets/images/baby/04.jpg" alt="Baby Shower" class="img-fluid">
                    <div class="gallery-overlay">
                        <div class="gallery-content">
                            <h4>Baby Shower - Juan Pablo</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="gallery-item">
                    <img src="assets/images/empresa/11.jpg" alt="Evento Empresarial" class="img-fluid">
                    <div class="gallery-overlay">
                        <div class="gallery-content">
                            <h4>Brindis Empresarial</h4>
                            <span>Ban Bajio</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="galeria.php" class="btn-link">Ver galería completa <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- Sección CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="fade-up">
            <h2 class="cta-title">¿Listo para crear algo increíble?</h2>
            <p class="cta-text">Hagamos realidad el evento de tus sueños. Contáctanos y comencemos a planear juntos.</p>
            <div class="cta-buttons">
                <a href="registro.php" class="btn-primary btn-large">Solicitar cotización</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>