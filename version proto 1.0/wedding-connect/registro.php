<?php
// Incluir configuración de base de datos
require_once 'config/database.php';

// Inicializar variables
$message = '';
$message_type = '';

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_evento = $_POST['fecha_evento'] ?? '';
    $tipo_boda = $_POST['tipo_boda'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    
    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($fecha_evento) || empty($tipo_boda)) {
        $message = 'Por favor complete todos los campos requeridos';
        $message_type = 'error';
    } else {
        try {
            // Conectar a la base de datos
            $db = getDB();
            
            // Preparar consulta
            $sql = "INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_boda, mensaje) 
                    VALUES (:nombre, :correo, :telefono, :fecha_evento, :tipo_boda, :mensaje)";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':fecha_evento' => $fecha_evento,
                ':tipo_boda' => $tipo_boda,
                ':mensaje' => $mensaje
            ]);
            
            $message = '¡Registro exitoso! Te contactaremos pronto.';
            $message_type = 'success';
            
            // Limpiar formulario
            $_POST = [];
            
        } catch (PDOException $e) {
            $message = 'Error al guardar el registro: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Wedding Connect</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/registro.css">
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
                        <a class="nav-link" href="mision.php">
                            <i class="bi bi-bullseye"></i> Misión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vision.php">
                            <i class="bi bi-eye"></i> Visión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registro.php">
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

    <!-- Hero Section de Registro -->
    <section class="registro-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Solicita tu Cotización</h1>
                    <p class="lead mb-0">Comienza a planear la boda de tus sueños con nosotros</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-calendar-check" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Registro -->
    <section class="registro-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="registro-card">
                        <div class="text-center mb-5">
                            <i class="bi bi-heart-fill registro-icon"></i>
                            <h2 class="section-title text-center">Formulario de Solicitud</h2>
                            <p class="text-muted">Completa el formulario y te contactaremos para una cotización personalizada</p>
                        </div>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="" id="registrationForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">
                                            <i class="bi bi-person-fill"></i> Nombre completo *
                                        </label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                                               required placeholder="Ej: Ana García López">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo" class="form-label">
                                            <i class="bi bi-envelope-fill"></i> Correo electrónico *
                                        </label>
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                               value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>" 
                                               required placeholder="ejemplo@email.com">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono" class="form-label">
                                            <i class="bi bi-telephone-fill"></i> Teléfono *
                                        </label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                               value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>" 
                                               required placeholder="55 1234 5678">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_evento" class="form-label">
                                            <i class="bi bi-calendar-event-fill"></i> Fecha del evento *
                                        </label>
                                        <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" 
                                               value="<?php echo htmlspecialchars($_POST['fecha_evento'] ?? ''); ?>" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tipo_boda" class="form-label">
                                            <i class="bi bi-heart-fill"></i> Tipo de boda *
                                        </label>
                                        <select class="form-select" id="tipo_boda" name="tipo_boda" required>
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="civil" <?php echo ($_POST['tipo_boda'] ?? '') == 'civil' ? 'selected' : ''; ?>>Civil</option>
                                            <option value="religiosa" <?php echo ($_POST['tipo_boda'] ?? '') == 'religiosa' ? 'selected' : ''; ?>>Religiosa</option>
                                            <option value="destino" <?php echo ($_POST['tipo_boda'] ?? '') == 'destino' ? 'selected' : ''; ?>>Destino</option>
                                            <option value="intima" <?php echo ($_POST['tipo_boda'] ?? '') == 'intima' ? 'selected' : ''; ?>>Íntima</option>
                                            <option value="lujo" <?php echo ($_POST['tipo_boda'] ?? '') == 'lujo' ? 'selected' : ''; ?>>Lujo</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mensaje" class="form-label">
                                            <i class="bi bi-chat-left-text-fill"></i> Mensaje adicional
                                        </label>
                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" 
                                                  placeholder="Cuéntanos más sobre tus ideas, número de invitados, presupuesto aproximado..."><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-5">
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-send-fill"></i> Enviar Solicitud
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary btn-lg px-5">
                                        <i class="bi bi-arrow-clockwise"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="mt-5 text-center">
                            <p class="text-muted mb-3">
                                <i class="bi bi-info-circle"></i> Todos los campos marcados con * son obligatorios
                            </p>
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Información Adicional -->
    <section class="info-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">¿Qué pasa después?</h2>
                    <p class="lead text-muted">Nuestro proceso después de recibir tu solicitud</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-step text-center p-4">
                        <div class="step-number mb-3">1</div>
                        <h4>Contacto Inmediato</h4>
                        <p>Te contactaremos en menos de 24 horas para confirmar los detalles de tu evento.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="info-step text-center p-4">
                        <div class="step-number mb-3">2</div>
                        <h4>Reunión Personalizada</h4>
                        <p>Agendaremos una cita para conocer tus expectativas y crear un plan a tu medida.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="info-step text-center p-4">
                        <div class="step-number mb-3">3</div>
                        <h4>Propuesta Detallada</h4>
                        <p>Recibirás una cotización completa con todos los servicios y costos detallados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
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
                
                <div class="col-lg-3 mb-4">
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
                
                <div class="col-lg-3 mb-4">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p class="text-light mb-3">Suscríbete para recibir tips y promociones</p>
                    <form class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu email" required>
                            <button class="btn btn-outline-light" type="submit">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="bg-light my-4">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2026 Wedding Connect. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                    <a href="#" class="text-light text-decoration-none">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Personalizado -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/registro.js"></script>
</body>
</html>