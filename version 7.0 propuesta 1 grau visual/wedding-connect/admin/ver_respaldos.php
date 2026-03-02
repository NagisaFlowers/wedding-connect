<?php
// admin/ver_respaldos.php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';

$db = getDB();

// Obtener lista de respaldos
$respaldos = $db->query("SELECT r.*, a.nombre_completo, a.username 
                         FROM respaldos r 
                         JOIN administradores a ON r.admin_id = a.id 
                         ORDER BY r.fecha_respaldo DESC 
                         LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);

// Estadísticas
$stats = $db->query("SELECT 
                        COUNT(*) as total,
                        SUM(tamano) as total_size,
                        MAX(fecha_respaldo) as ultimo,
                        COUNT(DISTINCT DATE(fecha_respaldo)) as dias_con_respaldo
                     FROM respaldos")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Respaldos - Wedding Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/panel-nuevo.css">
    <style>
        .size-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), #3498db);
            border-radius: 2px;
            margin-top: 5px;
        }
        .card-respaldo {
            transition: all 0.3s ease;
            border-left: 4px solid var(--color-primary);
        }
        .card-respaldo:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
    </style>
</head>
<body class="admin-body-nuevo">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card-nuevo">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1><i class="bi bi-database-check me-2"></i> Historial de Respaldos</h1>
                            <p class="text-muted mb-0">Últimos 50 respaldos realizados</p>
                        </div>
                        <a href="admin.php?tab=dashboard" class="btn btn-outline-nuevo">
                            <i class="bi bi-arrow-left"></i> Volver al Panel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card-nuevo">
                    <div class="stat-icon-nuevo"><i class="bi bi-database"></i></div>
                    <div class="stat-number-nuevo"><?php echo $stats['total'] ?? 0; ?></div>
                    <div class="stat-label-nuevo">Total Respaldos</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-nuevo">
                    <div class="stat-icon-nuevo"><i class="bi bi-hdd-stack"></i></div>
                    <div class="stat-number-nuevo"><?php echo round(($stats['total_size'] ?? 0) / 1024, 2); ?> KB</div>
                    <div class="stat-label-nuevo">Espacio Total</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-nuevo">
                    <div class="stat-icon-nuevo"><i class="bi bi-calendar-check"></i></div>
                    <div class="stat-number-nuevo"><?php echo $stats['dias_con_respaldo'] ?? 0; ?></div>
                    <div class="stat-label-nuevo">Días con Respaldo</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-nuevo">
                    <div class="stat-icon-nuevo"><i class="bi bi-clock-history"></i></div>
                    <div class="stat-number-nuevo"><?php echo $stats['ultimo'] ? date('d/m', strtotime($stats['ultimo'])) : 'N/A'; ?></div>
                    <div class="stat-label-nuevo">Último Respaldo</div>
                </div>
            </div>
        </div>
        
        <!-- Lista de respaldos -->
        <div class="table-container-nuevo">
            <div class="table-header-nuevo">
                <h4><i class="bi bi-list-ul me-2"></i> Registro de Respaldos</h4>
            </div>
            
            <?php if (empty($respaldos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-database-x display-1 d-block mb-3" style="color: var(--color-primary);"></i>
                    <h5>No hay respaldos registrados aún</h5>
                    <p class="text-muted">Los respaldos se registrarán automáticamente cuando uses la función de respaldo</p>
                    <a href="admin.php?tab=dashboard" class="btn btn-primary-nuevo mt-3">
                        <i class="bi bi-database"></i> Ir a Respaldar
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Archivo</th>
                                <th>Tamaño</th>
                                <th>Administrador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($respaldos as $respaldo): 
                                $tamano_kb = round($respaldo['tamano'] / 1024, 2);
                                $porcentaje_max = min(100, ($respaldo['tamano'] / 50000) * 100); // Asumiendo 50KB como máximo para la barra
                            ?>
                                <tr>
                                    <td><span class="badge badge-primary-nuevo">#<?php echo $respaldo['id']; ?></span></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($respaldo['fecha_respaldo'])); ?></td>
                                    <td>
                                        <i class="bi bi-file-earmark-sql me-2" style="color: var(--color-primary);"></i>
                                        <?php echo $respaldo['nombre_archivo']; ?>
                                        <div class="size-bar" style="width: <?php echo $porcentaje_max; ?>%;"></div>
                                    </td>
                                    <td><?php echo $tamano_kb; ?> KB</td>
                                    <td>
                                        <i class="bi bi-person-circle me-1"></i>
                                        <?php echo $respaldo['nombre_completo'] ?? $respaldo['username']; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-nuevo" onclick="alert('El archivo ya no está disponible en el servidor. Solo se guarda el registro.')">
                                            <i class="bi bi-info-circle"></i> Detalles
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Nota informativa -->
                <div class="alert alert-info mt-3" style="background: rgba(52, 152, 219, 0.1); border-left: 4px solid #3498db;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Nota:</strong> Solo se guarda el registro del respaldo, no el archivo en sí. 
                    Los archivos se descargan directamente a tu computadora.
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>