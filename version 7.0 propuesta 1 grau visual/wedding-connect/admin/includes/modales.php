<?php
// admin/includes/modales.php - CON VALIDACIONES COMPLETAS
?>

<!-- MODAL PARA CAMBIAR CONTRASEÑA -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-shield-lock"></i> Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>" id="formCambiarPassword">
                <input type="hidden" name="cambiar_password" value="1">
                <div class="modal-body-nuevo">
                    <div class="alert alert-info mb-3" style="background: rgba(212, 181, 160, 0.1); border-left: 4px solid var(--color-primary);">
                        <i class="bi bi-person-circle me-2"></i>
                        <strong>Administrador:</strong> <?php echo $_SESSION['admin_nombre'] ?? 'Administrador'; ?>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Cambiando contraseña de forma segura
                        </small>
                    </div>
                    
                    <div class="form-group-nuevo mb-3">
                        <label class="form-label-nuevo">Contraseña Actual *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock-fill" style="color: var(--color-primary);"></i>
                            </span>
                            <input type="password" class="form-control-nuevo border-start-0" name="password_actual" id="password_actual" required placeholder="Ingrese su contraseña actual">
                        </div>
                    </div>
                    
                    <div class="form-group-nuevo mb-3">
                        <label class="form-label-nuevo">Nueva Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-key-fill" style="color: var(--color-primary);"></i>
                            </span>
                            <input type="password" class="form-control-nuevo border-start-0" name="password_nuevo" id="nuevoPassword" required minlength="4" placeholder="Mínimo 4 caracteres">
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> La contraseña debe tener al menos 4 caracteres
                        </div>
                    </div>
                    
                    <div class="form-group-nuevo mb-3">
                        <label class="form-label-nuevo">Confirmar Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-check-circle" style="color: var(--color-primary);"></i>
                            </span>
                            <input type="password" class="form-control-nuevo border-start-0" name="password_confirmar" id="confirmarPassword" required minlength="4" placeholder="Confirme su nueva contraseña">
                        </div>
                        <div class="form-text" id="passwordMatchMessage"></div>
                    </div>
                    
                    <!-- Requisitos -->
                    <div class="mt-3">
                        <small class="text-muted fw-bold">Requisitos:</small>
                        <ul class="list-unstyled mt-2 mb-0">
                            <li id="reqLength" class="text-muted small">
                                <i class="bi bi-circle"></i> Mínimo 4 caracteres
                            </li>
                            <li id="reqMatch" class="text-muted small">
                                <i class="bi bi-circle"></i> Las contraseñas coinciden
                            </li>
                            <li id="reqDiff" class="text-muted small">
                                <i class="bi bi-circle"></i> Diferente a la actual
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer-nuevo">
                    <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-nuevo" id="btnCambiarPassword" disabled>
                        <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA NUEVO CLIENTE - CON VALIDACIONES -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-person-plus"></i> Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>" id="formNuevoCliente" onsubmit="return validarFormularioNuevoCliente()">
                <div class="modal-body-nuevo">
                    <!-- Campo: Nombre maxleght pone limite -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Nombre Completo *</label>
                            <input type="text" 
                                   class="form-control-nuevo" 
                                   name="nombre" 
                                   id="nuevo_nombre"
                                   required 
                                   maxlength="50" 
                                   pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                   title="Solo letras y espacios, máximo 50 caracteres"
                                   placeholder="Ej: Juan Pérez"
                                   onkeyup="validarNombre(this)">
                            <div class="form-text" id="nuevo_nombre_help">
                                <i class="bi bi-info-circle"></i> Solo letras, máximo 50 caracteres
                            </div>
                        </div>
                        
                        <!-- Campo: Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Email *</label>
                            <input type="email" 
                                   class="form-control-nuevo" 
                                   name="correo" 
                                   id="nuevo_correo"
                                   required 
                                   maxlength="60"
                                   placeholder="ejemplo@correo.com"
                                   onkeyup="validarEmail(this)">
                            <div class="form-text" id="nuevo_correo_help">
                                <i class="bi bi-info-circle"></i> Máximo 60 caracteres
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo: Teléfono y Tipo Evento -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Teléfono *</label>
                            <input type="tel" 
                                   class="form-control-nuevo" 
                                   name="telefono" 
                                   id="nuevo_telefono"
                                   required 
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   title="10 dígitos numéricos"
                                   placeholder="5512345678"
                                   onkeyup="validarTelefono(this)">
                            <div class="form-text" id="nuevo_telefono_help">
                                <i class="bi bi-info-circle"></i> 10 dígitos, solo números
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Tipo de Evento *</label>
                            <select class="form-control-nuevo" name="tipo_evento_id" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($categorias as $categoria => $tipos): ?>
                                    <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                        <?php foreach ($tipos as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nombre']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Campo: Fecha Evento y Mensaje -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Fecha del Evento *</label>
                            <input type="date" class="form-control-nuevo" name="fecha_evento" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Mensaje <small class="text-muted">(máx 200 palabras)</small></label>
                            <textarea class="form-control-nuevo" 
                                      name="mensaje" 
                                      id="nuevo_mensaje"
                                      rows="3"
                                      maxlength="2000"
                                      onkeyup="contarPalabras(this, 'nuevo_palabras')"
                                      placeholder="Requerimientos especiales..."></textarea>
                            <div class="form-text" id="nuevo_palabras">
                                <i class="bi bi-info-circle"></i> 0/200 palabras
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-nuevo">
                    <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-nuevo" id="btnGuardarNuevo">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR CLIENTE - CON VALIDACIONES -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-pencil-square"></i> Editar Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnCancelarEditar"></button>
            </div>
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>" id="formEditarCliente" onsubmit="return validarFormularioEditarCliente()">
                <input type="hidden" name="actualizar_cliente" value="1">
                <input type="hidden" id="editar_cliente_id" name="cliente_id">
                <div class="modal-body-nuevo">
                    <!-- Campo: Nombre -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Nombre Completo *</label>
                            <input type="text" 
                                   class="form-control-nuevo" 
                                   id="editar_nombre" 
                                   name="nombre" 
                                   required 
                                   maxlength="50"
                                   pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+"
                                   title="Solo letras y espacios, máximo 50 caracteres"
                                   placeholder="Ej: Juan Pérez"
                                   onkeyup="validarNombre(this, 'editar')">
                            <div class="form-text" id="editar_nombre_help">
                                <i class="bi bi-info-circle"></i> Solo letras, máximo 50 caracteres
                            </div>
                        </div>
                        
                        <!-- Campo: Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Email *</label>
                            <input type="email" 
                                   class="form-control-nuevo" 
                                   id="editar_correo" 
                                   name="correo" 
                                   required 
                                   maxlength="60"
                                   placeholder="ejemplo@correo.com"
                                   onkeyup="validarEmail(this, 'editar')">
                            <div class="form-text" id="editar_correo_help">
                                <i class="bi bi-info-circle"></i> Máximo 60 caracteres
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo: Teléfono y Tipo Evento -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Teléfono *</label>
                            <input type="tel" 
                                   class="form-control-nuevo" 
                                   id="editar_telefono" 
                                   name="telefono" 
                                   required 
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   title="10 dígitos numéricos"
                                   placeholder="5512345678"
                                   onkeyup="validarTelefono(this, 'editar')">
                            <div class="form-text" id="editar_telefono_help">
                                <i class="bi bi-info-circle"></i> 10 dígitos, solo números
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Tipo de Evento *</label>
                            <select class="form-control-nuevo" id="editar_tipo_evento_id" name="tipo_evento_id" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($categorias as $categoria => $tipos): ?>
                                    <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                        <?php foreach ($tipos as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nombre']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Campo: Fecha Evento y Mensaje -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Fecha del Evento *</label>
                            <input type="date" class="form-control-nuevo" id="editar_fecha_evento" name="fecha_evento" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label-nuevo">Mensaje <small class="text-muted">(máx 200 palabras)</small></label>
                            <textarea class="form-control-nuevo" 
                                      id="editar_mensaje" 
                                      name="mensaje" 
                                      rows="3"
                                      maxlength="2000"
                                      onkeyup="contarPalabras(this, 'editar_palabras')"
                                      placeholder="Requerimientos especiales..."></textarea>
                            <div class="form-text" id="editar_palabras">
                                <i class="bi bi-info-circle"></i> 0/200 palabras
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-nuevo">
                    <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-nuevo">Actualizar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODALES PARA VER DETALLES DE CLIENTES -->
<?php foreach ($todos_clientes as $cliente): ?>
<div class="modal fade" id="modalCliente<?php echo $cliente['id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-person-badge"></i> <?php echo htmlspecialchars($cliente['nombre']); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-nuevo">
                <p><strong>Email:</strong> <?php echo $cliente['correo']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $cliente['telefono']; ?></p>
                <p><strong>Tipo de Evento:</strong> <?php echo $cliente['tipo_nombre']; ?></p>
                <p><strong>Fecha del Evento:</strong> <?php echo date('d/m/Y', strtotime($cliente['fecha_evento'])); ?></p>
                <?php if ($cliente['mensaje']): ?>
                    <p><strong>Mensaje:</strong><br><?php echo nl2br($cliente['mensaje']); ?></p>
                <?php endif; ?>
            </div>
            <div class="modal-footer-nuevo">
                <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cerrar</button>
                <a href="tel:<?php echo $cliente['telefono']; ?>" class="btn btn-success-nuevo">
                    <i class="bi bi-telephone"></i> Llamar
                </a>
                <a href="mailto:<?php echo $cliente['correo']; ?>" class="btn btn-primary-nuevo">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- MODAL PARA CLIENTES TOTALES -->
<div class="modal fade" id="modalClientesTotales" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-people-fill"></i> Detalles: Clientes Totales</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-nuevo">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <div class="stat-card-nuevo" style="cursor: default;">
                            <div class="stat-icon-nuevo"><i class="bi bi-people-fill"></i></div>
                            <div class="stat-number-nuevo"><?php echo $stats['total_clientes'] ?? 0; ?></div>
                            <div class="stat-label-nuevo">Total Registrados</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card-nuevo" style="cursor: default;">
                            <div class="stat-icon-nuevo"><i class="bi bi-heart-fill"></i></div>
                            <div class="stat-number-nuevo"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                            <div class="stat-label-nuevo">Tipos de Evento</div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-card-nuevo" style="cursor: default;">
                            <div class="stat-icon-nuevo"><i class="bi bi-calendar4-event"></i></div>
                            <div class="stat-number-nuevo">
                                <?php 
                                $eventos_mes = $db->query("SELECT COUNT(*) as total FROM clientes WHERE MONTH(fecha_registro) = MONTH(CURDATE())")->fetch(PDO::FETCH_ASSOC);
                                echo $eventos_mes['total'] ?? 0;
                                ?>
                            </div>
                            <div class="stat-label-nuevo">Registros este Mes</div>
                        </div>
                    </div>
                </div>
                
                <h5 class="mb-3"><i class="bi bi-list-ul"></i> Últimos 10 Clientes Registrados</h5>
                <div class="table-responsive-nuevo">
                    <table class="table-nuevo">
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
                            $ultimos_clientes = $db->query("SELECT c.id, c.nombre, c.fecha_registro, t.nombre as tipo_nombre 
                                                            FROM clientes c 
                                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                                            ORDER BY c.id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ultimos_clientes as $cliente):
                            ?>
                                <tr>
                                    <td><span class="badge badge-primary-nuevo">#<?php echo $cliente['id']; ?></span></td>
                                    <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                    <td><?php echo $cliente['tipo_nombre']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer-nuevo">
                <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cerrar</button>
                <a href="admin.php?tab=clientes" class="btn btn-primary-nuevo">Ver Todos los Clientes</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA TIPOS DE EVENTO -->
<div class="modal fade" id="modalTiposEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-heart-fill"></i> Detalles: Tipos de Eventos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-nuevo">
                <div class="row mb-4">
                    <div class="col-md-6 text-center">
                        <div class="stat-card-nuevo" style="cursor: default;">
                            <div class="stat-icon-nuevo"><i class="bi bi-collection"></i></div>
                            <div class="stat-number-nuevo"><?php echo $stats['tipos_evento'] ?? 0; ?></div>
                            <div class="stat-label-nuevo">Tipos Únicos</div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="stat-card-nuevo" style="cursor: default;">
                            <div class="stat-icon-nuevo"><i class="bi bi-diagram-3"></i></div>
                            <div class="stat-number-nuevo">
                                <?php 
                                $distribucion = $db->query("SELECT COUNT(DISTINCT t.categoria) as categorias 
                                                            FROM clientes c 
                                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id")->fetch(PDO::FETCH_ASSOC);
                                echo $distribucion['categorias'] ?? 0;
                                ?>
                            </div>
                            <div class="stat-label-nuevo">Categorías</div>
                        </div>
                    </div>
                </div>
                
                <h5 class="mb-3"><i class="bi bi-pie-chart"></i> Distribución por Tipo</h5>
                <div class="table-responsive-nuevo">
                    <table class="table-nuevo">
                        <thead>
                            <tr>
                                <th>Tipo de Evento</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $tipos_distribucion = $db->query("SELECT 
                                t.nombre, 
                                COUNT(*) as cantidad,
                                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 1) as porcentaje
                                FROM clientes c 
                                JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                GROUP BY c.tipo_evento_id 
                                ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($tipos_distribucion as $tipo):
                            ?>
                                <tr>
                                    <td><?php echo $tipo['nombre']; ?></td>
                                    <td><strong><?php echo $tipo['cantidad']; ?></strong></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" 
                                                 style="width: <?php echo $tipo['porcentaje']; ?>%; background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));">
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
            <div class="modal-footer-nuevo">
                <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA ÚLTIMO EVENTO -->
<div class="modal fade" id="modalUltimoEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-calendar-check"></i> Detalles: Último Evento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-nuevo">
                <?php 
                $ultimo_evento = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                             FROM clientes c 
                                             JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                             ORDER BY c.fecha_evento DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($ultimo_evento):
                ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-calendar-check"></i></div>
                                <div class="modal-stat-numero"><?php echo date('d/m/Y', strtotime($ultimo_evento['fecha_evento'])); ?></div>
                                <div class="stat-label-nuevo">Fecha Evento</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-person-circle"></i></div>
                                <div class="modal-stat-numero modal-stat-nombre"><?php echo htmlspecialchars($ultimo_evento['nombre']); ?></div>
                                <div class="stat-label-nuevo">Cliente</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-heart"></i></div>
                                <div class="modal-stat-numero"><?php echo $ultimo_evento['tipo_nombre']; ?></div>
                                <div class="stat-label-nuevo">Tipo de Evento</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6><i class="bi bi-info-circle"></i> Información Completa</h6>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($ultimo_evento['nombre']); ?></p>
                                    <p><strong>Email:</strong> <?php echo $ultimo_evento['correo']; ?></p>
                                    <p><strong>Teléfono:</strong> <?php echo $ultimo_evento['telefono']; ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Tipo de Evento:</strong> <?php echo $ultimo_evento['tipo_nombre']; ?></p>
                                    <p><strong>Fecha del Evento:</strong> <?php echo date('d/m/Y', strtotime($ultimo_evento['fecha_evento'])); ?></p>
                                    <p><strong>Registrado el:</strong> <?php echo date('d/m/Y H:i', strtotime($ultimo_evento['fecha_registro'])); ?></p>
                                </div>
                            </div>
                            <?php if ($ultimo_evento['mensaje']): ?>
                            <div class="mt-3">
                                <strong>Mensaje:</strong>
                                <div class="alert alert-light mt-2">
                                    <?php echo nl2br(htmlspecialchars($ultimo_evento['mensaje'])); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-1 d-block mb-3" style="color: var(--color-primary);"></i>
                        <h5>No hay eventos registrados</h5>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer-nuevo">
                <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($ultimo_evento): ?>
                <a href="tel:<?php echo $ultimo_evento['telefono']; ?>" class="btn btn-success-nuevo">
                    <i class="bi bi-telephone"></i> Llamar
                </a>
                <a href="mailto:<?php echo $ultimo_evento['correo']; ?>" class="btn btn-primary-nuevo">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA PRÓXIMO EVENTO -->
<div class="modal fade" id="modalProximoEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-nuevo">
            <div class="modal-header-nuevo">
                <h5 class="modal-title-nuevo"><i class="bi bi-calendar-date"></i> Detalles: Próximo Evento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-nuevo">
                <?php 
                $proximo_evento = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                              FROM clientes c 
                                              JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                              WHERE c.fecha_evento >= CURDATE() 
                                              ORDER BY c.fecha_evento ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($proximo_evento):
                ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-calendar-date"></i></div>
                                <div class="modal-stat-numero"><?php echo date('d/m/Y', strtotime($proximo_evento['fecha_evento'])); ?></div>
                                <div class="stat-label-nuevo">Fecha Evento</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-hourglass-split"></i></div>
                                <div class="modal-stat-numero">
                                    <?php 
                                    $fecha_evento = new DateTime($proximo_evento['fecha_evento']);
                                    $hoy = new DateTime();
                                    $diferencia = $hoy->diff($fecha_evento);
                                    echo $diferencia->days;
                                    ?>
                                </div>
                                <div class="stat-label-nuevo">Días Restantes</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-nuevo" style="cursor: default; height: 100%;">
                                <div class="stat-icon-nuevo"><i class="bi bi-heart"></i></div>
                                <div class="modal-stat-numero"><?php echo $proximo_evento['tipo_nombre']; ?></div>
                                <div class="stat-label-nuevo">Tipo de Evento</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6><i class="bi bi-info-circle"></i> Información Completa</h6>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($proximo_evento['nombre']); ?></p>
                                    <p><strong>Email:</strong> <?php echo $proximo_evento['correo']; ?></p>
                                    <p><strong>Teléfono:</strong> <?php echo $proximo_evento['telefono']; ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Tipo de Evento:</strong> <?php echo $proximo_evento['tipo_nombre']; ?></p>
                                    <p><strong>Fecha del Evento:</strong> <?php echo date('d/m/Y', strtotime($proximo_evento['fecha_evento'])); ?></p>
                                    <p><strong>Registrado el:</strong> <?php echo date('d/m/Y H:i', strtotime($proximo_evento['fecha_registro'])); ?></p>
                                </div>
                            </div>
                            <?php if ($proximo_evento['mensaje']): ?>
                            <div class="mt-3">
                                <strong>Mensaje:</strong>
                                <div class="alert alert-light mt-2">
                                    <?php echo nl2br(htmlspecialchars($proximo_evento['mensaje'])); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-1 d-block mb-3" style="color: var(--color-primary);"></i>
                        <h5>No hay próximos eventos</h5>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer-nuevo">
                <button type="button" class="btn btn-outline-nuevo" data-bs-dismiss="modal">Cerrar</button>
                <?php if ($proximo_evento): ?>
                <a href="tel:<?php echo $proximo_evento['telefono']; ?>" class="btn btn-success-nuevo">
                    <i class="bi bi-telephone"></i> Llamar
                </a>
                <a href="mailto:<?php echo $proximo_evento['correo']; ?>" class="btn btn-primary-nuevo">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT DE VALIDACIONES - Agregar al final -->
<script src="../../assets/js/views-panel.js"></script>