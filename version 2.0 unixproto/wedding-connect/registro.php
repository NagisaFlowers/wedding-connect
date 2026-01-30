<?php
// Incluir configuración de base de datos
require_once 'config/database.php';

// Inicializar variables
$message = '';
$message_type = '';
$form_data = []; // Array para datos del formulario
$registro_exitoso = false; // Bandera para indicar registro exitoso

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha_evento = $_POST['fecha_evento'] ?? '';
    $tipo_evento = $_POST['tipo_evento'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    
    // Guardar datos en array para mantenerlos después del POST
    $form_data = [
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'fecha_evento' => $fecha_evento,
        'tipo_evento' => $tipo_evento,
        'mensaje' => $mensaje
    ];
    
    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($fecha_evento) || empty($tipo_evento)) {
        $message = 'Por favor complete todos los campos requeridos';
        $message_type = 'error';
    } else {
        try {
            // Conectar a la base de datos
            $db = getDB();
            
            // Preparar consulta
            $sql = "INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_boda, mensaje, fecha_registro) 
                    VALUES (:nombre, :correo, :telefono, :fecha_evento, :tipo_evento, :mensaje, NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':fecha_evento' => $fecha_evento,
                ':tipo_evento' => $tipo_evento,
                ':mensaje' => $mensaje
            ]);
            
            $message = '¡Registro exitoso! Te contactaremos pronto.';
            $message_type = 'success';
            $registro_exitoso = true; // Marcar como registro exitoso
            
            // LIMPIAR DATOS DEL FORMULARIO después de registro exitoso
            $form_data = [
                'nombre' => '',
                'correo' => '',
                'telefono' => '',
                'fecha_evento' => '',
                'tipo_evento' => '',
                'mensaje' => ''
            ];
            
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
                                                <i class="bi bi-person-fill text-primary me-2"></i> Nombre completo *
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" 
                                                   value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>" 
                                                   required placeholder="Ej: Ana García López">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-envelope-fill text-primary me-2"></i> Correo electrónico *
                                            </label>
                                            <input type="email" class="form-control form-control-lg" id="correo" name="correo" 
                                                   value="<?php echo htmlspecialchars($form_data['correo'] ?? ''); ?>" 
                                                   required placeholder="ejemplo@email.com">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-telephone-fill text-primary me-2"></i> Teléfono *
                                            </label>
                                            <input type="tel" class="form-control form-control-lg" id="telefono" name="telefono" 
                                                   value="<?php echo htmlspecialchars($form_data['telefono'] ?? ''); ?>" 
                                                   required placeholder="55 1234 5678">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_evento" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-calendar-event-fill text-primary me-2"></i> Fecha del evento *
                                            </label>
                                            <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento" 
                                                   value="<?php echo htmlspecialchars($form_data['fecha_evento'] ?? ''); ?>" 
                                                   required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="tipo_evento" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-heart-fill text-primary me-2"></i> Tipo de evento *
                                            </label>
                                            <select class="form-select form-select-lg" id="tipo_evento" name="tipo_evento" required>
                                                <option value="">Seleccionar tipo de evento...</option>
                                                <!-- Mantener todas las opciones existentes -->
                                                <optgroup label="🎭 Bodas">
                                                    <option value="boda_civil" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_civil' ? 'selected' : ''; ?>>Boda Civil</option>
                                                    <option value="boda_religiosa" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_religiosa' ? 'selected' : ''; ?>>Boda Religiosa</option>
                                                    <option value="boda_destino" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_destino' ? 'selected' : ''; ?>>Boda Destino</option>
                                                    <option value="boda_intima" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_intima' ? 'selected' : ''; ?>>Boda Íntima</option>
                                                    <option value="boda_lujo" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_lujo' ? 'selected' : ''; ?>>Boda de Lujo</option>
                                                    <option value="boda_tematica" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_tematica' ? 'selected' : ''; ?>>Boda Temática</option>
                                                    <option value="boda_playa" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_playa' ? 'selected' : ''; ?>>Boda en Playa</option>
                                                    <option value="boda_campo" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_campo' ? 'selected' : ''; ?>>Boda en Campo</option>
                                                    <option value="boda_urbana" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_urbana' ? 'selected' : ''; ?>>Boda Urbana</option>
                                                    <option value="boda_vintage" <?php echo ($form_data['tipo_evento'] ?? '') == 'boda_vintage' ? 'selected' : ''; ?>>Boda Vintage</option>
                                                </optgroup>
                                                
                                                <!-- Mantener el resto de las opciones -->
                                                <optgroup label="👸 XV Años">
                                                    <option value="xv_anos" <?php echo ($form_data['tipo_evento'] ?? '') == 'xv_anos' ? 'selected' : ''; ?>>XV Años Tradicional</option>
                                                    <option value="xv_anos_tematica" <?php echo ($form_data['tipo_evento'] ?? '') == 'xv_anos_tematica' ? 'selected' : ''; ?>>XV Años Temático</option>
                                                    <option value="xv_anos_lujo" <?php echo ($form_data['tipo_evento'] ?? '') == 'xv_anos_lujo' ? 'selected' : ''; ?>>XV Años de Lujo</option>
                                                    <option value="xv_anos_intima" <?php echo ($form_data['tipo_evento'] ?? '') == 'xv_anos_intima' ? 'selected' : ''; ?>>XV Años Íntimo</option>
                                                </optgroup>
                                                
                                                <optgroup label="🎀 Baby Shower">
                                                    <option value="baby_shower" <?php echo ($form_data['tipo_evento'] ?? '') == 'baby_shower' ? 'selected' : ''; ?>>Baby Shower</option>
                                                    <option value="baby_shower_gender_reveal" <?php echo ($form_data['tipo_evento'] ?? '') == 'baby_shower_gender_reveal' ? 'selected' : ''; ?>>Baby Shower (Gender Reveal)</option>
                                                    <option value="baby_shower_tematica" <?php echo ($form_data['tipo_evento'] ?? '') == 'baby_shower_tematica' ? 'selected' : ''; ?>>Baby Shower Temático</option>
                                                </optgroup>
                                                
                                                <optgroup label="🏢 Eventos Empresariales">
                                                    <option value="evento_empresarial" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_empresarial' ? 'selected' : ''; ?>>Evento Empresarial</option>
                                                    <option value="convencion" <?php echo ($form_data['tipo_evento'] ?? '') == 'convencion' ? 'selected' : ''; ?>>Convención</option>
                                                    <option value="lanzamiento_producto" <?php echo ($form_data['tipo_evento'] ?? '') == 'lanzamiento_producto' ? 'selected' : ''; ?>>Lanzamiento de Producto</option>
                                                    <option value="conferencia" <?php echo ($form_data['tipo_evento'] ?? '') == 'conferencia' ? 'selected' : ''; ?>>Conferencia</option>
                                                    <option value="seminario" <?php echo ($form_data['tipo_evento'] ?? '') == 'seminario' ? 'selected' : ''; ?>>Seminario</option>
                                                    <option value="team_building" <?php echo ($form_data['tipo_evento'] ?? '') == 'team_building' ? 'selected' : ''; ?>>Team Building</option>
                                                    <option value="fiesta_navidad_empresa" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_navidad_empresa' ? 'selected' : ''; ?>>Fiesta de Navidad Empresarial</option>
                                                </optgroup>
                                                
                                                <optgroup label="🏛️ Eventos Municipales">
                                                    <option value="evento_municipal" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_municipal' ? 'selected' : ''; ?>>Evento Municipal</option>
                                                    <option value="feria_local" <?php echo ($form_data['tipo_evento'] ?? '') == 'feria_local' ? 'selected' : ''; ?>>Feria Local</option>
                                                    <option value="festival_cultural" <?php echo ($form_data['tipo_evento'] ?? '') == 'festival_cultural' ? 'selected' : ''; ?>>Festival Cultural</option>
                                                    <option value="concierto_publico" <?php echo ($form_data['tipo_evento'] ?? '') == 'concierto_publico' ? 'selected' : ''; ?>>Concierto Público</option>
                                                    <option value="celebracion_aniversario_ciudad" <?php echo ($form_data['tipo_evento'] ?? '') == 'celebracion_aniversario_ciudad' ? 'selected' : ''; ?>>Celebración Aniversario Ciudad</option>
                                                    <option value="evento_deportivo_municipal" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_deportivo_municipal' ? 'selected' : ''; ?>>Evento Deportivo Municipal</option>
                                                </optgroup>
                                                
                                                <optgroup label="📅 Eventos del Año">
                                                    <option value="cumpleanos" <?php echo ($form_data['tipo_evento'] ?? '') == 'cumpleanos' ? 'selected' : ''; ?>>Cumpleaños</option>
                                                    <option value="aniversario" <?php echo ($form_data['tipo_evento'] ?? '') == 'aniversario' ? 'selected' : ''; ?>>Aniversario</option>
                                                    <option value="graduacion" <?php echo ($form_data['tipo_evento'] ?? '') == 'graduacion' ? 'selected' : ''; ?>>Graduación</option>
                                                    <option value="bautizo" <?php echo ($form_data['tipo_evento'] ?? '') == 'bautizo' ? 'selected' : ''; ?>>Bautizo</option>
                                                    <option value="primera_comunion" <?php echo ($form_data['tipo_evento'] ?? '') == 'primera_comunion' ? 'selected' : ''; ?>>Primera Comunión</option>
                                                    <option value="despedida_soltero" <?php echo ($form_data['tipo_evento'] ?? '') == 'despedida_soltero' ? 'selected' : ''; ?>>Despedida de Soltero/a</option>
                                                    <option value="fiesta_compromiso" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_compromiso' ? 'selected' : ''; ?>>Fiesta de Compromiso</option>
                                                    <option value="renovacion_votos" <?php echo ($form_data['tipo_evento'] ?? '') == 'renovacion_votos' ? 'selected' : ''; ?>>Renovación de Votos</option>
                                                    <option value="fiesta_halloween" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_halloween' ? 'selected' : ''; ?>>Fiesta de Halloween</option>
                                                    <option value="fiesta_navidad" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_navidad' ? 'selected' : ''; ?>>Fiesta de Navidad</option>
                                                    <option value="fiesta_ano_nuevo" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_ano_nuevo' ? 'selected' : ''; ?>>Fiesta de Año Nuevo</option>
                                                    <option value="fiesta_pascua" <?php echo ($form_data['tipo_evento'] ?? '') == 'fiesta_pascua' ? 'selected' : ''; ?>>Fiesta de Pascua</option>
                                                </optgroup>
                                                
                                                <optgroup label="🎪 Otros Eventos">
                                                    <option value="evento_religioso" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_religioso' ? 'selected' : ''; ?>>Evento Religioso</option>
                                                    <option value="evento_benefico" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_benefico' ? 'selected' : ''; ?>>Evento Benéfico</option>
                                                    <option value="evento_gala" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_gala' ? 'selected' : ''; ?>>Evento de Gala</option>
                                                    <option value="evento_privado" <?php echo ($form_data['tipo_evento'] ?? '') == 'evento_privado' ? 'selected' : ''; ?>>Evento Privado</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="mensaje" class="form-label fw-bold text-uppercase small">
                                                <i class="bi bi-chat-left-text-fill text-primary me-2"></i> Mensaje adicional
                                            </label>
                                            <textarea class="form-control form-control-lg" id="mensaje" name="mensaje" rows="5" 
                                                      placeholder="Cuéntanos más sobre tus ideas, número de invitados, presupuesto aproximado, ubicación preferida..."><?php echo htmlspecialchars($form_data['mensaje'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-5">
                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="bi bi-send-fill me-2"></i> Enviar Solicitud
                                        </button>
                                        <button type="reset" class="btn btn-outline-primary btn-lg px-5">
                                            <i class="bi bi-arrow-clockwise me-2"></i> Limpiar Formulario
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="mt-5 text-center">
                                <p class="text-muted mb-4">
                                    <i class="bi bi-info-circle text-primary me-2"></i> Todos los campos marcados con * son obligatorios
                                </p>
                                <a href="index.php" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i> Volver al inicio
                                </a>
                            </div>
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