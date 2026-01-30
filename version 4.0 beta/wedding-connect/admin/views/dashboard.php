<!-- CONTENIDO DEL DASHBOARD -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card animate-fade-in clickable-card" style="animation-delay: 0.1s" 
             data-bs-toggle="modal" data-bs-target="#modalClientesTotales">
            <div class="text-center">
                <i class="bi bi-people-fill stat-icon"></i>
                <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                <div class="stat-label">Clientes Totales</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in clickable-card" style="animation-delay: 0.2s" 
             data-bs-toggle="modal" data-bs-target="#modalTiposEvento">
            <div class="text-center">
                <i class="bi bi-heart-fill stat-icon"></i>
                <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                <div class="stat-label">Tipos de Eventos</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in clickable-card" style="animation-delay: 0.3s" 
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
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card animate-fade-in clickable-card" style="animation-delay: 0.4s" 
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
            <a href="admin.php?tab=clientes" class="btn btn-primary btn-sm">
                <i class="bi bi-eye"></i> Ver Todos
            </a>
            <button class="btn btn-outline-secondary btn-sm" onclick="resetSort()" title="Restablecer orden">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['clientes_dashboard'])): ?>
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-info-circle display-6 d-block mb-3"></i>
            <h5>No hay clientes registrados</h5>
            <p class="mb-0">Comienza agregando tu primer cliente.</p>
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
                        <tr>
                            <!-- ID -->
                            <td data-sort="<?php echo $cliente['id']; ?>">
                                <span class="badge bg-dark">#<?php echo $cliente['id']; ?></span>
                            </td>
                            <!-- Nombre -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>">
                                <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                            </td>
                            <!-- Email -->
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>">
                                <?php echo $cliente['correo']; ?>
                            </td>
                            <!-- Teléfono -->
                            <td data-sort="<?php echo $cliente['telefono']; ?>">
                                <?php echo $cliente['telefono']; ?>
                            </td>
                            <!-- Tipo Evento -->
                            <td data-sort="<?php echo $cliente['tipo_boda']; ?>">
                                <?php 
                                $badge_class = 'badge-' . $cliente['tipo_boda'];
                                $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
                                ?>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $tipo_text; ?>
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
                                <i class="bi <?php echo $icon; ?> <?php echo $color; ?>"></i>
                                <?php echo $fecha_evento; ?>
                            </td>
                            <!-- Registro -->
                            <td data-sort="<?php echo $cliente['fecha_registro']; ?>">
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <small class="text-muted">
                <i class="bi bi-info-circle"></i> 
                Haz clic en cualquier encabezado para ordenar la tabla.
                <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<style>
.sort-icon {
    font-size: 12px;
    margin-left: 5px;
    opacity: 0.6;
    display: inline-block;
    transition: transform 0.3s;
}

.sort-asc .sort-icon {
    opacity: 1;
    color: #0d6efd;
}

.sort-desc .sort-icon {
    opacity: 1;
    color: #0d6efd;
    transform: rotate(180deg);
}

.table th {
    position: relative;
    user-select: none;
}

.table th:hover {
    background-color: rgba(0,0,0,0.03);
}
</style>

<script>
// Variables globales para el ordenamiento
let currentSortColumn = 0;
let currentSortDirection = 'asc'; // 'asc' o 'desc'
let originalData = [];

// Guardar los datos originales al cargar
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('clientesDashboard');
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

// Búsqueda simple
function searchTable() {
    const input = document.getElementById('searchDashboard');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('clientesDashboard');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let show = false;
        const cells = row.querySelectorAll('td');
        
        cells.forEach((cell, index) => {
            // No buscar en la columna de acciones (si existe)
            if (index !== 7) { // Ajusta según tus columnas
                if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                    show = true;
                }
            }
        });
        
        row.style.display = show ? '' : 'none';
    });
}
</script>