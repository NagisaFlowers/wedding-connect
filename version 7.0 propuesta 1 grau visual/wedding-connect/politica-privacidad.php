<?php
$titulo = "Política de Privacidad - Wedding Connect";
include 'includes/header.php';
?>

<!-- Hero Section para Política de Privacidad (armonizado con nosotros.php) -->
<section class="hero-section" style="background: linear-gradient(135deg, rgba(212, 181, 160, 0.5) 0%, rgba(44, 62, 80, 0.5) 100%), url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <br><br><br>
                <span class="hero-subtitle">Wedding & Event Planner</span>
                <br></br><br></br>
                <h1 class="display-4 fw-bold mb-4">Política de Privacidad</h1>
                <p class="lead mb-4">Cómo protegemos y gestionamos tu información personal</p>
                <div class="legal-badge">
                    <i class="bi bi-shield-check"></i> Cumplimiento LFPDPPP
                </div>
                <p class="mb-0 text-light"><i class="bi bi-calendar-check"></i> Última actualización: Enero 2026</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenido de Política de Privacidad -->
<section class="about-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="service-card border-0 p-5">
                    <!-- Ley Mexicana Resumen -->
                    <div class="law-summary mb-5">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h2 class="h3 fw-bold mb-0">
                                <i class="bi bi-building"></i> Marco Legal en México
                            </h2>
                            <a href="https://www.diputados.gob.mx/LeyesBiblio/pdf/LFPDPPP.pdf" 
                               target="_blank" 
                               class="btn-legal" 
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
                                        <div class="value-card h-100">
                                            <div class="value-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <h6 class="card-title text-primary">Identificativos</h6>
                                            <ul class="small text-start">
                                                <li>Nombre completo</li>
                                                <li>Dirección</li>
                                                <li>Teléfono/Email</li>
                                                <li>RFC</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="value-card h-100">
                                            <div class="value-icon">
                                                <i class="bi bi-calendar-event"></i>
                                            </div>
                                            <h6 class="card-title text-primary">Del Evento</h6>
                                            <ul class="small text-start">
                                                <li>Fecha y lugar</li>
                                                <li>Número de invitados</li>
                                                <li>Presupuesto</li>
                                                <li>Preferencias</li>
                                            </ul>
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
                                        <div class="value-card text-center p-3">
                                            <div class="value-icon">
                                                <i class="bi bi-lock display-5 text-primary mb-3"></i>
                                            </div>
                                            <h6>Encriptación</h6>
                                            <p class="small">SSL para transferencia de datos</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="value-card text-center p-3">
                                            <div class="value-icon">
                                                <i class="bi bi-shield display-5 text-success mb-3"></i>
                                            </div>
                                            <h6>Control de Acceso</h6>
                                            <p class="small">Personal autorizado únicamente</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="value-card text-center p-3">
                                            <div class="value-icon">
                                                <i class="bi bi-backup display-5 text-warning mb-3"></i>
                                            </div>
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
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <h5 class="card-title text-primary">Nuestras Oficinas</h5>
                                    <p class="mb-2">Wedding Connect</p>
                                    <p class="mb-2">Enrique c rebsamen 405 bulevares 1a seccion AGS, AGS</p>
                                    <p class="mb-2"><i class="bi bi-telephone"></i> +52 1 449 769 8371</p>
                                    <p class="mb-0"><i class="bi bi-envelope"></i> cristinagallo.planner@gmail.com</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <h5 class="card-title text-primary">Autoridad Reguladora</h5>
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
</section>

<!-- Reading time indicator -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="reading-time text-center mb-4" id="reading-time"></div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>