<?php
// admin/includes/modales.php - Todos los modales del sistema
?>

<!-- Modal para nuevo cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus"></i> Nuevo Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="guardar_cliente" value="1">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" name="nombre" required 
                                   placeholder="Ej: María García">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="correo" required 
                                   placeholder="maria@email.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" name="telefono" required 
                                   placeholder="555-123-4567">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Evento *</label>
                            <select class="form-select" name="tipo_evento" required>
                                <option value="">Seleccionar...</option>
                                <!-- Bodas -->
                                <optgroup label="🎭 Bodas">
                                    <option value="boda_civil">Boda Civil</option>
                                    <option value="boda_religiosa">Boda Religiosa</option>
                                    <option value="boda_destino">Boda Destino</option>
                                    <option value="boda_intima">Boda Íntima</option>
                                    <option value="boda_lujo">Boda de Lujo</option>
                                    <option value="boda_tematica">Boda Temática</option>
                                    <option value="boda_playa">Boda en Playa</option>
                                    <option value="boda_campo">Boda en Campo</option>
                                    <option value="boda_urbana">Boda Urbana</option>
                                    <option value="boda_vintage">Boda Vintage</option>
                                </optgroup>
                                <!-- XV Años -->
                                <optgroup label="👸 XV Años">
                                    <option value="xv_anos">XV Años Tradicional</option>
                                    <option value="xv_anos_tematica">XV Años Temático</option>
                                    <option value="xv_anos_lujo">XV Años de Lujo</option>
                                    <option value="xv_anos_intima">XV Años Íntimo</option>
                                </optgroup>
                                <!-- Baby Shower -->
                                <optgroup label="🎀 Baby Shower">
                                    <option value="baby_shower">Baby Shower</option>
                                    <option value="baby_shower_gender_reveal">Baby Shower (Gender Reveal)</option>
                                    <option value="baby_shower_tematica">Baby Shower Temático</option>
                                </optgroup>
                                <!-- Eventos Empresariales -->
                                <optgroup label="🏢 Eventos Empresariales">
                                    <option value="evento_empresarial">Evento Empresarial</option>
                                    <option value="convencion">Convención</option>
                                    <option value="lanzamiento_producto">Lanzamiento de Producto</option>
                                    <option value="conferencia">Conferencia</option>
                                    <option value="seminario">Seminario</option>
                                    <option value="team_building">Team Building</option>
                                    <option value="fiesta_navidad_empresa">Fiesta de Navidad Empresarial</option>
                                </optgroup>
                                <!-- Eventos Municipales -->
                                <optgroup label="🏛️ Eventos Municipales">
                                    <option value="evento_municipal">Evento Municipal</option>
                                    <option value="feria_local">Feria Local</option>
                                    <option value="festival_cultural">Festival Cultural</option>
                                    <option value="concierto_publico">Concierto Público</option>
                                    <option value="celebracion_aniversario_ciudad">Celebración Aniversario Ciudad</option>
                                    <option value="evento_deportivo_municipal">Evento Deportivo Municipal</option>
                                </optgroup>
                                <!-- Eventos del Año -->
                                <optgroup label="📅 Eventos del Año">
                                    <option value="cumpleanos">Cumpleaños</option>
                                    <option value="aniversario">Aniversario</option>
                                    <option value="graduacion">Graduación</option>
                                    <option value="bautizo">Bautizo</option>
                                    <option value="primera_comunion">Primera Comunión</option>
                                    <option value="despedida_soltero">Despedida de Soltero/a</option>
                                    <option value="fiesta_compromiso">Fiesta de Compromiso</option>
                                    <option value="renovacion_votos">Renovación de Votos</option>
                                    <option value="fiesta_halloween">Fiesta de Halloween</option>
                                    <option value="fiesta_navidad">Fiesta de Navidad</option>
                                    <option value="fiesta_ano_nuevo">Fiesta de Año Nuevo</option>
                                    <option value="fiesta_pascua">Fiesta de Pascua</option>
                                </optgroup>
                                <!-- Otros -->
                                <optgroup label="🎪 Otros Eventos">
                                    <option value="evento_religioso">Evento Religioso</option>
                                    <option value="evento_benefico">Evento Benéfico</option>
                                    <option value="evento_gala">Evento de Gala</option>
                                    <option value="evento_privado">Evento Privado</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha del Evento *</label>
                            <input type="date" class="form-control" name="fecha_evento" required
                                   min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mensaje o Notas</label>
                            <textarea class="form-control" name="mensaje" rows="3" 
                                      placeholder="Detalles adicionales..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarCliente">
                        <i class="bi bi-save"></i> Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR CLIENTE -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square"></i> Editar Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnCancelarEditar"></button>
            </div>
            <form method="POST" action="" id="formEditarCliente">
                <input type="hidden" name="actualizar_cliente" value="1">
                <input type="hidden" id="editar_cliente_id" name="cliente_id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" id="editar_correo" name="correo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="editar_telefono" name="telefono" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Evento *</label>
                            <select class="form-select" id="editar_tipo_evento" name="tipo_evento" required>
                                <option value="">Seleccionar...</option>
                                <!-- Bodas -->
                                <optgroup label="🎭 Bodas">
                                    <option value="boda_civil">Boda Civil</option>
                                    <option value="boda_religiosa">Boda Religiosa</option>
                                    <option value="boda_destino">Boda Destino</option>
                                    <option value="boda_intima">Boda Íntima</option>
                                    <option value="boda_lujo">Boda de Lujo</option>
                                    <option value="boda_tematica">Boda Temática</option>
                                    <option value="boda_playa">Boda en Playa</option>
                                    <option value="boda_campo">Boda en Campo</option>
                                    <option value="boda_urbana">Boda Urbana</option>
                                    <option value="boda_vintage">Boda Vintage</option>
                                </optgroup>
                                <!-- XV Años -->
                                <optgroup label="👸 XV Años">
                                    <option value="xv_anos">XV Años Tradicional</option>
                                    <option value="xv_anos_tematica">XV Años Temático</option>
                                    <option value="xv_anos_lujo">XV Años de Lujo</option>
                                    <option value="xv_anos_intima">XV Años Íntimo</option>
                                </optgroup>
                                <!-- Baby Shower -->
                                <optgroup label="🎀 Baby Shower">
                                    <option value="baby_shower">Baby Shower</option>
                                    <option value="baby_shower_gender_reveal">Baby Shower (Gender Reveal)</option>
                                    <option value="baby_shower_tematica">Baby Shower Temático</option>
                                </optgroup>
                                <!-- Eventos Empresariales -->
                                <optgroup label="🏢 Eventos Empresariales">
                                    <option value="evento_empresarial">Evento Empresarial</option>
                                    <option value="convencion">Convención</option>
                                    <option value="lanzamiento_producto">Lanzamiento de Producto</option>
                                    <option value="conferencia">Conferencia</option>
                                    <option value="seminario">Seminario</option>
                                    <option value="team_building">Team Building</option>
                                    <option value="fiesta_navidad_empresa">Fiesta de Navidad Empresarial</option>
                                </optgroup>
                                <!-- Eventos Municipales -->
                                <optgroup label="🏛️ Eventos Municipales">
                                    <option value="evento_municipal">Evento Municipal</option>
                                    <option value="feria_local">Feria Local</option>
                                    <option value="festival_cultural">Festival Cultural</option>
                                    <option value="concierto_publico">Concierto Público</option>
                                    <option value="celebracion_aniversario_ciudad">Celebración Aniversario Ciudad</option>
                                    <option value="evento_deportivo_municipal">Evento Deportivo Municipal</option>
                                </optgroup>
                                <!-- Eventos del Año -->
                                <optgroup label="📅 Eventos del Año">
                                    <option value="cumpleanos">Cumpleaños</option>
                                    <option value="aniversario">Aniversario</option>
                                    <option value="graduacion">Graduación</option>
                                    <option value="bautizo">Bautizo</option>
                                    <option value="primera_comunion">Primera Comunión</option>
                                    <option value="despedida_soltero">Despedida de Soltero/a</option>
                                    <option value="fiesta_compromiso">Fiesta de Compromiso</option>
                                    <option value="renovacion_votos">Renovación de Votos</option>
                                    <option value="fiesta_halloween">Fiesta de Halloween</option>
                                    <option value="fiesta_navidad">Fiesta de Navidad</option>
                                    <option value="fiesta_ano_nuevo">Fiesta de Año Nuevo</option>
                                    <option value="fiesta_pascua">Fiesta de Pascua</option>
                                </optgroup>
                                <!-- Otros -->
                                <optgroup label="🎪 Otros Eventos">
                                    <option value="evento_religioso">Evento Religioso</option>
                                    <option value="evento_benefico">Evento Benéfico</option>
                                    <option value="evento_gala">Evento de Gala</option>
                                    <option value="evento_privado">Evento Privado</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha del Evento *</label>
                            <input type="date" class="form-control" id="editar_fecha_evento" name="fecha_evento" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mensaje o Notas</label>
                            <textarea class="form-control" id="editar_mensaje" name="mensaje" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnActualizarCliente">
                        <i class="bi bi-save"></i> Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODALES PARA VER DETALLES DE CLIENTES -->
<?php foreach ($todos_clientes as $cliente): 
    $badge_class = 'badge-' . $cliente['tipo_boda'];
    $tipo_text = formatearTipoEvento($cliente['tipo_boda']);
?>
<div class="modal fade" id="modalCliente<?php echo $cliente['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-badge"></i> 
                    <?php echo htmlspecialchars($cliente['nombre']); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p><?php echo $cliente['correo']; ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Teléfono</label>
                            <p><?php echo $cliente['telefono']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Tipo de Evento</label>
                            <p>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $tipo_text; ?>
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Fecha del Evento</label>
                            <p><?php echo date('d/m/Y', strtotime($cliente['fecha_evento'])); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Registrado el</label>
                            <p><?php echo date('d/m/Y H:i', strtotime($cliente['fecha_registro'])); ?></p>
                        </div>
                    </div>
                </div>
                <?php if ($cliente['mensaje']): ?>
                    <div class="mt-3 border-top pt-3">
                        <h6><i class="bi bi-chat-left-text"></i> Mensaje</h6>
                        <div class="alert alert-light">
                            <?php echo nl2br(htmlspecialchars($cliente['mensaje'])); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="mailto:<?php echo $cliente['correo']; ?>" class="btn btn-primary">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal para Clientes Totales -->
<div class="modal fade" id="modalClientesTotales" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-people-fill"></i> Detalles: Clientes Totales
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-people-fill stat-icon"></i>
                            <div class="stat-number"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                            <div class="stat-label">Total Registrados</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-calendar-check stat-icon"></i>
                            <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                            <div class="stat-label">Tipos de Evento Únicos</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-calendar4-event stat-icon"></i>
                            <div class="stat-number">
                                <?php 
                                $eventos_mes = $conn->query("SELECT COUNT(*) as total FROM clientes WHERE MONTH(fecha_registro) = MONTH(CURDATE())")->fetch(PDO::FETCH_ASSOC);
                                echo $eventos_mes['total'] ?? 0;
                                ?>
                            </div>
                            <div class="stat-label">Registros este Mes</div>
                        </div>
                    </div>
                </div>
                
                <h6><i class="bi bi-list-ul"></i> Últimos 10 Clientes Registrados</h6>
                <div class="table-responsive mt-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Evento</th>
                                <th>Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $ultimos_clientes = $conn->query("SELECT id, nombre, tipo_boda, fecha_registro FROM clientes ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ultimos_clientes as $cliente):
                            ?>
                            <tr>
                                <td>#<?php echo $cliente['id']; ?></td>
                                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $cliente['tipo_boda']; ?>">
                                        <?php echo formatearTipoEvento($cliente['tipo_boda']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="admin.php?tab=clientes" class="btn btn-primary">
                    <i class="bi bi-people"></i> Ver Todos los Clientes
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Tipos de Eventos -->
<div class="modal fade" id="modalTiposEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-heart-fill"></i> Detalles: Tipos de Eventos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6 text-center">
                        <div class="stat-card">
                            <i class="bi bi-collection stat-icon"></i>
                            <div class="stat-number"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                            <div class="stat-label">Tipos Únicos</div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="stat-card">
                            <i class="bi bi-diagram-3 stat-icon"></i>
                            <div class="stat-number">
                                <?php 
                                $distribucion = $conn->query("SELECT COUNT(DISTINCT categoria) as categorias FROM (SELECT 
                                    CASE 
                                        WHEN tipo_boda LIKE 'boda_%' THEN 'Bodas'
                                        WHEN tipo_boda LIKE 'xv_%' THEN 'XV Años'
                                        WHEN tipo_boda LIKE 'baby_%' THEN 'Baby Shower'
                                        WHEN tipo_boda LIKE '%empresarial%' OR tipo_boda LIKE '%team%' THEN 'Empresariales'
                                        WHEN tipo_boda LIKE '%municipal%' THEN 'Municipales'
                                        ELSE 'Otros'
                                    END as categoria
                                    FROM clientes) as categorias")->fetch(PDO::FETCH_ASSOC);
                                echo $distribucion['categorias'] ?? 0;
                                ?>
                            </div>
                            <div class="stat-label">Categorías</div>
                        </div>
                    </div>
                </div>
                
                <h6><i class="bi bi-pie-chart"></i> Distribución por Tipo</h6>
                <div class="table-responsive mt-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tipo de Evento</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $tipos_distribucion = $conn->query("SELECT 
                                tipo_boda, 
                                COUNT(*) as cantidad,
                                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 1) as porcentaje
                                FROM clientes 
                                GROUP BY tipo_boda 
                                ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($tipos_distribucion as $tipo):
                            ?>
                            <tr>
                                <td>
                                    <span class="badge badge-<?php echo $tipo['tipo_boda']; ?>">
                                        <?php echo formatearTipoEvento($tipo['tipo_boda']); ?>
                                    </span>
                                </td>
                                <td><strong><?php echo $tipo['cantidad']; ?></strong></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" 
                                             style="width: <?php echo $tipo['porcentaje']; ?>%; background-color: var(--color-oro);">
                                            <?php echo $tipo['porcentaje']; ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Último Evento -->
<div class="modal fade" id="modalUltimoEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-check"></i> Detalles: Último Evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php 
                $ultimo_evento = $conn->query("SELECT * FROM clientes ORDER BY fecha_evento DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($ultimo_evento):
                ?>
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-calendar-check stat-icon"></i>
                            <div class="stat-number fecha-style">
                                <?php echo date('d/m/Y', strtotime($ultimo_evento['fecha_evento'])); ?>
                            </div>
                            <div class="stat-label">Fecha Evento</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-person-circle stat-icon"></i>
                            <div class="stat-number" style="font-size: 1.4rem !important;">
                                <?php echo htmlspecialchars($ultimo_evento['nombre']); ?>
                            </div>
                            <div class="stat-label">Cliente</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-heart stat-icon"></i>
                            <div class="stat-number">
                                <?php echo formatearTipoEvento($ultimo_evento['tipo_boda']); ?>
                            </div>
                            <div class="stat-label">Tipo de Evento</div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <h6><i class="bi bi-info-circle"></i> Información Completa</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($ultimo_evento['nombre']); ?></p>
                                <p><strong>Email:</strong> <?php echo $ultimo_evento['correo']; ?></p>
                                <p><strong>Teléfono:</strong> <?php echo $ultimo_evento['telefono']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tipo de Evento:</strong> 
                                    <span class="badge badge-<?php echo $ultimo_evento['tipo_boda']; ?>">
                                        <?php echo formatearTipoEvento($ultimo_evento['tipo_boda']); ?>
                                    </span>
                                </p>
                                <p><strong>Fecha del Evento:</strong> <?php echo date('d/m/Y', strtotime($ultimo_evento['fecha_evento'])); ?></p>
                                <p><strong>Registrado el:</strong> <?php echo date('d/m/Y H:i', strtotime($ultimo_evento['fecha_registro'])); ?></p>
                            </div>
                        </div>
                        <?php if ($ultimo_evento['mensaje']): ?>
                        <div class="mt-3">
                            <strong>Mensaje/Notas:</strong>
                            <div class="alert alert-light mt-2">
                                <?php echo nl2br(htmlspecialchars($ultimo_evento['mensaje'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                    <h5>No hay eventos registrados</h5>
                    <p class="mb-0">Aún no se han registrado eventos en el sistema.</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($ultimo_evento): ?>
                <a href="mailto:<?php echo $ultimo_evento['correo']; ?>" class="btn btn-primary">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Próximo Evento -->
<div class="modal fade" id="modalProximoEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-date"></i> Detalles: Próximo Evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php 
                $proximo_evento = $conn->query("SELECT * FROM clientes WHERE fecha_evento >= CURDATE() ORDER BY fecha_evento ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($proximo_evento):
                ?>
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-calendar-date stat-icon"></i>
                            <div class="stat-number fecha-style">
                                <?php echo date('d/m/Y', strtotime($proximo_evento['fecha_evento'])); ?>
                            </div>
                            <div class="stat-label">Fecha Evento</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-hourglass-split stat-icon"></i>
                            <div class="stat-number">
                                <?php 
                                $fecha_evento = new DateTime($proximo_evento['fecha_evento']);
                                $hoy = new DateTime();
                                $diferencia = $hoy->diff($fecha_evento);
                                echo $diferencia->days;
                                ?>
                            </div>
                            <div class="stat-label">Días Restantes</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card">
                            <i class="bi bi-heart stat-icon"></i>
                            <div class="stat-number">
                                <?php echo formatearTipoEvento($proximo_evento['tipo_boda']); ?>
                            </div>
                            <div class="stat-label">Tipo de Evento</div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <h6><i class="bi bi-info-circle"></i> Información Completa</h6>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($proximo_evento['nombre']); ?></p>
                                <p><strong>Email:</strong> <?php echo $proximo_evento['correo']; ?></p>
                                <p><strong>Teléfono:</strong> <?php echo $proximo_evento['telefono']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tipo de Evento:</strong> 
                                    <span class="badge badge-<?php echo $proximo_evento['tipo_boda']; ?>">
                                        <?php echo formatearTipoEvento($proximo_evento['tipo_boda']); ?>
                                    </span>
                                </p>
                                <p><strong>Fecha del Evento:</strong> <?php echo date('d/m/Y', strtotime($proximo_evento['fecha_evento'])); ?></p>
                                <p><strong>Registrado el:</strong> <?php echo date('d/m/Y H:i', strtotime($proximo_evento['fecha_registro'])); ?></p>
                            </div>
                        </div>
                        <?php if ($proximo_evento['mensaje']): ?>
                        <div class="mt-3">
                            <strong>Mensaje/Notas:</strong>
                            <div class="alert alert-light mt-2">
                                <?php echo nl2br(htmlspecialchars($proximo_evento['mensaje'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <i class="bi bi-clock-history"></i>
                    <strong>Próximos Eventos (5 siguientes)</strong>
                    <div class="mt-2">
                        <?php 
                        $proximos_eventos = $conn->query("SELECT nombre, tipo_boda, fecha_evento FROM clientes WHERE fecha_evento >= CURDATE() ORDER BY fecha_evento ASC LIMIT 5 OFFSET 1")->fetchAll(PDO::FETCH_ASSOC);
                        if ($proximos_eventos):
                        ?>
                        <div class="list-group">
                            <?php foreach ($proximos_eventos as $evento): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><?php echo htmlspecialchars($evento['nombre']); ?></span>
                                    <span><?php echo date('d/m/Y', strtotime($evento['fecha_evento'])); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="mb-0">No hay más eventos programados.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php else: ?>
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                    <h5>No hay próximos eventos</h5>
                    <p class="mb-0">No hay eventos programados para fechas futuras.</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($proximo_evento): ?>
                <a href="mailto:<?php echo $proximo_evento['correo']; ?>" class="btn btn-primary">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>