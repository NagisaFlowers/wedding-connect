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

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id_eliminar]);
    $mensaje = "Cliente eliminado correctamente";
}

$stats = $conn->query("SELECT 
    COUNT(*) as total_clientes,
    COUNT(DISTINCT tipo_boda) as tipos_boda,
    MIN(fecha_evento) as proxima_boda,
    MAX(fecha_evento) as ultima_boda
    FROM clientes")->fetch(PDO::FETCH_ASSOC);

$clientes = $conn->query("SELECT * FROM clientes ORDER BY fecha_registro DESC")->fetchAll(PDO::FETCH_ASSOC);

$busqueda = '';
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    $stmt = $conn->prepare("SELECT * FROM clientes 
        WHERE nombre LIKE ? OR correo LIKE ? OR telefono LIKE ? 
        ORDER BY fecha_registro DESC");
    $searchTerm = "%$busqueda%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Wedding Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/panel.css">
</head>
<body class="admin-body">
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-admin fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="panel.php">
                <i class="bi bi-shield-lock"></i> Wedding Connect <span class="badge bg-light text-dark">Admin</span>
            </a>
            
            <div class="d-flex align-items-center">
                <div class="welcome-text me-3 d-none d-md-block">
                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['admin_nombre']; ?>
                </div>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="admin-sidebar">
                    <div class="list-group">
                        <a href="panel.php" class="list-group-item list-group-item-action active">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a href="panel.php?tab=clientes" class="list-group-item list-group-item-action">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-calendar-event"></i> Eventos
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-bar-chart"></i> Reportes
                        </a>
                        <a href="index.php" class="list-group-item list-group-item-action" target="_blank">
                            <i class="bi bi-eye"></i> Ver Sitio Web
                        </a>
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
            
            <div class="col-lg-10">
                <?php if (isset($mensaje)): ?>
                    <div class="alert alert-panel-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
                    <div>
                        <h1 class="h3 text-dark mb-1">
                            <i class="bi bi-speedometer2"></i> Panel de Administración
                        </h1>
                        <p class="text-muted mb-0">
                            <small>Gestión completa de clientes y eventos</small>
                        </p>
                    </div>
                    <div class="search-box">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                       name="buscar" placeholder="Buscar cliente..." 
                                       value="<?php echo htmlspecialchars($busqueda); ?>"
                                       id="searchInput">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                <?php if ($busqueda): ?>
                                    <a href="panel.php" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
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
                                <div class="stat-number"><?php echo $stats['tipos_boda'] ?? 0; ?></div>
                                <div class="stat-label">Tipos de Bodas</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
                            <div class="text-center">
                                <i class="bi bi-calendar-check stat-icon"></i>
                                <div class="stat-number">
                                    <?php 
                                    if ($stats['proxima_boda']) {
                                        echo date('d-m', strtotime($stats['proxima_boda']));
                                    } else {
                                        echo '--';
                                    }
                                    ?>
                                </div>
                                <div class="stat-label">Próxima Boda</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card animate-fade-in" style="animation-delay: 0.4s">
                            <div class="text-center">
                                <i class="bi bi-calendar-date stat-icon"></i>
                                <div class="stat-number">
                                    <?php 
                                    if ($stats['ultima_boda']) {
                                        echo date('d-m-Y', strtotime($stats['ultima_boda']));
                                    } else {
                                        echo '--';
                                    }
                                    ?>
                                </div>
                                <div class="stat-label">Última Boda</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-container animate-fade-in" style="animation-delay: 0.5s">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">
                                <i class="bi bi-table"></i> Lista de Clientes
                            </h4>
                            <small class="text-muted">Registros totales: <?php echo count($clientes); ?></small>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                                <i class="bi bi-person-plus"></i> Nuevo
                            </button>
                            <button class="btn btn-secondary btn-sm" id="exportExcel">
                                <i class="bi bi-download"></i> Exportar
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
                            <table class="table table-hover" id="clientesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Tipo Boda</th>
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
                                                $tipo_text = ucfirst($cliente['tipo_boda']);
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <i class="bi bi-heart"></i> <?php echo $tipo_text; ?>
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
                                                <div class="btn-group">
                                                    <button class="btn btn-info btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalCliente<?php echo $cliente['id']; ?>"
                                                            title="Ver detalles">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <a href="mailto:<?php echo $cliente['correo']; ?>" 
                                                       class="btn btn-warning btn-sm" title="Enviar email">
                                                        <i class="bi bi-envelope"></i>
                                                    </a>
                                                    <a href="panel.php?eliminar=<?php echo $cliente['id']; ?>" 
                                                       class="btn btn-danger btn-sm btn-eliminar"
                                                       title="Eliminar"
                                                       onclick="return confirm('¿Eliminar a <?php echo addslashes($cliente['nombre']); ?>?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                                
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
                                                                            <label class="form-label text-muted">Tipo de Boda</label>
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
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <a href="mailto:<?php echo $cliente['correo']; ?>" class="btn btn-primary">
                                                                    <i class="bi bi-envelope"></i> Contactar
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-4 pt-3 border-top">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history"></i> 
                                    <strong>Última actualización:</strong> <?php echo date('H:i:s'); ?>
                                </small>
                            </div>
                            <div class="col-md-4 text-center">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check"></i> Sesión activa
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">
                                    <i class="bi bi-person-circle"></i> 
                                    <?php echo $_SESSION['admin_nombre']; ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-center text-muted">
                    <small>
                        <i class="bi bi-c-circle"></i> <?php echo date('Y'); ?> Wedding Connect 
                        | Panel Administrativo v2.0
                        | <span id="currentDateTime"></span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/panel.js"></script>
</body>
</html>