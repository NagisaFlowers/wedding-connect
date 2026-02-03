<!-- CONTENIDO DEL DASHBOARD NORMALIZADO -->
<div class="row g-4 mb-4">
    <!-- Tarjeta de Clientes Totales -->
    <div class="col-md-3">
        <div class="stat-card pulse" style="animation-delay: 0.1s" 
             data-bs-toggle="modal" data-bs-target="#modalClientesTotales">
            <div class="text-center">
                <i class="bi bi-people-fill stat-icon"></i>
                <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                <div class="stat-label">Clientes Totales</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> Click para detalles
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Tipos de Evento -->
    <div class="col-md-3">
        <div class="stat-card pulse" style="animation-delay: 0.2s" 
             data-bs-toggle="modal" data-bs-target="#modalTiposEvento">
            <div class="text-center">
                <i class="bi bi-heart-fill stat-icon"></i>
                <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                <div class="stat-label">Tipos de Eventos</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> Click para detalles
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Próximo Evento -->
    <div class="col-md-3">
        <div class="stat-card pulse" style="animation-delay: 0.3s" 
             data-bs-toggle="modal" data-bs-target="#modalProximoEvento">
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
                <div class="stat-label">Próximo Evento</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> Click para detalles
                </small>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Último Evento -->
    <div class="col-md-3">
        <div class="stat-card pulse" style="animation-delay: 0.4s" 
             data-bs-toggle="modal" data-bs-target="#modalUltimoEvento">
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
                <div class="stat-label">Último Evento</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> Click para detalles
                </small>
            </div>
        </div>
    </div>
</div>

<!-- LISTA DE CLIENTES DEL DASHBOARD -->
<div class="table-container animate-fade-in" style="animation-delay: 0.5s">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0" style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                <i class="bi bi-table"></i> Lista de Clientes
            </h4>
            <small class="text-muted">Últimos 10 registros</small>
        </div>
        <div class="btn-group">
            <button class="btn btn-admin me-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </button>
            <a href="admin.php?tab=clientes" class="btn btn-outline-wedding">
                <i class="bi bi-eye"></i> Ver Todos
            </a>
        </div>
    </div>
    
    <?php if (empty($datos['clientes_dashboard'])): ?>
        <div class="alert alert-wedding text-center py-5" style="background: rgba(212, 175, 55, 0.1); border-color: var(--wedding-gold);">
            <i class="bi bi-heart display-6 d-block mb-3" style="color: var(--wedding-rose);"></i>
            <h5 style="color: var(--wedding-burgundy);">No hay clientes registrados</h5>
            <p class="mb-0">Comienza agregando tu primer cliente.</p>
            <button class="btn btn-admin mt-3" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Agregar Primer Cliente
            </button>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="clientesDashboard">
                <thead class="table-light">
                    <tr>
                        <th onclick="sortTable(0)" style="cursor: pointer;">
                            ID <span id="sortIcon0" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(1)" style="cursor: pointer;">
                            Nombre <span id="sortIcon1" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(2)" style="cursor: pointer;">
                            Email <span id="sortIcon2" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(3)" style="cursor: pointer;">
                            Teléfono <span id="sortIcon3" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(4)" style="cursor: pointer;">
                            Tipo Evento <span id="sortIcon4" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(5)" style="cursor: pointer;">
                            Fecha Evento <span id="sortIcon5" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortTable(6)" style="cursor: pointer;">
                            Registro <span id="sortIcon6" class="sort-icon">⇅</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes_dashboard'] as $cliente): ?>
                        <tr style="cursor: pointer;" onclick="viewClientDetails(<?php echo $cliente['id']; ?>)">
                            <!-- ID -->
                            <td data-sort="<?php echo $cliente['id']; ?>">
                                <span class="badge" style="background: var(--wedding-gold);">#<?php echo $cliente['id']; ?></span>
                            </td>
                            <!-- Nombre -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>">
                                <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                            </td>
                            <!-- Email -->
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>">
                                <i class="bi bi-envelope me-1"></i><?php echo $cliente['correo']; ?>
                            </td>
                            <!-- Teléfono -->
                            <td data-sort="<?php echo $cliente['telefono']; ?>">
                                <i class="bi bi-telephone me-1"></i><?php echo $cliente['telefono']; ?>
                            </td>
                            <!-- Tipo Evento (NORMALIZADO) -->
                            <td data-sort="<?php echo strtolower($cliente['tipo_nombre']); ?>">
                                <?php 
                                $badge_class = '';
                                $tipo_text = $cliente['tipo_nombre'];
                                // Determinar color según tipo
                                if (stripos($cliente['tipo_nombre'], 'civil') !== false) {
                                    $badge_class = 'bg-warning';
                                } elseif (stripos($cliente['tipo_nombre'], 'religiosa') !== false) {
                                    $badge_class = 'bg-success';
                                } elseif (stripos($cliente['tipo_nombre'], 'playa') !== false) {
                                    $badge_class = 'bg-info';
                                } else {
                                    $badge_class = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <i class="bi bi-heart me-1"></i><?php echo $tipo_text; ?>
                                </span>
                            </td>
                            <!-- Fecha Evento -->
                            <td data-sort="<?php echo $cliente['fecha_evento']; ?>">
                                <?php 
                                $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                                $hoy = date('Y-m-d');
                                $icon = $cliente['fecha_evento'] < $hoy ? 'bi-check-circle' : 
                                        ($cliente['fecha_evento'] == $hoy ? 'bi-star' : 'bi-calendar');
                                $color = $cliente['fecha_evento'] < $hoy ? 'text-success' : 
                                        ($cliente['fecha_evento'] == $hoy ? 'text-warning' : 'text-primary');
                                ?>
                                <i class="bi <?php echo $icon; ?> <?php echo $color; ?> me-1"></i>
                                <?php echo $fecha_evento; ?>
                            </td>
                            <!-- Registro -->
                            <td data-sort="<?php echo $cliente['fecha_registro']; ?>">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>
                                    <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3 text-center">
            <small class="text-muted">
                <i class="bi bi-info-circle"></i> 
                Haz clic en cualquier encabezado para ordenar la tabla.
                <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
                <span class="ms-2"><i class="bi bi-cursor"></i> Click en fila para ver detalles</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script>
// Variables globales para el ordenamiento
let currentSortColumn = 0;
let currentSortDirection = 'asc';
let originalData = [];

// Guardar los datos originales al cargar
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('clientesDashboard');
    if (table) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        originalData = rows.map(row => {
            const cells = Array.from(row.querySelectorAll('td'));
            return cells.map(cell => {
                return {
                    html: cell.innerHTML,
                    sort: cell.getAttribute('data-sort') || cell.textContent.trim()
                };
            });
        });
    }
});

// Función para ordenar la tabla
function sortTable(columnIndex) {
    const table = document.getElementById('clientesDashboard');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const headers = table.querySelectorAll('thead th');
    
    // Resetear iconos anteriores
    headers.forEach((header, index) => {
        header.classList.remove('sort-asc', 'sort-desc');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '⇅';
    });
    
    // Determinar dirección de ordenamiento
    if (currentSortColumn === columnIndex) {
        currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        currentSortColumn = columnIndex;
        currentSortDirection = 'asc';
    }
    
    // Actualizar icono del header actual
    const currentHeader = headers[columnIndex];
    currentHeader.classList.add(currentSortDirection === 'asc' ? 'sort-asc' : 'sort-desc');
    const currentIcon = currentHeader.querySelector('.sort-icon');
    currentIcon.textContent = currentSortDirection === 'asc' ? '↑' : '↓';
    
    // Ordenar las filas
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelectorAll('td')[columnIndex];
        const cellB = rowB.querySelectorAll('td')[columnIndex];
        
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
        if (currentSortDirection === 'asc') {
            return valueA < valueB ? -1 : valueA > valueB ? 1 : 0;
        } else {
            return valueA > valueB ? -1 : valueA < valueB ? 1 : 0;
        }
    });
    
    // Reordenar las filas en la tabla
    rows.forEach(row => tbody.appendChild(row));
}

// Función para verificar si un string es una fecha
function isDate(value) {
    if (!value) return false;
    // Verificar formato ISO (YYYY-MM-DD)
    const isoRegex = /^\d{4}-\d{2}-\d{2}/;
    if (isoRegex.test(value)) return true;
    
    // Verificar si puede convertirse a fecha
    const date = new Date(value);
    return date instanceof Date && !isNaN(date);
}

// Función para ver detalles del cliente
function viewClientDetails(clientId) {
    // Abrir el modal de detalles del cliente
    const modalElement = document.getElementById('modalCliente' + clientId);
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}

// Función para restablecer al orden original
function resetSort() {
    const table = document.getElementById('clientesDashboard');
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
    originalData.forEach(rowData => {
        const row = document.createElement('tr');
        row.style.cursor = 'pointer';
        
        // Extraer ID del badge
        const idMatch = rowData[0].html.match(/#(\d+)/);
        if (idMatch && idMatch[1]) {
            const clientId = idMatch[1];
            row.onclick = function() {
                viewClientDetails(clientId);
            };
        }
        
        rowData.forEach(cellData => {
            const cell = document.createElement('td');
            cell.innerHTML = cellData.html;
            if (cellData.sort) {
                cell.setAttribute('data-sort', cellData.sort);
            }
            row.appendChild(cell);
        });
        tbody.appendChild(row);
    });
    
    currentSortColumn = 0;
    currentSortDirection = 'asc';
}
</script>