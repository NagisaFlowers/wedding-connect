<?php
// admin/views/eventos.php - Vista de eventos NORMALIZADA
?>

<!-- CONTENIDO DE EVENTOS -->
<div class="row g-4 mb-4">
    <!-- Tarjeta de Total Eventos -->
    <div class="col-md-3">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-calendar4-event stat-icon" style="color: var(--wedding-burgundy);"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['total_eventos'] ?? 0; ?></div>
                <div class="stat-label">Total Eventos</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-heart-fill text-danger"></i> Todos los eventos
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Eventos Futuros -->
    <div class="col-md-3">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-calendar-heart stat-icon" style="color: var(--wedding-gold);"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['eventos_futuros'] ?? 0; ?></div>
                <div class="stat-label">Eventos Futuros</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-clock"></i> Por venir
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Eventos Hoy -->
    <div class="col-md-3">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-calendar-day stat-icon" style="color: #ff6b6b;"></i>
                <div class="stat-number">
                    <?php 
                    // CORRECCIÓN: Contar eventos de hoy correctamente
                    $hoy = date('Y-m-d');
                    $eventos_hoy = 0;
                    foreach ($datos['eventos'] as $evento) {
                        if (date('Y-m-d', strtotime($evento['fecha_evento'])) == $hoy) {
                            $eventos_hoy++;
                        }
                    }
                    echo $eventos_hoy;
                    ?>
                </div>
                <div class="stat-label">Eventos Hoy</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> ¡Hoy!
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Eventos Pasados -->
    <div class="col-md-3">
        <div class="stat-card pulse">
            <div class="text-center">
                <i class="bi bi-calendar-check stat-icon" style="color: #28a745;"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['eventos_pasados'] ?? 0; ?></div>
                <div class="stat-label">Eventos Pasados</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-check-circle-fill text-success"></i> Completados
                </small>
            </div>
        </div>
    </div>
</div>

<div class="table-container animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0" style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                <i class="bi bi-calendar-heart"></i> Calendario de Eventos
            </h4>
            <small class="text-muted">Próximos eventos ordenados por fecha</small>
        </div>
        <div class="btn-group" id="filtroEventos">
            <button class="btn btn-outline-wedding me-2" onclick="filterByEstado('todos')">
                <i class="bi bi-grid"></i> Todos
            </button>
            <button class="btn btn-outline-danger me-2" onclick="filterByEstado('próximo')">
                <i class="bi bi-clock"></i> Próximos
            </button>
            <button class="btn btn-outline-warning me-2" onclick="filterByEstado('hoy')">
                <i class="bi bi-star"></i> Hoy
            </button>
            <button class="btn btn-outline-success" onclick="filterByEstado('completado')">
                <i class="bi bi-check-circle"></i> Completados
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['eventos'])): ?>
        <div class="alert alert-wedding text-center py-5" style="background: rgba(212, 175, 55, 0.1); border-color: var(--wedding-gold);">
            <i class="bi bi-calendar-x display-6 d-block mb-3" style="color: var(--wedding-rose);"></i>
            <h5 style="color: var(--wedding-burgundy);">No hay eventos programados</h5>
            <p class="mb-0">Comienza agregando clientes con fechas de evento.</p>
            <button class="btn btn-admin mt-3 pulse" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Agregar Nuevo Cliente
            </button>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="eventosTable">
                <thead class="table-light" style="background: linear-gradient(135deg, var(--wedding-ivory) 0%, #f5f0e6 100%);">
                    <tr>
                        <th onclick="sortEventosTable(0)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-calendar-date"></i> Fecha <span id="sortIconE0" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(1)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-person-heart"></i> Cliente <span id="sortIconE1" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(2)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-telephone"></i> Contacto <span id="sortIconE2" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(3)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-heart"></i> Tipo <span id="sortIconE3" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(4)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-hourglass"></i> Días Restantes <span id="sortIconE4" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(5)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-circle-fill"></i> Estado <span id="sortIconE5" class="sort-icon">⇅</span>
                        </th>
                        <th style="color: var(--wedding-burgundy);">
                            <i class="bi bi-chat-heart"></i> Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['eventos'] as $evento): 
                        $fecha_evento = new DateTime($evento['fecha_evento']);
                        $hoy = new DateTime();
                        $hoy->setTime(0, 0, 0); // Establecer a medianoche para comparar solo la fecha
                        
                        $fecha_evento_solo = clone $fecha_evento;
                        $fecha_evento_solo->setTime(0, 0, 0);
                        
                        $diferencia = $hoy->diff($fecha_evento_solo);
                        $dias_restantes = $diferencia->days;
                        
                        // CORREGIR la lógica de "Hoy"
                        if ($fecha_evento_solo < $hoy) {
                            $estado = 'completado';
                            $badge = 'bg-success';
                            $icon = 'bi-check-circle-fill';
                            $dias_sort = -1;
                            $border_color = 'border-left: 3px solid #28a745;';
                        } elseif ($fecha_evento_solo == $hoy) { // Comparación CORREGIDA
                            $estado = 'hoy';
                            $badge = 'bg-warning';
                            $icon = 'bi-exclamation-triangle-fill';
                            $dias_restantes = 0;
                            $dias_sort = 0;
                            $border_color = 'border-left: 3px solid #ffc107;';
                        } elseif ($dias_restantes <= 7) {
                            $estado = 'próximo';
                            $badge = 'bg-danger';
                            $icon = 'bi-clock-fill';
                            $dias_sort = $dias_restantes;
                            $border_color = 'border-left: 3px solid #dc3545;';
                        } else {
                            $estado = 'programado';
                            $badge = 'bg-primary';
                            $icon = 'bi-calendar-heart';
                            $dias_sort = $dias_restantes;
                            $border_color = 'border-left: 3px solid #0d6efd;';
                        }
                        
                        $tipo_text = $evento['tipo_nombre'];
                        
                        // Colores para tipos de evento
                        $tipo_colors = [
                            'civil' => '#ffc107',
                            'religiosa' => '#198754',
                            'playa' => '#0dcaf0',
                            'intima' => '#6f42c1',
                            'lujo' => '#fd7e14'
                        ];
                        
                        // Determinar color según tipo
                        $tipo_color = '#6c757d'; // Color por defecto
                        foreach ($tipo_colors as $key => $color) {
                            if (stripos($tipo_text, $key) !== false) {
                                $tipo_color = $color;
                                break;
                            }
                        }
                        
                        $fecha_iso = $evento['fecha_evento'];
                        $fecha_display = date('d/m/Y', strtotime($evento['fecha_evento']));
                        $dia_semana = date('l', strtotime($evento['fecha_evento']));
                        
                        $dias_es = array(
                            'Monday' => 'Lunes',
                            'Tuesday' => 'Martes',
                            'Wednesday' => 'Miércoles',
                            'Thursday' => 'Jueves',
                            'Friday' => 'Viernes',
                            'Saturday' => 'Sábado',
                            'Sunday' => 'Domingo'
                        );
                        $dia_semana_es = $dias_es[$dia_semana] ?? $dia_semana;
                    ?>
                        <tr data-estado="<?php echo $estado; ?>" 
                            data-fecha="<?php echo $evento['fecha_evento']; ?>"
                            style="<?php echo $border_color; ?>">
                            <!-- Fecha -->
                            <td data-sort="<?php echo $fecha_iso; ?>">
                                <div style="text-align: center;">
                                    <div style="font-size: 1.2rem; font-weight: bold; color: var(--wedding-burgundy);">
                                        <?php echo $fecha_display; ?>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-week"></i> <?php echo $dia_semana_es; ?>
                                    </small>
                                </div>
                            </td>
                            <!-- Cliente -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($evento['nombre'])); ?>">
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar me-2" style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, var(--wedding-rose) 0%, #f5d0d4 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-heart-fill" style="color: var(--wedding-burgundy);"></i>
                                    </div>
                                    <div>
                                        <strong style="color: var(--wedding-burgundy);"><?php echo htmlspecialchars($evento['nombre']); ?></strong>
                                        <?php if ($evento['mensaje']): ?>
                                            <br>
                                            <button class="btn btn-link btn-sm p-0 text-decoration-none" 
                                                    data-bs-toggle="tooltip" 
                                                    title="<?php echo htmlspecialchars(substr($evento['mensaje'], 0, 100)); ?>..."
                                                    style="color: var(--wedding-gold);">
                                                <small>
                                                    <i class="bi bi-chat-left-heart"></i> Ver mensaje
                                                </small>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <!-- Contacto -->
                            <td data-sort="<?php echo strtolower($evento['correo']); ?>">
                                <div class="contact-info">
                                    <div class="mb-1">
                                        <i class="bi bi-envelope me-1" style="color: var(--wedding-gold);"></i>
                                        <a href="mailto:<?php echo $evento['correo']; ?>" class="text-decoration-none" style="color: var(--wedding-burgundy);">
                                            <?php echo $evento['correo']; ?>
                                        </a>
                                    </div>
                                    <div>
                                        <i class="bi bi-telephone me-1" style="color: var(--wedding-gold);"></i>
                                        <a href="tel:<?php echo $evento['telefono']; ?>" class="text-decoration-none" style="color: var(--wedding-burgundy);">
                                            <?php echo $evento['telefono']; ?>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <!-- Tipo Evento (NORMALIZADO) -->
                            <td data-sort="<?php echo strtolower($tipo_text); ?>">
                                <span class="badge" style="background-color: <?php echo $tipo_color; ?>; color: white;">
                                    <i class="bi bi-heart me-1"></i><?php echo $tipo_text; ?>
                                </span>
                            </td>
                            <!-- Días Restantes -->
                            <td data-sort="<?php echo $dias_sort; ?>">
                                <?php if ($estado == 'completado'): ?>
                                    <span class="text-muted">
                                        <i class="bi bi-check-circle text-success"></i> Finalizado
                                    </span>
                                <?php elseif ($estado == 'hoy'): ?>
                                    <span class="text-warning fw-bold">
                                        <i class="bi bi-star-fill"></i> ¡HOY!
                                    </span>
                                <?php else: ?>
                                    <span class="fw-bold" style="color: var(--wedding-burgundy);">
                                        <?php echo $dias_restantes; ?>
                                    </span> días
                                    <?php if ($dias_restantes <= 7): ?>
                                        <br>
                                        <small class="text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> ¡Pronto!
                                        </small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <!-- Estado -->
                            <td data-sort="<?php echo $estado; ?>">
                                <?php 
                                $estado_text = ucfirst($estado);
                                if ($estado == 'próximo') $estado_text = 'Próximo';
                                if ($estado == 'hoy') $estado_text = 'Hoy';
                                if ($estado == 'completado') $estado_text = 'Completado';
                                if ($estado == 'programado') $estado_text = 'Programado';
                                ?>
                                <span class="badge <?php echo $badge; ?>">
                                    <i class="bi <?php echo $icon; ?>"></i> <?php echo $estado_text; ?>
                                </span>
                            </td>
                            <!-- Acciones -->
                            <td data-no-sort="true">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-wedding me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalCliente<?php echo $evento['id']; ?>"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    <a href="mailto:<?php echo $evento['correo']; ?>" 
                                       class="btn btn-outline-wedding me-1" title="Enviar email">
                                        <i class="bi bi-envelope-heart"></i>
                                    </a>
                                    
                                    <a href="tel:<?php echo $evento['telefono']; ?>" 
                                       class="btn btn-outline-wedding me-1" title="Llamar">
                                        <i class="bi bi-telephone-outbound"></i>
                                    </a>
                                    
                                    <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Evento+<?php echo urlencode($evento['nombre']); ?>&dates=<?php echo date('Ymd', strtotime($evento['fecha_evento'])); ?>/<?php echo date('Ymd', strtotime($evento['fecha_evento'] . ' +1 day')); ?>&details=Cliente:+<?php echo urlencode($evento['nombre']); ?>%0ATel:+<?php echo urlencode($evento['telefono']); ?>%0ATipo:+<?php echo urlencode($tipo_text); ?>" 
                                       target="_blank"
                                       class="btn btn-outline-wedding"
                                       title="Agregar a Google Calendar">
                                        <i class="bi bi-calendar-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3 text-center">
            <small class="text-muted">
                <i class="bi bi-info-circle"></i> 
                <strong>Leyenda:</strong> 
                <span class="badge bg-danger"><i class="bi bi-clock"></i> Próximo (≤ 7 días)</span> 
                <span class="badge bg-primary"><i class="bi bi-calendar-heart"></i> Programado</span> 
                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Completado</span>
                <span class="badge bg-warning"><i class="bi bi-star"></i> Hoy</span>
                <span class="ms-3"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script>
// Variables para ordenamiento de eventos
let currentEventosSortColumn = 0;
let currentEventosSortDirection = 'asc';

// Función para ordenar tabla de eventos (NUEVA)
function sortEventosTable(columnIndex) {
    const table = document.getElementById('eventosTable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const headers = table.querySelectorAll('thead th');
    
    // Resetear iconos anteriores
    headers.forEach((header, index) => {
        header.classList.remove('sort-asc', 'sort-desc');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '⇅';
    });
    
    // Determinar dirección
    if (currentEventosSortColumn === columnIndex) {
        currentEventosSortDirection = currentEventosSortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        currentEventosSortColumn = columnIndex;
        currentEventosSortDirection = 'asc';
    }
    
    // Actualizar icono
    const currentHeader = headers[columnIndex];
    if (currentHeader) {
        currentHeader.classList.add(currentEventosSortDirection === 'asc' ? 'sort-asc' : 'sort-desc');
        const currentIcon = currentHeader.querySelector('.sort-icon');
        if (currentIcon) {
            currentIcon.textContent = currentEventosSortDirection === 'asc' ? '↑' : '↓';
        }
    }
    
    // Ordenar filas
    rows.sort((rowA, rowB) => {
        const cellsA = rowA.querySelectorAll('td');
        const cellsB = rowB.querySelectorAll('td');
        
        if (cellsA.length <= columnIndex || cellsB.length <= columnIndex) return 0;
        
        const cellA = cellsA[columnIndex];
        const cellB = cellsB[columnIndex];
        
        // Verificar si es columna no ordenable
        if (cellA.getAttribute('data-no-sort') || cellB.getAttribute('data-no-sort')) {
            return 0;
        }
        
        let valueA = cellA.getAttribute('data-sort') || cellA.textContent.trim();
        let valueB = cellB.getAttribute('data-sort') || cellB.textContent.trim();
        
        // Convertir a números si es posible
        if (!isNaN(valueA) && !isNaN(valueB)) {
            valueA = parseFloat(valueA);
            valueB = parseFloat(valueB);
        }
        // Convertir fechas si es posible
        else if (isDate(valueA) && isDate(valueB)) {
            valueA = new Date(valueA).getTime();
            valueB = new Date(valueB).getTime();
        }
        // Para texto, convertir a minúsculas para comparación
        else {
            valueA = valueA.toString().toLowerCase();
            valueB = valueB.toString().toLowerCase();
        }
        
        // Comparar según dirección
        if (currentEventosSortDirection === 'asc') {
            return valueA < valueB ? -1 : valueA > valueB ? 1 : 0;
        } else {
            return valueA > valueB ? -1 : valueA < valueB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    rows.forEach(row => tbody.appendChild(row));
}

// Función auxiliar para verificar si es fecha
function isDate(value) {
    if (!value) return false;
    // Verificar formato ISO (YYYY-MM-DD)
    const isoRegex = /^\d{4}-\d{2}-\d{2}/;
    if (isoRegex.test(value)) return true;
    
    // Verificar si puede convertirse a fecha
    const date = new Date(value);
    return date instanceof Date && !isNaN(date);
}

// Función para filtrar por estado
function filterByEstado(estado) {
    const table = document.getElementById('eventosTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (estado === 'todos') {
            row.style.display = '';
        } else {
            const rowEstado = row.getAttribute('data-estado');
            row.style.display = rowEstado === estado ? '' : 'none';
        }
    });
    
    // Actualizar botones activos
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Hacer botones responsivos
document.addEventListener('DOMContentLoaded', function() {
    // Ajustar grupo de botones en móviles
    const btnGroup = document.getElementById('filtroEventos');
    if (window.innerWidth < 768 && btnGroup) {
        btnGroup.classList.add('btn-group-vertical');
        btnGroup.classList.remove('btn-group');
    }
    
    // Ajustar en cambio de tamaño de ventana
    window.addEventListener('resize', function() {
        const btnGroup = document.getElementById('filtroEventos');
        if (window.innerWidth < 768) {
            if (btnGroup) {
                btnGroup.classList.add('btn-group-vertical');
                btnGroup.classList.remove('btn-group');
            }
        } else {
            if (btnGroup) {
                btnGroup.classList.add('btn-group');
                btnGroup.classList.remove('btn-group-vertical');
            }
        }
    });
});

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>