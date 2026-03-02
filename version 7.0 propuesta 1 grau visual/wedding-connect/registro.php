<?php
date_default_timezone_set('America/Mexico_City');
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
    return preg_replace('/[^a-z_]/', '', $clave);
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
        
        // Validar nombre: solo letras y espacios, máximo 40 caracteres
        if (!preg_match('/^[a-zA-ZáéíóúñÑüÜ\s]+$/', $nombre)) {
            $errores[] = 'El nombre solo puede contener letras y espacios.';
        } elseif (strlen($nombre) > 40) {
            $errores[] = 'El nombre no puede exceder los 40 caracteres.';
        }
        
        // Validar correo: formato y máximo 50 caracteres
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido.';
        } elseif (strlen($correo) > 60) {
            $errores[] = 'El correo no puede exceder los 60 caracteres.';
        }
        
        // Validar teléfono: exactamente 10 dígitos
        $telefono_limpio = preg_replace('/\D/', '', $telefono);
        if (!preg_match('/^\d{10}$/', $telefono_limpio)) {
            $errores[] = 'El teléfono debe contener exactamente 10 dígitos numéricos.';
        }
        
        // Validar fecha: no puede ser pasada
        $hoy = date('Y-m-d');
        if (empty($fecha_evento)) {
            $errores[] = 'La fecha del evento es obligatoria.';
        } elseif ($fecha_evento < $hoy) {
            $errores[] = 'La fecha del evento debe ser hoy (' . date('d/m/Y') . ') o una fecha futura.';
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
                
                // Preparar consulta (SIN numero_personas)
                $sql = "INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_evento_id, mensaje, fecha_registro) 
                        VALUES (:nombre, :correo, :telefono, :fecha_evento, :tipo_evento_id, :mensaje, NOW())";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':correo' => $correo,
                    ':telefono' => $telefono_limpio,
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

// Incluir header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('assets/images/registro.jpeg');"><!-- fondo registro -->
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="hero-content" data-aos="fade-up">
                    <br><br>
                    <span class="hero-subtitle">Wedding & Event Planner</span>
                    <h1 class="hero-title-fancy">Solicita tu Cotización</h1>
                    <p class="hero-subtitle-fancy">Comienza a planear tu evento especial con nosotros</p>
                    <div class="hero-buttons">
                        <a href="#registro-form" class="btn-primary">Completar Formulario</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulario de Registro -->
<section id="registro-form" class="about-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header text-center" data-aos="fade-up">
                    <span class="section-tag">Solicitud</span>
                    <h2 class="section-title">Formulario de Contacto</h2>
                    <p class="section-description">Completa tus datos y te contactaremos a la brevedad</p>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <i class="bi <?php echo $message_type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- FORMULARIO CON CSS CORREGIDO -->
                <div class="form-container" data-aos="fade-up" style="background: #ffffff; padding: 3rem; border: 1px solid #e9ecef; position: relative;">
                    
                    <!-- ESTILOS DIRECTOS PARA EL HEADER (funcionan seguro) -->
                    <div style="text-align: center; margin-bottom: 3rem;">
                        <!-- Icono con estilos en línea -->
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d4b5a0, #b89a85); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 20px rgba(212, 181, 160, 0.3);">
                            <i class="bi bi-stars" style="font-size: 3rem; color: white;"></i>
                        </div>
                        <h3 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #1a1a1a; margin-bottom: 0.5rem;">Cuéntanos tu idea</h3>
                        <p style="font-family: 'Montserrat', sans-serif; font-size: 1rem; color: #6c757d; max-width: 500px; margin: 0 auto;">Déjanos tus datos y comencemos a crear algo increíble juntos</p>
                    </div>
                    
                    <form method="POST" action="" id="registrationForm">
                        <?php if ($registro_exitoso): ?>
                            <input type="hidden" id="registro_exitoso" value="1">
                        <?php endif; ?>
                        
                        <div class="row g-4">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="form-label">
                                        <i class="bi bi-person-fill"></i> Nombre completo *
                                    </label>
                                    <div class="input-wrapper" style="position: relative; display: flex; align-items: center;">
                                        <i class="bi bi-person" style="position: absolute; left: 15px; color: #6c757d; z-index: 1;"></i>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                            value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>" 
                                            required placeholder="Ana García López" maxlength="30"
                                            style="padding-left: 45px; width: 100%; height: 55px; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Correo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correo" class="form-label">
                                        <i class="bi bi-envelope-fill"></i> Correo electrónico *
                                    </label>
                                    <div class="input-wrapper" style="position: relative; display: flex; align-items: center;">
                                        <i class="bi bi-envelope" style="position: absolute; left: 15px; color: #6c757d; z-index: 1;"></i>
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                            value="<?php echo htmlspecialchars($form_data['correo'] ?? ''); ?>" 
                                            required placeholder="ana@email.com" maxlength="50"
                                            style="padding-left: 45px; width: 100%; height: 55px; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono" class="form-label">
                                        <i class="bi bi-telephone-fill"></i> Teléfono *
                                    </label>
                                    <div class="input-wrapper" style="position: relative; display: flex; align-items: center;">
                                        <i class="bi bi-telephone" style="position: absolute; left: 15px; color: #6c757d; z-index: 1;"></i>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                            value="<?php echo htmlspecialchars($form_data['telefono'] ?? ''); ?>" 
                                            required placeholder="449 123 4567"
                                            style="padding-left: 45px; width: 100%; height: 55px; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Fecha del evento -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_evento" class="form-label">
                                        <i class="bi bi-calendar-heart-fill"></i> Fecha del evento *
                                    </label>
                                    <div class="input-wrapper" style="position: relative; display: flex; align-items: center;">
                                        <i class="bi bi-calendar" style="position: absolute; left: 15px; color: #6c757d; z-index: 1;"></i>
                                        <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" 
                                            value="<?php echo htmlspecialchars($form_data['fecha_evento'] ?? ''); ?>" 
                                            required
                                            style="padding-left: 45px; width: 100%; height: 55px; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tipo de evento -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipo_evento_id" class="form-label">
                                        <i class="bi bi-stars"></i> Tipo de evento *
                                    </label>
                                    <div class="input-wrapper" style="position: relative; display: flex; align-items: center;">
                                        <i class="bi bi-tag" style="position: absolute; left: 15px; color: #6c757d; z-index: 1;"></i>
                                        <select class="form-select" id="tipo_evento_id" name="tipo_evento_id" required
                                                style="padding-left: 45px; width: 100%; height: 55px; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;">
                                            <option value="">Seleccionar tipo...</option>
                                            <?php 
                                            $categorias = [];
                                            foreach ($tipos_evento as $tipo) {
                                                $categorias[$tipo['categoria']][] = $tipo;
                                            }
                                            
                                              $labels_categorias = [
                                                'bodas' => '🎭 Bodas',
                                                'xv_anos' => '👸 XV Años',
                                                'baby_shower' => '🎀 Baby Shower',
                                                'empresariales' => '🏢 Eventos Empresariales',
                                                'gubernamentales' => '🏛️ Eventos Gubernamentales',
                                                'anuales' => '📅 Eventos del Año',
                                                'otros' => '🎪 Otros Eventos'
                                            ];
                                            
                                            foreach ($categorias as $categoria => $tipos): 
                                                if (!empty($tipos)): 
                                            ?>
                                                <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                                    <?php foreach ($tipos as $tipo): 
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
                            </div>
                            
                            <!-- Mensaje adicional -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mensaje" class="form-label">
                                        <i class="bi bi-chat-text-fill"></i> Mensaje adicional
                                    </label>
                                    <div class="input-wrapper" style="position: relative;">
                                        <i class="bi bi-chat" style="position: absolute; left: 15px; top: 15px; color: #6c757d; z-index: 1;"></i>
                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" 
                                                placeholder="Cuéntanos más sobre tus ideas, presupuesto aproximado, ubicación preferida..."
                                                style="padding-left: 45px; width: 100%; border: 2px solid #e9ecef; border-radius: 12px; font-family: 'Montserrat', sans-serif;"><?php echo htmlspecialchars($form_data['mensaje'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-text" style="font-size: 0.8rem; color: #6c757d; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.3rem;">
                                        <i class="bi bi-info-circle" style="color: #d4b5a0;"></i>
                                        Todos los campos marcados con * son obligatorios
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; margin: 2rem 0; position: relative;">
                            <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, #d4b5a0, transparent); transform: translateY(-50%);"></div>
                            <span style="background: white; padding: 0 1.5rem; color: #d4b5a0; font-family: 'Brittany Signature', cursive; font-size: 1.2rem; position: relative; z-index: 1;">✦ Envía tu solicitud ✦</span>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; gap: 1rem; font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; padding: 1.2rem 3rem; background: linear-gradient(135deg, #d4b5a0, #b89a85); color: #1a1a1a; border: none; cursor: pointer; border-radius: 50px; box-shadow: 0 10px 20px rgba(212, 181, 160, 0.3); transition: all 0.4s ease;">
                                <span>Enviar Solicitud</span>
                                <i class="bi bi-send-heart-fill"></i>
                            </button>
                            <!-- Botón de Limpiar (Armonizado con el mismo estilo pero outline) -->
                            <button type="reset" class="btn-elegant-outline">
                                <i class="bi bi-arrow-clockwise me-2"></i> Limpiar Formulario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Información Adicional -->
<section class="services-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Proceso</span>
            <h2 class="section-title">¿Qué pasa después?</h2>
            <p class="section-description">Nuestro proceso después de recibir tu solicitud</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-telephone-outbound"></i>
                    </div>
                    <h3 class="service-title">Contacto Inmediato</h3>
                    <p class="service-description">Te contactaremos en menos de 24 horas para confirmar los detalles de tu evento.</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h3 class="service-title">Reunión Personalizada</h3>
                    <p class="service-description">Agendaremos una cita para conocer tus expectativas y crear un plan a tu medida.</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h3 class="service-title">Propuesta Detallada</h3>
                    <p class="service-description">Recibirás una cotización completa con todos los servicios y costos detallados.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Incluir footer
include 'includes/footer.php';
?>