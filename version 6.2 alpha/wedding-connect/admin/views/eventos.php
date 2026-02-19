<!-- admin/views/eventos.php - Vista de eventos CON BUSCADOR Y BOTÓN PROGRAMADO -->
<?php
// FORZAR ZONA HORARIA DE MÉXICO
date_default_timezone_set('America/Mexico_City');
// Obtener el mes actual para el calendario
$mes_actual_calendario = isset($_GET['mes_calendario']) ? (int)$_GET['mes_calendario'] : (int)date('n');
$ano_actual_calendario = isset($_GET['ano_calendario']) ? (int)$_GET['ano_calendario'] : (int)date('Y');

// Ajustar mes y año
if ($mes_actual_calendario < 1) {
    $mes_actual_calendario = 12;
    $ano_actual_calendario--;
} elseif ($mes_actual_calendario > 12) {
    $mes_actual_calendario = 1;
    $ano_actual_calendario++;
}

$nombre_meses = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
?>
<!-- estilos css -->
<link rel="stylesheet" href="../../assets/css/panel-nuevo.css">
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

<!-- CALENDARIO DE EVENTOS -->
<div class="table-container-nuevo animate-nuevo" style="margin-bottom: 30px;">
    <div class="table-header-nuevo">
        <div>
            <h4><i class="bi bi-calendar3"></i> Calendario Visual</h4>
            <small class="text-muted">Vista mensual de eventos programados</small>
        </div>
        
        <!-- Selector de mes -->
        <div class="mes-selector-nuevo">
            <a href="?tab=eventos&mes_calendario=<?php echo $mes_actual_calendario - 1; ?>&ano_calendario=<?php echo $ano_actual_calendario; ?>" 
               class="btn-mes-nuevo" title="Mes anterior">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h5 class="mes-actual-nuevo">
                <i class="bi bi-calendar-month"></i> 
                <?php echo $nombre_meses[$mes_actual_calendario - 1] . ' ' . $ano_actual_calendario; ?>
            </h5>
            <a href="?tab=eventos&mes_calendario=<?php echo $mes_actual_calendario + 1; ?>&ano_calendario=<?php echo $ano_actual_calendario; ?>" 
               class="btn-mes-nuevo" title="Mes siguiente">
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <div class="calendario-visual-nuevo">
        <?php
        // Calcular días del mes
        $primer_dia = new DateTime("$ano_actual_calendario-$mes_actual_calendario-01");
        $ultimo_dia = new DateTime("$ano_actual_calendario-$mes_actual_calendario-" . $primer_dia->format('t'));
        $dias_en_mes = $ultimo_dia->format('d');
        $dia_semana_inicio = (int)$primer_dia->format('N'); // 1 (Lunes) a 7 (Domingo)
        
        // Nombres de días
        $dias_semana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        ?>
        
        <!-- Días de la semana -->
        <div class="dias-semana-nuevo">
            <?php foreach ($dias_semana as $dia): ?>
                <div class="dia-semana-nuevo"><?php echo $dia; ?></div>
            <?php endforeach; ?>
        </div>
        
        <!-- Grid de días -->
        <div class="dias-grid-nuevo">
            <?php
            // Celdas vacías antes del primer día
            for ($i = 1; $i < $dia_semana_inicio; $i++):
            ?>
                <div class="dia-celda-nuevo dia-vacio"></div>
            <?php endfor; ?>
            
            <?php
            // Días del mes
            for ($dia = 1; $dia <= $dias_en_mes; $dia++):
                $fecha_actual = sprintf('%04d-%02d-%02d', $ano_actual_calendario, $mes_actual_calendario, $dia);
                $eventos_dia = array_filter($datos['eventos'], function($e) use ($fecha_actual) {
                    return substr($e['fecha_evento'], 0, 10) === $fecha_actual;
                });
                
                // Determinar clase especial para hoy
                $clase_hoy = ($fecha_actual === date('Y-m-d')) ? 'dia-hoy' : '';
                $tiene_eventos = !empty($eventos_dia) ? 'tiene-eventos' : '';
            ?>
                <div class="dia-celda-nuevo <?php echo $clase_hoy . ' ' . $tiene_eventos; ?>" data-fecha="<?php echo $fecha_actual; ?>">
                    <span class="dia-numero-nuevo"><?php echo $dia; ?></span>
                                      
                    <?php if (!empty($eventos_dia)): ?>
                        <div class="eventos-mini-nuevo">
                            <?php 
                            $contador = 0;
                            foreach ($eventos_dia as $evento): 
                                if ($contador >= 2) break; // Mostrar máximo 2 eventos
                                
                                // Calcular días restantes para determinar el color
                                $fecha_evento_dt = new DateTime($evento['fecha_evento']);
                                $hoy_dt = new DateTime();
                                $hoy_dt->setTime(0, 0, 0);
                                $fecha_evento_solo = clone $fecha_evento_dt;
                                $fecha_evento_solo->setTime(0, 0, 0);
                                $diferencia = $hoy_dt->diff($fecha_evento_solo);
                                $dias_restantes = $diferencia->days;
                                
                                // Determinar clase según estado (con rojo para próximos)
                                if ($fecha_evento_solo < $hoy_dt) {
                                    $estado_clase = 'evento-mini-completado'; // Verde
                                } elseif ($fecha_evento_solo == $hoy_dt) {
                                    $estado_clase = 'evento-mini-hoy'; // Amarillo
                                } elseif ($dias_restantes <= 7) {
                                    $estado_clase = 'evento-mini-proximo'; // Rojo (nueva clase)
                                } else {
                                    $estado_clase = 'evento-mini-programado'; // Lila
                                }
                                $contador++;
                            ?>
                                <div class="evento-mini <?php echo $estado_clase; ?>" 
                                    title="<?php echo htmlspecialchars($evento['nombre']); ?>">
                                    <i class="bi bi-circle-fill"></i>
                                    <span class="evento-mini-nombre"><?php echo htmlspecialchars($evento['nombre']); ?></span>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (count($eventos_dia) > 2): ?>
                                <div class="evento-mini mas-eventos">
                                    +<?php echo count($eventos_dia) - 2; ?> más
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
            
            <?php
            // Completar grid si es necesario
            $total_celdas = $dia_semana_inicio - 1 + $dias_en_mes;
            $celdas_restantes = 42 - $total_celdas; // 42 = 6 filas × 7 días
            if ($celdas_restantes > 0 && $celdas_restantes < 7):
                for ($i = 0; $i < $celdas_restantes; $i++):
            ?>
                <div class="dia-celda-nuevo dia-vacio"></div>
            <?php 
                endfor;
            endif;
            ?>
        </div>
    </div>
    
    <!-- Leyenda del calendario -->
    <div class="calendario-leyenda-nuevo">
        <div class="leyenda-item">
            <span class="leyenda-color" style="background: linear-gradient(135deg, var(--primary), var(--secondary));"></span>
            <span>Programado</span>
        </div>
        <div class="leyenda-item">
            <span class="leyenda-color" style="background: #f39c12;"></span>
            <span>Hoy</span>
        </div>
        <div class="leyenda-item">
            <span class="leyenda-color" style="background: #2ecc71;"></span>
            <span>Completado</span>
        </div>
        <div class="leyenda-item">
            <span class="leyenda-color" style="background: #e74c3c;"></span>
            <span>Próximo (≤7 días)</span>
        </div>
    </div>
</div>

<!-- Tabla de eventos (vista detallada) CON BUSCADOR Y BOTÓN PROGRAMADO -->
<div class="table-container-nuevo animate-nuevo">
    <div class="table-header-nuevo">
        <div>
            <h4><i class="bi bi-calendar-heart"></i> Lista Detallada de Eventos</h4>
            <small class="text-muted">Próximos eventos ordenados por fecha</small>
        </div>
        
        <!-- BUSCADOR Y FILTROS -->
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <!-- BUSCADOR -->
            <div class="input-group" style="width: 280px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search" style="color: var(--primary);"></i>
                </span>
                <input type="text" 
                       class="form-control border-start-0" 
                       id="buscadorEventos" 
                       placeholder="Buscar por cliente, email, teléfono o tipo..."
                       style="border-left: none;">
            </div>
            
            <!-- FILTROS DE EVENTOS (CON BOTÓN PROGRAMADO) -->
            <div class="btn-group flex-wrap gap-2" role="group" id="filtrosEventos">
                <button class="btn btn-outline-nuevo active" onclick="filtrarEventos('todos')">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="btn btn-outline-nuevo" onclick="filtrarEventos('programado')">
                    <i class="bi bi-calendar-heart"></i> Programado
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
    </div>
    
    <!-- CONTADOR DE RESULTADOS -->
    <div class="mb-2 text-muted small" id="resultadosBusquedaEventos">
        Mostrando <span id="mostrandoCountEventos"><?php echo count($datos['eventos']); ?></span> de <?php echo count($datos['eventos']); ?> eventos
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

                        // USAR LA MISMA ZONA HORARIA PARA AMBAS FECHAS
                        $hoy = new DateTime(); // Esto usará la zona horaria que forzamos
                        $hoy->setTime(0, 0, 0);

                        $fecha_evento_solo = clone $fecha_evento;
                        $fecha_evento_solo->setTime(0, 0, 0);
                        $diferencia = $hoy->diff($fecha_evento_solo);
                        $dias_restantes = $diferencia->days;
                        
                        // Determinar el signo de la diferencia
                        if ($fecha_evento_solo < $hoy) {
                            $dias_restantes = -$dias_restantes; // Negativo para eventos pasados
                        }

                        // determinar estado
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
                            $estado = 'proximo'; // ¡ASEGÚRATE QUE SEA EXACTAMENTE 'proximo'!
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
                        <tr data-estado="<?php echo $estado; ?>" data-fecha="<?php echo $evento['fecha_evento']; ?>"
                            data-cliente="<?php echo strtolower(htmlspecialchars($evento['nombre'])); ?>"
                            data-email="<?php echo strtolower($evento['correo']); ?>"
                            data-telefono="<?php echo $evento['telefono']; ?>"
                            data-tipo="<?php echo strtolower($evento['tipo_nombre']); ?>">
                            
                            <td data-sort="<?php echo $evento['fecha_evento']; ?>"><strong><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></strong></td>
                            <td data-sort="<?php echo strtolower(htmlspecialchars($evento['nombre'])); ?>" class="nombre-cliente-evento"><?php echo htmlspecialchars($evento['nombre']); ?></td>
                            <td data-sort="<?php echo strtolower($evento['correo']); ?>">
                                <div><i class="bi bi-envelope me-1" style="color: var(--primary);"></i><?php echo $evento['correo']; ?></div>
                                <div><i class="bi bi-telephone me-1" style="color: var(--primary);"></i><?php echo $evento['telefono']; ?></div>
                            </td>
                            <td data-sort="<?php echo strtolower($evento['tipo_nombre']); ?>" class="tipo-evento-evento"><?php echo $evento['tipo_nombre']; ?></td>
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
        
        <!-- MENSAJE SIN RESULTADOS (oculto por defecto) -->
        <div id="sinResultadosEventos" class="text-center py-4" style="display: none;">
            <i class="bi bi-search display-4" style="color: var(--primary);"></i>
            <h5 class="mt-3">No se encontraron eventos</h5>
            <p class="text-muted">Intenta con otros términos de búsqueda o filtros</p>
        </div>
        
        <!-- LEYENDA -->
        <div class="mt-3 text-center">
            <small class="text-muted">
                <i class="bi bi-info-circle"></i> 
                <strong>Leyenda:</strong> 
                <span class="badge badge-primary-nuevo" style="margin: 0 5px;"><i class="bi bi-calendar-heart"></i> Programado</span>
                <span class="badge badge-danger-nuevo" style="margin: 0 5px;"><i class="bi bi-clock"></i> Próximo (≤ 7 días)</span> 
                <span class="badge badge-success-nuevo" style="margin: 0 5px;"><i class="bi bi-check-circle"></i> Completado</span>
                <span class="badge badge-warning-nuevo" style="margin: 0 5px;"><i class="bi bi-star"></i> Hoy</span>
                <span class="ms-3"><i class="bi bi-arrow-up"></i> = Ascendente</span>
                <span class="ms-2"><i class="bi bi-arrow-down"></i> = Descendente</span>
            </small>
        </div>
    <?php endif; ?>
</div>

<script src="../../assets/js/views-panel.js"></script>