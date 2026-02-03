<?php
// 1. Incluir Bootstrap correctamente (siguiendo tu estructura)
require_once __DIR__ . '/../app/Bootstrap.php';

// 2. Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Si ya está logueado, redirigir al panel de la RAÍZ
if (isset($_SESSION['admin_id']) || isset($_SESSION['usuario_id'])) {
    header("Location: ../panel.php");
    exit();
}

// 4. Procesar el formulario de login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validación simple
    if (empty($username) || empty($password)) {
        $error = "Usuario y contraseña son requeridos";
    } else {
        // Usar tu función verificarLogin de database.php
        if (function_exists('verificarLogin')) {
            $admin = verificarLogin($username, $password);
            
            if ($admin) {
                // Iniciar sesión
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nombre'] = $admin['nombre'] ?? $admin['username'];
                $_SESSION['es_admin'] = true;
                
                // REDIRIGIR A panel.php EN LA RAÍZ (../panel.php)
                header("Location: ../panel.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            // Fallback si no existe la función
            if ($username === 'admin' && $password === 'admin123') {
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_nombre'] = 'Administrador';
                $_SESSION['es_admin'] = true;
                
                // REDIRIGIR A panel.php EN LA RAÍZ
                header("Location: ../panel.php");
                exit();
            } else {
                $error = "Credenciales inválidas";
            }
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
                    <h2 class="login-title">Panel de Administración</h2>
                    <p class="login-subtitle">Acceso exclusivo para personal autorizado</p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
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
                    </div>
                    
                    <button type="submit" class="btn-login pulse">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Acceder al Panel
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
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/login.js"></script>
</body>
</html>