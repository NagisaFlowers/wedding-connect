<?php
// admin/views/dashboard.php - Vista del dashboard
?>
<!-- CONTENIDO DEL DASHBOARD -->
<div class="stats-grid-nuevo">
    <!-- Clientes Totales -->
    <div class="stat-card-nuevo" data-bs-toggle="modal" data-bs-target="#modalClientesTotales">
        <div class="stat-icon-nuevo">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $stats['total_clientes'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Clientes Totales</div>
        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Click para detalles</small>
    </div>
    
    <!-- Tipos de Evento -->
    <div class="stat-card-nuevo" data-bs-toggle="modal" data-bs-target="#modalTiposEvento">
        <div class="stat-icon-nuevo">
            <i class="bi bi-heart-fill"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Tipos de Eventos</div>
        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Click para detalles</small>
    </div>
    
    <!-- Próximo Evento -->
    <div class="stat-card-nuevo" data-bs-toggle="modal" data-bs-target="#modalProximoEvento">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero">
            <?php echo $stats['proximo_evento'] ? date('d/m/Y', strtotime($stats['proximo_evento'])) : '--'; ?>
        </div>
        <div class="stat-label-nuevo">Próximo Evento</div>
        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Click para detalles</small>
    </div>
    
    <!-- Último Evento -->
    <div class="stat-card-nuevo" data-bs-toggle="modal" data-bs-target="#modalUltimoEvento">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar-date"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero">
            <?php echo $stats['ultimo_evento'] ? date('d/m/Y', strtotime($stats['ultimo_evento'])) : '--'; ?>
        </div>
        <div class="stat-label-nuevo">Último Evento</div>
        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Click para detalles</small>
    </div>
</div>

<!-- Lista de Clientes -->
<div class="table-container-nuevo animate-nuevo">
    <div class="table-header-nuevo">
        <div>
            <h4><i class="bi bi-table"></i> Lista de Clientes</h4>
            <small class="text-muted">Últimos 10 registros</small>
        </div>
        <div>
            <button class="btn btn-primary-nuevo me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </button>
            <a href="admin.php?tab=clientes" class="btn btn-outline-nuevo">
                <i class="bi bi-eye"></i> Ver Todos
            </a>
        </div>
    </div>
    
    <?php if (empty($datos['clientes_dashboard'])): ?>
        <div class="text-center py-5" style="background: rgba(155, 135, 184, 0.05); border-radius: var(--radius-md);">
            <i class="bi bi-heart display-1" style="color: var(--primary);"></i>
            <h5 class="mt-3" style="color: var(--primary-dark);">No hay clientes registrados</h5>
            <p class="text-muted">Comienza agregando tu primer cliente.</p>
            <button class="btn btn-primary-nuevo mt-3" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Agregar Primer Cliente
            </button>
        </div>
    <?php else: ?>
        <div class="table-responsive-nuevo">
            <table class="table-nuevo" id="tablaDashboard">
                <thead>
                    <tr>
                        <th onclick="ordenarTabla(0)" style="cursor: pointer;">ID <span id="icono0">⇅</span></th>
                        <th onclick="ordenarTabla(1)" style="cursor: pointer;">Nombre <span id="icono1">⇅</span></th>
                        <th onclick="ordenarTabla(2)" style="cursor: pointer;">Email <span id="icono2">⇅</span></th>
                        <th onclick="ordenarTabla(3)" style="cursor: pointer;">Teléfono <span id="icono3">⇅</span></th>
                        <th onclick="ordenarTabla(4)" style="cursor: pointer;">Tipo Evento <span id="icono4">⇅</span></th>
                        <th onclick="ordenarTabla(5)" style="cursor: pointer;">Fecha Evento <span id="icono5">⇅</span></th>
                        <th onclick="ordenarTabla(6)" style="cursor: pointer;">Registro <span id="icono6">⇅</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes_dashboard'] as $cliente): ?>
                        <tr onclick="viewClientDetails(<?php echo $cliente['id']; ?>)">
                            <td data-sort="<?php echo $cliente['id']; ?>"><span class="badge badge-primary-nuevo">#<?php echo $cliente['id']; ?></span></td>
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>"><strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong></td>
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>"><i class="bi bi-envelope me-1"></i><?php echo $cliente['correo']; ?></td>
                            <td data-sort="<?php echo $cliente['telefono']; ?>"><i class="bi bi-telephone me-1"></i><?php echo $cliente['telefono']; ?></td>
                            <td data-sort="<?php echo strtolower($cliente['tipo_nombre']); ?>"><?php echo $cliente['tipo_nombre']; ?></td>
                            <td data-sort="<?php echo $cliente['fecha_evento']; ?>"><?php echo date('d/m/Y', strtotime($cliente['fecha_evento'])); ?></td>
                            <td data-sort="<?php echo $cliente['fecha_registro']; ?>"><small><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></small></td>
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
    <?php endif; ?>
</div>

<script src="../../assets/js/views-panel.js"></script>
