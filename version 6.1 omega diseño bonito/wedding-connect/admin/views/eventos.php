<?php
// admin/views/eventos.php - Vista de eventos CORREGIDA
?>
<!-- Estadísticas de eventos -->
<div class="stats-grid-nuevo">
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar4-event"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $datos['eventos_stats']['total_eventos'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Total Eventos</div>
    </div>
    
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar-heart"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $datos['eventos_stats']['eventos_futuros'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Eventos Futuros</div>
    </div>
    
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar-day"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero">
            <?php 
            $hoy = date('Y-m-d');
            $eventos_hoy = 0;
            foreach ($datos['eventos'] as $evento) {
                if (date('Y-m-d', strtotime($evento['fecha_evento'])) == $hoy) $eventos_hoy++;
            }
            echo $eventos_hoy;
            ?>
        </div>
        <div class="stat-label-nuevo">Eventos Hoy</div>
    </div>
    
    <div class="stat-card-nuevo">
        <div class="stat-icon-nuevo">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-number-nuevo estadistica-numero"><?php echo $datos['eventos_stats']['eventos_pasados'] ?? 0; ?></div>
        <div class="stat-label-nuevo">Eventos Pasados</div>
    </div>
</div>

<!-- Tabla de eventos -->
<div class="table-container-nuevo animate-nuevo">
    <div class="table-header-nuevo">
        <div>
            <h4><i class="bi bi-calendar-heart"></i> Calendario de Eventos</h4>
            <small class="text-muted">Próximos eventos ordenados por fecha</small>
        </div>
        
        <!-- FILTROS DE EVENTOS -->
        <div class="btn-group flex-wrap gap-2" role="group" id="filtrosEventos">
            <button class="btn btn-outline-nuevo active" onclick="filtrarEventos('todos')">
                <i class="bi bi-grid"></i> Todos
            </button>
            <button class="btn btn-outline-nuevo" onclick="filtrarEventos('proximo')">
                <i class="bi bi-clock"></i> Próximos
            </button>
            <button class="btn btn-outline-nuevo" onclick="filtrarEventos('hoy')">
                <i class="bi bi-star"></i> Hoy
            </button>
            <button class="btn btn-outline-nuevo" onclick="filtrarEventos('completado')">
                <i class="bi bi-check-circle"></i> Completados
            </button>
        </div>
    </div>
    
    <?php if (empty($datos['eventos'])): ?>
        <div class="text-center py-5" style="background: rgba(155, 135, 184, 0.05); border-radius: var(--radius-md);">
            <i class="bi bi-calendar-x display-1" style="color: var(--primary);"></i>
            <h5 class="mt-3" style="color: var(--primary-dark);">No hay eventos programados</h5>
        </div>
    <?php else: ?>
        <div class="table-responsive-nuevo">
            <table class="table-nuevo" id="eventosTable">
                <thead>
                    <tr>
                        <th onclick="ordenarTablaEventos(0)" style="cursor: pointer;">Fecha <span id="iconoE0">⇅</span></th>
                        <th onclick="ordenarTablaEventos(1)" style="cursor: pointer;">Cliente <span id="iconoE1">⇅</span></th>
                        <th onclick="ordenarTablaEventos(2)" style="cursor: pointer;">Contacto <span id="iconoE2">⇅</span></th>
                        <th onclick="ordenarTablaEventos(3)" style="cursor: pointer;">Tipo <span id="iconoE3">⇅</span></th>
                        <th onclick="ordenarTablaEventos(4)" style="cursor: pointer;">Días Restantes <span id="iconoE4">⇅</span></th>
                        <th onclick="ordenarTablaEventos(5)" style="cursor: pointer;">Estado <span id="iconoE5">⇅</span></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['eventos'] as $evento): 
                        $fecha_evento = new DateTime($evento['fecha_evento']);
                        $hoy = new DateTime();
                        $hoy->setTime(0, 0, 0);
                        $fecha_evento_solo = clone $fecha_evento;
                        $fecha_evento_solo->setTime(0, 0, 0);
                        $diferencia = $hoy->diff($fecha_evento_solo);
                        $dias_restantes = $diferencia->days;
                        
                        if ($fecha_evento_solo < $hoy) {
                            $estado = 'completado';
                            $badge = 'badge-success-nuevo';
                            $icon = 'bi-check-circle';
                            $estado_texto = 'Completado';
                            $dias_sort = -1;
                        } elseif ($fecha_evento_solo == $hoy) {
                            $estado = 'hoy';
                            $badge = 'badge-warning-nuevo';
                            $icon = 'bi-star';
                            $estado_texto = 'Hoy';
                            $dias_sort = 0;
                        } elseif ($dias_restantes <= 7) {
                            $estado = 'proximo';
                            $badge = 'badge-danger-nuevo';
                            $icon = 'bi-clock';
                            $estado_texto = 'Próximo';
                            $dias_sort = $dias_restantes;
                        } else {
                            $estado = 'programado';
                            $badge = 'badge-primary-nuevo';
                            $icon = 'bi-calendar-heart';
                            $estado_texto = 'Programado';
                            $dias_sort = $dias_restantes;
                        }
                        
                        // Generar enlace para Google Calendar
                        $fecha_inicio = date('Ymd', strtotime($evento['fecha_evento']));
                        $fecha_fin = date('Ymd', strtotime($evento['fecha_evento'] . ' +1 day'));
                        $titulo = urlencode('Evento: ' . $evento['nombre']);
                        $descripcion = urlencode("Cliente: {$evento['nombre']}\nTeléfono: {$evento['telefono']}\nTipo: {$evento['tipo_nombre']}");
                        $google_calendar_url = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$titulo}&dates={$fecha_inicio}/{$fecha_fin}&details={$descripcion}";
                    ?>
                        <tr data-estado="<?php echo $estado; ?>" data-fecha="<?php echo $evento['fecha_evento']; ?>">
                            <td data-sort="<?php echo $evento['fecha_evento']; ?>"><strong><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></strong></td>
                            <td data-sort="<?php echo strtolower(htmlspecialchars($evento['nombre'])); ?>"><strong><?php echo htmlspecialchars($evento['nombre']); ?></strong></td>
                            <td data-sort="<?php echo strtolower($evento['correo']); ?>">
                                <div><i class="bi bi-envelope me-1" style="color: var(--primary);"></i><?php echo $evento['correo']; ?></div>
                                <div><i class="bi bi-telephone me-1" style="color: var(--primary);"></i><?php echo $evento['telefono']; ?></div>
                            </td>
                            <td data-sort="<?php echo strtolower($evento['tipo_nombre']); ?>"><span class="badge badge-primary-nuevo"><?php echo $evento['tipo_nombre']; ?></span></td>
                            <td data-sort="<?php echo $dias_sort; ?>">
                                <?php 
                                if ($estado == 'completado') echo 'Finalizado';
                                elseif ($estado == 'hoy') echo '<span class="text-warning fw-bold">¡HOY!</span>';
                                else echo $dias_restantes . ' días';
                                ?>
                            </td>
                            <td data-sort="<?php echo $estado; ?>">
                                <span class="badge <?php echo $badge; ?>"><i class="bi <?php echo $icon; ?>"></i> <?php echo $estado_texto; ?></span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-nuevo" 
                                            onclick="verDetallesCliente(<?php echo $evento['id']; ?>)"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="mailto:<?php echo $evento['correo']; ?>" 
                                       class="btn btn-outline-nuevo"
                                       title="Enviar email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    <a href="tel:<?php echo $evento['telefono']; ?>" 
                                       class="btn btn-outline-nuevo"
                                       title="Llamar">
                                        <i class="bi bi-telephone"></i>
                                    </a>
                                    <a href="<?php echo $google_calendar_url; ?>" 
                                       target="_blank"
                                       class="btn btn-outline-nuevo"
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
        
        <!-- LEYENDA -->
        <div class="mt-3 text-center">
            <small class="text-muted">
                <i class="bi bi-info-circle"></i> 
                <strong>Leyenda:</strong> 
                <span class="badge badge-danger-nuevo" style="margin: 0 5px;"><i class="bi bi-clock"></i> Próximo (≤ 7 días)</span> 
                <span class="badge badge-primary-nuevo" style="margin: 0 5px;"><i class="bi bi-calendar-heart"></i> Programado</span> 
                <span class="badge badge-success-nuevo" style="margin: 0 5px;"><i class="bi bi-check-circle"></i> Completado</span>
                <span class="badge badge-warning-nuevo" style="margin: 0 5px;"><i class="bi bi-star"></i> Hoy</span>
                <span class="ms-3"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script src="../../assets/js/views-panel.js"></script>
