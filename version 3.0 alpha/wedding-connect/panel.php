<?php
// panel.php - Panel de Administración de Wedding Connect
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
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

// Insertar nuevo cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && !isset($_POST['actualizar_cliente'])) {
    try {
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $tipo_evento = $_POST['tipo_evento'] ?? '';
        $fecha_evento = $_POST['fecha_evento'] ?? '';
        $mensaje_cliente = $_POST['mensaje'] ?? '';
        
        // Validar datos básicos
        if (empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento) || empty($fecha_evento)) {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }
        
        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, telefono, tipo_boda, fecha_evento, mensaje, fecha_registro) 
                               VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        $stmt->execute([$nombre, $correo, $telefono, $tipo_evento, $fecha_evento, $mensaje_cliente]);
        
        // Redirigir para evitar reenvío del formulario
        header("Location: panel.php?tab=" . $tab . "&success=1");
        exit();
        
    } catch (Exception $e) {
        $error_mensaje = "Error al guardar cliente: " . $e->getMessage();
    }
}

// Actualizar cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_cliente'])) {
    try {
        $cliente_id = $_POST['cliente_id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $tipo_evento = $_POST['tipo_evento'] ?? '';
        $fecha_evento = $_POST['fecha_evento'] ?? '';
        $mensaje_cliente = $_POST['mensaje'] ?? '';
        
        // Validar datos básicos
        if (empty($cliente_id) || empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento) || empty($fecha_evento)) {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }
        
        // Validar que el cliente exista
        $stmt = $conn->prepare("SELECT id FROM clientes WHERE id = ?");
        $stmt->execute([$cliente_id]);
        if (!$stmt->fetch()) {
            throw new Exception("Cliente no encontrado");
        }
        
        // Actualizar en la base de datos
        $stmt = $conn->prepare("UPDATE clientes SET 
                               nombre = ?, 
                               correo = ?, 
                               telefono = ?, 
                               tipo_boda = ?, 
                               fecha_evento = ?, 
                               mensaje = ? 
                               WHERE id = ?");
        
        $stmt->execute([$nombre, $correo, $telefono, $tipo_evento, $fecha_evento, $mensaje_cliente, $cliente_id]);
        
        // Redirigir para evitar reenvío del formulario
        header("Location: panel.php?tab=" . $tab . "&success=2");
        exit();
        
    } catch (Exception $e) {
        $error_mensaje = "Error al actualizar cliente: " . $e->getMessage();
    }
}

// Eliminar cliente
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    try {
        $id_eliminar = $_GET['eliminar'];
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id_eliminar]);
        $mensaje = "Cliente eliminado correctamente";
    } catch (Exception $e) {
        $error_mensaje = "Error al eliminar cliente: " . $e->getMessage();
    }
}

// Mostrar mensaje de éxito si existe
if (isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
        $mensaje = "Cliente guardado exitosamente";
    } elseif ($_GET['success'] == 2) {
        $mensaje = "Cliente actualizado exitosamente";
    }
}

// Obtener estadísticas para dashboard
$stats = $conn->query("SELECT 
    COUNT(*) as total_clientes,
    COUNT(DISTINCT tipo_boda) as tipos_evento,
    MIN(fecha_evento) as proximo_evento,
    MAX(fecha_evento) as ultimo_evento
    FROM clientes")->fetch(PDO::FETCH_ASSOC);

// Obtener clientes para pestaña clientes
$clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$busqueda = '';
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    $stmt = $conn->prepare("SELECT * FROM clientes 
        WHERE nombre LIKE ? OR correo LIKE ? OR telefono LIKE ? 
        ORDER BY id DESC");
    $searchTerm = "%$busqueda%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener eventos para pestaña eventos
if ($tab == 'eventos') {
    $eventos = $conn->query("SELECT * FROM clientes ORDER BY fecha_evento ASC")->fetchAll(PDO::FETCH_ASSOC);
    
    // Estadísticas para eventos
    $eventos_stats = $conn->query("SELECT 
        COUNT(*) as total_eventos,
        SUM(CASE WHEN fecha_evento > CURDATE() THEN 1 ELSE 0 END) as eventos_futuros,
        SUM(CASE WHEN fecha_evento = CURDATE() THEN 1 ELSE 0 END) as eventos_hoy,
        SUM(CASE WHEN fecha_evento < CURDATE() THEN 1 ELSE 0 END) as eventos_pasados
        FROM clientes")->fetch(PDO::FETCH_ASSOC);
}

// Obtener datos para reportes
if ($tab == 'reportes') {
    // Estadísticas para reportes
    $reportes_stats = $conn->query("SELECT 
        tipo_boda,
        COUNT(*) as cantidad,
        ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 2) as porcentaje
        FROM clientes 
        GROUP BY tipo_boda 
        ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener todos los clientes para los modales (se usan en todas las pestañas)
$todos_clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Función para formatear nombres de tipos de evento
function formatearTipoEvento($tipo_boda) {
    // Reemplazar guiones bajos con espacios y capitalizar
    $tipo = str_replace('_', ' ', $tipo_boda);
    $tipo = ucwords($tipo);
    
    // Reemplazamientos específicos
    $reemplazos = [
        'Xv Anos' => 'XV Años',
        'Baby Shower Gender Reveal' => 'Baby Shower (Gender Reveal)',
        'Team Building' => 'Team Building',
        'Ano Nuevo' => 'Año Nuevo',
        'Boda Civil' => 'Boda Civil',
        'Boda Religiosa' => 'Boda Religiosa',
        'Boda Destino' => 'Boda Destino',
        'Boda Intima' => 'Boda Íntima',
        'Boda Lujo' => 'Boda de Lujo',
        'Boda Tematica' => 'Boda Temática',
        'Boda Playa' => 'Boda en Playa',
        'Boda Campo' => 'Boda en Campo',
        'Boda Urbana' => 'Boda Urbana',
        'Boda Vintage' => 'Boda Vintage',
    ];
    
    return $reemplazos[$tipo] ?? $tipo;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Wedding Connect</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/panel.css">
    <style>
        /* Fix para el fondo negro del modal */
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal {
            z-index: 1050 !important;
        }
        
        /* Estilos responsivos para tablas */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Tabla responsiva */
        .table-container {
            width: 100%;
            overflow: hidden;
        }
        
        /* Ajustes para pantallas pequeñas */
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 15px;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .table th, .table td {
                padding: 8px 6px;
                font-size: 0.85rem;
            }
            
            .table td .btn-group {
                display: flex;
                flex-wrap: nowrap;
            }
            
            .table td .btn-group .btn {
                padding: 4px 6px;
                font-size: 0.8rem;
                margin: 1px;
            }
            
            .table td .badge {
                font-size: 0.75rem;
                padding: 3px 6px;
            }
            
            .table th {
                font-size: 0.9rem;
                white-space: nowrap;
            }
            
            .search-box {
                margin-top: 15px;
                width: 100%;
            }
            
            .col-lg-10 {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .navbar-admin {
                padding: 10px 0;
            }
        }
        
        @media (max-width: 576px) {
            .h3 {
                font-size: 1.5rem;
            }
            
            .table th, .table td {
                padding: 6px 4px;
                font-size: 0.8rem;
            }
            
            .btn-group .btn {
                padding: 3px 5px;
                font-size: 0.75rem;
            }
            
            .table td .btn-group {
                flex-direction: column;
            }
            
            .table td .btn-group .btn {
                margin-bottom: 2px;
                width: 100%;
            }
            
            .modal-dialog {
                margin: 10px;
            }
            
            .modal-content {
                padding: 10px;
            }
        }
        
        /* Mejoras específicas para tabla de eventos */
        #eventosTable {
            font-size: 0.9rem;
        }
        
        #eventosTable td {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body class="admin-body">
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-admin fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="panel.php">
                <i class="bi bi-shield-lock"></i> Wedding Connect</span>
            </a>
            
            <div class="d-flex align-items-center">
                <div class="welcome-text me-3 d-none d-md-block">
                    <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador'); ?>
                </div>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container-fluid mt-4">
        <div class="row">
             <!-- Sidebar con diseño de panelNUEVO.php -->
            <div class="col-lg-2">
                <div class="admin-sidebar">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock" style="font-size: 3rem; color: #6f42c1;"></i>
                        </div>
                        <h5 class="mb-1">Panel de Control</h5>
                        <p class="text-muted small">Wedding Connect</p>
                    </div>

                    <nav class="nav flex-column">
                        <a class="nav-link <?php echo $tab == 'dashboard' ? 'active' : ''; ?>" href="panel.php">
                            <i class="bi bi-house me-2"></i> Dashboard
                        </a>
                        <a class="nav-link <?php echo $tab == 'clientes' ? 'active' : ''; ?>" href="panel.php?tab=clientes">
                            <i class="bi bi-people me-2"></i> Clientes
                        </a>
                        <a class="nav-link <?php echo $tab == 'eventos' ? 'active' : ''; ?>" href="panel.php?tab=eventos">
                            <i class="bi bi-calendar-event me-2"></i> Eventos
                        </a>
                        <a class="nav-link <?php echo $tab == 'reportes' ? 'active' : ''; ?>" href="panel.php?tab=reportes">
                            <i class="bi bi-bar-chart me-2"></i> Reportes
                        </a>

                    </nav>
                    <!--reloj de sesion-->
                    <div class="mt-4 p-3">
                        <small class="text-muted">Sesión activa</small>
                        <div id="currentDateTime" class="small"></div>
                    </div>
                    
                    <div class="px-3 mt-4">
                        <small class="text-muted d-block mb-2">ESTADÍSTICAS</small>
                        <div class="d-flex justify-content-between small">
                            <span>Clientes:</span>
                            <span class="fw-bold"><?php echo $stats['total_clientes'] ?? 0; ?></span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span>Hoy:</span>
                            <span class="fw-bold"><?php echo date('d/m/Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenido de la pestaña -->
            <div class="col-lg-10">
                <!-- SE ELIMINARON LAS ALERTAS AQUÍ -->
                
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
                                       value="<?php echo htmlspecialchars($busqueda); ?>"
                                       id="searchInput">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                <?php if ($busqueda): ?>
                                    <a href="panel.php?tab=clientes" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($tab == 'dashboard'): ?>
                    <!-- CONTENIDO DEL DASHBOARD -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.1s">
                                <div class="text-center">
                                    <i class="bi bi-people-fill stat-icon"></i>
                                    <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                                    <div class="stat-label">Clientes Totales</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.2s">
                                <div class="text-center">
                                    <i class="bi bi-heart-fill stat-icon"></i>
                                    <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                                    <div class="stat-label">Tipos de Eventos</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
                                <div class="text-center">
                                    <i class="bi bi-calendar-check stat-icon"></i>
                                    <div class="stat-number">
                                        <?php 
                                        if ($stats['proximo_evento']) {
                                            echo date('d/m/Y', strtotime($stats['proximo_evento']));
                                        } else {
                                            echo '--';
                                        }
                                        ?>
                                    </div>
                                    <div class="stat-label">Último Evento</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.4s">
                                <div class="text-center">
                                    <i class="bi bi-calendar-date stat-icon"></i>
                                    <div class="stat-number">
                                        <?php 
                                        if ($stats['ultimo_evento']) {
                                            echo date('d/m/Y', strtotime($stats['ultimo_evento']));
                                        } else {
                                            echo '--';
                                        }
                                        ?>
                                    </div>
                                    <div class="stat-label">Próximo Evento</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LISTA DE CLIENTES DEL DASHBOARD -->
                    <div class="table-container animate-fade-in" style="animation-delay: 0.5s">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">
                                    <i class="bi bi-table"></i> Lista de Clientes
                                </h4>
                                <small class="text-muted">Últimos 10 registros</small>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-success btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalNuevoCliente">
                                    <i class="bi bi-person-plus"></i> Nuevo
                                </button>
                                <a href="panel.php?tab=clientes" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Ver Todos
                                </a>
                            </div>
                        </div>
                        
                        <?php 
                        $clientes_dashboard = $conn->query("SELECT * FROM clientes ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
                        if (empty($clientes_dashboard)): ?>
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-info-circle display-6 d-block mb-3"></i>
                                <h5>No hay clientes registrados</h5>
                                <p class="mb-0">Comienza agregando tu primer cliente.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="clientesDashboard">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Tipo Evento</th>
                                            <th>Fecha Evento</th>
                                            <th>Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes_dashboard as $cliente): ?>
                                            <tr>
                                                <td><span class="badge bg-dark">#<?php echo $cliente['id']; ?></span></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                                </td>
                                                <td><?php echo $cliente['correo']; ?></td>
                                                <td><?php echo $cliente['telefono']; ?></td>
                                                <td>
                                                    <?php 
                                                    $badge_class = 'badge-' . $cliente['tipo_boda'];
                                                    $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo $tipo_text; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                                                    $hoy = date('Y-m-d');
                                                    $icon = $cliente['fecha_evento'] < $hoy ? 'bi-check-circle' : 
                                                            ($cliente['fecha_evento'] == $hoy ? 'bi-star' : 'bi-calendar');
                                                    $color = $cliente['fecha_evento'] < $hoy ? 'text-success' : 
                                                            ($cliente['fecha_evento'] == $hoy ? 'text-warning' : 'text-primary');
                                                    ?>
                                                    <i class="bi <?php echo $icon; ?> <?php echo $color; ?>"></i>
                                                    <?php echo $fecha_evento; ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                                                    </small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                
                <?php elseif ($tab == 'clientes'): ?>
                    <!-- CONTENIDO DE CLIENTES -->
                    <div class="table-container animate-fade-in">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">
                                    <i class="bi bi-table"></i> Lista de Clientes
                                </h4>
                                <small class="text-muted">Registros totales: <?php echo count($clientes); ?></small>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-success btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalNuevoCliente">
                                    <i class="bi bi-person-plus"></i> Nuevo
                                </button>
                                <button class="btn btn-secondary btn-sm" id="exportExcel">
                                    <i class="bi bi-file-earmark-excel"></i> Exportar
                                </button>
                                <button class="btn btn-info btn-sm" id="printTable">
                                    <i class="bi bi-printer"></i> Imprimir
                                </button>
                            </div>
                        </div>
                        
                        <?php if (empty($clientes)): ?>
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-info-circle display-6 d-block mb-3"></i>
                                <h5>No hay clientes registrados</h5>
                                <p class="mb-0">Comienza agregando tu primer cliente.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="clientesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Tipo Evento</th>
                                            <th>Fecha Evento</th>
                                            <th>Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <tr>
                                                <td><span class="badge bg-dark">#<?php echo $cliente['id']; ?></span></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                                    <?php if ($cliente['mensaje']): ?>
                                                        <br>
                                                        <button class="btn btn-link btn-sm p-0 text-decoration-none" 
                                                                data-bs-toggle="tooltip" 
                                                                title="<?php echo htmlspecialchars(substr($cliente['mensaje'], 0, 100)); ?>...">
                                                            <small class="text-muted">
                                                                <i class="bi bi-chat-left-text"></i> Ver mensaje
                                                            </small>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo $cliente['correo']; ?>" class="text-decoration-none">
                                                        <?php echo $cliente['correo']; ?>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-secondary btn-copiar-email ms-1" 
                                                            data-email="<?php echo $cliente['correo']; ?>"
                                                            title="Copiar email">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="tel:<?php echo $cliente['telefono']; ?>" class="text-decoration-none">
                                                        <?php echo $cliente['telefono']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $badge_class = 'badge-' . $cliente['tipo_boda'];
                                                    $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>" data-tipo="<?php echo $cliente['tipo_boda']; ?>">
                                                        <?php echo $tipo_text; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                                                    $hoy = date('Y-m-d');
                                                    $icon = $cliente['fecha_evento'] < $hoy ? 'bi-check-circle' : 
                                                            ($cliente['fecha_evento'] == $hoy ? 'bi-star' : 'bi-calendar');
                                                    $color = $cliente['fecha_evento'] < $hoy ? 'text-success' : 
                                                            ($cliente['fecha_evento'] == $hoy ? 'text-warning' : 'text-primary');
                                                    ?>
                                                    <i class="bi <?php echo $icon; ?> <?php echo $color; ?>"></i>
                                                    <?php echo $fecha_evento; ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <!-- Botón Ver -->
                                                        <button class="btn btn-info" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalCliente<?php echo $cliente['id']; ?>"
                                                                title="Ver detalles">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        
                                                        <!-- Botón Editar -->
                                                        <button class="btn btn-warning btn-editar" 
                                                                data-id="<?php echo $cliente['id']; ?>"
                                                                title="Editar Cliente">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        
                                                        <!-- Botón Correo -->
                                                        <a href="mailto:<?php echo $cliente['correo']; ?>" 
                                                           class="btn btn-primary" title="Enviar email">
                                                            <i class="bi bi-envelope"></i>
                                                        </a>
                                                        
                                                        <!-- Botón Eliminar -->
                                                        <a href="panel.php?eliminar=<?php echo $cliente['id']; ?>&tab=clientes" 
                                                           class="btn btn-danger btn-eliminar"
                                                           title="Eliminar"
                                                           onclick="return confirm('¿Eliminar a <?php echo addslashes($cliente['nombre']); ?>?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                
                <?php elseif ($tab == 'eventos'): ?>
                    <!-- CONTENIDO DE EVENTOS -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.1s">
                                <div class="text-center">
                                    <i class="bi bi-calendar4-event stat-icon"></i>
                                    <div class="stat-number"><?php echo $eventos_stats['total_eventos'] ?? 0; ?></div>
                                    <div class="stat-label">Total Eventos</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.2s">
                                <div class="text-center">
                                    <i class="bi bi-calendar-check stat-icon"></i>
                                    <div class="stat-number"><?php echo $eventos_stats['eventos_futuros'] ?? 0; ?></div>
                                    <div class="stat-label">Eventos Futuros</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
                                <div class="text-center">
                                    <i class="bi bi-calendar-day stat-icon text-warning"></i>
                                    <div class="stat-number"><?php echo $eventos_stats['eventos_hoy'] ?? 0; ?></div>
                                    <div class="stat-label">Eventos Hoy</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="stat-card animate-fade-in" style="animation-delay: 0.4s">
                                <div class="text-center">
                                    <i class="bi bi-calendar-x stat-icon text-success"></i>
                                    <div class="stat-number"><?php echo $eventos_stats['eventos_pasados'] ?? 0; ?></div>
                                    <div class="stat-label">Eventos Pasados</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-container animate-fade-in">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">
                                    <i class="bi bi-calendar-event"></i> Calendario de Eventos
                                </h4>
                                <small class="text-muted">Próximos eventos ordenados por fecha</small>
                            </div>
                        </div>
                        
                        <?php if (empty($eventos)): ?>
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-calendar-x display-6 d-block mb-3"></i>
                                <h5>No hay eventos programados</h5>
                                <p class="mb-0">Comienza agregando clientes con fechas de evento.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="eventosTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Contacto</th>
                                            <th>Tipo Evento</th>
                                            <th>Días Restantes</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($eventos as $evento): 
                                            $fecha_evento = new DateTime($evento['fecha_evento']);
                                            $hoy = new DateTime();
                                            $diferencia = $hoy->diff($fecha_evento);
                                            $dias_restantes = $diferencia->days;
                                            
                                            if ($fecha_evento < $hoy) {
                                                $estado = 'Completado';
                                                $badge = 'bg-success';
                                                $icon = 'bi-check-circle';
                                            } elseif ($fecha_evento->format('Y-m-d') == $hoy->format('Y-m-d')) {
                                                $estado = 'Hoy';
                                                $badge = 'bg-warning';
                                                $icon = 'bi-exclamation-circle';
                                                $dias_restantes = 0;
                                            } elseif ($dias_restantes <= 7) {
                                                $estado = 'Próximo';
                                                $badge = 'bg-danger';
                                                $icon = 'bi-clock';
                                            } else {
                                                $estado = 'Programado';
                                                $badge = 'bg-primary';
                                                $icon = 'bi-calendar';
                                            }
                                            
                                            $badge_class = 'badge-' . $evento['tipo_boda'];
                                            $tipo_text = formatearTipoEvento($evento['tipo_boda']);
                                        ?>
                                            <tr data-estado="<?php echo strtolower($estado); ?>" 
                                                data-fecha="<?php echo $evento['fecha_evento']; ?>">
                                                <td>
                                                    <strong><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo date('l', strtotime($evento['fecha_evento'])); ?></small>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($evento['nombre']); ?></strong>
                                                    <?php if ($evento['mensaje']): ?>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="bi bi-chat-left-text"></i> 
                                                            <?php echo substr(htmlspecialchars($evento['mensaje']), 0, 50); ?>...
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div><i class="bi bi-envelope"></i> <?php echo $evento['correo']; ?></div>
                                                    <div><i class="bi bi-telephone"></i> <?php echo $evento['telefono']; ?></div>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo $tipo_text; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($estado == 'Completado'): ?>
                                                        <span class="text-muted">Finalizado</span>
                                                    <?php elseif ($estado == 'Hoy'): ?>
                                                        <span class="text-warning fw-bold">¡HOY!</span>
                                                    <?php else: ?>
                                                        <span class="fw-bold"><?php echo $dias_restantes; ?></span> días
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo $badge; ?>">
                                                        <i class="bi <?php echo $icon; ?>"></i> <?php echo $estado; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <!-- Botón Ver -->
                                                        <button class="btn btn-info" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalCliente<?php echo $evento['id']; ?>"
                                                                title="Ver detalles">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        
                                                        <!-- Botón Correo -->
                                                        <a href="mailto:<?php echo $evento['correo']; ?>" 
                                                           class="btn btn-primary" title="Enviar email">
                                                            <i class="bi bi-envelope"></i>
                                                        </a>
                                                        
                                                        <!-- Botón Llamar -->
                                                        <a href="tel:<?php echo $evento['telefono']; ?>" 
                                                           class="btn btn-success" title="Llamar">
                                                            <i class="bi bi-telephone"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> 
                                    <strong>Leyenda:</strong> 
                                    <span class="badge bg-danger">Próximo (≤ 7 días)</span> 
                                    <span class="badge bg-warning">Hoy</span> 
                                    <span class="badge bg-primary">Programado</span> 
                                    <span class="badge bg-success">Completado</span>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                
                <?php elseif ($tab == 'reportes'): ?>
                    <!-- CONTENIDO DE REPORTES -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="stat-card animate-fade-in">
                                <div class="text-center">
                                    <i class="bi bi-pie-chart stat-icon"></i>
                                    <div class="stat-number"><?php echo count($reportes_stats); ?></div>
                                    <div class="stat-label">Tipos de Eventos</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card animate-fade-in">
                                <div class="text-center">
                                    <i class="bi bi-calendar-month stat-icon"></i>
                                    <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                                    <div class="stat-label">Total Clientes</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card animate-fade-in">
                                <div class="text-center">
                                    <i class="bi bi-graph-up stat-icon"></i>
                                    <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                                    <div class="stat-label">Variedad Eventos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Gráfico de tipos de eventos -->
                        <div class="col-lg-12">
                            <div class="table-container animate-fade-in">
                                <h5><i class="bi bi-pie-chart"></i> Distribución por Tipo de Evento</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>Tipo de Evento</th>
                                                <th>Cantidad</th>
                                                <th>Porcentaje</th>
                                                <th>Gráfico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total_clientes = $conn->query("SELECT COUNT(*) as total FROM clientes")->fetch(PDO::FETCH_ASSOC);
                                            $total = $total_clientes['total'] ?? 1;
                                            
                                            foreach ($reportes_stats as $reporte): 
                                                $porcentaje = ($reporte['cantidad'] / $total) * 100;
                                                $tipo_text = formatearTipoEvento($reporte['tipo_boda']);
                                                $badge_class = 'badge-' . $reporte['tipo_boda'];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge <?php echo $badge_class; ?>">
                                                            <?php echo $tipo_text; ?>
                                                        </span>
                                                    </td>
                                                    <td><strong><?php echo $reporte['cantidad']; ?></strong></td>
                                                    <td><?php echo number_format($porcentaje, 1); ?>%</td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar" 
                                                                 role="progressbar" 
                                                                 style="width: <?php echo $porcentaje; ?>%; background-color: var(--admin-accent);"
                                                                 aria-valuenow="<?php echo $porcentaje; ?>" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                                <?php echo number_format($porcentaje, 1); ?>%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resumen rápido -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="table-container animate-fade-in">
                                <h5><i class="bi bi-calendar-check"></i> Próximos Eventos</h5>
                                <?php 
                                $proximos_eventos = $conn->query("SELECT * FROM clientes WHERE fecha_evento >= CURDATE() ORDER BY fecha_evento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <div class="list-group">
                                    <?php foreach ($proximos_eventos as $evento): 
                                        $tipo_text = formatearTipoEvento($evento['tipo_boda']);
                                        $badge_class = 'badge-' . $evento['tipo_boda'];
                                    ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($evento['nombre']); ?></h6>
                                                <small><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></small>
                                            </div>
                                            <small class="text-muted">
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo $tipo_text; ?>
                                                </span>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="table-container animate-fade-in">
                                <h5><i class="bi bi-people"></i> Últimos Registros</h5>
                                <?php 
                                $ultimos_clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <div class="list-group">
                                    <?php foreach ($ultimos_clientes as $cliente): 
                                        $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
                                        $badge_class = 'badge-' . $cliente['tipo_boda'];
                                    ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($cliente['nombre']); ?></h6>
                                                <small><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></small>
                                            </div>
                                            <small class="text-muted">
                                                <?php echo $cliente['correo']; ?> | 
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo $tipo_text; ?>
                                                </span>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="mt-4 text-center text-muted">
                    <small>
                        <i class="bi bi-c-circle"></i> <?php echo date('Y'); ?> Wedding Connect 
                        | Panel Administrativo v1.0
                        | <span id="currentDateTime"></span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo cliente -->
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus"></i> Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="guardar_cliente" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" name="nombre" required 
                                       placeholder="Ej: María García">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="correo" required 
                                       placeholder="maria@email.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="telefono" required 
                                       placeholder="555-123-4567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Evento *</label>
                                <select class="form-select" name="tipo_evento" required>
                                    <option value="">Seleccionar...</option>
                                    <!-- Bodas -->
                                    <optgroup label="🎭 Bodas">
                                        <option value="boda_civil">Boda Civil</option>
                                        <option value="boda_religiosa">Boda Religiosa</option>
                                        <option value="boda_destino">Boda Destino</option>
                                        <option value="boda_intima">Boda Íntima</option>
                                        <option value="boda_lujo">Boda de Lujo</option>
                                        <option value="boda_tematica">Boda Temática</option>
                                        <option value="boda_playa">Boda en Playa</option>
                                        <option value="boda_campo">Boda en Campo</option>
                                        <option value="boda_urbana">Boda Urbana</option>
                                        <option value="boda_vintage">Boda Vintage</option>
                                    </optgroup>
                                    <!-- XV Años -->
                                    <optgroup label="👸 XV Años">
                                        <option value="xv_anos">XV Años Tradicional</option>
                                        <option value="xv_anos_tematica">XV Años Temático</option>
                                        <option value="xv_anos_lujo">XV Años de Lujo</option>
                                        <option value="xv_anos_intima">XV Años Íntimo</option>
                                    </optgroup>
                                    <!-- Baby Shower -->
                                    <optgroup label="🎀 Baby Shower">
                                        <option value="baby_shower">Baby Shower</option>
                                        <option value="baby_shower_gender_reveal">Baby Shower (Gender Reveal)</option>
                                        <option value="baby_shower_tematica">Baby Shower Temático</option>
                                    </optgroup>
                                    <!-- Eventos Empresariales -->
                                    <optgroup label="🏢 Eventos Empresariales">
                                        <option value="evento_empresarial">Evento Empresarial</option>
                                        <option value="convencion">Convención</option>
                                        <option value="lanzamiento_producto">Lanzamiento de Producto</option>
                                        <option value="conferencia">Conferencia</option>
                                        <option value="seminario">Seminario</option>
                                        <option value="team_building">Team Building</option>
                                        <option value="fiesta_navidad_empresa">Fiesta de Navidad Empresarial</option>
                                    </optgroup>
                                    <!-- Eventos Municipales -->
                                    <optgroup label="🏛️ Eventos Municipales">
                                        <option value="evento_municipal">Evento Municipal</option>
                                        <option value="feria_local">Feria Local</option>
                                        <option value="festival_cultural">Festival Cultural</option>
                                        <option value="concierto_publico">Concierto Público</option>
                                        <option value="celebracion_aniversario_ciudad">Celebración Aniversario Ciudad</option>
                                        <option value="evento_deportivo_municipal">Evento Deportivo Municipal</option>
                                    </optgroup>
                                    <!-- Eventos del Año -->
                                    <optgroup label="📅 Eventos del Año">
                                        <option value="cumpleanos">Cumpleaños</option>
                                        <option value="aniversario">Aniversario</option>
                                        <option value="graduacion">Graduación</option>
                                        <option value="bautizo">Bautizo</option>
                                        <option value="primera_comunion">Primera Comunión</option>
                                        <option value="despedida_soltero">Despedida de Soltero/a</option>
                                        <option value="fiesta_compromiso">Fiesta de Compromiso</option>
                                        <option value="renovacion_votos">Renovación de Votos</option>
                                        <option value="fiesta_halloween">Fiesta de Halloween</option>
                                        <option value="fiesta_navidad">Fiesta de Navidad</option>
                                        <option value="fiesta_ano_nuevo">Fiesta de Año Nuevo</option>
                                        <option value="fiesta_pascua">Fiesta de Pascua</option>
                                    </optgroup>
                                    <!-- Otros -->
                                    <optgroup label="🎪 Otros Eventos">
                                        <option value="evento_religioso">Evento Religioso</option>
                                        <option value="evento_benefico">Evento Benéfico</option>
                                        <option value="evento_gala">Evento de Gala</option>
                                        <option value="evento_privado">Evento Privado</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha del Evento *</label>
                                <input type="date" class="form-control" name="fecha_evento" required
                                       min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mensaje o Notas</label>
                                <textarea class="form-control" name="mensaje" rows="3" 
                                          placeholder="Detalles adicionales..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarCliente">
                            <i class="bi bi-save"></i> Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR CLIENTE (NUEVO) -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Editar Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnCancelarEditar"></button>
                </div>
                <form method="POST" action="" id="formEditarCliente">
                    <input type="hidden" name="actualizar_cliente" value="1">
                    <input type="hidden" id="editar_cliente_id" name="cliente_id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="editar_correo" name="correo" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" id="editar_telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Evento *</label>
                                <select class="form-select" id="editar_tipo_evento" name="tipo_evento" required>
                                    <option value="">Seleccionar...</option>
                                    <!-- Bodas -->
                                    <optgroup label="🎭 Bodas">
                                        <option value="boda_civil">Boda Civil</option>
                                        <option value="boda_religiosa">Boda Religiosa</option>
                                        <option value="boda_destino">Boda Destino</option>
                                        <option value="boda_intima">Boda Íntima</option>
                                        <option value="boda_lujo">Boda de Lujo</option>
                                        <option value="boda_tematica">Boda Temática</option>
                                        <option value="boda_playa">Boda en Playa</option>
                                        <option value="boda_campo">Boda en Campo</option>
                                        <option value="boda_urbana">Boda Urbana</option>
                                        <option value="boda_vintage">Boda Vintage</option>
                                    </optgroup>
                                    <!-- XV Años -->
                                    <optgroup label="👸 XV Años">
                                        <option value="xv_anos">XV Años Tradicional</option>
                                        <option value="xv_anos_tematica">XV Años Temático</option>
                                        <option value="xv_anos_lujo">XV Años de Lujo</option>
                                        <option value="xv_anos_intima">XV Años Íntimo</option>
                                    </optgroup>
                                    <!-- Baby Shower -->
                                    <optgroup label="🎀 Baby Shower">
                                        <option value="baby_shower">Baby Shower</option>
                                        <option value="baby_shower_gender_reveal">Baby Shower (Gender Reveal)</option>
                                        <option value="baby_shower_tematica">Baby Shower Temático</option>
                                    </optgroup>
                                    <!-- Eventos Empresariales -->
                                    <optgroup label="🏢 Eventos Empresariales">
                                        <option value="evento_empresarial">Evento Empresarial</option>
                                        <option value="convencion">Convención</option>
                                        <option value="lanzamiento_producto">Lanzamiento de Producto</option>
                                        <option value="conferencia">Conferencia</option>
                                        <option value="seminario">Seminario</option>
                                        <option value="team_building">Team Building</option>
                                        <option value="fiesta_navidad_empresa">Fiesta de Navidad Empresarial</option>
                                    </optgroup>
                                    <!-- Eventos Municipales -->
                                    <optgroup label="🏛️ Eventos Municipales">
                                        <option value="evento_municipal">Evento Municipal</option>
                                        <option value="feria_local">Feria Local</option>
                                        <option value="festival_cultural">Festival Cultural</option>
                                        <option value="concierto_publico">Concierto Público</option>
                                        <option value="celebracion_aniversario_ciudad">Celebración Aniversario Ciudad</option>
                                        <option value="evento_deportivo_municipal">Evento Deportivo Municipal</option>
                                    </optgroup>
                                    <!-- Eventos del Año -->
                                    <optgroup label="📅 Eventos del Año">
                                        <option value="cumpleanos">Cumpleaños</option>
                                        <option value="aniversario">Aniversario</option>
                                        <option value="graduacion">Graduación</option>
                                        <option value="bautizo">Bautizo</option>
                                        <option value="primera_comunion">Primera Comunión</option>
                                        <option value="despedida_soltero">Despedida de Soltero/a</option>
                                        <option value="fiesta_compromiso">Fiesta de Compromiso</option>
                                        <option value="renovacion_votos">Renovación de Votos</option>
                                        <option value="fiesta_halloween">Fiesta de Halloween</option>
                                        <option value="fiesta_navidad">Fiesta de Navidad</option>
                                        <option value="fiesta_ano_nuevo">Fiesta de Año Nuevo</option>
                                        <option value="fiesta_pascua">Fiesta de Pascua</option>
                                    </optgroup>
                                    <!-- Otros -->
                                    <optgroup label="🎪 Otros Eventos">
                                        <option value="evento_religioso">Evento Religioso</option>
                                        <option value="evento_benefico">Evento Benéfico</option>
                                        <option value="evento_gala">Evento de Gala</option>
                                        <option value="evento_privado">Evento Privado</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha del Evento *</label>
                                <input type="date" class="form-control" id="editar_fecha_evento" name="fecha_evento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mensaje o Notas</label>
                                <textarea class="form-control" id="editar_mensaje" name="mensaje" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnActualizarCliente">
                            <i class="bi bi-save"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODALES PARA VER DETALLES DE CLIENTES (DISPONIBLES EN TODAS LAS PESTAÑAS) -->
    <?php foreach ($todos_clientes as $cliente): 
        $badge_class = 'badge-' . $cliente['tipo_boda'];
        $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
    ?>
    <div class="modal fade" id="modalCliente<?php echo $cliente['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-badge"></i> 
                        <?php echo htmlspecialchars($cliente['nombre']); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p><?php echo $cliente['correo']; ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Teléfono</label>
                                <p><?php echo $cliente['telefono']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Tipo de Evento</label>
                                <p>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo $tipo_text; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Fecha del Evento</label>
                                <p><?php echo date('d/m/Y', strtotime($cliente['fecha_evento'])); ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Registrado el</label>
                                <p><?php echo date('d/m/Y H:i', strtotime($cliente['fecha_registro'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if ($cliente['mensaje']): ?>
                        <div class="mt-3 border-top pt-3">
                            <h6><i class="bi bi-chat-left-text"></i> Mensaje</h6>
                            <div class="alert alert-light">
                                <?php echo nl2br(htmlspecialchars($cliente['mensaje'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <!-- SE QUITÓ EL BOTÓN EDITAR DE AQUÍ -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="mailto:<?php echo $cliente['correo']; ?>" class="btn btn-primary">
                        <i class="bi bi-envelope"></i> Contactar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/panel.js"></script>
    <script>
    // Script para manejar el botón de editar
    $(document).ready(function() {
        // Cuando se hace clic en el botón editar
        $('.btn-editar').on('click', function(e) {
            e.preventDefault();
            var clienteId = $(this).data('id');
            cargarClienteParaEditar(clienteId);
        });
        
        // Función para cargar datos del cliente en el modal de edición
        function cargarClienteParaEditar(clienteId) {
            // Mostrar mensaje de carga
            showToast('⏳ Cargando datos del cliente...', 'info');
            
            // Obtener datos del cliente desde la base de datos
            $.ajax({
                url: 'obtener_cliente.php',
                type: 'GET',
                data: {id: clienteId},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Llenar el formulario con los datos
                        $('#editar_cliente_id').val(response.cliente.id);
                        $('#editar_nombre').val(response.cliente.nombre);
                        $('#editar_correo').val(response.cliente.correo);
                        $('#editar_telefono').val(response.cliente.telefono);
                        $('#editar_tipo_evento').val(response.cliente.tipo_boda);
                        $('#editar_fecha_evento').val(response.cliente.fecha_evento);
                        $('#editar_mensaje').val(response.cliente.mensaje || '');
                        
                        // Cerrar cualquier modal abierto
                        $('.modal').modal('hide');
                        
                        // Limpiar cualquier backdrop residual
                        $('.modal-backdrop').remove();
                        
                        // Mostrar el modal de edición después de un breve retraso
                        setTimeout(() => {
                            var modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                            modal.show();
                            showToast('✅ Datos cargados correctamente', 'success');
                        }, 300);
                    } else {
                        showToast('❌ Error al cargar los datos: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    showToast('❌ Error de conexión al cargar los datos', 'error');
                }
            });
        }
        
        // Fix para el botón cancelar del modal de editar
        $('#btnCancelarEditar').on('click', function() {
            // Cerrar el modal correctamente
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
            if (modal) {
                modal.hide();
            }
            
            // Limpiar el backdrop residual
            setTimeout(() => {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('overflow', '');
                $('body').css('padding-right', '');
            }, 300);
        });
        
        // También para el botón cancelar en el footer
        $('#modalEditarCliente .btn-secondary').on('click', function() {
            $('#btnCancelarEditar').click();
        });
        
        // Función para mostrar notificaciones
        function showToast(message, type = 'info') {
            const types = {
                'success': {bg: '#28a745', icon: '✅'},
                'error': {bg: '#dc3545', icon: '❌'},
                'warning': {bg: '#ffc107', icon: '⚠️'},
                'info': {bg: '#17a2b8', icon: 'ℹ️'}
            };
            
            const config = types[type] || types.info;
            
            $('.toast-notification').remove();
            
            const toast = $(`
                <div class="toast-notification" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    border-left: 4px solid ${config.bg};
                    padding: 15px 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    z-index: 99999;
                    max-width: 350px;
                    display: flex;
                    align-items: center;
                    animation: slideIn 0.3s ease;
                ">
                    <span style="font-size: 20px; margin-right: 10px;">${config.icon}</span>
                    <span style="font-size: 14px;">${message}</span>
                </div>
            `);
            
            $('body').append(toast);
            
            setTimeout(() => {
                toast.fadeOut(300, () => toast.remove());
            }, 4000);
        }
    });
    </script>
</body>
</html>