<?php
// admin/admin.php - Punto de entrada del panel
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Usar conexión centralizada
require_once '../config/database.php';

// Determinar qué tab mostrar
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

// Inicializar variables de mensaje
$mensaje = '';
$error_mensaje = '';

// Incluir funciones
require_once 'includes/functions.php';

// Procesar acciones (insertar, actualizar, eliminar clientes)
procesarAcciones($tab);

// Obtener estadísticas para dashboard
$stats = obtenerEstadisticas();

// Obtener datos según la pestaña
switch ($tab) {
    case 'clientes':
        $datos = obtenerDatosClientes();
        break;
    case 'eventos':
        $datos = obtenerDatosEventos();
        break;
    case 'reportes':
        $datos = obtenerDatosReportes();
        break;
    default:
        $datos = obtenerDatosDashboard();
        break;
}

// Obtener todos los clientes para modales
$db = getDB();
$todos_clientes = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                             FROM clientes c 
                             JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                             ORDER BY c.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Wedding Connect</title>
    <link rel="shortcut icon" href="../assets/images/logocristinagallo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&family=Marcellus&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="../assets/css/dark-mode.css">
</head>
<body>
    <!-- ELEMENTOS DECORATIVOS DE FONDO -->
    <div class="bg-decoration bg-rings"></div>
    <div class="bg-decoration bg-hearts"></div>
    
    <div class="panel-wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- SIDEBAR ELEGANTE -->
                <div class="col-lg-3 col-xl-2 px-0">
                    <nav class="nav-sidebar">
                        <div class="nav-header text-center">
                            <div class="admin-avatar pulse" style="width: 5.0rem; height: 5.0rem; border-radius: 100%; overflow: hidden;">
                                <img src="../assets/images/avatar.png" 
                                    alt="Avatar" 
                                    style="width: 110%; height: 110%; object-fit: cover;">
                            </div>
                            <h4 class="mb-1" style="color: var(--wedding-burgundy); font-family: 'Great Vibes', cursive; font-size: 2rem;">
                                <?php echo $_SESSION['admin_nombre'] ?? 'Administrador'; ?>
                            </h4>
                            <small class="text-muted">
                                <i class="bi bi-shield-check"></i> Panel Administrativo
                            </small>
                        </div>
                        
                        <!-- ===== BOTÓN DE AJUSTES AGREGADO ===== -->
                        <div class="row">
                            <div class="btn-group mt-2">
                                <button type="button" class="btn btn-outline-wedding dropdown-toggle" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill"></i> Ajustes
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end wedding-dropdown">
                                    <li>
                                        <h6 class="dropdown-header" style="color: var(--wedding-burgundy);">
                                            <i class="bi bi-shield-check"></i> Seguridad
                                        </h6>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
                                            <i class="bi bi-key-fill"></i> Cambiar Contraseña
                                            <span class="badge bg-warning ms-2" style="color: #000;">Admin: <?php echo $_SESSION['admin_nombre'] ?? 'cristina'; ?></span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        
                        <div class="nav-body p-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab == 'dashboard' ? 'active' : ''; ?>" 
                                       href="admin.php?tab=dashboard">
                                        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab == 'clientes' ? 'active' : ''; ?>" 
                                       href="admin.php?tab=clientes">
                                        <span class="nav-icon"><i class="bi bi-people"></i></span>
                                        Clientes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab == 'eventos' ? 'active' : ''; ?>" 
                                       href="admin.php?tab=eventos">
                                        <span class="nav-icon"><i class="bi bi-calendar-heart"></i></span>
                                        Eventos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab == 'reportes' ? 'active' : ''; ?>" 
                                       href="admin.php?tab=reportes">
                                        <span class="nav-icon"><i class="bi bi-bar-chart"></i></span>
                                        Reportes
                                    </a>
                                </li>
                                <li class="nav-item mt-4 pt-3 border-top">
                                    <a class="nav-link text-danger" href="logout.php">
                                        <span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>
                                        Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="nav-footer p-3 text-center border-top">
                            <small class="text-muted">
                                <i class="bi bi-heart-fill text-danger"></i> Wedding Connect<br>
                                <i>Sesión Activa</i> |
                                <span id="liveTime"></span>
                                <span class="d-block mt-1">version 6.0</span>
                            </small>
                        </div>
                    </nav>
                </div>
                
                <!-- CONTENIDO PRINCIPAL -->
                <div class="col-lg-9 col-xl-10 main-content">
                    <!-- ENCABEZADO -->
                    <div class="welcome-card">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="display-6 mb-2" style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                                    <i class="bi bi-heart-fill text-danger me-2"></i>
                                    Bienvenida, <?php echo $_SESSION['admin_nombre'] ?? 'Administradora'; ?>
                                </h1>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    <span id="liveDate"></span> 
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="btn-group">
                                    <button class="btn btn-admin me-2 pulse" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalNuevoCliente">
                                        <i class="bi bi-plus-circle"></i> Nuevo Cliente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mostrar mensajes de éxito o error -->
                    <?php if ($mensaje): ?>
                        <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                            <i class="bi bi-check-circle me-2"></i> <?php echo $mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error_mensaje): ?>
                        <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> <?php echo $error_mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- CONTENIDO DE LA PESTAÑA -->
                    <div class="tab-content">
                        <?php
                        // Incluir la vista correspondiente
                        switch ($tab) {
                            case 'clientes':
                                require_once 'views/clientes.php';
                                break;
                            case 'eventos':
                                require_once 'views/eventos.php';
                                break;
                            case 'reportes':
                                require_once 'views/reportes.php';
                                break;
                            default:
                                require_once 'views/dashboard.php';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        // Función para mostrar fecha en español
    function updateSpanishDate() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const dateString = now.toLocaleDateString('es-ES', options);
        document.getElementById('liveDate').textContent = dateString;
    }
    
    // Reloj en tiempo real
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('es-ES', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });
        document.getElementById('liveTime').textContent = timeString;
    }
    
    // Inicializar fecha y hora
    updateSpanishDate();
    setInterval(updateTime, 1000);
    updateTime();
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    </script>
    
    <?php
    // Incluir modales
    require_once 'includes/modales.php';
    ?>
    <!-- Dark Mode JavaScript -->
    <script src="../assets/js/dark-mode.js"></script>
</body>
</html>