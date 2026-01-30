<?php
// admin/admin.php - Punto de entrada del panel
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    $host = 'localhost';
    $dbname = 'wedding_connect';
    $db_user = 'root';
    $db_pass = '';
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Determinar qué tab mostrar
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

// Inicializar variables de mensaje
$mensaje = '';
$error_mensaje = '';

// Incluir funciones
require_once 'includes/functions.php';

// Procesar acciones (insertar, actualizar, eliminar clientes)
procesarAcciones($conn, $tab);

// Obtener estadísticas para dashboard
$stats = obtenerEstadisticas($conn);

// Obtener datos según la pestaña
switch ($tab) {
    case 'clientes':
        $datos = obtenerDatosClientes($conn);
        break;
    case 'eventos':
        $datos = obtenerDatosEventos($conn);
        break;
    case 'reportes':
        $datos = obtenerDatosReportes($conn);
        break;
    default:
        $datos = obtenerDatosDashboard($conn);
        break;
}

// Obtener todos los clientes para modales
$todos_clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Incluir header
require_once 'includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'includes/sidebar.php'; ?>
        
        <!-- Contenido de la pestaña -->
        <div class="col-lg-10">
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
            
            <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
                <div>
                    <h1 class="h3 text-dark mb-1">
                        <?php if ($tab == 'dashboard'): ?>
                            <i class="bi bi-speedometer2"></i> Panel de Administración
                        <?php elseif ($tab == 'clientes'): ?>
                            <i class="bi bi-people"></i> Gestión de Clientes
                        <?php elseif ($tab == 'eventos'): ?>
                            <i class="bi bi-calendar-event"></i> Calendario de Eventos
                        <?php elseif ($tab == 'reportes'): ?>
                            <i class="bi bi-bar-chart"></i> Reportes y Estadísticas
                        <?php endif; ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <small>
                            <?php if ($tab == 'dashboard'): ?>
                                Gestión completa de clientes y eventos
                            <?php elseif ($tab == 'clientes'): ?>
                                Administra la información de tus clientes
                            <?php elseif ($tab == 'eventos'): ?>
                                Visualiza y gestiona todos los eventos programados
                            <?php elseif ($tab == 'reportes'): ?>
                                Análisis y estadísticas del sistema
                            <?php endif; ?>
                        </small>
                    </p>
                </div>
                <?php if ($tab == 'clientes'): ?>
                <div class="search-box">
                    <form method="GET" action="">
                        <input type="hidden" name="tab" value="clientes">
                        <div class="input-group">
                            <input type="text" class="form-control" 
                                   name="buscar" placeholder="Buscar cliente..." 
                                   value="<?php echo htmlspecialchars($datos['busqueda'] ?? ''); ?>"
                                   id="searchInput">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($datos['busqueda'])): ?>
                                <a href="admin.php?tab=clientes" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            
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
            
            <div class="mt-4 text-center text-muted">
                <small>
                    <i class="bi bi-c-circle"></i> <?php echo date('Y'); ?> Wedding Connect 
                    | Panel Administrativo v3.0
                    | <span id="currentDateTime"></span>
                </small>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir modales
require_once 'includes/modales.php';

// Incluir footer
require_once 'includes/footer.php';
?>