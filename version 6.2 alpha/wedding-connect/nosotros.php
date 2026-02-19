<?php
$titulo = "Nosotros - Wedding Connect";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="shortcut icon" href="assets/images/logocristinagallo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Fuentes elegantes -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/nosotros.css">
</head>
<body>
    <!-- Barra de navegación ACTUALIZADA -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-heart-fill"></i> Wedding Connect
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="nosotros.php">
                            <i class="bi bi-people"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">
                            <i class="bi bi-calendar-plus"></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">
                            <i class="bi bi-shield-lock"></i> Administrar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section elegante -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Sobre Nosotros</h1>
                    <p class="lead mb-4">Más de una década creando experiencias únicas e inolvidables. Tu evento perfecto, nuestra pasión.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#historia" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-book-heart"></i> Nuestra Historia
                        </a>
                        <a href="#valores" class="btn btn-primary dark btn-lg px-4">
                            <i class="bi bi-award"></i> Nuestros Valores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestra Historia -->
    <section id="historia" class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestra Historia</h2>
                    <p class="lead text-muted">Una trayectoria de excelencia y pasión por los eventos</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card service-card">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                                    <div class="service-icon mb-3">
                                        <i class="bi bi-book-heart"></i>
                                    </div>
                                    <h4 class="card-title">Desde 2010</h4>
                                </div>
                                <div class="col-lg-8">
                                    <div class="about-text">
                                        <p class="mb-4">Cristina Gallo Event Planner se remonta a la organización de pequeñas celebraciones en entornos íntimos como casas y jardines, donde desde un inicio se forjó una sólida reputación basada en la atención al detalle y la creatividad.</p>
                                        <p class="mb-4">Este enfoque meticuloso, sumado a una apasionada dedicación por hacer de cada evento —especialmente cada boda— una experiencia única, generó un crecimiento orgánico impulsado por la recomendación boca a boca entre los clientes satisfechos.</p>
                                        <p class="mb-4">Con una ejecución demostrable de más de 70 eventos anuales y un historial de éxito en cada uno de ellos, la constante innovación y el compromiso inquebrantable con la satisfacción del cliente han posicionado a la empresa como un líder y referente en el sector de la planificación de eventos.</p>
                                        <p class="mb-0">Nuestra área de servicio es Aguascalientes, México • Jalisco, México • Aguascalientes Centro, Aguascalientes, México • Zacatecas, México.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas -->
    <section class="py-5 cta-section text-dark">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="stat-number display-4 fw-bold">10+</div>
                    <div class="stat-label h5">Años de Experiencia</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number display-4 fw-bold">70+</div>
                    <div class="stat-label h5">Eventos Anuales</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number display-4 fw-bold">500+</div>
                    <div class="stat-label h5">Bodas Realizadas</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number display-4 fw-bold">100%</div>
                    <div class="stat-label h5">Satisfacción</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Misión -->
                <div class="col-lg-6">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <h3 class="card-title mb-3">Nuestra Misión</h3>
                            <div class="mission-text text-start">
                                <p>Nuestra misión es hacer que su día sea especial y tenga todo lo que siempre soñaron, ¡y todo sin preocupaciones! Materializar la visión única de cada cliente, diseñando y ejecutando experiencias excepcionales en los ámbitos social, corporativo y gubernamental.</p>
                                <p class="mb-0">Nos comprometemos a superar expectativas a través de una planificación meticulosa, una logística impecable y un servicio apasionado, donde cada detalle es cuidado con excelencia.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Visión -->
                <div class="col-lg-6">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-eye"></i>
                            </div>
                            <h3 class="card-title mb-3">Nuestra Visión</h3>
                            <div class="vision-text text-start">
                                <p>Ser el referente indiscutible y líder en la industria de la planificación de eventos, ser reconocidos por nuestra innovación constante, nuestra adherencia al más alto protocolo y nuestra capacidad infalible para crear experiencias emocionalmente resonantes y operativamente perfectas.</p>
                                <p class="mb-0">Aspiramos a ser la primera opción para quienes buscan excelencia, confianza y un partner creativo que eleve cualquier celebración o acto institucional a su máxima expresión.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestros Valores -->
    <section id="valores" class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestros Valores</h2>
                    <p class="lead text-muted">Los principios que guían nuestro trabajo y nos definen</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-award"></i>
                            </div>
                            <h4 class="card-title">Excelencia Operativa</h4>
                            <p class="card-text">Compromiso con el más alto estándar de calidad en cada fase, garantizando el éxito total de cada evento.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h4 class="card-title">Pasión por el Detalle</h4>
                            <p class="card-text">Creemos que la magia reside en los detalles. Nuestra meticulosidad y creatividad son el sello que hace único cada proyecto.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <h4 class="card-title">Innovación Constante</h4>
                            <p class="card-text">Buscamos siempre nuevas ideas, diseños y soluciones para sorprender y mantenernos a la vanguardia.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="card-title">Confianza y Protocolo</h4>
                            <p class="card-text">Actuamos con profesionalidad, discreción y respeto por los protocolos oficiales y las tradiciones.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <h4 class="card-title">Compromiso con el Cliente</h4>
                            <p class="card-text">Colocamos las necesidades y felicidad de nuestros clientes en el centro de todo lo que hacemos.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4 class="card-title">Trabajo en Equipo</h4>
                            <p class="card-text">Coordinamos equipos especializados con liderazgo y sinergia para el éxito de cada evento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipo de Trabajo -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestro Fundador</h2>
                    <p class="lead text-muted">La visión y experiencia detrás de Wedding Connect</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card service-card">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <div class="mb-3">
                                        <div class="service-icon mb-3">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <h4 class="card-title mb-2">Cristina Gallo</h4>
                                        <p class="text-muted mb-0">Fundadora y CEO</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-3">Con más de 10 años de experiencia en la industria de eventos, Cristina Gallo ha transformado la visión de Wedding Connect en un referente de excelencia en planificación de bodas y eventos especiales.</p>
                                    <p class="mb-0">Su pasión por los detalles y compromiso con la satisfacción del cliente han sido el motor detrás del crecimiento y éxito de la empresa, estableciendo nuevos estándares de calidad en el sector.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <!-- Primera columna - Logo y redes -->
                <div class="col-lg-4 mb-4">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-heart-fill"></i> Wedding Connect
                    </h4>
                    <p class="text-light">Creando momentos inolvidables desde 2010</p>
                    
                    <!-- Mapa para móvil (visible solo en pantallas pequeñas) -->
                    <div class="d-lg-none mb-4">
                        <h5 class="text-white mb-3">Ubicación</h5>
                        <div class="map-container" style="border-radius: 15px; overflow: hidden; border: 2px solid var(--oro-rosa);">
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
                    
                    <div class="mt-4">
                        <a href="https://www.facebook.com/PlannerCristinaGallo/" class="social-icon" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/cristinagallo_planner/" class="social-icon" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/mar%C3%ADa-cristina-gallo-medina-020328191/?originalSubdomain=mx" class="social-icon" target="_blank">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send/?phone=524497698371&text&type=phone_number&app_absent=0" class="social-icon" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Segunda columna - Contacto -->
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-4">Contacto</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Enrique C Rebsamen 405, Bulevares 1a Sección, Aguascalientes, AGS
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:+524497698371" class="text-light text-decoration-none">449 769 8371</a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:cristinagallo.planner@gmail.com" class="text-light text-decoration-none">cristinagallo.planner@gmail.com</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Tercera columna - MAPA (visible en desktop) -->
                <div class="col-lg-4 mb-4 d-none d-lg-block">
                    <h5 class="text-white mb-4">Nuestra Ubicación</h5>
                    <div class="map-container" style="border-radius: 20px; overflow: hidden; border: 3px solid var(--oro-rosa); box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.506789624638!2d-102.29893768457715!3d21.88253258554442!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ee6d8c8b1c8d%3A0x8c7b8c8c8c8c8c8c!2sEnrique%20C%20Rebsamen%20405%2C%20Bulevares%201a%20Secci%C3%B3n%2C%2020120%20Aguascalientes%2C%20Ags.!5e0!3m2!1ses!2smx!4v1620000000000!5m2!1ses!2smx" 
                            width="100%" 
                            height="250" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                    <p class="text-light mt-2 small">
                        <i class="bi bi-geo-alt-fill" style="color: var(--oro-rosa);"></i>
                        Enrique C Rebsamen 405, Bulevares 1a Sección
                    </p>
                </div>
            </div>
            
            <hr class="bg-light my-4">
            
            <!-- Copyright y enlaces legales -->
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">
                        &copy; <?php echo date("Y"); ?> Wedding Connect. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="politica-privacidad.php" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                    <a href="terminos-condiciones.php" class="text-light text-decoration-none">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Personalizado -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>