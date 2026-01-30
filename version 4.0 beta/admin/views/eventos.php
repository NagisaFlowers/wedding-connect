<?php
// admin/views/eventos.php - Vista de eventos
?>

<!-- CONTENIDO DE EVENTOS -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card animate-fade-in" style="animation-delay: 0.1s">
            <div class="text-center">
                <i class="bi bi-calendar4-event stat-icon"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['total_eventos'] ?? 0; ?></div>
                <div class="stat-label">Total Eventos</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in" style="animation-delay: 0.2s">
            <div class="text-center">
                <i class="bi bi-calendar-check stat-icon"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['eventos_futuros'] ?? 0; ?></div>
                <div class="stat-label">Eventos Futuros</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
            <div class="text-center">
                <i class="bi bi-calendar-day stat-icon text-warning"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['eventos_hoy'] ?? 0; ?></div>
                <div class="stat-label">Eventos Hoy</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in" style="animation-delay: 0.4s">
            <div class="text-center">
                <i class="bi bi-calendar-x stat-icon text-success"></i>
                <div class="stat-number"><?php echo $datos['eventos_stats']['eventos_pasados'] ?? 0; ?></div>
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
    
    <?php if (empty($datos['eventos'])): ?>
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-calendar-x display-6 d-block mb-3"></i>
            <h5>No hay eventos programados</h5>
            <p class="mb-0">Comienza agregando clientes con fechas de evento.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="eventosTable">
                <thead class="table-light">
                    <tr>
                        <th onclick="sortEventosTable(0)" style="cursor: pointer;">
                            Fecha <span id="sortIconE0" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(1)" style="cursor: pointer;">
                            Cliente <span id="sortIconE1" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(2)" style="cursor: pointer;">
                            Contacto <span id="sortIconE2" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(3)" style="cursor: pointer;">
                            Tipo Evento <span id="sortIconE3" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(4)" style="cursor: pointer;">
                            Días Restantes <span id="sortIconE4" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortEventosTable(5)" style="cursor: pointer;">
                            Estado <span id="sortIconE5" class="sort-icon">⇅</span>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['eventos'] as $evento): 
                        $fecha_evento = new DateTime($evento['fecha_evento']);
                        $hoy = new DateTime();
                        $diferencia = $hoy->diff($fecha_evento);
                        $dias_restantes = $diferencia->days;
                        
                        if ($fecha_evento < $hoy) {
                            $estado = 'Completado';
                            $badge = 'bg-success';
                            $icon = 'bi-check-circle';
                            $dias_sort = -1; // Para ordenamiento
                        } elseif ($fecha_evento->format('Y-m-d') == $hoy->format('Y-m-d')) {
                            $estado = 'Hoy';
                            $badge = 'bg-warning';
                            $icon = 'bi-exclamation-circle';
                            $dias_restantes = 0;
                            $dias_sort = 0;
                        } elseif ($dias_restantes <= 7) {
                            $estado = 'Próximo';
                            $badge = 'bg-danger';
                            $icon = 'bi-clock';
                            $dias_sort = $dias_restantes;
                        } else {
                            $estado = 'Programado';
                            $badge = 'bg-primary';
                            $icon = 'bi-calendar';
                            $dias_sort = $dias_restantes;
                        }
                        
                        $badge_class = 'badge-' . $evento['tipo_boda'];
                        $tipo_text = formatearTipoEvento($evento['tipo_boda']);
                        
                        // Para ordenamiento de fechas, necesitamos múltiples formatos
                        $fecha_iso = $evento['fecha_evento']; // YYYY-MM-DD para ordenamiento
                        $fecha_display = date('d/m/Y', strtotime($evento['fecha_evento'])); // Para mostrar
                        $dia_semana = date('l', strtotime($evento['fecha_evento']));
                        
                        // Traducir día de la semana
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
                        <tr data-estado="<?php echo strtolower($estado); ?>" 
                            data-fecha="<?php echo $evento['fecha_evento']; ?>">
                            <!-- Fecha -->
                            <td data-sort="<?php echo $fecha_iso; ?>">
                                <strong><?php echo $fecha_display; ?></strong>
                                <br>
                                <small class="text-muted"><?php echo $dia_semana_es; ?></small>
                            </td>
                            <!-- Cliente -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($evento['nombre'])); ?>">
                                <strong><?php echo htmlspecialchars($evento['nombre']); ?></strong>
                                <?php if ($evento['mensaje']): ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-chat-left-text"></i> 
                                        <?php echo substr(htmlspecialchars($evento['mensaje']), 0, 50); ?>...
                                    </small>
                                <?php endif; ?>
                            </td>
                            <!-- Contacto -->
                            <td data-sort="<?php echo strtolower($evento['correo']); ?>">
                                <div><i class="bi bi-envelope"></i> <?php echo $evento['correo']; ?></div>
                                <div><i class="bi bi-telephone"></i> <?php echo $evento['telefono']; ?></div>
                            </td>
                            <!-- Tipo Evento -->
                            <td data-sort="<?php echo $evento['tipo_boda']; ?>">
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $tipo_text; ?>
                                </span>
                            </td>
                            <!-- Días Restantes -->
                            <td data-sort="<?php echo $dias_sort; ?>">
                                <?php if ($estado == 'Completado'): ?>
                                    <span class="text-muted">Finalizado</span>
                                <?php elseif ($estado == 'Hoy'): ?>
                                    <span class="text-warning fw-bold">¡HOY!</span>
                                <?php else: ?>
                                    <span class="fw-bold"><?php echo $dias_restantes; ?></span> días
                                <?php endif; ?>
                            </td>
                            <!-- Estado -->
                            <td data-sort="<?php echo $estado; ?>">
                                <span class="badge <?php echo $badge; ?>">
                                    <i class="bi <?php echo $icon; ?>"></i> <?php echo $estado; ?>
                                </span>
                            </td>
                            <!-- Acciones -->
                            <td data-no-sort="true">
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
                <span class="badge bg-primary">Programado</span> 
                <span class="badge bg-success">Completado</span>
                <span class="ms-3">Haz clic en cualquier encabezado para ordenar la tabla.</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script>
// Variables para ordenamiento de eventos
let currentEventosSortColumn = 0;
let currentEventosSortDirection = 'asc';
let originalEventosData = [];

// Guardar datos originales de eventos
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('eventosTable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    originalEventosData = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        return cells.map(cell => {
            return {
                html: cell.innerHTML,
                sort: cell.getAttribute('data-sort') || cell.textContent.trim(),
                noSort: cell.hasAttribute('data-no-sort')
            };
        });
    });
});

// Función para ordenar tabla de eventos
function sortEventosTable(columnIndex) {
    const table = document.getElementById('eventosTable');
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
    currentHeader.classList.add(currentEventosSortDirection === 'asc' ? 'sort-asc' : 'sort-desc');
    const currentIcon = currentHeader.querySelector('.sort-icon');
    currentIcon.textContent = currentEventosSortDirection === 'asc' ? '↑' : '↓';
    
    // Ordenar filas
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelectorAll('td')[columnIndex];
        const cellB = rowB.querySelectorAll('td')[columnIndex];
        
        // Verificar si es columna no ordenable
        if (cellA.getAttribute('data-no-sort') || cellB.getAttribute('data-no-sort')) {
            return 0;
        }
        
        let valueA = cellA.getAttribute('data-sort') || cellA.textContent.trim();
        let valueB = cellB.getAttribute('data-sort') || cellB.textContent.trim();
        
        // Para columna de fecha (índice 0)
        if (columnIndex === 0) {
            // Las fechas ya están en formato ISO (YYYY-MM-DD) en data-sort
            // Solo necesitamos asegurarnos de que sean comparables como strings
            // ya que YYYY-MM-DD se ordena lexicográficamente correctamente
            valueA = new Date(valueA).getTime();
            valueB = new Date(valueB).getTime();
        }
        // Para columna de días restantes (índice 4)
        else if (columnIndex === 4) {
            // Ya tenemos números en data-sort para esta columna
            valueA = parseFloat(valueA);
            valueB = parseFloat(valueB);
        }
        // Para otras columnas, convertir a números si es posible
        else if (!isNaN(valueA) && !isNaN(valueB)) {
            valueA = parseFloat(valueA);
            valueB = parseFloat(valueB);
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

// Función para buscar en tabla de eventos
function searchEventosTable() {
    const input = document.getElementById('searchEventos');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('eventosTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let show = false;
        const cells = row.querySelectorAll('td');
        
        cells.forEach((cell, index) => {
            // No buscar en columna de acciones (última columna)
            if (index !== cells.length - 1) {
                const cellText = cell.textContent.toLowerCase();
                if (cellText.indexOf(filter) > -1) {
                    show = true;
                }
            }
        });
        
        row.style.display = show ? '' : 'none';
    });
}

// Función para restablecer orden de eventos
function resetEventosSort() {
    const table = document.getElementById('eventosTable');
    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('thead th');
    
    // Resetear iconos
    headers.forEach((header, index) => {
        header.classList.remove('sort-asc', 'sort-desc');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '⇅';
    });
    
    // Restaurar datos originales
    tbody.innerHTML = '';
    originalEventosData.forEach(rowData => {
        const row = document.createElement('tr');
        rowData.forEach(cellData => {
            const cell = document.createElement('td');
            cell.innerHTML = cellData.html;
            if (cellData.sort) {
                cell.setAttribute('data-sort', cellData.sort);
            }
            if (cellData.noSort) {
                cell.setAttribute('data-no-sort', 'true');
            }
            row.appendChild(cell);
        });
        tbody.appendChild(row);
    });
    
    currentEventosSortColumn = 0;
    currentEventosSortDirection = 'asc';
}

// Función para exportar eventos a Excel
function exportEventosToExcel() {
    const table = document.getElementById('eventosTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach((cell, index) => {
            // Omitir columna de acciones (última columna)
            if (index !== cells.length - 1) {
                let text = cell.textContent.trim();
                // Limpiar texto
                text = text.replace(/\n/g, ' ').replace(/\s+/g, ' ');
                // Agregar comillas si contiene comas
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
    link.setAttribute('download', 'eventos_wedding_connect_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
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
}

// Agregar botones de filtro de estado dinámicamente
document.addEventListener('DOMContentLoaded', function() {
    const estados = ['todos', 'próximo', 'hoy', 'programado', 'completado'];
    const nombresEstados = {
        'todos': 'Todos',
        'próximo': 'Próximos',
        'hoy': 'Hoy',
        'programado': 'Programados',
        'completado': 'Completados'
    };
    
    const colors = {
        'todos': 'secondary',
        'próximo': 'danger',
        'hoy': 'warning',
        'programado': 'primary',
        'completado': 'success'
    };
    

    
    // Insertar después del título
    const titleDiv = document.querySelector('.table-container .d-flex');
    if (titleDiv) {
        titleDiv.parentNode.insertBefore(filterContainer, titleDiv.nextElementSibling);
    }
});
</script>