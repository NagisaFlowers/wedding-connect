<?php
// admin/views/reportes.php - Vista de reportes CORREGIDA
?>
<div class="stats-grid-nuevo">
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-pie-chart"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo count($datos['reportes_stats']); ?></div>
        <div class="stat-label-nuevo">Tipos de Eventos</div>
    </div>
    
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $stats['total_clientes'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Total Clientes</div>
    </div>
    
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Variedad Eventos</div>
    </div>
</div>

<div class="table-container-nuevo animate-nuevo">
    <div class="table-header-nuevo">
        <h4><i class="bi bi-pie-chart-fill"></i> Distribución por Tipo de Evento</h4>
        <div class="btn-group gap-2">
            <button class="btn btn-outline-nuevo" onclick="exportarReporteExcel()">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </button>
            <button class="btn btn-outline-nuevo" onclick="imprimirReporte()">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
    
    <div class="table-responsive-nuevo">
        <table class="table-nuevo" id="reportesTable">
            <thead>
                <tr>
                    <th onclick="ordenarTablaReportes(0)" style="cursor: pointer;">Tipo de Evento <span id="iconoR0">⇅</span></th>
                    <th onclick="ordenarTablaReportes(1)" style="cursor: pointer;">Cantidad <span id="iconoR1">⇅</span></th>
                    <th onclick="ordenarTablaReportes(2)" style="cursor: pointer;">Porcentaje <span id="iconoR2">⇅</span></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                require_once __DIR__ . '/../../config/database.php';
                $db = getDB();
                $total_clientes = $db->query("SELECT COUNT(*) as total FROM clientes")->fetch(PDO::FETCH_ASSOC);
                $total = $total_clientes['total'] ?? 1;
                
                foreach ($datos['reportes_stats'] as $reporte): 
                    $porcentaje = ($reporte['cantidad'] / $total) * 100;
                ?>
                    <tr>
                        <td data-sort="<?php echo strtolower($reporte['nombre']); ?>"><strong><?php echo $reporte['nombre']; ?></strong></td>
                        <td data-sort="<?php echo $reporte['cantidad']; ?>"><?php echo $reporte['cantidad']; ?></td>
                        <td data-sort="<?php echo $porcentaje; ?>">
                            <div class="progress" style="height: 20px; background: rgba(155, 135, 184, 0.1);">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?php echo $porcentaje; ?>%; background: linear-gradient(90deg, var(--primary), var(--secondary));"
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
    
    <div class="mt-3 text-center">
        <small class="text-muted">
            <i class="bi bi-info-circle"></i> Haz clic en cualquier encabezado para ordenar.
            <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
            <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
        </small>
    </div>
</div>

<div class="row mt-4 g-4">
    <!-- Próximos Eventos -->
    <div class="col-md-6">
        <div class="table-container-nuevo">
            <h4><i class="bi bi-calendar-heart"></i> Próximos Eventos</h4>
            <?php 
            $proximos_eventos = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                            FROM clientes c 
                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                            WHERE c.fecha_evento >= CURDATE() 
                                            ORDER BY c.fecha_evento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            if (empty($proximos_eventos)): ?>
                <p class="text-muted text-center py-4">No hay próximos eventos</p>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($proximos_eventos as $evento): ?>
                        <div class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($evento['nombre']); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo $evento['tipo_nombre']; ?></small>
                            </div>
                            <span class="badge badge-primary-nuevo"><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Últimos Registros -->
    <div class="col-md-6">
        <div class="table-container-nuevo">
            <h4><i class="bi bi-people-fill"></i> Últimos Registros</h4>
            <?php 
            $ultimos_clientes = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                            FROM clientes c 
                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                            ORDER BY c.id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            if (empty($ultimos_clientes)): ?>
                <p class="text-muted text-center py-4">No hay clientes registrados</p>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($ultimos_clientes as $cliente): ?>
                        <div class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo $cliente['tipo_nombre']; ?></small>
                            </div>
                            <span class="badge badge-success-nuevo"><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../../assets/js/views-panel.js"></script>
