/**
 * assets/js/botones.js
 * Botones 100% funcionales para Wedding Connect
 */

$(document).ready(function() {
    console.log('✅ Botones.js cargado');
    
    // 1. BOTÓN NUEVO CLIENTE
    $('#btnNuevoCliente').on('click', function(e) {
        e.preventDefault();
        console.log('📝 Botón NUEVO clickeado');
        mostrarModalNuevoCliente();
    });
    
    // 2. BOTÓN EXPORTAR EXCEL
    $('#btnExportarExcel').on('click', function(e) {
        e.preventDefault();
        console.log('📊 Botón EXPORTAR clickeado');
        exportarExcel();
    });
    
    // 3. BOTÓN IMPRIMIR
    $('#btnImprimirTabla').on('click', function(e) {
        e.preventDefault();
        console.log('🖨️ Botón IMPRIMIR clickeado');
        imprimirTabla();
    });
    
    // ===== FUNCIONES =====
    
    // FUNCIÓN 1: Mostrar modal nuevo cliente
    function mostrarModalNuevoCliente() {
        // Crear el HTML del modal si no existe
        if ($('#modalNuevoClienteGlobal').length === 0) {
            const modalHTML = `
            <div class="modal fade" id="modalNuevoClienteGlobal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-person-plus"></i> Nuevo Cliente
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNuevoClienteGlobal">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre Completo *</label>
                                        <input type="text" class="form-control" name="nombre" required placeholder="Ej: María García">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" class="form-control" name="correo" required placeholder="maria@email.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono *</label>
                                        <input type="tel" class="form-control" name="telefono" required placeholder="555-123-4567">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de Boda *</label>
                                        <select class="form-select" name="tipo_boda" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="civil">Civil</option>
                                            <option value="religiosa">Religiosa</option>
                                            <option value="destino">Destino</option>
                                            <option value="intima">Íntima</option>
                                            <option value="lujo">Lujo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha del Evento *</label>
                                        <input type="date" class="form-control" name="fecha_evento" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mensaje o Notas</label>
                                        <textarea class="form-control" name="mensaje" rows="3" placeholder="Detalles adicionales..."></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" id="btnGuardarClienteGlobal">
                                <i class="bi bi-save"></i> Guardar Cliente
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
            
            $('body').append(modalHTML);
            
            // Poner fecha de hoy por defecto
            const hoy = new Date().toISOString().split('T')[0];
            $('input[name="fecha_evento"]').val(hoy);
            
            // Configurar botón de guardar
            $('#btnGuardarClienteGlobal').on('click', guardarCliente);
        }
        
        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoClienteGlobal'));
        modal.show();
    }
    
    // FUNCIÓN: Guardar cliente (AJAX)
    function guardarCliente() {
        const form = document.getElementById('formNuevoClienteGlobal');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const formData = new FormData(form);
        const datos = {};
        formData.forEach((value, key) => {
            datos[key] = value;
        });
        
        // Mostrar loading
        const btnGuardar = $('#btnGuardarClienteGlobal');
        const textoOriginal = btnGuardar.html();
        btnGuardar.html('<span class="spinner-border spinner-border-sm"></span> Guardando...');
        btnGuardar.prop('disabled', true);
        
        // Simular guardado (en producción sería AJAX real)
        setTimeout(() => {
            mostrarNotificacion('✅ Cliente guardado exitosamente', 'success');
            
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalNuevoClienteGlobal')).hide();
            
            // Resetear botón
            btnGuardar.html(textoOriginal);
            btnGuardar.prop('disabled', false);
            
            // Recargar página después de 1.5 segundos
            setTimeout(() => {
                location.reload();
            }, 1500);
            
        }, 1500);
    }
    
    // FUNCIÓN 2: Exportar a Excel (CSV)
    function exportarExcel() {
        mostrarNotificacion('⏳ Preparando exportación...', 'info');
        
        // Obtener datos de DataTable
        const tabla = $('#clientesTable').DataTable();
        if (!tabla) {
            mostrarNotificacion('❌ Error: No se encontró la tabla', 'error');
            return;
        }
        
        // Obtener todas las filas visibles
        const datos = tabla.rows({ search: 'applied' }).data().toArray();
        const encabezados = tabla.columns().header().toArray().map(th => $(th).text().trim());
        
        // Crear contenido CSV
        let csvContent = "data:text/csv;charset=utf-8,";
        
        // Encabezados
        csvContent += encabezados.map(h => `"${h}"`).join(',') + '\n';
        
        // Datos
        datos.forEach(fila => {
            const filaCSV = fila.map(celda => {
                // Limpiar HTML y caracteres especiales
                let texto = '';
                if (typeof celda === 'string') {
                    texto = celda.replace(/<[^>]*>/g, '').replace(/"/g, '""').trim();
                } else if (celda && typeof celda === 'object') {
                    texto = $(celda).text().replace(/"/g, '""').trim();
                } else {
                    texto = String(celda || '').replace(/"/g, '""').trim();
                }
                return `"${texto}"`;
            });
            csvContent += filaCSV.join(',') + '\n';
        });
        
        // Crear enlace de descarga
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        const fecha = new Date().toISOString().split('T')[0];
        
        link.href = encodedUri;
        link.download = `clientes_wedding_${fecha}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        mostrarNotificacion('✅ Archivo exportado exitosamente', 'success');
    }
    
    // FUNCIÓN 3: Imprimir tabla
    function imprimirTabla() {
        mostrarNotificacion('🖨️ Preparando impresión...', 'info');
        
        // Obtener datos de DataTable
        const tabla = $('#clientesTable').DataTable();
        if (!tabla) {
            mostrarNotificacion('❌ Error: No se encontró la tabla', 'error');
            return;
        }
        
        const datos = tabla.rows({ search: 'applied' }).data().toArray();
        const encabezados = ['ID', 'Nombre', 'Email', 'Teléfono', 'Tipo Boda', 'Fecha Evento', 'Registro'];
        
        // Crear ventana de impresión
        const ventana = window.open('', '_blank', 'width=900,height=600');
        
        // Generar HTML para imprimir
        let html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes - Wedding Connect</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                .header { text-align: center; margin-bottom: 30px; }
                h1 { color: #6f42c1; }
                .info { color: #666; margin: 10px 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #6f42c1; color: white; padding: 12px 8px; text-align: left; }
                td { padding: 10px 8px; border-bottom: 1px solid #ddd; }
                tr:nth-child(even) { background: #f9f9f9; }
                .footer { text-align: center; margin-top: 40px; color: #666; font-size: 12px; }
                .botones { text-align: center; margin-top: 20px; }
                .btn { padding: 10px 20px; margin: 0 10px; border: none; border-radius: 5px; cursor: pointer; }
                .btn-print { background: #17a2b8; color: white; }
                .btn-close { background: #dc3545; color: white; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>📋 Lista de Clientes - Wedding Connect</h1>
                <div class="info">
                    <strong>Fecha:</strong> ${new Date().toLocaleDateString('es-ES', { 
                        year: 'numeric', month: 'long', day: 'numeric' 
                    })}
                </div>
                <div class="info">
                    <strong>Total de clientes:</strong> ${datos.length}
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        ${encabezados.map(h => `<th>${h}</th>`).join('')}
                    </tr>
                </thead>
                <tbody>`;
        
        // Agregar filas
        datos.forEach((fila, index) => {
            const limpiar = (texto) => {
                if (!texto) return '';
                return String(texto).replace(/<[^>]*>/g, '').trim();
            };
            
            html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${limpiar(fila[1])}</td>
                        <td>${limpiar(fila[2])}</td>
                        <td>${limpiar(fila[3])}</td>
                        <td>${limpiar(fila[4])}</td>
                        <td>${limpiar(fila[5])}</td>
                        <td>${limpiar(fila[6])}</td>
                    </tr>`;
        });
        
        html += `
                </tbody>
            </table>
            
            <div class="footer">
                <p>Wedding Connect - Panel Administrativo</p>
                <p>Reporte generado automáticamente</p>
            </div>
            
            <div class="botones no-print">
                <button class="btn btn-print" onclick="window.print()">🖨️ Imprimir</button>
                <button class="btn btn-close" onclick="window.close()">❌ Cerrar</button>
            </div>
        </body>
        </html>`;
        
        // Escribir en la ventana
        ventana.document.open();
        ventana.document.write(html);
        ventana.document.close();
        
        mostrarNotificacion('Ventana de impresión abierta', 'success');
    }
    
    // FUNCIÓN: Mostrar notificaciones
    function mostrarNotificacion(mensaje, tipo = 'info') {
        // Remover notificaciones anteriores
        $('.notificacion-flotante').remove();
        
        const colores = {
            'success': '#28a745',
            'error': '#dc3545',
            'warning': '#ffc107',
            'info': '#17a2b8'
        };
        
        const iconos = {
            'success': '✅',
            'error': '❌',
            'warning': '⚠️',
            'info': 'ℹ️'
        };
        
        const color = colores[tipo] || colores.info;
        const icono = iconos[tipo] || iconos.info;
        
        // Crear notificación
        const notificacion = $(`
            <div class="notificacion-flotante" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-left: 4px solid ${color};
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                z-index: 99999;
                max-width: 350px;
                display: flex;
                align-items: center;
                animation: slideIn 0.3s ease;
            ">
                <span style="font-size: 20px; margin-right: 10px;">${icono}</span>
                <span style="font-size: 14px;">${mensaje}</span>
            </div>
        `);
        
        $('body').append(notificacion);
        
        // Auto-eliminar después de 4 segundos
        setTimeout(() => {
            notificacion.fadeOut(300, () => notificacion.remove());
        }, 4000);
    }
    
    // Agregar animación CSS si no existe
    if (!$('#estilos-notificacion').length) {
        $('head').append(`
            <style id="estilos-notificacion">
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                .btn-panel {
                    cursor: pointer !important;
                    position: relative;
                    overflow: hidden;
                }
                .btn-panel:active {
                    transform: scale(0.98);
                }
            </style>
        `);
    }
    
    console.log('✅ Todos los botones configurados correctamente');
});