<?php
// admin/login.php - DISEÑO ORIGINAL CON RECUPERACIÓN
require_once __DIR__ . '/../app/Bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_id']) || isset($_SESSION['usuario_id'])) {
    header("Location: ../panel.php");
    exit();
}

$error = '';
$success_message = '';

// Procesar solicitud de código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recuperar_password'])) {
    $email = $_POST['email_recuperacion'] ?? '';
    
    if (empty($email)) {
        $error = "Por favor ingresa tu correo electrónico";
    } else {
        require_once __DIR__ . '/../config/database.php';
        $resultado = generarCodigoRecuperacion($email);
        
        if ($resultado['success']) {
            $success_message = $resultado['message'];
            $_SESSION['recuperacion_admin_id'] = $resultado['admin_id'];
            $_SESSION['recuperacion_email'] = $email;
            $_SESSION['mostrar_paso2'] = true;
        } else {
            $error = $resultado['message'];
        }
    }
}

// Procesar verificación de código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verificar_codigo'])) {
    $codigo = $_POST['codigo_verificacion'] ?? '';
    $admin_id = $_SESSION['recuperacion_admin_id'] ?? 0;
    
    if (empty($codigo)) {
        $error = "Por favor ingresa el código de verificación";
    } else {
        require_once __DIR__ . '/../config/database.php';
        $resultado = verificarCodigoRecuperacion($admin_id, $codigo);
        
        if ($resultado['success']) {
            $_SESSION['codigo_verificado'] = true;
            $success_message = "Código verificado correctamente. Ahora puedes cambiar tu contraseña.";
        } else {
            $error = $resultado['message'];
        }
    }
}

// Procesar cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_password_recuperacion'])) {
    $nuevo_password = $_POST['nuevo_password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    $admin_id = $_SESSION['recuperacion_admin_id'] ?? 0;
    
    if (empty($nuevo_password) || empty($confirmar_password)) {
        $error = "Todos los campos son obligatorios";
    } elseif (strlen($nuevo_password) < 4) {
        $error = "La contraseña debe tener al menos 4 caracteres";
    } elseif ($nuevo_password !== $confirmar_password) {
        $error = "Las contraseñas no coinciden";
    } else {
        require_once __DIR__ . '/../config/database.php';
        $resultado = cambiarPassword($admin_id, $nuevo_password);
        
        if ($resultado['success']) {
            unset($_SESSION['recuperacion_admin_id']);
            unset($_SESSION['recuperacion_email']);
            unset($_SESSION['codigo_verificado']);
            unset($_SESSION['mostrar_paso2']);
            
            $success_message = "✅ ¡Contraseña actualizada exitosamente! Ahora puedes iniciar sesión.";
        } else {
            $error = $resultado['message'];
        }
    }
}

// Procesar login normal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['recuperar_password']) && !isset($_POST['verificar_codigo']) && !isset($_POST['cambiar_password_recuperacion'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Usuario y contraseña son requeridos";
    } else {
        require_once __DIR__ . '/../config/database.php';
        $admin = verificarLogin($username, $password);
        
        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nombre'] = $admin['nombre'] ?? $admin['username'];
            $_SESSION['es_admin'] = true;
            
            header("Location: ../panel.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo - Wedding Connect</title>
    <link rel="shortcut icon" href="../assets/images/logocristinagallo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&family=Marcellus&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .forgot-password-link {
            display: block;
            text-align: right;
            margin-top: 8px;
            font-size: 0.9rem;
            color: #9d1f3c;
            text-decoration: none;
        }
        .forgot-password-link:hover {
            color: #d4af37;
            text-decoration: underline;
        }
        .recovery-step { display: none; }
        .recovery-step.active { display: block; }
    </style>
</head>
<body>
    <!-- ELEMENTOS DECORATIVOS DE FONDO -->
    <div class="bg-decoration bg-rings"></div>
    <div class="bg-decoration bg-hearts"></div>
    <div class="bg-decoration bg-sparkle"></div>
    
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="login-wrapper">
        <div class="login-container">
            <!-- LADO IZQUIERDO - IMAGEN Y TEXTO -->
            <div class="wedding-side">
                <div class="wedding-content">
                    <div class="wedding-icon heartbeat">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    
                    <h2 class="wedding-quote">
                        "Donde los sueños de amor se hacen realidad"
                    </h2>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Gestión de clientes</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Panel administrativo exclusivo</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Calendario de eventos</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Reportes y estadísticas detalladas</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- LADO DERECHO - FORMULARIO -->
            <div class="login-side">
                <div class="login-header">
                    <h1 class="brand-logo">Wedding Connect</h1>
                    <h2 class="login-title">Acceder</h2>
                    <p class="login-subtitle">Acceso exclusivo para personal autorizado</p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="login-form">
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="bi bi-person-badge"></i>Usuario
                        </label>
                        <div class="position-relative">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="form-control" 
                                   placeholder="Ingresa tu nombre de usuario"
                                   required
                                   autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-shield-lock"></i>Contraseña
                        </label>
                        <div class="position-relative">
                            <i class="bi bi-key-fill input-icon"></i>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Ingresa tu contraseña"
                                   required>
                        </div>
                        <a href="#" class="forgot-password-link" data-bs-toggle="modal" data-bs-target="#modalRecuperarPassword">
                            <i class="bi bi-question-circle"></i> ¿Se te olvidó tu contraseña?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn-login pulse">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Iniciar Sesión
                    </button>
                </form>
                
                <div class="login-footer">
                    <div class="quick-links">
                        <a href="../index.php" class="quick-link">
                            <i class="bi bi-house"></i> Volver al Inicio
                        </a>
                    </div>
                    
                    <div class="copyright">
                        <p>
                            <i class="bi bi-c-circle"></i> 2026 Wedding Connect - 
                            <i class="bi bi-heart-fill text-danger ms-1 me-1"></i>
                            Todos los derechos reservados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL DE RECUPERACIÓN DE CONTRASEÑA -->
    <div class="modal fade" id="modalRecuperarPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: 2px solid #d4af37;">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock-fill"></i> Recuperar Contraseña
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <!-- PASO 1: Solicitar correo -->
                <div id="step1" class="recovery-step active">
                    <form method="POST" action="">
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="bi bi-envelope-paper-heart" style="font-size: 3rem; color: #d4af37;"></i>
                                <h6 class="mt-3">Ingresa tu correo electrónico</h6>
                                <p class="text-muted small">Te enviaremos un código de verificación</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-envelope-fill"></i> Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       name="email_recuperacion" 
                                       id="email_recuperacion"
                                       placeholder="tucorreo@ejemplo.com"
                                       required
                                       style="border: 2px solid #d4af37; border-radius: 10px;">
                            </div>
                            
                            <div id="emailError" class="alert alert-danger d-none">
                                <i class="bi bi-exclamation-triangle-fill"></i> No se encuentra el correo en el sistema
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                            <button type="submit" name="recuperar_password" class="btn" style="background: #d4af37; color: white;">
                                <i class="bi bi-send-check"></i> Continuar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- PASO 2: Verificar código -->
                <div id="step2" class="recovery-step">
                    <form method="POST" action="">
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="bi bi-shield-check" style="font-size: 3rem; color: #d4af37;"></i>
                                <h6 class="mt-3">Código de Verificación</h6>
                                <p class="text-muted small">Hemos enviado un código a tu correo</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-123"></i> Código de 6 dígitos
                                </label>
                                <input type="text" 
                                       class="form-control text-center" 
                                       name="codigo_verificacion" 
                                       id="codigo_verificacion"
                                       placeholder="123456"
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       inputmode="numeric"
                                       required
                                       style="border: 2px solid #d4af37; border-radius: 10px; font-size: 24px; letter-spacing: 8px; font-weight: bold;">
                                <div class="form-text text-center mt-2">
                                    <i class="bi bi-hourglass-split"></i> El código expira en 15 minutos
                                </div>
                            </div>
                            
                            <div id="codeError" class="alert alert-danger d-none">
                                <i class="bi bi-exclamation-triangle-fill"></i> Código inválido o expirado
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="volverPaso1()">
                                <i class="bi bi-arrow-left"></i> Volver
                            </button>
                            <button type="submit" name="verificar_codigo" class="btn" style="background: #d4af37; color: white;">
                                <i class="bi bi-check-circle"></i> Verificar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- PASO 3: Cambiar contraseña -->
                <div id="step3" class="recovery-step">
                    <form method="POST" action="">
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="bi bi-key-fill" style="font-size: 3rem; color: #d4af37;"></i>
                                <h6 class="mt-3">Nueva Contraseña</h6>
                                <p class="text-muted small">Ingresa tu nueva contraseña</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-lock-fill"></i> Nueva Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       name="nuevo_password" 
                                       id="nuevo_password_rec"
                                       placeholder="Mínimo 4 caracteres"
                                       minlength="4"
                                       required
                                       style="border: 2px solid #d4af37; border-radius: 10px;">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-lock-fill"></i> Confirmar Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       name="confirmar_password" 
                                       id="confirmar_password_rec"
                                       placeholder="Repite tu contraseña"
                                       minlength="4"
                                       required
                                       style="border: 2px solid #d4af37; border-radius: 10px;">
                                <div class="form-text" id="passwordMatchMessageRec"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="volverPaso2()">
                                <i class="bi bi-arrow-left"></i> Volver
                            </button>
                            <button type="submit" name="cambiar_password_recuperacion" class="btn" id="btnCambiarPasswordRec" style="background: #d4af37; color: white;">
                                <i class="bi bi-shield-check"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/login.js"></script>
    
    <script>
    function mostrarPaso(paso) {
        document.querySelectorAll('.recovery-step').forEach(el => {
            el.classList.remove('active');
        });
        document.getElementById('step' + paso).classList.add('active');
    }
    
    function volverPaso1() {
        mostrarPaso(1);
    }
    
    function volverPaso2() {
        mostrarPaso(2);
    }
    
    // Validar contraseñas
    document.addEventListener('DOMContentLoaded', function() {
        const pass = document.getElementById('nuevo_password_rec');
        const confirm = document.getElementById('confirmar_password_rec');
        const btn = document.getElementById('btnCambiarPasswordRec');
        const msg = document.getElementById('passwordMatchMessageRec');
        
        if (pass && confirm) {
            function validar() {
                if (pass.value.length >= 4 && pass.value === confirm.value) {
                    msg.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Las contraseñas coinciden</span>';
                    btn.disabled = false;
                } else {
                    msg.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle"></i> Las contraseñas no coinciden</span>';
                    btn.disabled = true;
                }
            }
            pass.addEventListener('input', validar);
            confirm.addEventListener('input', validar);
            validar();
        }
    });
    
    <?php if (isset($_SESSION['mostrar_paso2']) && $_SESSION['mostrar_paso2'] === true): ?>
    document.addEventListener('DOMContentLoaded', function() {
        mostrarPaso(2);
        var modal = new bootstrap.Modal(document.getElementById('modalRecuperarPassword'));
        modal.show();
        <?php unset($_SESSION['mostrar_paso2']); ?>
    });
    <?php elseif (isset($_SESSION['codigo_verificado']) && $_SESSION['codigo_verificado'] === true): ?>
    document.addEventListener('DOMContentLoaded', function() {
        mostrarPaso(3);
        var modal = new bootstrap.Modal(document.getElementById('modalRecuperarPassword'));
        modal.show();
        <?php unset($_SESSION['codigo_verificado']); ?>
    });
    <?php endif; ?>
    </script>
</body>
</html>