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

// Obtener estadísticas para dashboard (desde database.php)
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

// Obtener tipos de evento para modales
$tipos_evento = $db->query("SELECT * FROM tipos_evento WHERE activo = 1 ORDER BY categoria, nombre")->fetchAll();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- NUEVO PANEL CSS -->
    <link rel="stylesheet" href="../assets/css/panel-nuevo.css">
</head>
<body class="admin-body-nuevo">
    <!-- ELEMENTOS DECORATIVOS DE FONDO -->
    <div class="bg-decoration bg-rings"></div>
    <div class="bg-decoration bg-hearts"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR NUEVO -->
            <div class="col-lg-3 col-xl-2 px-3">
                <nav class="sidebar-nuevo">
                    <div class="sidebar-header-nuevo">
                        <div class="avatar-nuevo">
                            <img src="../assets/images/avatar.png" alt="Avatar">
                        </div>
                        <h4><?php echo $_SESSION['admin_nombre'] ?? 'Administrador'; ?></h4>
                        <small><i class="bi bi-shield-check"></i> Panel Administrativo</small>
                    </div>
                    
                    <!-- Botón de ajustes -->
                    <button type="button" class="settings-btn-nuevo" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear-fill me-2"></i> Ajustes
                    </button>
                    <ul class="dropdown-menu dropdown-menu-nuevo w-100">
                        <li>
                            <h6 class="dropdown-header"><i class="bi bi-shield-check"></i> Seguridad</h6>
                        </li>
                        <li>
                            <button class="dropdown-item dropdown-item-nuevo" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
                                <i class="bi bi-key-fill me-2"></i> Cambiar Contraseña
                                <span class="badge bg-warning ms-2">Admin</span>
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Navegación -->
                    <ul class="nav-nuevo mt-4">
                        <li class="nav-item-nuevo">
                            <a class="nav-link-nuevo <?php echo $tab == 'dashboard' ? 'active' : ''; ?>" 
                               href="admin.php?tab=dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item-nuevo">
                            <a class="nav-link-nuevo <?php echo $tab == 'clientes' ? 'active' : ''; ?>" 
                               href="admin.php?tab=clientes">
                                <i class="bi bi-people"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item-nuevo">
                            <a class="nav-link-nuevo <?php echo $tab == 'eventos' ? 'active' : ''; ?>" 
                               href="admin.php?tab=eventos">
                                <i class="bi bi-calendar-heart"></i> Eventos
                            </a>
                        </li>
                        <li class="nav-item-nuevo">
                            <a class="nav-link-nuevo <?php echo $tab == 'reportes' ? 'active' : ''; ?>" 
                               href="admin.php?tab=reportes">
                                <i class="bi bi-bar-chart"></i> Reportes
                            </a>
                        </li>
                        <li class="nav-item-nuevo mt-4 pt-3 border-top">
                            <a class="nav-link-nuevo text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-white-50">
                            <i class="bi bi-heart-fill text-danger"></i> Wedding Connect<br>
                            <span id="liveTime" class="d-block mt-1"></span>
                            <span class="d-block mt-1">versión 6.1 beta</span>
                        </small>
                    </div>
                </nav>
            </div>
            
            <!-- CONTENIDO PRINCIPAL -->
            <div class="col-lg-9 col-xl-10 main-content-nuevo">
                <!-- ENCABEZADO -->
                <div class="welcome-card-nuevo">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1>
                                <i class="bi bi-heart-fill text-danger me-2"></i>
                                Bienvenida, <?php echo $_SESSION['admin_nombre'] ?? 'Administradora'; ?>
                            </h1>
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar-check me-1"></i>
                                <span id="liveDate"></span>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary-nuevo" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalNuevoCliente">
                                <i class="bi bi-plus-circle"></i> Nuevo Cliente
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mostrar mensajes -->
                <?php if ($mensaje): ?>
                    <div class="alert alert-success alert-dismissible fade show animate-nuevo" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error_mensaje): ?>
                    <div class="alert alert-danger alert-dismissible fade show animate-nuevo" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- CONTENIDO DE LA PESTAÑA -->
                <div class="tab-content">
                    <?php
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
    
    <!-- MODALES -->
    <?php require_once 'includes/modales.php'; ?>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- NUEVO PANEL JS -->
    <script src="../assets/js/panel-nuevo.js"></script>
    <script src="../assets/js/views-panel.js"></script>
</body>
</html>