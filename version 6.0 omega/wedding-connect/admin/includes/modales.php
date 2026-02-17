<?php
// admin/includes/modales.php - Todos los modales del sistema NORMALIZADOS
?>
<!-- ===== NUEVO MODAL PARA CAMBIAR CONTRASEÑA (CON HASH) ===== -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>" id="formCambiarPassword">
                <input type="hidden" name="cambiar_password" value="1">
                <div class="modal-body">
                    <div class="alert alert-info" style="background: rgba(212, 175, 55, 0.1); border-color: var(--wedding-gold);">
                        <i class="bi bi-person-circle"></i> 
                        <strong>Administrador:</strong> 
                        <span style="font-weight: 600; color: var(--wedding-burgundy);">
                            <?php echo $_SESSION['admin_nombre'] ?? 'cristina'; ?>
                        </span>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Cambiando contraseña de forma segura
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-key"></i> Contraseña Actual *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock-fill" style="color: var(--wedding-gold);"></i>
                            </span>
                            <input type="password" 
                                   class="form-control border-start-0" 
                                   name="password_actual" 
                                   id="password_actual"
                                   required 
                                   placeholder="Ingrese su contraseña actual"
                                   style="border-left: none;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-key-fill"></i> Nueva Contraseña *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-shield" style="color: var(--wedding-gold);"></i>
                            </span>
                            <input type="password" 
                                   class="form-control border-start-0" 
                                   name="password_nuevo" 
                                   id="nuevoPassword" 
                                   required 
                                   placeholder="Mínimo 4 caracteres"
                                   minlength="4"
                                   style="border-left: none;">
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> La contraseña debe tener al menos 4 caracteres
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-check-circle"></i> Confirmar Nueva Contraseña *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-shield-check" style="color: var(--wedding-gold);"></i>
                            </span>
                            <input type="password" 
                                   class="form-control border-start-0" 
                                   name="password_confirmar" 
                                   id="confirmarPassword" 
                                   required 
                                   placeholder="Confirme su nueva contraseña"
                                   minlength="4"
                                   style="border-left: none;">
                        </div>
                        <div class="form-text" id="passwordMatchMessage"></div>
                    </div>
                    
                    <!-- Indicador de seguridad -->
                    <div class="mt-3 p-3 rounded" id="passwordStrength" style="display: none; background: rgba(0,0,0,0.02);">
                        <small class="text-muted fw-bold">Seguridad de la contraseña:</small>
                        <div class="progress mt-2" style="height: 8px; border-radius: 4px;">
                            <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%; border-radius: 4px;"></div>
                        </div>
                        <small class="text-muted mt-2 d-block" id="strengthText"></small>
                    </div>
                    
                    <!-- Requisitos de contraseña -->
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnCambiarPassword" disabled>
                        <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordActual = document.getElementById('password_actual');
    const nuevoPassword = document.getElementById('nuevoPassword');
    const confirmarPassword = document.getElementById('confirmarPassword');
    const btnCambiar = document.getElementById('btnCambiarPassword');
    const matchMessage = document.getElementById('passwordMatchMessage');
    const passwordStrength = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    // Elementos de requisitos
    const reqLength = document.getElementById('reqLength');
    const reqMatch = document.getElementById('reqMatch');
    const reqDiff = document.getElementById('reqDiff');
    
    function validarContrasenas() {
        const actual = passwordActual.value;
        const nuevo = nuevoPassword.value;
        const confirmar = confirmarPassword.value;
        
        let isValid = true;
        
        // Validar longitud
        if (nuevo.length >= 4) {
            reqLength.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i> Mínimo 4 caracteres ✓';
            reqLength.classList.remove('text-muted');
        } else {
            reqLength.innerHTML = '<i class="bi bi-circle text-muted"></i> Mínimo 4 caracteres';
            reqLength.classList.add('text-muted');
            isValid = false;
        }
        
        // Validar coincidencia
        if (nuevo.length > 0 && confirmar.length > 0 && nuevo === confirmar) {
            reqMatch.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i> Las contraseñas coinciden ✓';
            reqMatch.classList.remove('text-muted');
            matchMessage.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Las contraseñas coinciden</span>';
        } else {
            reqMatch.innerHTML = '<i class="bi bi-circle text-muted"></i> Las contraseñas coinciden';
            reqMatch.classList.add('text-muted');
            if (nuevo.length > 0 || confirmar.length > 0) {
                matchMessage.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle"></i> Las contraseñas no coinciden</span>';
            } else {
                matchMessage.innerHTML = '';
            }
            isValid = false;
        }
        
        // Validar que sea diferente a la actual
        if (actual.length > 0 && nuevo.length > 0 && actual !== nuevo) {
            reqDiff.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i> Diferente a la actual ✓';
            reqDiff.classList.remove('text-muted');
        } else {
            reqDiff.innerHTML = '<i class="bi bi-circle text-muted"></i> Diferente a la actual';
            reqDiff.classList.add('text-muted');
            if (actual.length > 0 && nuevo.length > 0 && actual === nuevo) {
                isValid = false;
            }
        }
        
        // Validar que todos los campos tengan contenido
        if (actual.length === 0 || nuevo.length === 0 || confirmar.length === 0) {
            isValid = false;
        }
        
        // Habilitar/deshabilitar botón
        btnCambiar.disabled = !isValid;
        
        // Mostrar fortaleza de contraseña
        if (nuevo.length > 0) {
            passwordStrength.style.display = 'block';
            calcularFortaleza(nuevo);
        } else {
            passwordStrength.style.display = 'none';
        }
    }
    
    function calcularFortaleza(password) {
        let fortaleza = 0;
        let nivel = '';
        let color = '';
        
        if (password.length >= 6) fortaleza += 25;
        if (password.match(/[a-z]/)) fortaleza += 25;
        if (password.match(/[A-Z]/)) fortaleza += 25;
        if (password.match(/[0-9]/)) fortaleza += 25;
        if (password.match(/[^a-zA-Z0-9]/)) fortaleza += 25;
        
        fortaleza = Math.min(fortaleza, 100);
        
        if (fortaleza <= 25) {
            nivel = 'Muy débil';
            color = '#dc3545';
        } else if (fortaleza <= 50) {
            nivel = 'Débil';
            color = '#ffc107';
        } else if (fortaleza <= 75) {
            nivel = 'Buena';
            color = '#0dcaf0';
        } else {
            nivel = 'Fuerte';
            color = '#198754';
        }
        
        strengthBar.style.width = fortaleza + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.innerHTML = '<span style="color: ' + color + ';">' + nivel + '</span>';
    }
    
    // Agregar event listeners
    passwordActual.addEventListener('input', validarContrasenas);
    nuevoPassword.addEventListener('input', validarContrasenas);
    confirmarPassword.addEventListener('input', validarContrasenas);
    
    // Resetear formulario al cerrar el modal
    const modal = document.getElementById('modalCambiarPassword');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('formCambiarPassword').reset();
            btnCambiar.disabled = true;
            matchMessage.innerHTML = '';
            passwordStrength.style.display = 'none';
            
            // Resetear requisitos
            reqLength.innerHTML = '<i class="bi bi-circle"></i> Mínimo 4 caracteres';
            reqMatch.innerHTML = '<i class="bi bi-circle"></i> Las contraseñas coinciden';
            reqDiff.innerHTML = '<i class="bi bi-circle"></i> Diferente a la actual';
            
            [reqLength, reqMatch, reqDiff].forEach(el => el.classList.add('text-muted'));
        });
    }
});
</script>

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
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>">
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
                            <select class="form-select" name="tipo_evento_id" required>
                                <option value="">Seleccionar...</option>
                                <?php 
                                // Obtener tipos de evento
                                require_once __DIR__ . '/../../config/database.php';
                                $db = getDB();
                                $tipos_evento = $db->query("SELECT * FROM tipos_evento WHERE activo = 1 ORDER BY categoria, nombre")->fetchAll();
                                
                                // Agrupar por categoría
                                $categorias = [];
                                foreach ($tipos_evento as $tipo) {
                                    $categorias[$tipo['categoria']][] = $tipo;
                                }
                                
                                $labels_categorias = [
                                    'bodas' => '🎭 Bodas',
                                    'xv_anos' => '👸 XV Años',
                                    'baby_shower' => '🎀 Baby Shower',
                                    'empresariales' => '🏢 Eventos Empresariales',
                                    'municipales' => '🏛️ Eventos Municipales',
                                    'anuales' => '📅 Eventos del Año',
                                    'otros' => '🎪 Otros Eventos'
                                ];
                                
                                foreach ($categorias as $categoria => $tipos): 
                                    if (!empty($tipos)): 
                                ?>
                                    <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                        <?php foreach ($tipos as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>">
                                                <?php echo htmlspecialchars($tipo['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
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
            <form method="POST" action="admin.php?tab=<?php echo $tab; ?>" id="formEditarCliente">
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
                            <select class="form-select" id="editar_tipo_evento_id" name="tipo_evento_id" required>
                                <option value="">Seleccionar...</option>
                                <?php 
                                foreach ($categorias as $categoria => $tipos): 
                                    if (!empty($tipos)): 
                                ?>
                                    <optgroup label="<?php echo $labels_categorias[$categoria] ?? ucfirst($categoria); ?>">
                                        <?php foreach ($tipos as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>">
                                                <?php echo htmlspecialchars($tipo['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
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
    // Obtener nombre del tipo de evento
    $tipo_nombre = obtenerNombreTipoEvento($cliente['tipo_evento_id']);
    
    // Determinar color del badge según el tipo de evento
    $badge_color = '';
    $text_color = 'white';
    
    if (stripos($tipo_nombre, 'civil') !== false) {
        $badge_color = '#ffc107';
        $text_color = '#000';
    } elseif (stripos($tipo_nombre, 'religiosa') !== false) {
        $badge_color = '#198754';
    } elseif (stripos($tipo_nombre, 'playa') !== false) {
        $badge_color = '#0dcaf0';
    } elseif (stripos($tipo_nombre, 'intima') !== false) {
        $badge_color = '#6f42c1';
    } elseif (stripos($tipo_nombre, 'lujo') !== false) {
        $badge_color = '#fd7e14';
    } elseif (stripos($tipo_nombre, 'destino') !== false) {
        $badge_color = '#20c997';
    } elseif (stripos($tipo_nombre, 'temática') !== false) {
        $badge_color = '#e83e8c';
    } else {
        $badge_color = '#d4af37'; // Color oro por defecto
    }
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
                                <span class="badge" style="background-color: <?php echo $badge_color; ?>; color: <?php echo $text_color; ?>;">
                                    <?php echo $tipo_nombre; ?>
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
                                $db = getDB();
                                $eventos_mes = $db->query("SELECT COUNT(*) as total FROM clientes WHERE MONTH(fecha_registro) = MONTH(CURDATE())")->fetch(PDO::FETCH_ASSOC);
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
                            $ultimos_clientes = $db->query("SELECT c.id, c.nombre, c.fecha_registro, t.nombre as tipo_nombre 
                                                            FROM clientes c 
                                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                                            ORDER BY c.id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ultimos_clientes as $cliente):
                                // Determinar color del badge según el tipo de evento
                                $badge_color = '';
                                $text_color = 'white';
                                $tipo_text = $cliente['tipo_nombre'];
                                
                                if (stripos($tipo_text, 'civil') !== false) {
                                    $badge_color = '#ffc107';
                                    $text_color = '#000';
                                } elseif (stripos($tipo_text, 'religiosa') !== false) {
                                    $badge_color = '#198754';
                                } elseif (stripos($tipo_text, 'playa') !== false) {
                                    $badge_color = '#0dcaf0';
                                } elseif (stripos($tipo_text, 'intima') !== false) {
                                    $badge_color = '#6f42c1';
                                } elseif (stripos($tipo_text, 'lujo') !== false) {
                                    $badge_color = '#fd7e14';
                                } else {
                                    $badge_color = '#d4af37';
                                }
                            ?>
                            <tr>
                                <td>#<?php echo $cliente['id']; ?></td>
                                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo $badge_color; ?>; color: <?php echo $text_color; ?>; padding: 5px 10px; font-weight: 500;">
                                        <?php echo $tipo_text; ?>
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
                                $distribucion = $db->query("SELECT COUNT(DISTINCT t.categoria) as categorias 
                                                            FROM clientes c 
                                                            JOIN tipos_evento t ON c.tipo_evento_id = t.id")->fetch(PDO::FETCH_ASSOC);
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
                            $tipos_distribucion = $db->query("SELECT 
                                t.nombre, 
                                COUNT(*) as cantidad,
                                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 1) as porcentaje
                                FROM clientes c 
                                JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                GROUP BY c.tipo_evento_id 
                                ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($tipos_distribucion as $tipo):
                                // Determinar color del badge según el tipo de evento
                                $badge_color = '';
                                $text_color = 'white';
                                $tipo_text = $tipo['nombre'];
                                
                                if (stripos($tipo_text, 'civil') !== false) {
                                    $badge_color = '#ffc107';
                                    $text_color = '#000';
                                } elseif (stripos($tipo_text, 'religiosa') !== false) {
                                    $badge_color = '#198754';
                                } elseif (stripos($tipo_text, 'playa') !== false) {
                                    $badge_color = '#0dcaf0';
                                } elseif (stripos($tipo_text, 'intima') !== false) {
                                    $badge_color = '#6f42c1';
                                } elseif (stripos($tipo_text, 'lujo') !== false) {
                                    $badge_color = '#fd7e14';
                                } else {
                                    $badge_color = '#d4af37';
                                }
                            ?>
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: <?php echo $badge_color; ?>; color: <?php echo $text_color; ?>; padding: 5px 10px; font-weight: 500;">
                                        <?php echo $tipo_text; ?>
                                    </span>
                                </td>
                                <td><strong><?php echo $tipo['cantidad']; ?></strong></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" 
                                             style="width: <?php echo $tipo['porcentaje']; ?>%; background-color: var(--wedding-gold); color: white; display: flex; align-items: center; padding-left: 8px; font-weight: 500;">
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
                $ultimo_evento = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                             FROM clientes c 
                                             JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                             ORDER BY c.fecha_evento DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($ultimo_evento):
                    // Determinar color del badge
                    $badge_color = '';
                    $text_color = 'white';
                    $tipo_text = $ultimo_evento['tipo_nombre'];
                    
                    if (stripos($tipo_text, 'civil') !== false) {
                        $badge_color = '#ffc107';
                        $text_color = '#000';
                    } elseif (stripos($tipo_text, 'religiosa') !== false) {
                        $badge_color = '#198754';
                    } elseif (stripos($tipo_text, 'playa') !== false) {
                        $badge_color = '#0dcaf0';
                    } elseif (stripos($tipo_text, 'intima') !== false) {
                        $badge_color = '#6f42c1';
                    } elseif (stripos($tipo_text, 'lujo') !== false) {
                        $badge_color = '#fd7e14';
                    } else {
                        $badge_color = '#d4af37';
                    }
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
                                <?php echo $tipo_text; ?>
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
                                    <span class="badge" style="background-color: <?php echo $badge_color; ?>; color: <?php echo $text_color; ?>; padding: 5px 10px;">
                                        <?php echo $tipo_text; ?>
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
                $proximo_evento = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                              FROM clientes c 
                                              JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                              WHERE c.fecha_evento >= CURDATE() 
                                              ORDER BY c.fecha_evento ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($proximo_evento):
                    // Determinar color del badge
                    $badge_color = '';
                    $text_color = 'white';
                    $tipo_text = $proximo_evento['tipo_nombre'];
                    
                    if (stripos($tipo_text, 'civil') !== false) {
                        $badge_color = '#ffc107';
                        $text_color = '#000';
                    } elseif (stripos($tipo_text, 'religiosa') !== false) {
                        $badge_color = '#198754';
                    } elseif (stripos($tipo_text, 'playa') !== false) {
                        $badge_color = '#0dcaf0';
                    } elseif (stripos($tipo_text, 'intima') !== false) {
                        $badge_color = '#6f42c1';
                    } elseif (stripos($tipo_text, 'lujo') !== false) {
                        $badge_color = '#fd7e14';
                    } else {
                        $badge_color = '#d4af37';
                    }
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
                                <?php echo $tipo_text; ?>
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
                                    <span class="badge" style="background-color: <?php echo $badge_color; ?>; color: <?php echo $text_color; ?>; padding: 5px 10px;">
                                        <?php echo $tipo_text; ?>
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
                        $proximos_eventos = $db->query("SELECT c.nombre, c.fecha_evento, t.nombre as tipo_nombre 
                                                        FROM clientes c 
                                                        JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                                        WHERE c.fecha_evento >= CURDATE() 
                                                        ORDER BY c.fecha_evento ASC LIMIT 5 OFFSET 1")->fetchAll(PDO::FETCH_ASSOC);
                        if ($proximos_eventos):
                        ?>
                        <div class="list-group">
                            <?php foreach ($proximos_eventos as $evento): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span><?php echo htmlspecialchars($evento['nombre']); ?></span>
                                        <br>
                                        <small class="text-muted"><?php echo $evento['tipo_nombre']; ?></small>
                                    </div>
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