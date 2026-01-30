<?php
// admin/views/clientes.php - Vista de clientes
?>

<!-- CONTENIDO DE CLIENTES -->
<div class="table-container animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">
                <i class="bi bi-table"></i> Lista de Clientes
            </h4>
            <small class="text-muted">Registros totales: <?php echo count($datos['clientes']); ?></small>
        </div>
        <div class="btn-group">
            <button class="btn btn-success btn-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus"></i> Nuevo
            </button>
            <button class="btn btn-secondary btn-sm" id="exportExcel">
                <i class="bi bi-file-earmark-excel"></i> Exportar
            </button>
            <button class="btn btn-info btn-sm" id="printTable">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['clientes'])): ?>
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-info-circle display-6 d-block mb-3"></i>
            <h5>No hay clientes registrados</h5>
            <p class="mb-0">Comienza agregando tu primer cliente.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="clientesTable">
                <thead class="table-light">
                    <tr>
                        <th onclick="sortClientesTable(0)" style="cursor: pointer;">
                            ID <span id="sortIconC0" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(1)" style="cursor: pointer;">
                            Nombre <span id="sortIconC1" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(2)" style="cursor: pointer;">
                            Email <span id="sortIconC2" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(3)" style="cursor: pointer;">
                            Teléfono <span id="sortIconC3" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(4)" style="cursor: pointer;">
                            Tipo Evento <span id="sortIconC4" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(5)" style="cursor: pointer;">
                            Fecha Evento <span id="sortIconC5" class="sort-icon">⇅</span>
                        </th>
                        <th onclick="sortClientesTable(6)" style="cursor: pointer;">
                            Registro <span id="sortIconC6" class="sort-icon">⇅</span>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes'] as $cliente): ?>
                        <tr>
                            <!-- ID -->
                            <td data-sort="<?php echo $cliente['id']; ?>">
                                <span class="badge bg-dark">#<?php echo $cliente['id']; ?></span>
                            </td>
                            <!-- Nombre -->
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>">
                                <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                <?php if ($cliente['mensaje']): ?>
                                    <br>
                                    <button class="btn btn-link btn-sm p-0 text-decoration-none" 
                                            data-bs-toggle="tooltip" 
                                            title="<?php echo htmlspecialchars(substr($cliente['mensaje'], 0, 100)); ?>...">
                                        <small class="text-muted">
                                            <i class="bi bi-chat-left-text"></i> Ver mensaje
                                        </small>
                                    </button>
                                <?php endif; ?>
                            </td>
                            <!-- Email -->
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>">
                                <a href="mailto:<?php echo $cliente['correo']; ?>" class="text-decoration-none">
                                    <?php echo $cliente['correo']; ?>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary btn-copiar-email ms-1" 
                                        data-email="<?php echo $cliente['correo']; ?>"
                                        title="Copiar email">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </td>
                            <!-- Teléfono -->
                            <td data-sort="<?php echo $cliente['telefono']; ?>">
                                <a href="tel:<?php echo $cliente['telefono']; ?>" class="text-decoration-none">
                                    <?php echo $cliente['telefono']; ?>
                                </a>
                            </td>
                            <!-- Tipo Evento -->
                            <td data-sort="<?php echo $cliente['tipo_boda']; ?>">
                                <?php 
                                $badge_class = 'badge-' . $cliente['tipo_boda'];
                                $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
                                ?>
                                <span class="badge <?php echo $badge_class; ?>" data-tipo="<?php echo $cliente['tipo_boda']; ?>">
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
                            <!-- Acciones -->
                            <td data-no-sort="true">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalCliente<?php echo $cliente['id']; ?>"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    <button class="btn btn-warning btn-editar" 
                                            data-id="<?php echo $cliente['id']; ?>"
                                            title="Editar Cliente">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <a href="mailto:<?php echo $cliente['correo']; ?>" 
                                       class="btn btn-primary" title="Enviar email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    
                                    <a href="admin.php?eliminar=<?php echo $cliente['id']; ?>&tab=clientes" 
                                       class="btn btn-danger btn-eliminar"
                                       title="Eliminar"
                                       onclick="return confirm('¿Eliminar a <?php echo addslashes($cliente['nombre']); ?>?')">
                                        <i class="bi bi-trash"></i>
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
                Haz clic en cualquier encabezado para ordenar la tabla.
                <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script src="assets/js/panel.js"></script>