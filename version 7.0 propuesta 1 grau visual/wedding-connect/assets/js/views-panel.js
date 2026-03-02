/**
 * script modal cambio de contraseña
 */

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
            color = '#28a745';
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

/**
 * script de clientes.php
 */
// ========================================
// FUNCIÓN DE BÚSQUEDA EN TIEMPO REAL
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorClientes');
    if (!buscador) return;
    
    const tabla = document.getElementById('clientesTable');
    if (!tabla) return;
    
    const filas = tabla.querySelectorAll('tbody tr');
    const sinResultados = document.getElementById('sinResultados');
    const mostrandoCount = document.getElementById('mostrandoCount');
    
    buscador.addEventListener('input', function() {
        const termino = this.value.toLowerCase().trim();
        let contadorVisible = 0;
        
        filas.forEach(fila => {
            // Obtener texto de las celdas relevantes
            const nombre = fila.querySelector('.nombre-cliente')?.textContent.toLowerCase() || '';
            const email = fila.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const telefono = fila.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            const tipoEvento = fila.querySelector('.tipo-evento')?.textContent.toLowerCase() || '';
            const id = fila.querySelector('td:first-child')?.textContent.toLowerCase() || '';
            
            // Buscar en todos los campos
            const coincide = nombre.includes(termino) || 
                            email.includes(termino) || 
                            telefono.includes(termino) || 
                            tipoEvento.includes(termino) ||
                            id.includes(termino);
            
            if (termino === '' || coincide) {
                fila.style.display = '';
                contadorVisible++;
            } else {
                fila.style.display = 'none';
            }
        });
        
        // Actualizar contador
        if (mostrandoCount) {
            mostrandoCount.textContent = contadorVisible;
        }
        
        // Mostrar/ocultar mensaje sin resultados
        if (sinResultados) {
            sinResultados.style.display = contadorVisible === 0 ? 'block' : 'none';
        }
    });
    
    // Limpiar búsqueda con Escape
    buscador.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            this.dispatchEvent(new Event('input'));
        }
    });
});

// ========================================
// VARIABLES PARA ORDENAMIENTO
// ========================================
let columnaActualClientes = 0;
let direccionActualClientes = 'asc';

// ========================================
// FUNCIÓN PARA ORDENAR TABLA DE CLIENTES
// ========================================
function ordenarTablaClientes(columna) {
    const tabla = document.getElementById('clientesTable');
    if (!tabla) return;
    
    const tbody = tabla.querySelector('tbody');
    const filas = Array.from(tbody.querySelectorAll('tr'));
    const headers = tabla.querySelectorAll('thead th');
    
    // Resetear iconos
    for (let i = 0; i < headers.length - 1; i++) {
        const icono = document.getElementById('iconoC' + i);
        if (icono) icono.textContent = '⇅';
    }
    
    // Determinar dirección
    if (columnaActualClientes === columna) {
        direccionActualClientes = direccionActualClientes === 'asc' ? 'desc' : 'asc';
    } else {
        columnaActualClientes = columna;
        direccionActualClientes = 'asc';
    }
    
    // Actualizar icono
    const iconoActual = document.getElementById('iconoC' + columna);
    if (iconoActual) {
        iconoActual.textContent = direccionActualClientes === 'asc' ? '↑' : '↓';
    }
    
    // Ordenar filas
    filas.sort((a, b) => {
        const celdasA = a.querySelectorAll('td');
        const celdasB = b.querySelectorAll('td');
        
        if (columna === 7) return 0; // No ordenar columna de acciones
        
        let valorA = celdasA[columna]?.getAttribute('data-sort') || celdasA[columna]?.textContent.trim() || '';
        let valorB = celdasB[columna]?.getAttribute('data-sort') || celdasB[columna]?.textContent.trim() || '';
        
        // Quitar # de IDs para orden numérico
        if (columna === 0) {
            valorA = parseInt(valorA.replace('#', ''));
            valorB = parseInt(valorB.replace('#', ''));
        } else if (!isNaN(valorA) && !isNaN(valorB) && valorA !== '' && valorB !== '') {
            valorA = parseFloat(valorA);
            valorB = parseFloat(valorB);
        } else {
            valorA = valorA.toString().toLowerCase();
            valorB = valorB.toString().toLowerCase();
        }
        
        if (direccionActualClientes === 'asc') {
            return valorA < valorB ? -1 : valorA > valorB ? 1 : 0;
        } else {
            return valorA > valorB ? -1 : valorA < valorB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    filas.forEach(fila => tbody.appendChild(fila));
}

// ========================================
// FUNCIÓN PARA VER DETALLES DE CLIENTE
// ========================================
function verDetallesCliente(clienteId) {
    const modalElement = document.getElementById('modalCliente' + clienteId);
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    } else {
        console.error('Modal no encontrado:', 'modalCliente' + clienteId);
        if (typeof showToast === 'function') {
            showToast('Error: No se encontró el modal del cliente', 'error');
        }
    }
}

// ========================================
// FUNCIÓN PARA EDITAR CLIENTE
// ========================================
function editarCliente(clienteId) {
    if (typeof showToast === 'function') {
        showToast('⏳ Cargando datos del cliente...', 'info');
    }
    
    // Buscar la fila del cliente
    const fila = document.querySelector(`tr[data-id="${clienteId}"]`);
    
    if (fila) {
        // Extraer datos de los atributos data
        const nombre = fila.dataset.nombre || '';
        const correo = fila.dataset.correo || '';
        const telefono = fila.dataset.telefono || '';
        const tipoEventoId = fila.dataset.tipo || '';
        const fechaEvento = fila.dataset.fecha || '';
        const mensaje = fila.dataset.mensaje || '';
        
        // Llenar el formulario de edición
        document.getElementById('editar_cliente_id').value = clienteId;
        document.getElementById('editar_nombre').value = nombre;
        document.getElementById('editar_correo').value = correo;
        document.getElementById('editar_telefono').value = telefono;
        
        // Establecer tipo de evento
        const selectTipo = document.getElementById('editar_tipo_evento_id');
        if (selectTipo) {
            selectTipo.value = tipoEventoId;
        }
        
        // Establecer fecha
        if (fechaEvento) {
            document.getElementById('editar_fecha_evento').value = fechaEvento;
        }
        
        // Establecer mensaje
        document.getElementById('editar_mensaje').value = mensaje;
        
        // Cerrar cualquier modal abierto
        document.querySelectorAll('.modal').forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) modalInstance.hide();
        });
        
        // Eliminar backdrops residuales
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        
        // Mostrar el modal de edición
        setTimeout(() => {
            const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
            modal.show();
            if (typeof showToast === 'function') {
                showToast('✅ Datos cargados correctamente', 'success');
            }
        }, 300);
    } else {
        // Fallback: cargar vía AJAX
        fetch(`../obtener_cliente.php?id=${clienteId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editar_cliente_id').value = data.cliente.id;
                    document.getElementById('editar_nombre').value = data.cliente.nombre;
                    document.getElementById('editar_correo').value = data.cliente.correo;
                    document.getElementById('editar_telefono').value = data.cliente.telefono;
                    document.getElementById('editar_tipo_evento_id').value = data.cliente.tipo_boda;
                    document.getElementById('editar_fecha_evento').value = data.cliente.fecha_evento;
                    document.getElementById('editar_mensaje').value = data.cliente.mensaje || '';
                    
                    document.querySelectorAll('.modal').forEach(modal => {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    });
                    
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                    
                    setTimeout(() => {
                        const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                        modal.show();
                        if (typeof showToast === 'function') {
                            showToast('✅ Datos cargados correctamente', 'success');
                        }
                    }, 300);
                } else {
                    if (typeof showToast === 'function') {
                        showToast('❌ Error al cargar los datos', 'error');
                    }
                }
            })
            .catch(() => {
                if (typeof showToast === 'function') {
                    showToast('❌ Error de conexión', 'error');
                }
            });
    }
}

// ========================================
// FUNCIÓN PARA EXPORTAR A EXCEL
// ========================================
function exportarClientesExcel() {
    const tabla = document.getElementById('clientesTable');
    if (!tabla) return;
    
    const filas = tabla.querySelectorAll('tr');
    let csv = [];
    
    // Encabezados
    const encabezados = ['ID', 'Nombre', 'Email', 'Teléfono', 'Tipo Evento', 'Fecha Evento', 'Registro'];
    csv.push(encabezados.join(','));
    
    // Datos
    filas.forEach((fila, index) => {
        if (index === 0) return; // Saltar encabezados originales
        
        // Solo exportar filas visibles
        if (fila.style.display === 'none') return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 7) return;
        
        const filaDatos = [];
        for (let i = 0; i < 7; i++) {
            let texto = celdas[i]?.textContent.trim().replace(/#/g, '') || '';
            // Limpiar texto y escapar comas
            texto = texto.replace(/,/g, ';').replace(/\n/g, ' ');
            filaDatos.push(`"${texto}"`);
        }
        csv.push(filaDatos.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', 'clientes_wedding_connect_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    if (typeof showToast === 'function') {
        showToast('✅ Archivo CSV generado correctamente', 'success');
    }
}

// ========================================
// FUNCIÓN PARA IMPRIMIR TABLA
// ========================================
function imprimirTablaClientes() {
    const ventana = window.open('', '_blank');
    
    // Obtener la fecha actual
    const ahora = new Date();
    const fechaActual = ahora.toLocaleDateString('es-ES', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Construir HTML de impresión
    let html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Clientes - Wedding Connect</title>
            <style>
                body { font-family: 'Arial', sans-serif; margin: 20px; }
                h1 { color: #9b87b8; text-align: center; font-family: 'Great Vibes', cursive; font-size: 3rem; }
                .fecha { text-align: right; margin-bottom: 20px; color: #666; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: linear-gradient(135deg, #9b87b8, #f5c6a0); color: white; padding: 10px; }
                td { padding: 8px; border: 1px solid #ddd; }
                .badge { background: #9b87b8; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.85rem; }
                .footer { margin-top: 30px; text-align: center; color: #666; font-size: 0.9rem; }
            </style>
        </head>
        <body>
            <h1>💍 Wedding Connect</h1>
            <div class="fecha">Fecha de impresión: ${fechaActual}</div>
            <table>
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
    `;
    
    // Agregar filas visibles
    const filas = document.querySelectorAll('#clientesTable tbody tr');
    filas.forEach(fila => {
        if (fila.style.display === 'none') return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 7) return;
        
        html += '<tr>';
        for (let i = 0; i < 7; i++) {
            html += `<td>${celdas[i]?.innerHTML.replace(/<[^>]*>/g, '') || ''}</td>`;
        }
        html += '</tr>';
    });
    
    html += `
                </tbody>
            </table>
            <div class="footer">
                <p>Wedding Connect - Sistema de Gestión de Bodas y Eventos</p>
                <p>Reporte generado el ${fechaActual}</p>
            </div>
            <script>window.onload = function() { window.print(); window.close(); }<\/script>
        </body>
        </html>
    `;
    
    ventana.document.write(html);
    ventana.document.close();
}

// ========================================
// INICIALIZAR EVENTOS DE CLIENTES
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Script de clientes cargado correctamente');
    
    // Botones de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('¿Estás segura de eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });
});

/**
 * script del dashboard.php
 */
// Variables para ordenamiento
let columnaActual = 0;
let direccionActual = 'asc';

function ordenarTabla(columna) {
    const tabla = document.getElementById('tablaDashboard');
    if (!tabla) return;
    
    const tbody = tabla.querySelector('tbody');
    const filas = Array.from(tbody.querySelectorAll('tr'));
    const headers = tabla.querySelectorAll('thead th');
    
    // Resetear iconos
    for (let i = 0; i < headers.length; i++) {
        const icono = document.getElementById('icono' + i);
        if (icono) icono.textContent = '⇅';
    }
    
    // Determinar dirección
    if (columnaActual === columna) {
        direccionActual = direccionActual === 'asc' ? 'desc' : 'asc';
    } else {
        columnaActual = columna;
        direccionActual = 'asc';
    }
    
    // Actualizar icono
    const iconoActual = document.getElementById('icono' + columna);
    if (iconoActual) {
        iconoActual.textContent = direccionActual === 'asc' ? '↑' : '↓';
    }
    
    // Ordenar filas
    filas.sort((a, b) => {
        const celdasA = a.querySelectorAll('td');
        const celdasB = b.querySelectorAll('td');
        
        let valorA = celdasA[columna]?.getAttribute('data-sort') || celdasA[columna]?.textContent.trim() || '';
        let valorB = celdasB[columna]?.getAttribute('data-sort') || celdasB[columna]?.textContent.trim() || '';
        
        // Quitar # de IDs para orden numérico
        if (columna === 0) {
            valorA = parseInt(valorA.replace('#', ''));
            valorB = parseInt(valorB.replace('#', ''));
        } else if (!isNaN(valorA) && !isNaN(valorB) && valorA !== '' && valorB !== '') {
            valorA = parseFloat(valorA);
            valorB = parseFloat(valorB);
        } else {
            valorA = valorA.toString().toLowerCase();
            valorB = valorB.toString().toLowerCase();
        }
        
        if (direccionActual === 'asc') {
            return valorA < valorB ? -1 : valorA > valorB ? 1 : 0;
        } else {
            return valorA > valorB ? -1 : valorA < valorB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    filas.forEach(fila => tbody.appendChild(fila));
}

function viewClientDetails(clientId) {
    const modal = new bootstrap.Modal(document.getElementById('modalCliente' + clientId));
    modal.show();
}

/**
 * script de eventos.php - VERSIÓN CORREGIDA
 */
// ========================================
// VARIABLES PARA ORDENAMIENTO
// ========================================
let columnaActualEventos = 0;
let direccionActualEventos = 'asc';

// ========================================
// FUNCIÓN PARA ORDENAR TABLA DE EVENTOS
// ========================================
function ordenarTablaEventos(columna) {
    const tabla = document.getElementById('eventosTable');
    if (!tabla) return;
    
    const tbody = tabla.querySelector('tbody');
    const filas = Array.from(tbody.querySelectorAll('tr'));
    const headers = tabla.querySelectorAll('thead th');
    
    // Resetear iconos
    for (let i = 0; i < headers.length - 1; i++) {
        const icono = document.getElementById('iconoE' + i);
        if (icono) icono.textContent = '⇅';
    }
    
    // Determinar dirección
    if (columnaActualEventos === columna) {
        direccionActualEventos = direccionActualEventos === 'asc' ? 'desc' : 'asc';
    } else {
        columnaActualEventos = columna;
        direccionActualEventos = 'asc';
    }
    
    // Actualizar icono
    const iconoActual = document.getElementById('iconoE' + columna);
    if (iconoActual) {
        iconoActual.textContent = direccionActualEventos === 'asc' ? '↑' : '↓';
    }
    
    // Ordenar filas
    filas.sort((a, b) => {
        const celdasA = a.querySelectorAll('td');
        const celdasB = b.querySelectorAll('td');
        
        if (columna === 6) return 0; // No ordenar columna de acciones
        
        let valorA = celdasA[columna]?.getAttribute('data-sort') || celdasA[columna]?.textContent.trim() || '';
        let valorB = celdasB[columna]?.getAttribute('data-sort') || celdasB[columna]?.textContent.trim() || '';
        
        // Conversión especial para días restantes
        if (columna === 4) {
            if (valorA === 'Finalizado') valorA = -1;
            if (valorB === 'Finalizado') valorB = -1;
            if (valorA === '¡HOY!') valorA = 0;
            if (valorB === '¡HOY!') valorB = 0;
        }
        
        if (!isNaN(valorA) && !isNaN(valorB) && valorA !== '' && valorB !== '') {
            valorA = parseFloat(valorA);
            valorB = parseFloat(valorB);
        } else {
            valorA = valorA.toString().toLowerCase();
            valorB = valorB.toString().toLowerCase();
        }
        
        if (direccionActualEventos === 'asc') {
            return valorA < valorB ? -1 : valorA > valorB ? 1 : 0;
        } else {
            return valorA > valorB ? -1 : valorA < valorB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    filas.forEach(fila => tbody.appendChild(fila));
}

// ========================================
// FUNCIÓN PARA FILTRAR EVENTOS (CORREGIDA)
// ========================================
function filtrarEventos(filtro) {
    console.log('Filtrando eventos por:', filtro); // Para depuración
    
    const filas = document.querySelectorAll('#eventosTable tbody tr');
    const botones = document.querySelectorAll('#filtrosEventos .btn');
    
    // Quitar clase active de todos los botones
    botones.forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Activar el botón correspondiente
    botones.forEach(btn => {
        const textoBoton = btn.textContent.trim().toLowerCase();
        
        if ((filtro === 'todos' && textoBoton.includes('todos')) ||
            (filtro === 'programado' && textoBoton.includes('programado')) ||
            (filtro === 'proximo' && (textoBoton.includes('próximo') || textoBoton.includes('proximo'))) ||
            (filtro === 'hoy' && textoBoton.includes('hoy')) ||
            (filtro === 'completado' && textoBoton.includes('completado'))) {
            btn.classList.add('active');
        }
    });
    
    // Contar filas visibles
    let contadorVisible = 0;
    
    // Aplicar filtro a las filas
    filas.forEach(fila => {
        const estado = fila.getAttribute('data-estado');
        console.log('Fila estado:', estado, 'vs filtro:', filtro); // Para depuración
        
        if (filtro === 'todos') {
            fila.style.display = '';
            contadorVisible++;
        } else {
            if (estado === filtro) {
                fila.style.display = '';
                contadorVisible++;
            } else {
                fila.style.display = 'none';
            }
        }
    });
    
    // Actualizar contador de resultados
    const mostrandoCount = document.getElementById('mostrandoCountEventos');
    if (mostrandoCount) {
        mostrandoCount.textContent = contadorVisible;
    }
    
    // Mostrar/ocultar mensaje sin resultados
    const sinResultados = document.getElementById('sinResultadosEventos');
    if (sinResultados) {
        sinResultados.style.display = contadorVisible === 0 ? 'block' : 'none';
    }
    
    console.log('Filas visibles después del filtro:', contadorVisible);
}

// ========================================
// FUNCIÓN DE BÚSQUEDA EN TIEMPO REAL PARA EVENTOS (CORREGIDA)
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorEventos');
    if (!buscador) return;
    
    const tabla = document.getElementById('eventosTable');
    if (!tabla) return;
    
    const filas = tabla.querySelectorAll('tbody tr');
    const sinResultados = document.getElementById('sinResultadosEventos');
    const mostrandoCount = document.getElementById('mostrandoCountEventos');
    
    function filtrarTabla() {
        const termino = buscador.value.toLowerCase().trim();
        let contadorVisible = 0;
        
        // Obtener el filtro activo actual
        let filtroActivo = 'todos';
        const botonActivo = document.querySelector('#filtrosEventos .btn.active');
        if (botonActivo) {
            const onclickAttr = botonActivo.getAttribute('onclick');
            if (onclickAttr) {
                const match = onclickAttr.match(/filtrarEventos\('([^']+)'\)/);
                if (match) filtroActivo = match[1];
            }
        }
        
        filas.forEach(fila => {
            // Obtener texto de las celdas relevantes
            const cliente = fila.querySelector('.nombre-cliente-evento')?.textContent.toLowerCase() || '';
            const contacto = fila.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const tipo = fila.querySelector('.tipo-evento-evento')?.textContent.toLowerCase() || '';
            
            // Buscar en todos los campos
            const coincide = termino === '' || 
                            cliente.includes(termino) || 
                            contacto.includes(termino) || 
                            tipo.includes(termino);
            
            // Verificar filtro de estado
            const estado = fila.getAttribute('data-estado');
            const coincideFiltro = filtroActivo === 'todos' || estado === filtroActivo;
            
            if (coincide && coincideFiltro) {
                fila.style.display = '';
                contadorVisible++;
            } else {
                fila.style.display = 'none';
            }
        });
        
        // Actualizar contador
        if (mostrandoCount) {
            mostrandoCount.textContent = contadorVisible;
        }
        
        // Mostrar/ocultar mensaje sin resultados
        if (sinResultados) {
            sinResultados.style.display = contadorVisible === 0 ? 'block' : 'none';
        }
    }
    
    buscador.addEventListener('input', filtrarTabla);
    
    // Limpiar búsqueda con Escape
    buscador.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            filtrarTabla();
        }
    });
});

// ========================================
// INICIALIZAR EVENTOS DE EVENTOS
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Script de eventos cargado correctamente');
    
    // Verificar que los estados están correctos (depuración)
    setTimeout(() => {
        const filas = document.querySelectorAll('#eventosTable tbody tr');
        filas.forEach((fila, index) => {
            console.log(`Fila ${index + 1}:`, fila.getAttribute('data-estado'));
        });
    }, 1000);
    
    // Ajustar botones en móviles
    const filtrosDiv = document.getElementById('filtrosEventos');
    if (window.innerWidth < 768 && filtrosDiv) {
        filtrosDiv.classList.add('btn-group-vertical');
        filtrosDiv.classList.remove('btn-group');
    }
    
    window.addEventListener('resize', function() {
        if (filtrosDiv) {
            if (window.innerWidth < 768) {
                filtrosDiv.classList.add('btn-group-vertical');
                filtrosDiv.classList.remove('btn-group');
            } else {
                filtrosDiv.classList.add('btn-group');
                filtrosDiv.classList.remove('btn-group-vertical');
            }
        }
    });
});
/**
 * script de reportes.php
 */
// ========================================
// GRÁFICO DE BARRAS HORIZONTAL PARA REPORTES
// ========================================
let graficoBarras = null;

function inicializarGraficoBarras() {
    const canvas = document.getElementById('graficoBarras');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Obtener datos de la tabla
    const filas = document.querySelectorAll('#reportesTable tbody tr');
    const tipos = [];
    const cantidades = [];
    const colores = [
        '#9b87b8', '#f5c6a0', '#e8b4b8', '#8a9a5b', '#800020', 
        '#6f42c1', '#0dcaf0', '#fd7e14', '#20c997', '#dc3545'
    ];
    
    let colorIndex = 0;
    let total = 0;
    
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 3) return;
        
        const tipo = celdas[0]?.textContent.trim() || '';
        const cantidad = parseInt(celdas[1]?.textContent.trim() || '0');
        
        if (tipo && cantidad > 0) {
            tipos.push(tipo);
            cantidades.push(cantidad);
            total += cantidad;
            colorIndex++;
        }
    });
    
    if (tipos.length === 0) return;
    
    // Destruir gráfico anterior
    if (graficoBarras) {
        graficoBarras.destroy();
    }
    
    // Crear gráfico de barras horizontales
    graficoBarras = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tipos,
            datasets: [{
                label: 'Cantidad de Eventos',
                data: cantidades,
                backgroundColor: colores.slice(0, tipos.length),
                borderColor: 'white',
                borderWidth: 1,
                borderRadius: 8,
                barPercentage: 0.7
            }]
        },
        options: {
            indexAxis: 'y', // Barras horizontales
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.dataset.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    title: {
                        display: true,
                        text: 'Número de Eventos',
                        color: '#666',
                        font: { family: 'Inter', size: 12 }
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        maxRotation: 0
                    }
                }
            }
        }
    });
    
    console.log('✅ Gráfico de barras inicializado');
}

// ========================================
// FUNCIÓN PARA EXPORTAR GRÁFICO
// ========================================
function exportarGrafico() {
    const canvas = document.getElementById('graficoBarras');
    if (!canvas) {
        if (typeof showToast === 'function') {
            showToast('❌ No hay gráfico para exportar', 'error');
        }
        return;
    }
    
    const link = document.createElement('a');
    link.download = 'grafico_distribucion_' + new Date().toISOString().split('T')[0] + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
    
    if (typeof showToast === 'function') {
        showToast('✅ Gráfico exportado como imagen', 'success');
    }
}

// ========================================
// VARIABLES PARA ORDENAMIENTO DE REPORTES
// ========================================
let columnaActualReportes = 0;
let direccionActualReportes = 'asc';

// ========================================
// FUNCIÓN PARA ORDENAR TABLA DE REPORTES
// ========================================
function ordenarTablaReportes(columna) {
    const tabla = document.getElementById('reportesTable');
    if (!tabla) return;
    
    const tbody = tabla.querySelector('tbody');
    const filas = Array.from(tbody.querySelectorAll('tr'));
    const headers = tabla.querySelectorAll('thead th');
    
    // Resetear iconos
    for (let i = 0; i < headers.length; i++) {
        const icono = document.getElementById('iconoR' + i);
        if (icono) icono.textContent = '⇅';
    }
    
    // Determinar dirección
    if (columnaActualReportes === columna) {
        direccionActualReportes = direccionActualReportes === 'asc' ? 'desc' : 'asc';
    } else {
        columnaActualReportes = columna;
        direccionActualReportes = 'asc';
    }
    
    // Actualizar icono
    const iconoActual = document.getElementById('iconoR' + columna);
    if (iconoActual) {
        iconoActual.textContent = direccionActualReportes === 'asc' ? '↑' : '↓';
    }
    
    // Ordenar filas
    filas.sort((a, b) => {
        const celdasA = a.querySelectorAll('td');
        const celdasB = b.querySelectorAll('td');
        
        let valorA = celdasA[columna]?.getAttribute('data-sort') || celdasA[columna]?.textContent.trim() || '';
        let valorB = celdasB[columna]?.getAttribute('data-sort') || celdasB[columna]?.textContent.trim() || '';
        
        // Convertir a números si es posible
        if (!isNaN(valorA) && !isNaN(valorB) && valorA !== '' && valorB !== '') {
            valorA = parseFloat(valorA);
            valorB = parseFloat(valorB);
        } else {
            valorA = valorA.toString().toLowerCase();
            valorB = valorB.toString().toLowerCase();
        }
        
        if (direccionActualReportes === 'asc') {
            return valorA < valorB ? -1 : valorA > valorB ? 1 : 0;
        } else {
            return valorA > valorB ? -1 : valorA < valorB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    filas.forEach(fila => tbody.appendChild(fila));
}

// ========================================
// FUNCIÓN PARA EXPORTAR REPORTE A EXCEL
// ========================================
function exportarReporteExcel() {
    const tabla = document.getElementById('reportesTable');
    if (!tabla) return;
    
    const filas = tabla.querySelectorAll('tr');
    let csv = [];
    
    // Encabezados
    const encabezados = ['Tipo de Evento', 'Cantidad', 'Porcentaje'];
    csv.push(encabezados.join(','));
    
    // Datos
    filas.forEach((fila, index) => {
        if (index === 0) return; // Saltar encabezados originales
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 3) return;
        
        const tipo = celdas[0]?.textContent.trim() || '';
        const cantidad = celdas[1]?.textContent.trim() || '';
        let porcentaje = celdas[2]?.textContent.trim() || '';
        
        // Limpiar porcentaje (quitar el %)
        porcentaje = porcentaje.replace('%', '');
        
        csv.push(`"${tipo}",${cantidad},${porcentaje}`);
    });
    
    // Calcular total de la tabla (suma de cantidades)
    let totalClientes = 0;
    document.querySelectorAll('#reportesTable tbody td:nth-child(2)').forEach(td => {
        totalClientes += parseInt(td.textContent.trim() || '0');
    });
    
    csv.push(`"TOTAL",${totalClientes},100%`);
    
    const csvContent = csv.join('\n');
    const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', 'reportes_wedding_connect_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    if (typeof showToast === 'function') {
        showToast('✅ Reporte exportado correctamente', 'success');
    } else {
        alert('✅ Reporte exportado correctamente');
    }
}

// ========================================
// FUNCIÓN PARA IMPRIMIR REPORTE
// ========================================
function imprimirReporte() {
    const ventana = window.open('', '_blank');
    
    // Obtener la fecha actual
    const ahora = new Date();
    const fechaActual = ahora.toLocaleDateString('es-MX', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Obtener datos de la tabla
    const filas = document.querySelectorAll('#reportesTable tbody tr');
    let filasHTML = '';
    let totalClientes = 0;
    
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 3) return;
        
        const tipo = celdas[0]?.textContent.trim() || '';
        const cantidad = celdas[1]?.textContent.trim() || '';
        const porcentaje = celdas[2]?.textContent.trim() || '';
        
        totalClientes += parseInt(cantidad || '0');
        
        filasHTML += `
            <tr>
                <td>${tipo}</td>
                <td style="text-align: center;">${cantidad}</td>
                <td>
                    <div style="background: #f0f0f0; height: 20px; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: ${porcentaje}; background: linear-gradient(90deg, #9b87b8, #f5c6a0); text-align: center; color: white; font-size: 0.8rem; line-height: 20px;">
                            ${porcentaje}
                        </div>
                    </div>
                </td>
            </tr>
        `;
    });
    
    // Obtener estadísticas del DOM
    const totalTiposEventos = document.querySelectorAll('#reportesTable tbody tr').length;
    
    // Construir HTML de impresión
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reportes - Wedding Connect</title>
            <style>
                body { font-family: 'Arial', sans-serif; margin: 20px; }
                h1 { color: #9b87b8; text-align: center; font-family: 'Great Vibes', cursive; font-size: 3rem; }
                h2 { color: #9b87b8; margin-top: 30px; }
                .fecha { text-align: right; margin-bottom: 20px; color: #666; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: linear-gradient(135deg, #9b87b8, #f5c6a0); color: white; padding: 12px; text-align: left; }
                td { padding: 10px; border: 1px solid #ddd; }
                .badge { background: #9b87b8; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.85rem; }
                .footer { margin-top: 30px; text-align: center; color: #666; font-size: 0.9rem; border-top: 1px solid #ddd; padding-top: 20px; }
                .stats { display: flex; justify-content: space-around; margin: 30px 0; }
                .stat-box { text-align: center; padding: 15px; background: #f8f8f8; border-radius: 10px; flex: 1; margin: 0 10px; }
                .stat-number { font-size: 2rem; font-weight: bold; color: #9b87b8; }
                .stat-label { color: #666; }
            </style>
        </head>
        <body>
            <h1>💍 Wedding Connect</h1>
            <div class="fecha">Fecha de impresión: ${fechaActual}</div>
            
            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number">${totalTiposEventos}</div>
                    <div class="stat-label">Tipos de Eventos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${totalClientes}</div>
                    <div class="stat-label">Total Clientes</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${totalTiposEventos}</div>
                    <div class="stat-label">Variedad Eventos</div>
                </div>
            </div>
            
            <h2>Distribución por Tipo de Evento</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Evento</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    ${filasHTML}
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background: #f0f0f0;">
                        <td>TOTAL</td>
                        <td style="text-align: center;">${totalClientes}</td>
                        <td>100%</td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="footer">
                <p>Wedding Connect - Sistema de Gestión de Bodas y Eventos</p>
                <p>Reporte generado el ${fechaActual}</p>
            </div>
            
            <script>
                window.onload = function() { 
                    window.print(); 
                    setTimeout(() => window.close(), 1000);
                }
            <\/script>
        </body>
        </html>
    `;
    
    ventana.document.write(html);
    ventana.document.close();
}

// ========================================
// INICIALIZAR REPORTES
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Script de reportes cargado correctamente');
    
    // Inicializar gráfico de barras
    setTimeout(() => {
        inicializarGraficoBarras();
    }, 500);
});

// ========================================
// FUNCIÓN GLOBAL SHOWTOAST (por si no existe)
// ========================================
if (typeof showToast !== 'function') {
    window.showToast = function(message, type = 'info') {
        console.log(`[${type.toUpperCase()}] ${message}`);
        alert(message);
    };
}
//==========================================================
//validacion formularios en modales.php
//==========================================================

// Función para validar nombre (solo letras y espacios)
function validarNombre(input, prefijo = 'nuevo') {
    const valor = input.value;
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]*$/;
    const helpElement = document.getElementById(`${prefijo}_nombre_help`);
    
    if (!regex.test(valor)) {
        input.value = valor.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ ]/g, '');
        helpElement.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> Solo se permiten letras y espacios';
        helpElement.classList.add('text-warning');
    } else if (valor.length > 50) {
        input.value = valor.substring(0, 50);
        helpElement.innerHTML = '<i class="bi bi-info-circle"></i> Máximo 50 caracteres';
        helpElement.classList.remove('text-warning');
        helpElement.classList.add('text-muted');
    } else {
        helpElement.innerHTML = '<i class="bi bi-info-circle"></i> Solo letras, máximo 50 caracteres';
        helpElement.classList.remove('text-warning');
        helpElement.classList.add('text-muted');
    }
}

// Función para validar email
function validarEmail(input, prefijo = 'nuevo') {
    const valor = input.value;
    const helpElement = document.getElementById(`${prefijo}_correo_help`);
    
    if (valor.length > 60) {
        input.value = valor.substring(0, 60);
    }
    
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (valor && !regex.test(valor)) {
        helpElement.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> Formato de email inválido';
        helpElement.classList.add('text-warning');
    } else {
        helpElement.innerHTML = '<i class="bi bi-info-circle"></i> Máximo 60 caracteres';
        helpElement.classList.remove('text-warning');
        helpElement.classList.add('text-muted');
    }
}

// Función para validar teléfono (solo 10 dígitos)
function validarTelefono(input, prefijo = 'nuevo') {
    let valor = input.value;
    const helpElement = document.getElementById(`${prefijo}_telefono_help`);
    
    // Eliminar cualquier caracter que no sea número
    valor = valor.replace(/\D/g, '');
    
    // Limitar a 10 dígitos
    if (valor.length > 10) {
        valor = valor.substring(0, 10);
    }
    
    input.value = valor;
    
    if (valor.length < 10 && valor.length > 0) {
        helpElement.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> Deben ser 10 dígitos';
        helpElement.classList.add('text-warning');
    } else {
        helpElement.innerHTML = '<i class="bi bi-info-circle"></i> 10 dígitos, solo números';
        helpElement.classList.remove('text-warning');
        helpElement.classList.add('text-muted');
    }
}

// Función para contar palabras en el mensaje
function contarPalabras(textarea, elementoId) {
    const texto = textarea.value.trim();
    const palabras = texto === '' ? 0 : texto.split(/\s+/).length;
    const helpElement = document.getElementById(elementoId);
    
    if (palabras > 200) {
        // Limitar a 200 palabras
        const palabrasArray = texto.split(/\s+/);
        const textoLimitado = palabrasArray.slice(0, 200).join(' ');
        textarea.value = textoLimitado;
        helpElement.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> 200/200 palabras (máximo alcanzado)';
        helpElement.classList.add('text-warning');
    } else {
        helpElement.innerHTML = `<i class="bi bi-info-circle"></i> ${palabras}/200 palabras`;
        helpElement.classList.remove('text-warning');
        helpElement.classList.add('text-muted');
    }
}

// Validación al enviar formulario nuevo cliente
function validarFormularioNuevoCliente() {
    const nombre = document.getElementById('nuevo_nombre').value.trim();
    const correo = document.getElementById('nuevo_correo').value.trim();
    const telefono = document.getElementById('nuevo_telefono').value.trim();
    const mensaje = document.getElementById('nuevo_mensaje').value.trim();
    
    // Validar nombre (solo letras)
    const nombreRegex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/;
    if (!nombreRegex.test(nombre)) {
        alert('El nombre solo puede contener letras y espacios');
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        alert('Por favor ingrese un correo electrónico válido');
        return false;
    }
    
    // Validar teléfono (exactamente 10 dígitos)
    if (!/^\d{10}$/.test(telefono)) {
        alert('El teléfono debe contener exactamente 10 dígitos numéricos');
        return false;
    }
    
    // Validar palabras en mensaje (si tiene contenido)
    if (mensaje !== '') {
        const palabras = mensaje.split(/\s+/).length;
        if (palabras > 200) {
            alert('El mensaje no puede exceder las 200 palabras');
            return false;
        }
    }
    
    return true;
}

// Validación al enviar formulario editar cliente
function validarFormularioEditarCliente() {
    const nombre = document.getElementById('editar_nombre').value.trim();
    const correo = document.getElementById('editar_correo').value.trim();
    const telefono = document.getElementById('editar_telefono').value.trim();
    const mensaje = document.getElementById('editar_mensaje').value.trim();
    
    // Validar nombre (solo letras)
    const nombreRegex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/;
    if (!nombreRegex.test(nombre)) {
        alert('El nombre solo puede contener letras y espacios');
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        alert('Por favor ingrese un correo electrónico válido');
        return false;
    }
    
    // Validar teléfono (exactamente 10 dígitos)
    if (!/^\d{10}$/.test(telefono)) {
        alert('El teléfono debe contener exactamente 10 dígitos numéricos');
        return false;
    }
    
    // Validar palabras en mensaje (si tiene contenido)
    if (mensaje !== '') {
        const palabras = mensaje.split(/\s+/).length;
        if (palabras > 200) {
            alert('El mensaje no puede exceder las 200 palabras');
            return false;
        }
    }
    
    return true;
}

// Resto del script para cambio de contraseña
document.addEventListener('DOMContentLoaded', function() {
    const nuevoPass = document.getElementById('nuevoPassword');
    const confirmPass = document.getElementById('confirmarPassword');
    const btnSubmit = document.getElementById('btnCambiarPassword');
    const reqLength = document.getElementById('reqLength');
    const reqMatch = document.getElementById('reqMatch');

    if (nuevoPass && confirmPass && btnSubmit) {
        function validatePassword() {
            let isValid = true;
            const pass = nuevoPass.value;
            const confirm = confirmPass.value;

            // Validar longitud
            if (pass.length >= 4) {
                reqLength.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Mínimo 4 caracteres';
            } else {
                reqLength.innerHTML = '<i class="bi bi-circle me-1"></i> Mínimo 4 caracteres';
                isValid = false;
            }

            // Validar coincidencia
            if (pass && confirm && pass === confirm) {
                reqMatch.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Las contraseñas coinciden';
            } else {
                reqMatch.innerHTML = '<i class="bi bi-circle me-1"></i> Las contraseñas coinciden';
                if (pass || confirm) isValid = false;
            }

            btnSubmit.disabled = !isValid;
        }

        nuevoPass.addEventListener('input', validatePassword);
        confirmPass.addEventListener('input', validatePassword);
    }
});