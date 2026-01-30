<?php
// admin/views/reportes.php - Vista de reportes
?>

<!-- CONTENIDO DE REPORTES -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card animate-fade-in">
            <div class="text-center">
                <i class="bi bi-pie-chart stat-icon"></i>
                <div class="stat-number"><?php echo count($datos['reportes_stats']); ?></div>
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
                <table class="table table-hover table-sm display" id="reportesTable" style="width:100%">
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
                        
                        foreach ($datos['reportes_stats'] as $reporte): 
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
                                             style="width: <?php echo $porcentaje; ?>%; background-color: var(--color-oro);"
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
            <div class="list-group" id="proximosEventos">
                <?php 
                $proximos_eventos = $conn->query("SELECT * FROM clientes WHERE fecha_evento >= CURDATE() ORDER BY fecha_evento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($proximos_eventos as $evento): 
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
            <div class="list-group" id="ultimosRegistros">
                <?php 
                $ultimos_clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($ultimos_clientes as $cliente): 
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

<script>
$(document).ready(function() {
    // Inicializar DataTable para reportes
    $('#reportesTable').DataTable({
        "order": [[1, "desc"]], // Ordenar por cantidad descendente por defecto
        "pageLength": 10,
        "lengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        "searching": false,
        "info": false,
        "paging": false,
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3] }, // Todas las columnas ordenables
            { "type": "num", "targets": 1 }, // Columna cantidad es numérica
            { "type": "num", "targets": 2 }  // Columna porcentaje es numérica
        ],
        "buttons": [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Exportar Excel',
                className: 'btn btn-sm btn-success',
                title: 'Reportes_Wedding_Connect_' + new Date().toLocaleDateString()
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Imprimir Reporte',
                className: 'btn btn-sm btn-info',
                title: 'Reportes - Wedding Connect'
            }
        ],
        "dom": 'Bfrtip'
    });
});
</script>