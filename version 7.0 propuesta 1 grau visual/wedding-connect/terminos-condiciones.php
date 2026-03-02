<?php
$titulo = "Términos y Condiciones - Wedding Connect";
include 'includes/header.php';
?>

<!-- Hero Section para Términos y Condiciones -->
<section class="hero-section terms-hero" style="background: linear-gradient(135deg, rgba(44, 62, 80, 0.5) 0%, rgba(212, 181, 160, 0.5) 100%), url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <br><br>
                <span class="hero-subtitle">Wedding & Event Planner</span>
                <br></br><br>
                <h1 class="display-4 fw-bold mb-4">Términos y Condiciones</h1>
                <p class="lead mb-4">Las reglas que rigen nuestros servicios</p>
                <div class="legal-badge">
                    <i class="bi bi-file-text"></i> Aceptación de términos
                </div>
                <p class="mb-0 text-light"><i class="bi bi-calendar-check"></i> Última actualización: Enero 2026</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenido de Términos y Condiciones -->
<section class="legal-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="service-card border-0 p-5">
                    
                    <!-- Marco Legal Mexicano -->
                    <div class="law-summary mb-5">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h2 class="h3 fw-bold mb-0">
                                <i class="bi bi-building"></i> Marco Legal Aplicable
                            </h2>
                            <a href="https://www.diputados.gob.mx/LeyesBiblio/pdf/CCF.pdf" 
                               target="_blank" 
                               class="btn-legal" 
                               id="view-civil-code-btn">
                                <i class="bi bi-file-pdf"></i> Ver Código Civil
                            </a>
                        </div>
                        
                        <p class="mb-4">Estos Términos y Condiciones se rigen por las disposiciones del <strong>Código Civil Federal</strong> y la <strong>Ley Federal de Protección al Consumidor</strong> de los Estados Unidos Mexicanos.</p>
                        
                        <!-- Acordeón con información legal -->
                        <div class="accordion" id="legalAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJurisdiccion">
                                        <i class="bi bi-gavel me-2"></i> Jurisdicción y Legislación Aplicable
                                    </button>
                                </h2>
                                <div id="collapseJurisdiccion" class="accordion-collapse collapse show" data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        <p>Para la interpretación y cumplimiento de estos Términos y Condiciones, las partes se someten a las leyes y tribunales de la ciudad de <strong>Aguascalientes, Aguascalientes</strong>, renunciando expresamente a cualquier otro fuero que pudiera corresponderles por razón de su domicilio presente o futuro.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfeco">
                                        <i class="bi bi-shield-shaded me-2"></i> Derechos del Consumidor (PROFECO)
                                    </button>
                                </h2>
                                <div id="collapseProfeco" class="accordion-collapse collapse" data-bs-parent="#legalAccordion">
                                    <div class="accordion-body">
                                        <p>En términos de la Ley Federal de Protección al Consumidor, tienes derecho a:</p>
                                        <ul>
                                            <li>Información clara y veraz sobre nuestros servicios</li>
                                            <li>Protección contra publicidad engañosa</li>
                                            <li>Garantías en la prestación de servicios</li>
                                            <li>Acudir a la PROFECO en caso de controversia</li>
                                        </ul>
                                        <p class="mb-0 mt-2"><strong>PROFECO:</strong> Tel. 55 5568 8722 | <a href="https://www.gob.mx/profeco" target="_blank">www.gob.mx/profeco</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs para organizar los términos -->
                    <ul class="nav nav-tabs mb-4" id="termsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">
                                <i class="bi bi-file-earmark-text"></i> Términos Generales
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button">
                                <i class="bi bi-calendar-check"></i> Servicios
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button">
                                <i class="bi bi-credit-card"></i> Pagos y Cancelaciones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="responsibility-tab" data-bs-toggle="tab" data-bs-target="#responsibility" type="button">
                                <i class="bi bi-shield"></i> Responsabilidad
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="termsTabContent">
                        <!-- Tab 1: Términos Generales -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <h3 class="h4 fw-bold mb-4">1. Aceptación de los Términos</h3>
                            <p>Al acceder y utilizar los servicios de Wedding Connect (en adelante "la Empresa", "nosotros" o "nuestro"), usted acepta estar sujeto a estos Términos y Condiciones, así como a todas las leyes y regulaciones aplicables en los Estados Unidos Mexicanos.</p>
                            
                            <h4 class="h5 fw-bold mt-4 mb-3">1.1 Capacidad Legal</h4>
                            <p>Para hacer uso de nuestros servicios, declaras que eres mayor de 18 años y que cuentas con la capacidad legal necesaria para contratar y obligarte en términos de las leyes mexicanas.</p>
                            
                            <h4 class="h5 fw-bold mt-4 mb-3">1.2 Modificaciones</h4>
                            <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en vigor inmediatamente después de su publicación en este sitio web. El uso continuado de nuestros servicios constituye la aceptación de dichos cambios.</p>
                        </div>

                        <!-- Tab 2: Servicios -->
                        <div class="tab-pane fade" id="services" role="tabpanel">
                            <h3 class="h4 fw-bold mb-4">2. Servicios Ofrecidos</h3>
                            <p>Wedding Connect ofrece servicios de planificación y coordinación de eventos, incluyendo pero no limitado a:</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="value-card h-100">
                                        <div class="value-icon">
                                            <i class="bi bi-heart"></i>
                                        </div>
                                        <h5>Planificación Integral de Bodas</h5>
                                        <p class="small">Desde la conceptualización hasta la ejecución final de tu boda.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="value-card h-100">
                                        <div class="value-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <h5>Coordinación de Eventos Sociales</h5>
                                        <p class="small">XV años, aniversarios, bautizos y celebraciones especiales.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="value-card h-100">
                                        <div class="value-icon">
                                            <i class="bi bi-briefcase"></i>
                                        </div>
                                        <h5>Eventos Corporativos</h5>
                                        <p class="small">Convenciones, congresos y celebraciones empresariales.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="value-card h-100">
                                        <div class="value-icon">
                                            <i class="bi bi-chat"></i>
                                        </div>
                                        <h5>Asesoría en Protocolo</h5>
                                        <p class="small">Guía especializada en etiqueta y ceremonial.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Pagos y Cancelaciones -->
                        <div class="tab-pane fade" id="payment" role="tabpanel">
                            <h3 class="h4 fw-bold mb-4">3. Pagos y Cancelaciones</h3>
                            
                            <h4 class="h5 fw-bold mt-3">3.1 Precios y Formas de Pago</h4>
                            <p>Todos los precios están expresados en Pesos Mexicanos (MXN) e incluyen el Impuesto al Valor Agregado (IVA) cuando corresponda. Aceptamos las siguientes formas de pago:</p>
                            <ul>
                                <li>Transferencia bancaria</li>
                                <li>Depósito en cuenta</li>
                                <li>Tarjetas de crédito/débito (a través de pasarela de pago)</li>
                                <li>Efectivo (previo acuerdo)</li>
                            </ul>

                            <h4 class="h5 fw-bold mt-4">3.2 Anticipos y Saldos</h4>
                            <p>Para reservar nuestros servicios se requiere un anticipo del 30% al 50% del total del paquete contratado. El saldo restante deberá liquidarse antes de la fecha del evento, según lo acordado en el contrato.</p>

                            <h4 class="h5 fw-bold mt-4">3.3 Política de Cancelación</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tiempo de cancelación</th>
                                            <th>Reembolso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Más de 90 días antes del evento</td>
                                            <td>80% del anticipo</td>
                                        </tr>
                                        <tr>
                                            <td>Entre 90 y 60 días antes</td>
                                            <td>50% del anticipo</td>
                                        </tr>
                                        <tr>
                                            <td>Entre 60 y 30 días antes</td>
                                            <td>25% del anticipo</td>
                                        </tr>
                                        <tr>
                                            <td>Menos de 30 días antes</td>
                                            <td>No reembolsable</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab 4: Responsabilidad -->
                        <div class="tab-pane fade" id="responsibility" role="tabpanel">
                            <h3 class="h4 fw-bold mb-4">4. Limitación de Responsabilidad</h3>
                            
                            <p>Wedding Connect actuará con la diligencia y cuidado propios de un profesional en la materia. Sin embargo, no seremos responsables por:</p>
                            
                            <ul class="mt-3">
                                <li>Fuerza mayor o caso fortuito</li>
                                <li>Incumplimiento de proveedores externos (cuando no sean contratados directamente por nosotros)</li>
                                <li>Decisiones del cliente que afecten el desarrollo del evento</li>
                                <li>Daños o pérdidas de objetos personales durante el evento</li>
                            </ul>

                            <div class="alert alert-warning mt-4">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Importante:</strong> Recomendamos contratar un seguro de eventos para cubrir imprevistos.
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Proveedores -->
                    <div class="mt-5 pt-4 border-top">
                        <h3 class="h4 fw-bold mb-4">5. Relación con Proveedores</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <h5>Proveedores Recomendados</h5>
                                    <p class="small">Trabajamos con una red de proveedores de confianza, pero cada uno es responsable de sus propios servicios.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-file-check"></i>
                                    </div>
                                    <h5>Contratos Independientes</h5>
                                    <p class="small">Cada proveedor firma su propio contrato y asume su responsabilidad civil y fiscal.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Propiedad Intelectual -->
                    <div class="mt-5 pt-4 border-top">
                        <h3 class="h4 fw-bold mb-4">6. Propiedad Intelectual</h3>
                        
                        <p>Todos los contenidos de este sitio web, incluyendo pero no limitado a textos, logotipos, diseños, imágenes y software, son propiedad de Wedding Connect o de sus licenciantes y están protegidos por las leyes mexicanas e internacionales de propiedad intelectual.</p>
                        
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-c-circle"></i>
                            <strong>Queda prohibido:</strong> Reproducir, distribuir, modificar o utilizar cualquier contenido sin autorización expresa por escrito.
                        </div>
                    </div>

                    <!-- Sección de Contacto Legal -->
                    <div class="contact-section mt-5 pt-4 border-top">
                        <h3 class="h4 fw-bold mb-4">
                            <i class="bi bi-envelope-paper"></i> Contacto para Asuntos
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <h5>Domicilio Convencional</h5>
                                    <p class="mb-2">Enrique C. Rebsamen 405</p>
                                    <p class="mb-2">Bulevares 1a Sección</p>
                                    <p class="mb-2">Aguascalientes, AGS. C.P. 20120</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box h-100">
                                    <div class="info-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <h5>Contacto Legal</h5>
                                    <p class="mb-2"><i class="bi bi-envelope"></i> cristinagallo.planner@gmail.com</p>
                                    <p class="mb-2"><i class="bi bi-telephone"></i> +52 449 769 8371</p>
                                    <p class="mb-0"><small>Respuesta en un máximo de 24 a 48 horas hábiles</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consentimiento y Aceptación -->
                    <div class="consent-section mt-5">
                        <div class="alert alert-success">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill display-5"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading">Aceptación de Términos</h5>
                                    <p class="mb-0">Al contratar nuestros servicios, manifiestas haber leído, entendido y aceptado todos los términos y condiciones aquí expuestos, de conformidad con el Código Civil Federal y la Ley Federal de Protección al Consumidor.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Firma digital y fecha -->
                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            <i class="bi bi-check2-circle"></i> 
                            Estos términos fueron actualizados por última vez el <strong>15 de enero de 2026</strong>
                        </p>
                        <p class="small text-muted">
                            <i class="bi bi-shield-check"></i>
                            Versión 2.0 - Cumple con la NOM-151-SCFI-2016 para conservación de mensajes de datos
                        </p>
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