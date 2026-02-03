<?php
// admin/views/clientes.php - Vista de clientes NORMALIZADA
?>

<!-- CONTENIDO DE CLIENTES -->
<div class="table-container animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-0" style="color: var(--wedding-burgundy); font-family: 'Playfair Display', serif;">
                <i class="bi bi-people-heart"></i> Gestión de Clientes
            </h4>
            <small class="text-muted">Registros totales: <?php echo count($datos['clientes']); ?></small>
        </div>
        <div class="btn-group flex-wrap gap-2">
            <button class="btn btn-admin me-2 pulse" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </button>
            <button class="btn btn-outline-wedding me-2" id="exportExcel">
                <i class="bi bi-file-earmark-excel"></i> Exportar
            </button>
            <button class="btn btn-outline-wedding pulse" id="printTable">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['clientes'])): ?>
        <div class="alert alert-wedding text-center py-5" style="background: rgba(212, 175, 55, 0.1); border-color: var(--wedding-gold);">
            <i class="bi bi-heart display-6 d-block mb-3" style="color: var(--wedding-rose);"></i>
            <h5 style="color: var(--wedding-burgundy);">No hay clientes registrados</h5>
            <p class="mb-0">Comienza agregando tu primer cliente.</p>
            <button class="btn btn-admin mt-3 pulse" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Agregar Primer Cliente
            </button>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="clientesTable">
                <thead class="table-light" style="background: linear-gradient(135deg, var(--wedding-ivory) 0%, #f5f0e6 100%);">
                    <tr>
                        <th onclick="sortClientesTable(0)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            ID <span id="sortIconC0" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(1)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-person"></i> Nombre <span id="sortIconC1" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(2)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-envelope"></i> Email <span id="sortIconC2" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(3)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-telephone"></i> Teléfono <span id="sortIconC3" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(4)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-heart"></i> Tipo Evento <span id="sortIconC4" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(5)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-calendar"></i> Fecha Evento <span id="sortIconC5" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(6)" style="cursor: pointer; color: var(--wedding-burgundy);">
                            <i class="bi bi-clock"></i> Registro <span id="sortIconC6" class="sort-icon">⇅</span>
                        </th>
                        <th style="color: var(--wedding-burgundy);">
                            <i class="bi bi-gear"></i> Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes'] as $cliente): ?>
                        <tr style="border-left: 3px solid var(--wedding-gold);" data-fecha-event="<?php echo $cliente['fecha_evento']; ?>">
                            <!-- ID -->
                            <td data-sort="<?php echo $cliente['id']; ?>">
                                <span class="badge" style="background: var(--wedding-gold); color: white;">
                                    #<?php echo $cliente['id']; ?>
                                </span>
                            </td>
                            <!-- Nombre -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>">
                                <div class="d-flex align-items-center">
                                    <div class="client-avatar me-2" style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--wedding-rose) 0%, #f5d0d4 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="color: var(--wedding-burgundy); font-size: 0.8rem;"></i>
                                    </div>
                                    <div>
                                        <strong style="color: var(--wedding-burgundy);"><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                        <?php if ($cliente['mensaje']): ?>
                                            <br>
                                            <button class="btn btn-link btn-sm p-0 text-decoration-none" 
                                                    data-bs-toggle="tooltip" 
                                                    title="<?php echo htmlspecialchars(substr($cliente['mensaje'], 0, 100)); ?>..."
                                                    style="color: var(--wedding-gold);">
                                                <small>
                                                    <i class="bi bi-chat-left-heart"></i> Ver mensaje
                                                </small>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <!-- Email -->
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>">
                                <div class="d-flex align-items-center">
                                    <a href="mailto:<?php echo $cliente['correo']; ?>" class="text-decoration-none" style="color: var(--wedding-burgundy);">
                                        <i class="bi bi-envelope me-1"></i><?php echo $cliente['correo']; ?>
                                    </a>
                                    <button class="btn btn-sm btn-outline-wedding btn-copiar-email ms-1" 
                                            data-email="<?php echo $cliente['correo']; ?>"
                                            title="Copiar email">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            <!-- Teléfono -->
                            <td data-sort="<?php echo $cliente['telefono']; ?>">
                                <a href="tel:<?php echo $cliente['telefono']; ?>" class="text-decoration-none" style="color: var(--wedding-burgundy);">
                                    <i class="bi bi-telephone me-1"></i><?php echo $cliente['telefono']; ?>
                                </a>
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
                                } elseif (stripos($cliente['tipo_nombre'], 'lujo') !== false) {
                                    $badge_class = 'bg-danger';
                                } else {
                                    $badge_class = 'bg-secondary';
                                }
                                ?>
                                <span class="badge <?php echo $badge_class; ?>" data-tipo-id="<?php echo $cliente['tipo_evento_id']; ?>">
                                    <i class="bi bi-heart me-1"></i><?php echo $tipo_text; ?>
                                </span>
                            </td>
                            <!-- Fecha Evento -->
                            <td data-sort="<?php echo $cliente['fecha_evento']; ?>">
                                <?php 
                                $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                                $hoy = date('Y-m-d');
                                if ($cliente['fecha_evento'] < $hoy) {
                                    $icon = 'bi-check-circle';
                                    $color = 'text-success';
                                    $estado = 'Completado';
                                } elseif ($cliente['fecha_evento'] == $hoy) {
                                    $icon = 'bi-star';
                                    $color = 'text-warning';
                                    $estado = '¡Hoy!';
                                } else {
                                    $icon = 'bi-calendar-heart';
                                    $color = 'text-primary';
                                    $estado = 'Programado';
                                }
                                ?>
                                <div class="d-flex align-items-center">
                                    <i class="bi <?php echo $icon; ?> <?php echo $color; ?> me-2"></i>
                                    <div>
                                        <div><?php echo $fecha_evento; ?></div>
                                        <small class="text-muted"><?php echo $estado; ?></small>
                                    </div>
                                </div>
                            </td>
                            <!-- Registro -->
                            <td data-sort="<?php echo $cliente['fecha_registro']; ?>">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-plus me-1"></i>
                                    <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                                </small>
                            </td>
                            <!-- Acciones -->
                            <td data-no-sort="true">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-wedding me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalCliente<?php echo $cliente['id']; ?>"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    <button class="btn btn-outline-wedding me-1 btn-editar" 
                                            data-id="<?php echo $cliente['id']; ?>"
                                            title="Editar Cliente">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <a href="mailto:<?php echo $cliente['correo']; ?>" 
                                       class="btn btn-outline-wedding me-1" title="Enviar email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    
                                    <a href="admin.php?eliminar=<?php echo $cliente['id']; ?>&tab=clientes" 
                                       class="btn btn-outline-danger btn-eliminar"
                                       title="Eliminar"
                                       onclick="return confirm('¿Estás segura de eliminar a <?php echo addslashes($cliente['nombre']); ?>?')">
                                        <i class="bi bi-trash"></i>
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
                Haz clic en cualquier encabezado para ordenar la tabla.
                <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<!-- Ventana de impresión estilizada (oculta) -->
<div id="printContent" style="display: none;">
    <div style="padding: 20px; font-family: 'Arial', sans-serif;">
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #d4af37; padding-bottom: 15px;">
            <h1 style="color: #8B4513; font-family: 'Georgia', serif; margin: 0;">
                <i class="bi bi-heart" style="color: #e6b0aa;"></i> Wedding Connect
            </h1>
            <h2 style="color: #8B4513; margin: 10px 0 5px 0;">Lista de Clientes</h2>
            <p style="color: #666; margin: 0;">
                Fecha de impresión: <?php echo date('d/m/Y H:i:s'); ?> | 
                Total de clientes: <?php echo count($datos['clientes']); ?>
            </p>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: linear-gradient(135deg, #f5f0e6 0%, #e8dfc8 100%);">
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">ID</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Nombre</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Email</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Teléfono</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Tipo Evento</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Fecha Evento</th>
                    <th style="padding: 12px; border: 1px solid #d4af37; color: #8B4513; text-align: left;">Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['clientes'] as $cliente): ?>
                    <tr style="border-bottom: 1px solid #eee; border-left: 4px solid #d4af37;">
                        <td style="padding: 10px; border: 1px solid #eee;">
                            <span style="background: #d4af37; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">
                                #<?php echo $cliente['id']; ?>
                            </span>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee; color: #8B4513;">
                            <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee;">
                            <?php echo $cliente['correo']; ?>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee;">
                            <?php echo $cliente['telefono']; ?>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee;">
                            <?php 
                            $badge_color = '#6c757d'; // Default gris
                            if (stripos($cliente['tipo_nombre'], 'civil') !== false) {
                                $badge_color = '#ffc107'; // Amarillo
                            } elseif (stripos($cliente['tipo_nombre'], 'religiosa') !== false) {
                                $badge_color = '#198754'; // Verde
                            } elseif (stripos($cliente['tipo_nombre'], 'playa') !== false) {
                                $badge_color = '#0dcaf0'; // Azul claro
                            } elseif (stripos($cliente['tipo_nombre'], 'lujo') !== false) {
                                $badge_color = '#dc3545'; // Rojo
                            }
                            ?>
                            <span style="background: <?php echo $badge_color; ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">
                                <?php echo $cliente['tipo_nombre']; ?>
                            </span>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee;">
                            <?php 
                            $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                            $hoy = date('Y-m-d');
                            $estado = 'Programado';
                            if ($cliente['fecha_evento'] < $hoy) {
                                $estado = 'Completado';
                            } elseif ($cliente['fecha_evento'] == $hoy) {
                                $estado = '¡Hoy!';
                            }
                            ?>
                            <div><?php echo $fecha_evento; ?></div>
                            <small style="color: #666;"><?php echo $estado; ?></small>
                        </td>
                        <td style="padding: 10px; border: 1px solid #eee; color: #666;">
                            <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 30px; padding-top: 15px; border-top: 2px solid #d4af37; text-align: center; color: #666; font-size: 0.9em;">
            <p>Wedding Connect - Sistema de Gestión de Bodas</p>
            <p>Impreso el: <?php echo date('d/m/Y H:i:s'); ?></p>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 10px;">
                <div style="width: 20px; height: 20px; background: #d4af37; border-radius: 50%;"></div>
                <div style="width: 20px; height: 20px; background: #e6b0aa; border-radius: 50%;"></div>
                <div style="width: 20px; height: 20px; background: #8B4513; border-radius: 50%;"></div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printContent, #printContent * {
            visibility: visible;
        }
        #printContent {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<script>
// Variables para ordenamiento de clientes
let currentClientesSortColumn = 0;
let currentClientesSortDirection = 'asc';

// Función para ordenar tabla de clientes
function sortClientesTable(columnIndex) {
    const table = document.getElementById('clientesTable');
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
    if (currentClientesSortColumn === columnIndex) {
        currentClientesSortDirection = currentClientesSortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        currentClientesSortColumn = columnIndex;
        currentClientesSortDirection = 'asc';
    }
    
    // Actualizar icono
    const currentHeader = headers[columnIndex];
    currentHeader.classList.add(currentClientesSortDirection === 'asc' ? 'sort-asc' : 'sort-desc');
    const currentIcon = currentHeader.querySelector('.sort-icon');
    if (currentIcon) {
        currentIcon.textContent = currentClientesSortDirection === 'asc' ? '↑' : '↓';
    }
    
    // Ordenar filas
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelectorAll('td')[columnIndex];
        const cellB = rowB.querySelectorAll('td')[columnIndex];
        
        // Verificar si es columna no ordenable
        if (cellA && cellA.getAttribute('data-no-sort') === 'true') {
            return 0;
        }
        
        let valueA = cellA ? (cellA.getAttribute('data-sort') || cellA.textContent.trim()) : '';
        let valueB = cellB ? (cellB.getAttribute('data-sort') || cellB.textContent.trim()) : '';
        
        // Convertir a números si es posible
        if (!isNaN(valueA) && !isNaN(valueB)) {
            valueA = parseFloat(valueA);
            valueB = parseFloat(valueB);
        }
        // Convertir fechas si es posible
        else if (isDate(valueA) && isDate(valueB)) {
            valueA = new Date(valueA).getTime();
            valueB = new Date(valueB).getTime();
        } else {
            // Para texto, convertir a minúsculas
            valueA = valueA.toString().toLowerCase();
            valueB = valueB.toString().toLowerCase();
        }
        
        // Comparar según dirección
        if (currentClientesSortDirection === 'asc') {
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
    const date = new Date(value);
    return !isNaN(date.getTime());
}

// Función para exportar a Excel
function exportClientesToExcel() {
    const table = document.getElementById('clientesTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach((cell, index) => {
            // Omitir columna de acciones (última columna)
            if (index !== cells.length - 1) {
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
    link.setAttribute('download', 'clientes_wedding_connect_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Función para imprimir versión estilizada
function printClientesTable() {
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Clientes - Wedding Connect</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 20px;
                    background: #fff;
                }
                .print-header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 3px solid #d4af37;
                    padding-bottom: 15px;
                }
                .print-title {
                    color: #8B4513;
                    font-family: 'Georgia', serif;
                    margin: 0;
                    font-size: 24px;
                }
                .print-subtitle {
                    color: #8B4513;
                    margin: 10px 0 5px 0;
                    font-size: 18px;
                }
                .print-info {
                    color: #666;
                    margin: 0;
                    font-size: 14px;
                }
                .print-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                .print-table thead {
                    background: linear-gradient(135deg, #f5f0e6 0%, #e8dfc8 100%);
                }
                .print-table th {
                    padding: 12px;
                    border: 1px solid #d4af37;
                    color: #8B4513;
                    text-align: left;
                    font-weight: bold;
                }
                .print-table td {
                    padding: 10px;
                    border: 1px solid #eee;
                }
                .badge-print {
                    background: #d4af37;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 0.9em;
                }
                .event-badge {
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 0.9em;
                    display: inline-block;
                }
                .print-footer {
                    margin-top: 30px;
                    padding-top: 15px;
                    border-top: 2px solid #d4af37;
                    text-align: center;
                    color: #666;
                    font-size: 0.9em;
                }
                .color-dots {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin-top: 10px;
                }
                .color-dot {
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                }
                .row-border {
                    border-left: 4px solid #d4af37;
                }
                .status-text {
                    color: #666;
                    font-size: 0.85em;
                }
                @media print {
                    body {
                        padding: 0;
                    }
                    .print-table {
                        font-size: 12px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1 class="print-title">💍 Wedding Connect</h1>
                <h2 class="print-subtitle">Lista de Clientes</h2>
                <p class="print-info">
                    Fecha de impresión: ${new Date().toLocaleDateString('es-ES', { 
                        day: '2-digit', 
                        month: '2-digit', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })} | 
                    Total de clientes: ${<?php echo count($datos['clientes']); ?>}
                </p>
            </div>
            
            <table class="print-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Tipo Evento</th>
                        <th>Fecha Evento</th>
                        <th>Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes'] as $cliente): ?>
                        <tr class="row-border">
                            <td>
                                <span class="badge-print">#<?php echo $cliente['id']; ?></span>
                            </td>
                            <td style="color: #8B4513;">
                                <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                            </td>
                            <td><?php echo $cliente['correo']; ?></td>
                            <td><?php echo $cliente['telefono']; ?></td>
                            <td>
                                <?php 
                                $badge_color = '#6c757d';
                                if (stripos($cliente['tipo_nombre'], 'civil') !== false) {
                                    $badge_color = '#ffc107';
                                } elseif (stripos($cliente['tipo_nombre'], 'religiosa') !== false) {
                                    $badge_color = '#198754';
                                } elseif (stripos($cliente['tipo_nombre'], 'playa') !== false) {
                                    $badge_color = '#0dcaf0';
                                } elseif (stripos($cliente['tipo_nombre'], 'lujo') !== false) {
                                    $badge_color = '#dc3545';
                                }
                                ?>
                                <span class="event-badge" style="background: <?php echo $badge_color; ?>;">
                                    <?php echo $cliente['tipo_nombre']; ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $fecha_evento = date('d/m/Y', strtotime($cliente['fecha_evento']));
                                $hoy = date('Y-m-d');
                                $estado = 'Programado';
                                if ($cliente['fecha_evento'] < $hoy) {
                                    $estado = 'Completado';
                                } elseif ($cliente['fecha_evento'] == $hoy) {
                                    $estado = '¡Hoy!';
                                }
                                ?>
                                <div><?php echo $fecha_evento; ?></div>
                                <span class="status-text"><?php echo $estado; ?></span>
                            </td>
                            <td class="status-text">
                                <?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="print-footer">
                <p>Wedding Connect - Sistema de Gestión de Bodas</p>
                <p>Impreso el: ${new Date().toLocaleDateString('es-ES', { 
                    day: '2-digit', 
                    month: '2-digit', 
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })}</p>
                <div class="color-dots">
                    <div class="color-dot" style="background: #d4af37;"></div>
                    <div class="color-dot" style="background: #e6b0aa;"></div>
                    <div class="color-dot" style="background: #8B4513;"></div>
                </div>
            </div>
            
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 1000);
                };
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
}

// Función para manejar el botón de editar
document.addEventListener('DOMContentLoaded', function() {
    // Botones de editar cliente
    const editButtons = document.querySelectorAll('.btn-editar');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const clientId = this.getAttribute('data-id');
            
            // Buscar la fila del cliente
            const row = this.closest('tr');
            if (!row) return;
            
            // Obtener datos de las celdas
            const cells = row.querySelectorAll('td');
            
            // Extraer datos
            const nombre = cells[1]?.querySelector('strong')?.textContent?.trim() || '';
            const emailLink = cells[2]?.querySelector('a[href^="mailto:"]');
            const email = emailLink ? emailLink.textContent.trim() : '';
            const telefonoLink = cells[3]?.querySelector('a[href^="tel:"]');
            const telefono = telefonoLink ? telefonoLink.textContent.trim() : '';
            const tipoBadge = cells[4]?.querySelector('.badge');
            const tipoEventoId = tipoBadge ? tipoBadge.getAttribute('data-tipo-id') : '';
            const fechaEvento = row.getAttribute('data-fecha-event') || '';
            
            // Extraer mensaje del tooltip
            let mensaje = '';
            const mensajeButton = cells[1]?.querySelector('button[data-bs-toggle="tooltip"]');
            if (mensajeButton) {
                mensaje = mensajeButton.getAttribute('title') || '';
                // Limpiar el mensaje
                mensaje = mensaje.replace('...', '').trim();
            }
            
            // Rellenar el modal de edición
            document.getElementById('editar_cliente_id').value = clientId;
            document.getElementById('editar_nombre').value = nombre;
            document.getElementById('editar_correo').value = email;
            document.getElementById('editar_telefono').value = telefono;
            
            // Establecer el tipo de evento
            const selectTipo = document.getElementById('editar_tipo_evento_id');
            if (selectTipo && tipoEventoId) {
                selectTipo.value = tipoEventoId;
            }
            
            // Formatear fecha para el input date
            if (fechaEvento) {
                const fecha = new Date(fechaEvento);
                const fechaFormateada = fecha.toISOString().split('T')[0];
                document.getElementById('editar_fecha_evento').value = fechaFormateada;
            }
            
            // Establecer mensaje
            document.getElementById('editar_mensaje').value = mensaje;
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
            modal.show();
        });
    });
    
    // Configurar botón de exportar a Excel
    document.getElementById('exportExcel')?.addEventListener('click', function() {
        exportClientesToExcel();
    });
    
    // Configurar botón de imprimir
    document.getElementById('printTable')?.addEventListener('click', function() {
        printClientesTable();
    });
    
    // Configurar botones de copiar email
    const copyEmailButtons = document.querySelectorAll('.btn-copiar-email');
    copyEmailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const email = this.getAttribute('data-email');
            navigator.clipboard.writeText(email).then(() => {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-wedding');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-wedding');
                }, 2000);
            });
        });
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