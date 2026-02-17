<?php
// admin/views/reportes.php - Vista de reportes NORMALIZADA
?>

<!-- CONTENIDO DE REPORTES -->
<div class="row g-4 mb-4">
    <!-- Tarjeta de Tipos de Eventos -->
    <div class="col-md-4">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-pie-chart stat-icon" style="color: var(--wedding-gold);"></i>
                <div class="stat-number"><?php echo count($datos['reportes_stats']); ?></div>
                <div class="stat-label">Tipos de Eventos</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-heart-fill text-danger"></i> Variedad
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Total Clientes -->
    <div class="col-md-4">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-people-fill stat-icon" style="color: var(--wedding-burgundy);"></i>
                <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                <div class="stat-label">Total Clientes</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-person-heart text-primary"></i> Registrados
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Variedad Eventos -->
    <div class="col-md-4">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-graph-up-arrow stat-icon" style="color: #28a745;"></i>
                <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                <div class="stat-label">Variedad Eventos</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-stars text-warning"></i> Diversidad
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Gráfico de tipos de eventos -->
    <div class="col-lg-12">
        <div class="table-container animate-fade-in">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                    <i class="bi bi-pie-chart-fill"></i> Distribución por Tipo de Evento
                </h5>
                <div class="btn-group">
                    <button class="btn btn-outline-wedding btn-sm" onclick="exportReportToExcel()">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                    <button class="btn btn-outline-wedding btn-sm" onclick="printReport()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="reportesTable">
                    <thead style="background: linear-gradient(135deg, var(--wedding-ivory) 0%, #f5f0e6 100%);">
                        <tr>
                            <th style="color: var(--wedding-burgundy);">
                                <i class="bi bi-heart"></i> Tipo de Evento
                            </th>
                            <th style="color: var(--wedding-burgundy);">
                                <i class="bi bi-hash"></i> Cantidad
                            </th>
                            <th style="color: var(--wedding-burgundy);">
                                <i class="bi bi-percent"></i> Porcentaje
                            </th>
                            <th style="color: var(--wedding-burgundy);">
                                <i class="bi bi-bar-chart"></i> Gráfico
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        require_once __DIR__ . '/../../config/database.php';
                        $db = getDB();
                        $total_clientes = $db->query("SELECT COUNT(*) as total FROM clientes")->fetch(PDO::FETCH_ASSOC);
                        $total = $total_clientes['total'] ?? 1;
                        $colors = ['#d4af37', '#e8b4b8', '#8a9a5b', '#800020', '#6f42c1', '#0dcaf0'];
                        $color_index = 0;
                        
                        foreach ($datos['reportes_stats'] as $reporte): 
                            $porcentaje = ($reporte['cantidad'] / $total) * 100;
                            $tipo_text = $reporte['nombre'];
                            
                            // Determinar color según tipo
                            $tipo_color = '#6c757d'; // Color por defecto
                            if (stripos($tipo_text, 'civil') !== false) {
                                $tipo_color = '#ffc107';
                            } elseif (stripos($tipo_text, 'religiosa') !== false) {
                                $tipo_color = '#198754';
                            } elseif (stripos($tipo_text, 'playa') !== false) {
                                $tipo_color = '#0dcaf0';
                            } elseif (stripos($tipo_text, 'lujo') !== false) {
                                $tipo_color = '#fd7e14';
                            } else {
                                $tipo_color = $colors[$color_index % count($colors)];
                                $color_index++;
                            }
                        ?>
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: <?php echo $tipo_color; ?>; color: white;">
                                        <i class="bi bi-heart-fill"></i> <?php echo $tipo_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <strong style="font-size: 1.2rem; color: var(--wedding-burgundy);">
                                        <?php echo $reporte['cantidad']; ?>
                                    </strong>
                                </td>
                                <td>
                                    <span style="font-size: 1.2rem; color: var(--wedding-gold); font-weight: bold;">
                                        <?php echo number_format($porcentaje, 1); ?>%
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-3" style="height: 20px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: <?php echo $porcentaje; ?>%; background-color: <?php echo $tipo_color; ?>;"
                                                 aria-valuenow="<?php echo $porcentaje; ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo number_format($porcentaje, 1); ?>%</small>
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
<div class="row mt-4 g-4">
    <!-- Próximos Eventos -->
    <div class="col-md-6">
        <div class="table-container animate-fade-in">
            <h5 style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                <i class="bi bi-calendar-heart"></i> Próximos Eventos
            </h5>
            <div class="list-group" id="proximosEventos">
                <?php 
                $proximos_eventos = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                                FROM clientes c 
                                                JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                                WHERE c.fecha_evento >= CURDATE() 
                                                ORDER BY c.fecha_evento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                if (empty($proximos_eventos)): ?>
                    <div class="list-group-item text-center py-4" style="background: rgba(212, 175, 55, 0.05);">
                        <i class="bi bi-calendar-x display-6 d-block mb-2" style="color: var(--wedding-rose);"></i>
                        <p class="mb-0 text-muted">No hay eventos próximos</p>
                    </div>
                <?php else: 
                    foreach ($proximos_eventos as $evento): 
                        $tipo_text = $evento['tipo_nombre'];
                        
                        // Determinar color según tipo
                        $tipo_color = '#6c757d';
                        if (stripos($tipo_text, 'civil') !== false) {
                            $tipo_color = '#ffc107';
                        } elseif (stripos($tipo_text, 'religiosa') !== false) {
                            $tipo_color = '#198754';
                        } elseif (stripos($tipo_text, 'playa') !== false) {
                            $tipo_color = '#0dcaf0';
                        } elseif (stripos($tipo_text, 'lujo') !== false) {
                            $tipo_color = '#fd7e14';
                        }
                        
                        $fecha_evento = new DateTime($evento['fecha_evento']);
                        $hoy = new DateTime();
                        $diferencia = $hoy->diff($fecha_evento);
                        $dias_restantes = $diferencia->days;
                        
                        if ($fecha_evento->format('Y-m-d') == $hoy->format('Y-m-d')) {
                            $badge_class = 'bg-warning';
                            $texto_dias = '¡Hoy!';
                        } elseif ($dias_restantes <= 7) {
                            $badge_class = 'bg-danger';
                            $texto_dias = $dias_restantes . ' días';
                        } else {
                            $badge_class = 'bg-primary';
                            $texto_dias = $dias_restantes . ' días';
                        }
                ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="event-avatar me-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--wedding-rose) 0%, #f5d0d4 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-heart-fill" style="color: var(--wedding-burgundy);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--wedding-burgundy);"><?php echo htmlspecialchars($evento['nombre']); ?></h6>
                                    <small class="text-muted">
                                        <span class="badge" style="background-color: <?php echo $tipo_color; ?>; color: white;">
                                            <?php echo $tipo_text; ?>
                                        </span>
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div style="color: var(--wedding-burgundy); font-weight: bold;"><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></div>
                                <small class="badge <?php echo $badge_class; ?>"><?php echo $texto_dias; ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Últimos Registros -->
    <div class="col-md-6">
        <div class="table-container animate-fade-in">
            <h5 style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                <i class="bi bi-people-fill"></i> Últimos Registros
            </h5>
            <div class="list-group" id="ultimosRegistros">
                <?php 
                $ultimos_clientes = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                                FROM clientes c 
                                                JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                                ORDER BY c.id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                if (empty($ultimos_clientes)): ?>
                    <div class="list-group-item text-center py-4" style="background: rgba(212, 175, 55, 0.05);">
                        <i class="bi bi-person-x display-6 d-block mb-2" style="color: var(--wedding-rose);"></i>
                        <p class="mb-0 text-muted">No hay clientes registrados</p>
                    </div>
                <?php else: 
                    foreach ($ultimos_clientes as $cliente): 
                        $tipo_text = $cliente['tipo_nombre'];
                        
                        // Determinar color según tipo
                        $tipo_color = '#6c757d';
                        if (stripos($tipo_text, 'civil') !== false) {
                            $tipo_color = '#ffc107';
                        } elseif (stripos($tipo_text, 'religiosa') !== false) {
                            $tipo_color = '#198754';
                        } elseif (stripos($tipo_text, 'playa') !== false) {
                            $tipo_color = '#0dcaf0';
                        } elseif (stripos($tipo_text, 'lujo') !== false) {
                            $tipo_color = '#fd7e14';
                        }
                        
                        $dias_registro = floor((time() - strtotime($cliente['fecha_registro'])) / (60 * 60 * 24));
                        
                        if ($dias_registro == 0) {
                            $tiempo_text = 'Hoy';
                            $badge_class = 'bg-success';
                        } elseif ($dias_registro == 1) {
                            $tiempo_text = 'Ayer';
                            $badge_class = 'bg-info';
                        } else {
                            $tiempo_text = 'Hace ' . $dias_registro . ' días';
                            $badge_class = 'bg-secondary';
                        }
                ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="client-avatar me-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--wedding-gold) 0%, #e6c158 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-fill" style="color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--wedding-burgundy);"><?php echo htmlspecialchars($cliente['nombre']); ?></h6>
                                    <small class="text-muted">
                                        <i class="bi bi-envelope"></i> <?php echo $cliente['correo']; ?>
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="mb-1">
                                    <span class="badge" style="background-color: <?php echo $tipo_color; ?>; color: white;">
                                        <?php echo $tipo_text; ?>
                                    </span>
                                </div>
                                <small class="badge <?php echo $badge_class; ?>"><?php echo $tiempo_text; ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Función para exportar reporte a Excel
function exportReportToExcel() {
    const table = document.getElementById('reportesTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach((cell, index) => {
            if (index !== 3) { // Omitir columna de gráfico
                let text = cell.textContent.trim();
                text = text.replace(/\n/g, ' ').replace(/\s+/g, ' ');
                if (text.includes(',')) {
                    text = '"' + text + '"';
                }
                rowData.push(text);
            }
        });
        
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', 'reportes_wedding_connect_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Función para imprimir reporte (CORREGIDA)
function printReport() {
    const table = document.getElementById('reportesTable');
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Reportes - Wedding Connect</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    th { background: #f5f0e6; padding: 10px; border: 1px solid #ddd; text-align: left; }
                    td { padding: 8px; border: 1px solid #ddd; }
                    h1 { color: #800020; text-align: center; }
                    .print-date { text-align: right; margin-bottom: 20px; }
                    .progress { background: #e9ecef; height: 20px; border-radius: 4px; overflow: hidden; }
                    .progress-bar { height: 100%; }
                </style>
            </head>
            <body>
                <h1>Reportes de Eventos - Wedding Connect</h1>
                <div class="print-date">Fecha: ${new Date().toLocaleDateString('es-ES')}</div>
                ${table.outerHTML}
                <script>
                    window.onload = function() { window.print(); window.close(); }
                <\/script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>