<?php
$titulo = "Términos y Condiciones - Wedding Connect";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- CSS Personalizado -->
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
                        <a class="nav-link btn btn-outline-primary ms-2" href="admin.php">
                            <i class="bi bi-shield-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="terms-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Términos y Condiciones</h1>
                    <p class="lead mb-4">Condiciones generales para el uso de nuestros servicios</p>
                    <div class="legal-badge">
                        <i class="bi bi-file-earmark-text"></i> Contrato de Servicios
                    </div>
                    <p class="mb-0"><i class="bi bi-calendar-check"></i> Última actualización: Enero 2026</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido de Términos y Condiciones -->
    <section class="legal-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <!-- Resumen rápido -->
                            <div class="quick-summary mb-5">
                                <h2 class="h3 fw-bold mb-4 text-primary">
                                    <i class="bi bi-lightning"></i> Resumen Rápido
                                </h2>
                                
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-cash-coin display-5 text-success mb-3"></i>
                                            <h6>Depósito 30%</h6>
                                            <p class="small mb-0">Para confirmar reserva</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-calendar-x display-5 text-warning mb-3"></i>
                                            <h6>Cancelación</h6>
                                            <p class="small mb-0">Con 30+ días de anticipación</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-shield-check display-5 text-primary mb-3"></i>
                                            <h6>Garantía</h6>
                                            <p class="small mb-0">Planificación profesional</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-headset display-5 text-info mb-3"></i>
                                            <h6>Soporte</h6>
                                            <p class="small mb-0">Atención personalizada</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secciones con acordeón -->
                            <div class="mb-5">
                                <h2 class="h3 fw-bold mb-4 text-primary">Condiciones Detalladas</h2>
                                
                                <div class="accordion" id="termsAccordion">
                                    <!-- Sección 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                <i class="bi bi-check2-circle me-2"></i> Aceptación de Términos
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#termsAccordion">
                                            <div class="accordion-body">
                                                <p>Al utilizar los servicios de Wedding Connect, aceptas estos Términos y Condiciones. El contrato se formaliza con:</p>
                                                <ul>
                                                    <li>Firma del contrato de servicios</li>
                                                    <li>Pago del depósito inicial (30%)</li>
                                                    <li>Confirmación por correo electrónico</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Sección 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                <i class="bi bi-cash-coin me-2"></i> Política de Pagos
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Concepto</th>
                                                                <th>Monto</th>
                                                                <th>Plazo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Depósito inicial</td>
                                                                <td>30%</td>
                                                                <td>Al reservar</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Segundo pago</td>
                                                                <td>40%</td>
                                                                <td>60 días antes</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pago final</td>
                                                                <td>30%</td>
                                                                <td>7 días antes</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Sección 3 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                <i class="bi bi-calendar-x me-2"></i> Cancelaciones
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Anticipación</th>
                                                                <th>Reembolso</th>
                                                                <th>Notas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>90+ días</td>
                                                                <td>80%</td>
                                                                <td>Menos gastos administrativos</td>
                                                            </tr>
                                                            <tr>
                                                                <td>60-89 días</td>
                                                                <td>50%</td>
                                                                <td>Pagos a proveedores no reembolsables</td>
                                                            </tr>
                                                            <tr>
                                                                <td>30-59 días</td>
                                                                <td>25%</td>
                                                                <td>Cancelaciones parciales</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Menos de 30 días</td>
                                                                <td>0%</td>
                                                                <td>No reembolsable</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Sección 4 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                                <i class="bi bi-shield me-2"></i> Responsabilidades
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-primary">Del Cliente</h6>
                                                        <ul>
                                                            <li>Información veraz y completa</li>
                                                            <li>Pagos en tiempo y forma</li>
                                                            <li>Decisiones oportunas</li>
                                                            <li>Comunicación de cambios</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-primary">De Wedding Connect</h6>
                                                        <ul>
                                                            <li>Planificación profesional</li>
                                                            <li>Gestión de proveedores</li>
                                                            <li>Cumplimiento de plazos</li>
                                                            <li>Comunicación constante</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Sección 5 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                                <i class="bi bi-exclamation-triangle me-2"></i> Limitaciones
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                            <div class="accordion-body">
                                                <p><strong>Wedding Connect no será responsable por:</strong></p>
                                                <ul>
                                                    <li>Fuerza mayor (clima, desastres naturales)</li>
                                                    <li>Decisiones de proveedores externos</li>
                                                    <li>Cambios de última hora del cliente</li>
                                                    <li>Condiciones del lugar del evento</li>
                                                    <li>Comportamiento de invitados</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Garantías -->
                            <div class="warranty-section mb-5">
                                <h3 class="h4 fw-bold mb-4 text-primary">
                                    <i class="bi bi-award"></i> Nuestras Garantías
                                </h3>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card h-100 border-success">
                                            <div class="card-body text-center">
                                                <i class="bi bi-check-circle display-4 text-success mb-3"></i>
                                                <h5>Planificación Profesional</h5>
                                                <p class="small">Coordinación experta de cada detalle</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <i class="bi bi-people display-4 text-primary mb-3"></i>
                                                <h5>Proveedores Certificados</h5>
                                                <p class="small">Trabajamos solo con los mejores</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 border-warning">
                                            <div class="card-body text-center">
                                                <i class="bi bi-clock-history display-4 text-warning mb-3"></i>
                                                <h5>Soporte Continuo</h5>
                                                <p class="small">Atención antes, durante y después</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aceptación -->
                            <div class="acceptance-section mt-5">
                                <div class="alert alert-primary">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-file-text display-5"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading">Aceptación de Términos</h5>
                                            <p class="mb-0">Al contratar nuestros servicios, confirmas haber leído, comprendido y aceptado estos Términos y Condiciones en su totalidad.</p>
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
                        <a href="#" class="social-icon bg-primary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon bg-danger">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon bg-primary">
                            <i class="bi bi-linkedin"></i>
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
                            +52 1 449 769 8371
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