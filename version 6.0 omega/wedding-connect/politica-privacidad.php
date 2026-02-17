<?php
$titulo = "Política de Privacidad - Wedding Connect";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- letras con estilo -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/legal.css">
</head>
<body>
    <!-- Navbar Bootstrap -->
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
                        <a class="nav-link" href="nosotros.php">
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

    <!-- Hero Section -->
    <section class="privacy-hero hero-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Política de Privacidad</h1>
                    <p class="lead mb-4">Cómo protegemos y gestionamos tu información personal</p>
                    <div class="legal-badge">
                        <i class="bi bi-shield-check"></i> Cumplimiento LFPDPPP
                    </div>
                    <p class="mb-0"><i class="bi bi-calendar-check"></i> Última actualización: Enero 2026</p>
                </div>
            </div>
        </div>
</section>

    <!-- Contenido de Política de Privacidad -->
    <section class="legal-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <!-- Ley Mexicana Resumen -->
                            <div class="law-summary mb-5">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <h2 class="h3 fw-bold mb-0">
                                        <i class="bi bi-building"></i> Marco Legal en México
                                    </h2>
                                    <a href="https://www.diputados.gob.mx/LeyesBiblio/pdf/LFPDPPP.pdf" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm" 
                                       id="view-law-btn">
                                        <i class="bi bi-file-pdf"></i> Ver Ley Completa
                                    </a>
                                </div>
                                
                                <p class="mb-4">Esta Política de Privacidad se rige por la <strong>Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP)</strong> de México.</p>
                                
                                <!-- Acordeón con principios -->
                                <div class="accordion" id="principlesAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrinciples">
                                                <i class="bi bi-list-check me-2"></i> Principios de Protección de Datos
                                            </button>
                                        </h2>
                                        <div id="collapsePrinciples" class="accordion-collapse collapse show" data-bs-parent="#principlesAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Licitud</strong>
                                                        </div>
                                                        <p class="small mb-0">Tratamiento conforme a la ley</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Consentimiento</strong>
                                                        </div>
                                                        <p class="small mb-0">Autorización informada y expresa</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Información</strong>
                                                        </div>
                                                        <p class="small mb-0">Transparencia en el tratamiento</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Calidad</strong>
                                                        </div>
                                                        <p class="small mb-0">Datos exactos, completos y actualizados</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Finalidad</strong>
                                                        </div>
                                                        <p class="small mb-0">Uso específico y legítimo</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Proporcionalidad</strong>
                                                        </div>
                                                        <p class="small mb-0">Solo datos necesarios</p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <strong>Responsabilidad</strong>
                                                        </div>
                                                        <p class="small mb-0">Medidas de seguridad adecuadas</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secciones principales con tabs -->
                            <div class="mb-5">
                                <h2 class="h3 fw-bold mb-4 text-primary">Información Esencial</h2>
                                
                                <ul class="nav nav-tabs mb-4" id="privacyTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button">
                                            <i class="bi bi-database"></i> Datos Recopilados
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="rights-tab" data-bs-toggle="tab" data-bs-target="#rights" type="button">
                                            <i class="bi bi-shield-check"></i> Derechos ARCO
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">
                                            <i class="bi bi-lock"></i> Seguridad
                                        </button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="privacyTabContent">
                                    <!-- Tab 1: Datos -->
                                    <div class="tab-pane fade show active" id="data" role="tabpanel">
                                        <h5 class="fw-bold mb-3">Datos Personales Recopilados</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-primary">
                                                            <i class="bi bi-person"></i> Identificativos
                                                        </h6>
                                                        <ul class="small">
                                                            <li>Nombre completo</li>
                                                            <li>Dirección</li>
                                                            <li>Teléfono/Email</li>
                                                            <li>RFC</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-primary">
                                                            <i class="bi bi-calendar-event"></i> Del Evento
                                                        </h6>
                                                        <ul class="small">
                                                            <li>Fecha y lugar</li>
                                                            <li>Número de invitados</li>
                                                            <li>Presupuesto</li>
                                                            <li>Preferencias</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab 2: Derechos ARCO -->
                                    <div class="tab-pane fade" id="rights" role="tabpanel">
                                        <h5 class="fw-bold mb-3">Tus Derechos ARCO</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <div class="text-center p-3 border rounded">
                                                    <div class="arco-letter">A</div>
                                                    <h6 class="mt-2">Acceso</h6>
                                                    <p class="small mb-0">Conocer tus datos</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center p-3 border rounded">
                                                    <div class="arco-letter">R</div>
                                                    <h6 class="mt-2">Rectificación</h6>
                                                    <p class="small mb-0">Corregir información</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center p-3 border rounded">
                                                    <div class="arco-letter">C</div>
                                                    <h6 class="mt-2">Cancelación</h6>
                                                    <p class="small mb-0">Eliminar datos</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center p-3 border rounded">
                                                    <div class="arco-letter">O</div>
                                                    <h6 class="mt-2">Oposición</h6>
                                                    <p class="small mb-0">Negarte al tratamiento</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-info mt-3">
                                            <i class="bi bi-clock"></i> <strong>Plazo de respuesta:</strong> 20 días hábiles (prorrogables a 40)
                                        </div>
                                    </div>
                                    
                                    <!-- Tab 3: Seguridad -->
                                    <div class="tab-pane fade" id="security" role="tabpanel">
                                        <h5 class="fw-bold mb-3">Medidas de Seguridad</h5>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="text-center p-3">
                                                    <i class="bi bi-lock display-5 text-primary mb-3"></i>
                                                    <h6>Encriptación</h6>
                                                    <p class="small">SSL para transferencia de datos</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="text-center p-3">
                                                    <i class="bi bi-shield display-5 text-success mb-3"></i>
                                                    <h6>Control de Acceso</h6>
                                                    <p class="small">Personal autorizado únicamente</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="text-center p-3">
                                                    <i class="bi bi-backup display-5 text-warning mb-3"></i>
                                                    <h6>Respaldos</h6>
                                                    <p class="small">Copias de seguridad regulares</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de contacto -->
                            <div class="contact-section mt-5 pt-4 border-top">
                                <h3 class="h4 fw-bold mb-4">
                                    <i class="bi bi-headset"></i> Contacto y Ejercicio de Derechos
                                </h3>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">
                                                    <i class="bi bi-geo-alt"></i> Nuestras Oficinas
                                                </h5>
                                                <p class="mb-2">Wedding Connect</p>
                                                <p class="mb-2">Enrique c rebsamen 405 bulevares 1a seccion AGS, AGS</p>
                                                <p class="mb-2"><i class="bi bi-telephone"></i> +52 1 449 769 8371</p>
                                                <p class="mb-0"><i class="bi bi-envelope"></i> cristinagallo.planner@gmail.com</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">
                                                    <i class="bi bi-building"></i> Autoridad Reguladora
                                                </h5>
                                                <p class="mb-2"><strong>INAI</strong></p>
                                                <p class="mb-2">Instituto Nacional de Transparencia</p>
                                                <p class="mb-2"><i class="bi bi-telephone"></i> 800 835 4324</p>
                                                <p class="mb-0">
                                                    <a href="https://home.inai.org.mx/" target="_blank" class="text-decoration-none">
                                                        <i class="bi bi-globe"></i> home.inai.org.mx
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Consentimiento -->
                            <div class="consent-section mt-5">
                                <div class="alert alert-success">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-check-circle display-5"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading">Consentimiento Informado</h5>
                                            <p class="mb-0">Al utilizar nuestros servicios, aceptas el tratamiento de tus datos personales conforme a esta Política de Privacidad y la LFPDPPP.</p>
                                        </div>
                                    </div>
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
            <div class="row justify-content-center">
                <!-- Primera columna -->
                <div class="col-lg-4 mb-4">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-heart-fill"></i> Wedding Connect
                    </h4>
                    <p class="text-light">Creando momentos inolvidables desde 2010</p>
                    <div class="mt-4">
                        <a href="https://www.facebook.com/PlannerCristinaGallo/" class="social-icon bg-primary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/cristinagallo_planner/" class="social-icon bg-danger">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/mar%C3%ADa-cristina-gallo-medina-020328191/?originalSubdomain=mx" class="social-icon bg-primary">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send/?phone=524497698371&text&type=phone_number&app_absent=0" class="social-icon bg-success">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Segunda columna -->
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-4">Contacto</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Enrique c rebsamen 405 bulevares 1a seccion AGS, AGS
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            449 769 8371
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            cristinagallo.planner@gmail.com
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-light my-4">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2026 Wedding Connect. Todos los derechos reservados.</p>
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
    <script src="assets/js/legal.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>