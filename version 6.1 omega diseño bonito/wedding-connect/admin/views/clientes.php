<?php
// admin/views/clientes.php - Vista de clientes CORREGIDA
?>
<div class="table-container-nuevo animate-nuevo">
    <div class="table-header-nuevo">
        <div>
            <h4><i class="bi bi-people-heart"></i> Gestión de Clientes</h4>
            <small class="text-muted">Registros totales: <?php echo count($datos['clientes']); ?></small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-primary-nuevo" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus"></i> Nuevo Cliente
            </button>
            <button class="btn btn-outline-nuevo" id="exportExcel" onclick="exportarClientesExcel()">
                <i class="bi bi-file-earmark-excel"></i> Exportar
            </button>
            <button class="btn btn-outline-nuevo" id="printTable" onclick="imprimirTablaClientes()">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['clientes'])): ?>
        <div class="text-center py-5" style="background: rgba(155, 135, 184, 0.05); border-radius: var(--radius-md);">
            <i class="bi bi-heart display-1" style="color: var(--primary);"></i>
            <h5 class="mt-3" style="color: var(--primary-dark);">No hay clientes registrados</h5>
            <button class="btn btn-primary-nuevo mt-3" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Agregar Primer Cliente
            </button>
        </div>
    <?php else: ?>
        <div class="table-responsive-nuevo">
            <table class="table-nuevo" id="clientesTable">
                <thead>
                    <tr>
                        <th onclick="ordenarTablaClientes(0)" style="cursor: pointer;">ID <span id="iconoC0">⇅</span></th>
                        <th onclick="ordenarTablaClientes(1)" style="cursor: pointer;">Nombre <span id="iconoC1">⇅</span></th>
                        <th onclick="ordenarTablaClientes(2)" style="cursor: pointer;">Email <span id="iconoC2">⇅</span></th>
                        <th onclick="ordenarTablaClientes(3)" style="cursor: pointer;">Teléfono <span id="iconoC3">⇅</span></th>
                        <th onclick="ordenarTablaClientes(4)" style="cursor: pointer;">Tipo Evento <span id="iconoC4">⇅</span></th>
                        <th onclick="ordenarTablaClientes(5)" style="cursor: pointer;">Fecha Evento <span id="iconoC5">⇅</span></th>
                        <th onclick="ordenarTablaClientes(6)" style="cursor: pointer;">Registro <span id="iconoC6">⇅</span></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['clientes'] as $cliente): ?>
                        <tr data-id="<?php echo $cliente['id']; ?>" data-nombre="<?php echo htmlspecialchars($cliente['nombre']); ?>" data-correo="<?php echo $cliente['correo']; ?>" data-telefono="<?php echo $cliente['telefono']; ?>" data-tipo="<?php echo $cliente['tipo_evento_id']; ?>" data-fecha="<?php echo $cliente['fecha_evento']; ?>" data-mensaje="<?php echo htmlspecialchars($cliente['mensaje'] ?? ''); ?>">
                            <td data-sort="<?php echo $cliente['id']; ?>"><span class="badge badge-primary-nuevo">#<?php echo $cliente['id']; ?></span></td>
                            <td data-sort="<?php echo strtolower(htmlspecialchars($cliente['nombre'])); ?>">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-nuevo me-2" style="width: 30px; height: 30px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="color: white; font-size: 0.9rem;"></i>
                                    </div>
                                    <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                </div>
                            </td>
                            <td data-sort="<?php echo strtolower($cliente['correo']); ?>">
                                <a href="mailto:<?php echo $cliente['correo']; ?>" class="text-decoration-none" style="color: var(--dark);">
                                    <i class="bi bi-envelope me-1" style="color: var(--primary);"></i><?php echo $cliente['correo']; ?>
                                </a>
                            </td>
                            <td data-sort="<?php echo $cliente['telefono']; ?>">
                                <a href="tel:<?php echo $cliente['telefono']; ?>" class="text-decoration-none" style="color: var(--dark);">
                                    <i class="bi bi-telephone me-1" style="color: var(--primary);"></i><?php echo $cliente['telefono']; ?>
                                </a>
                            </td>
                            <td data-sort="<?php echo strtolower($cliente['tipo_nombre']); ?>">
                                <?php 
                                $badge_class = 'badge-primary-nuevo';
                                if (stripos($cliente['tipo_nombre'], 'civil') !== false) {
                                    $badge_class = 'badge-warning-nuevo';
                                } elseif (stripos($cliente['tipo_nombre'], 'religiosa') !== false) {
                                    $badge_class = 'badge-success-nuevo';
                                } elseif (stripos($cliente['tipo_nombre'], 'playa') !== false) {
                                    $badge_class = 'badge-info';
                                }
                                ?>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $cliente['tipo_nombre']; ?>
                                </span>
                            </td>
                            <td data-sort="<?php echo $cliente['fecha_evento']; ?>"><?php echo date('d/m/Y', strtotime($cliente['fecha_evento'])); ?></td>
                            <td data-sort="<?php echo $cliente['fecha_registro']; ?>"><small><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></small></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-nuevo" 
                                            onclick="verDetallesCliente(<?php echo $cliente['id']; ?>)"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-nuevo btn-editar" 
                                            onclick="editarCliente(<?php echo $cliente['id']; ?>)"
                                            title="Editar cliente">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="mailto:<?php echo $cliente['correo']; ?>" 
                                       class="btn btn-outline-nuevo"
                                       title="Enviar email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    <a href="admin.php?eliminar=<?php echo $cliente['id']; ?>&tab=clientes" 
                                       class="btn btn-outline-danger btn-eliminar"
                                       onclick="return confirm('¿Eliminar a <?php echo addslashes($cliente['nombre']); ?>?')"
                                       title="Eliminar cliente">
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
                <i class="bi bi-info-circle"></i> Haz clic en cualquier encabezado para ordenar. 
                <span class="ms-2"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script src="../../assets/js/views-panel.js"></script>

