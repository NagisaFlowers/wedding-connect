<?php
// Incluir configuración de base de datos centralizada
require_once 'config/database.php';

// Función para generar clave a partir del nombre del evento (para autocompletado JS)
function generarClave($nombre) {
    $clave = strtolower($nombre);
    $clave = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', ' ', '-'],
        ['a', 'e', 'i', 'o', 'u', 'n', 'u', '_', '_'],
        $clave
    );
    return preg_replace('/[^a-z_]/', '', $clave); // elimina cualquier otro carácter
}

// Inicializar variables
$message = '';
$message_type = '';
$form_data = [];
$registro_exitoso = false;

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fecha_evento = $_POST['fecha_evento'] ?? '';
    $tipo_evento_id = $_POST['tipo_evento_id'] ?? '';
    $mensaje = trim($_POST['mensaje'] ?? '');
    
    $form_data = [
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'fecha_evento' => $fecha_evento,
        'tipo_evento_id' => $tipo_evento_id,
        'mensaje' => $mensaje
    ];
    
    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($fecha_evento) || empty($tipo_evento_id)) {
        $message = 'Por favor complete todos los campos requeridos';
        $message_type = 'error';
    } else {
        $errores = [];
        
        // Validar nombre: solo letras y espacios, máximo 30 caracteres
        if (!preg_match('/^[a-zA-ZáéíóúñÑüÜ\s]+$/', $nombre)) {
            $errores[] = 'El nombre solo puede contener letras y espacios.';
        } elseif (strlen($nombre) > 30) {
            $errores[] = 'El nombre no puede exceder los 30 caracteres.';
        }
        
        // Validar correo: formato y máximo 50 caracteres
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido.';
        } elseif (strlen($correo) > 50) {
            $errores[] = 'El correo no puede exceder los 50 caracteres.';
        }
        
        // Validar teléfono: exactamente 10 dígitos
        $telefono_limpio = preg_replace('/\D/', '', $telefono);
        if (!preg_match('/^\d{10}$/', $telefono_limpio)) {
            $errores[] = 'El teléfono debe contener exactamente 10 dígitos numéricos.';
        }
        
        // Validar fecha: no puede ser pasada
        $hoy = new DateTime('today');
        $fecha = DateTime::createFromFormat('Y-m-d', $fecha_evento);
        if (!$fecha || $fecha < $hoy) {
            $errores[] = 'La fecha del evento debe ser hoy o en el futuro.';
        }
        
        // Validar mensaje: máximo 500 palabras (opcional)
        if (!empty($mensaje)) {
            $num_palabras = str_word_count($mensaje, 0, 'áéíóúñüÁÉÍÓÚÑÜ');
            if ($num_palabras > 500) {
                $errores[] = 'El mensaje no puede exceder las 500 palabras.';
            }
        }
        
        if (!empty($errores)) {
            $message = implode('<br>', $errores);
            $message_type = 'error';
        } else {
            try {
                // Usar conexión centralizada
                $db = getDB();
                
                // Preparar consulta
                $sql = "INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_evento_id, mensaje, fecha_registro) 
                        VALUES (:nombre, :correo, :telefono, :fecha_evento, :tipo_evento_id, :mensaje, NOW())";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':correo' => $correo,
                    ':telefono' => $telefono_limpio, // guardamos solo dígitos
                    ':fecha_evento' => $fecha_evento,
                    ':tipo_evento_id' => $tipo_evento_id,
                    ':mensaje' => $mensaje
                ]);
                
                $message = '¡Registro exitoso! Te contactaremos pronto.';
                $message_type = 'success';
                $registro_exitoso = true;
                
                // Limpiar datos del formulario
                $form_data = [
                    'nombre' => '',
                    'correo' => '',
                    'telefono' => '',
                    'fecha_evento' => '',
                    'tipo_evento_id' => '',
                    'mensaje' => ''
                ];
                
            } catch (PDOException $e) {
                $message = 'Error al guardar el registro: ' . $e->getMessage();
                $message_type = 'error';
            }
        }
    }
}

// Obtener tipos de evento para el select
$tipos_evento = obtenerTiposEvento();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Wedding Connect</title>
    <link rel="shortcut icon" href="assets/images/logocristinagallo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Fuentes elegantes -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/index.css">
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
                        <a class="nav-link active" href="registro.php">
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
                    <h1 class="display-4 fw-bold mb-4">Solicita tu Cotización</h1>
                    <p class="lead mb-4">Comienza a planear tu evento especial con nosotros. Déjanos hacer realidad tus sueños.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#registro-form" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-pencil-fill"></i> Completar Formulario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Registro -->
     <section id="registro-form" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card service-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <div class="service-icon mb-4">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                                <h2 class="display-5 fw-bold mb-3">Formulario de Solicitud</h2>
                                <p class="lead text-muted">Completa el formulario y te contactaremos para una cotización personalizada</p>
                            </div>
                            
                            <?php if ($message): ?>
                                <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                    <i class="bi <?php echo $message_type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
                                    <?php echo $message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="" id="registrationForm">
                                <?php if ($registro_exitoso): ?>
                                    <input type="hidden" id="registro_exitoso" value="1">
                                <?php endif; ?>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-person-badge-fill text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Nombre completo *
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" 
                                                   value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>" 
                                                   required placeholder="Ej: Ana García López" maxlength="30">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-envelope-paper-heart-fill text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Correo electrónico *
                                            </label>
                                            <input type="email" class="form-control form-control-lg" id="correo" name="correo" 
                                                   value="<?php echo htmlspecialchars($form_data['correo'] ?? ''); ?>" 
                                                   required placeholder="ejemplo@email.com" maxlength="50">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-telephone-inbound-fill text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Teléfono *
                                            </label>
                                            <input type="tel" class="form-control form-control-lg" id="telefono" name="telefono" 
                                                   value="<?php echo htmlspecialchars($form_data['telefono'] ?? ''); ?>" 
                                                   required placeholder="55 1234 5678">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_evento" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-calendar2-heart-fill text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Fecha del evento *
                                            </label>
                                            <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento" 
                                                   value="<?php echo htmlspecialchars($form_data['fecha_evento'] ?? ''); ?>" 
                                                   required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="tipo_evento_id" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-stars text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Tipo de evento *
                                            </label>
                                            <select class="form-select form-select-lg" id="tipo_evento_id" name="tipo_evento_id" required>
                                                <option value="">Seleccionar tipo de evento...</option>
                                                <?php 
                                                // Agrupar por categoría
                                                $categorias = [];
                                                foreach ($tipos_evento as $tipo) {
                                                    $categorias[$tipo['categoria']][] = $tipo;
                                                }
                                                
                                                $labels_categorias = [
                                                    'bodas' => '🎭 Bodas',
                                                    'xv_anos' => '👸 XV Años',
                                                    'baby_shower' => '🎀 Baby Shower',
                                                    'empresariales' => '🏢 Eventos Empresariales',
                                                    'municipales' => '🏛️ Eventos Municipales',
                                                    'anuales' => '📅 Eventos del Año',
                                                    'otros' => '🎪 Otros Eventos'
                                                ];
                                                
                                                foreach ($categorias as $categoria => $tipos): 
                                                    if (!empty($tipos)): 
                                                ?>
                                                    <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                                        <?php foreach ($tipos as $tipo): 
                                                            // Generar clave para autocompletado JS
                                                            $clave = generarClave($tipo['nombre']);
                                                        ?>
                                                            <option value="<?php echo $tipo['id']; ?>" 
                                                                    data-clave="<?php echo $clave; ?>"
                                                                    <?php echo ($form_data['tipo_evento_id'] ?? '') == $tipo['id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($tipo['nombre']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php 
                                                    endif;
                                                endforeach; 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="mensaje" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-chat-square-heart-fill text-wedding-gold me-2" style="color: #d4af37; font-size: 1.2rem;"></i> Mensaje adicional
                                            </label>
                                            <textarea class="form-control form-control-lg" id="mensaje" name="mensaje" rows="5" 
                                                      placeholder="Si no encuentras tu evento en la lista cuéntanos más sobre tus ideas, número de invitados, presupuesto aproximado $, ubicación preferida... Nosotros la haremos realidad!!"><?php echo htmlspecialchars($form_data['mensaje'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-5">
                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                        <button type="submit" class="btn btn-outline-primary btn-lg px-5">
                                            <i class="bi bi-send-heart-fill me-2"></i> Enviar Solicitud
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="mt-5 text-center">
                                <p class="text-muted mb-4">
                                    <i class="bi bi-info-circle text-wedding-gold me-2" style="color: #d4af37;"></i> Todos los campos marcados con * son obligatorios
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Información Adicional -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">¿Qué pasa después?</h2>
                    <p class="lead text-muted">Nuestro proceso después de recibir tu solicitud</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-telephone-outbound"></i>
                            </div>
                            <h4 class="card-title">Contacto Inmediato</h4>
                            <p class="card-text">Te contactaremos en menos de 24 horas para confirmar los detalles de tu evento y agendar una consulta personalizada.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <h4 class="card-title">Reunión Personalizada</h4>
                            <p class="card-text">Agendaremos una cita virtual o presencial para conocer tus expectativas, gustos y crear un plan completamente a tu medida.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h4 class="card-title">Propuesta Detallada</h4>
                            <p class="card-text">Recibirás una cotización completa y detallada con todos los servicios, tiempos y costos, adaptada específicamente a tus necesidades.</p>
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
    <!-- JavaScript Personalizado (asegúrate de que la ruta sea correcta) -->
    <script src="assets/js/registro.js"></script>
</body>
</html>