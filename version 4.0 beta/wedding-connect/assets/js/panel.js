/**
 * assets/js/panel.js - VERSIÓN CORREGIDA SIN ALERTAS Y CON FIX MODAL
 * Scripts para el panel de administración de Wedding Connect
 */

class PanelAdmin {
    constructor() {
        this.init();
    }
    
    init() {
        this.hideLoading();
        this.initDataTable();
        this.setupEventListeners();
        this.setupEditButtons();
        this.setupExportButtons();
        this.setupTableEvents();
        this.setupModalFix();
        this.setupDashboardCards();
    }
    
    hideLoading() {
        $('.loading-overlay').fadeOut(300).remove();
    }
    
    initDataTable() {
        // TABLA PRINCIPAL DE CLIENTES (pestaña clientes)
        if ($.fn.DataTable && $('#clientesTable').length) {
            try {
                $('#clientesTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    pageLength: 10,
                    order: [[0, 'desc']], // Ordenar por ID descendente
                    ordering: true,
                    responsive: true,
                    dom: '<"top"lf>rt<"bottom"ip>',
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 7 // Columna de acciones
                        },
                        {
                            type: 'num',
                            targets: 0
                        }
                    ]
                });
                console.log('DataTable de clientes inicializado correctamente');
            } catch (error) {
                console.error('Error al inicializar DataTable clientes:', error);
            }
        }
        
        // TABLA DEL DASHBOARD
        if ($.fn.DataTable && $('#clientesDashboard').length) {
            try {
                $('#clientesDashboard').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    pageLength: 10,
                    order: [[0, 'desc']], // Ordenar por ID descendente
                    ordering: false,
                    searching: false,
                    info: false,
                    paging: false,
                    responsive: true,
                    columnDefs: [
                        {
                            type: 'num',
                            targets: 0
                        }
                    ]
                });
                console.log('DataTable del dashboard inicializado correctamente');
            } catch (error) {
                console.error('Error al inicializar DataTable dashboard:', error);
            }
        }
        
        // TABLA DE EVENTOS (pestaña eventos)
        if ($.fn.DataTable && $('#eventosTable').length) {
            try {
                $('#eventosTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    pageLength: 10,
                    order: [[0, 'desc']], // Ordenar por fecha (columna 0) descendente
                    ordering: true,
                    responsive: true,
                    dom: '<"top"lf>rt<"bottom"ip>',
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 6 // Columna de acciones
                        },
                        {
                            type: 'date', // Especificar que la columna de fecha es tipo date
                            targets: 0
                        }
                    ]
                });
                console.log('DataTable de eventos inicializado correctamente');
            } catch (error) {
                console.error('Error al inicializar DataTable eventos:', error);
            }
        }
    }
    
    setupTableEvents() {
        // Actualizar numeración cuando cambie la página (solo para tabla principal)
        $(document).on('page.dt length.dt draw.dt', '#clientesTable', () => {
            setTimeout(this.actualizarNumeracionConsecutiva, 100);
        });
    }
    
    actualizarNumeracionConsecutiva() {
        const tabla = $('#clientesTable').DataTable();
        if (!tabla) return;
        
        const info = tabla.page.info();
        const inicio = info.start;
        
        // Para cada fila visible en la tabla principal
        $('#clientesTable tbody tr').each(function(index) {
            const $fila = $(this);
            const numeroConsecutivo = inicio + index + 1;
            
            // Actualizar el número en la celda ID
            const $badge = $fila.find('td:eq(0) .badge');
            if ($badge.length) {
                const idOriginal = $badge.data('original-id') || $badge.text().replace('#', '');
                $badge.data('original-id', idOriginal); // Guardar ID real
                $badge.text('#' + numeroConsecutivo);
                $badge.attr('title', 'ID Real: #' + idOriginal);
            }
        });
    }
    
    setupEventListeners() {
        // Confirmación para eliminar
        $(document).on('click', '.btn-eliminar', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
        
    }
    
    // Configurar botones de editar
    setupEditButtons() {
        // Cuando se hace clic en el botón editar
        $(document).on('click', '.btn-editar', function(e) {
            e.preventDefault();
            var clienteId = $(this).data('id');
            cargarClienteParaEditar(clienteId);
        });
    }
    
    // Configurar tarjetas clickeables del dashboard
    setupDashboardCards() {
        $('.clickable-card').on('click', function(e) {
            // Agregar efecto de clic
            $(this).css({
                'transform': 'scale(0.98)',
                'transition': 'transform 0.1s'
            });
            
            setTimeout(() => {
                $(this).css({
                    'transform': '',
                    'transition': ''
                });
            }, 100);
        });
        
        // Efecto hover para tarjetas
        $('.stat-card').hover(
            function() {
                if ($(this).hasClass('clickable-card')) {
                    $(this).css('cursor', 'pointer');
                }
            },
            function() {
                // Reset al salir del hover
            }
        );
    }
    
    // Fix para problemas de modales
    setupModalFix() {
        // Limpiar backdrop residual cuando se cierra un modal
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('overflow', '');
            $('body').css('padding-right', '');
        });
    }
    
    setupExportButtons() {
        // Exportar Excel (solo para tabla principal)
        $('#exportExcel').on('click', function(e) {
            e.preventDefault();
            exportarExcel();
        });
        
        // Imprimir (solo para tabla principal)
        $('#printTable').on('click', function(e) {
            e.preventDefault();
            imprimirTabla();
        });
    }
}

// FUNCIÓN: Cargar cliente para editar
function cargarClienteParaEditar(clienteId) {
    // Mostrar mensaje de carga
    showToast('⏳ Cargando datos del cliente...', 'info');
    
    // Obtener datos del cliente desde la base de datos
    $.ajax({
        url: 'obtener_cliente.php',
        type: 'GET',
        data: {id: clienteId},
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Llenar el formulario con los datos
                $('#editar_cliente_id').val(response.cliente.id);
                $('#editar_nombre').val(response.cliente.nombre);
                $('#editar_correo').val(response.cliente.correo);
                $('#editar_telefono').val(response.cliente.telefono);
                $('#editar_tipo_evento').val(response.cliente.tipo_boda);
                $('#editar_fecha_evento').val(response.cliente.fecha_evento);
                $('#editar_mensaje').val(response.cliente.mensaje || '');
                
                // Cerrar cualquier modal abierto
                $('.modal').modal('hide');
                
                // Limpiar backdrop residual
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                
                // Mostrar el modal de edición después de un breve retraso
                setTimeout(() => {
                    var modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                    modal.show();
                    showToast('✅ Datos cargados correctamente', 'success');
                }, 300);
            }
        },

    });
}

// FUNCIÓN: Exportar a Excel
function exportarExcel() {
    showToast('⏳ Preparando exportación...', 'info');
    
    // Crear un array para los datos
    const data = [];
    
    // Agregar encabezados (excluyendo "Acciones")
    const headers = [];
    $('#clientesTable thead th').each(function(index) {
        if (index < 7) { // Solo las primeras 7 columnas
            headers.push($(this).text().trim());
        }
    });
    data.push(headers);
    
    // Agregar filas de datos
    $('#clientesTable tbody tr').each(function() {
        const $row = $(this);
        const rowData = [];
        
        // 1. ID - Usar ID real en lugar del consecutivo
        let id = $row.find('td:eq(0) .badge').data('original-id') || 
                $row.find('td:eq(0) .badge').text().trim().replace('#', '');
        rowData.push(id);
        
        // 2. Nombre
        let nombre = $row.find('td:eq(1) strong').text().trim();
        if (!nombre) {
            const nombreCell = $row.find('td:eq(1)').clone();
            nombreCell.find('button, .btn-link, br, small').remove();
            nombre = nombreCell.text().trim().replace(/\s+/g, ' ');
        }
        rowData.push(nombre);
        
        // 3. Email
        let email = $row.find('td:eq(2) a').first().text().trim();
        if (!email) {
            email = $row.find('td:eq(2)').text().trim();
            email = email.replace('Copiar', '').trim();
        }
        rowData.push(email);
        
        // 4. Teléfono
        let telefono = $row.find('td:eq(3) a').text().trim();
        if (!telefono) telefono = $row.find('td:eq(3)').text().trim();
        rowData.push(telefono);
        
        // 5. Tipo de Boda
        let tipoBoda = $row.find('td:eq(4) .badge').text().trim();
        if (!tipoBoda) {
            const tipoCell = $row.find('td:eq(4)').clone();
            tipoCell.find('.badge, i').remove();
            tipoBoda = tipoCell.text().trim();
        }
        rowData.push(tipoBoda);
        
        // 6. Fecha Evento
        let fechaEvento = $row.find('td:eq(5)').text().trim();
        fechaEvento = fechaEvento.replace(/bi-[a-z-]+/g, '')
                                 .replace(/text-[a-z]+/g, '')
                                 .replace(/\s+/g, ' ')
                                 .trim();
        rowData.push(fechaEvento);
        
        // 7. Fecha Registro
        const fechaRegistro = $row.find('td:eq(6)').text().trim();
        rowData.push(fechaRegistro);
        
        data.push(rowData);
    });
    
    // Convertir a Excel
    let csvContent = "data:text/csv;charset=utf-8,";
    data.forEach(row => {
        const escapedRow = row.map(cell => {
            const cellText = String(cell || '')
                .replace(/"/g, '""')
                .replace(/\n/g, ' ')
                .replace(/\s+/g, ' ')
                .trim();
            return `"${cellText}"`;
        });
        csvContent += escapedRow.join(',') + '\n';
    });
    
    // Descargar el archivo
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    const fecha = new Date().toISOString().split('T')[0];
    
    link.href = encodedUri;
    link.download = `clientes_wedding_connect_${fecha}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('✅ Archivo CSV exportado exitosamente', 'success');
}

// FUNCIÓN: Mostrar toast notifications
function showToast(message, type = 'info') {
    const types = {
        'success': {bg: '#28a745', icon: '✅'},
        'error': {bg: '#dc3545', icon: '❌'},
        'warning': {bg: '#ffc107', icon: '⚠️'},
        'info': {bg: '#17a2b8', icon: 'ℹ️'}
    };
    
    const config = types[type] || types.info;
    
    $('.toast-notification').remove();
    
    const toast = $(`
        <div class="toast-notification" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-left: 4px solid ${config.bg};
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 99999;
            max-width: 350px;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease;
        ">
            <span style="font-size: 20px; margin-right: 10px;">${config.icon}</span>
            <span style="font-size: 14px;">${message}</span>
        </div>
    `);
    
    $('body').append(toast);
    
    setTimeout(() => {
        toast.fadeOut(300, () => toast.remove());
    }, 4000);
}

// Script para ordenar correctamente las tablas
function setupTableSorting() {
    // Para la tabla de clientes
    if ($.fn.DataTable && $('#clientesTable').length) {
        const table = $('#clientesTable').DataTable();
        if (table) {
            table.order([0, 'desc']).draw(); // Ordenar por ID descendente
        }
    }
    
    // Para la tabla de eventos
    if ($.fn.DataTable && $('#eventosTable').length) {
        const table = $('#eventosTable').DataTable();
        if (table) {
            table.order([0, 'desc']).draw(); // Ordenar por fecha descendente
        }
    }
}

// Agregar animación CSS si no existe
if (!$('#toast-styles').length) {
    $('head').append(`
        <style id="toast-styles">
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
                transition: transform 0.2s;
            }
            .btn-panel:active {
                transform: scale(0.98);
            }
        </style>
    `);
}

// Inicializar cuando el DOM esté listo
$(document).ready(function() {
    console.log('Panel cargado, inicializando...');
    
    try {
        const panel = new PanelAdmin();
        console.log('PanelAdmin inicializado correctamente');
        
        // Actualizar fecha y hora
        function updateDateTime() {
            const now = new Date();
            const fecha = now.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            const hora = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            $('#currentDateTime').text(`${fecha} ${hora}`);
        }
        
        if ($('#currentDateTime').length) {
            updateDateTime();
            setInterval(updateDateTime, 1000);
        }
        
        // Actualizar numeración después de inicializar DataTable
        setTimeout(() => {
            panel.actualizarNumeracionConsecutiva();
        }, 300);
        
        // Configurar ordenamiento de tablas
        setTimeout(() => {
            setupTableSorting();
        }, 500);
        
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
    } catch (error) {
        console.error('Error al inicializar PanelAdmin:', error);
    }
});

// Quitar loading overlay si existe
setTimeout(function() {
    $('.loading-overlay').fadeOut(300).remove();
}, 1000);

// Variables para ordenamiento de clientes
let currentClientesSortColumn = 0;
let currentClientesSortDirection = 'asc';
let originalClientesData = [];

// Guardar datos originales de clientes
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('clientesTable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    originalClientesData = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        return cells.map(cell => {
            return {
                html: cell.innerHTML,
                sort: cell.getAttribute('data-sort') || cell.textContent.trim()
            };
        });
    });
    
    // Botón imprimir (EXACTO como en panel.php)
    document.getElementById('printTable').addEventListener('click', function() {
        imprimirTablaClientes();
    });
    
    // Botón exportar (EXACTO como en panel.php)
    document.getElementById('exportExcel').addEventListener('click', function() {
        exportToExcel();
    });
});

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
    currentIcon.textContent = currentClientesSortDirection === 'asc' ? '↑' : '↓';
    
    // Ordenar filas
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelectorAll('td')[columnIndex];
        const cellB = rowB.querySelectorAll('td')[columnIndex];
        
        // Verificar si es columna no ordenable
        if (cellA.getAttribute('data-no-sort') || cellB.getAttribute('data-no-sort')) {
            return 0;
        }
        
        let valueA = cellA.getAttribute('data-sort') || cellA.textContent.trim();
        let valueB = cellB.getAttribute('data-sort') || cellB.textContent.trim();
        
        // Convertir a números si es posible
        if (!isNaN(valueA) && !isNaN(valueB)) {
            valueA = parseFloat(valueA);
            valueB = parseFloat(valueB);
        }
        // Convertir fechas
        else if (isDate(valueA) && isDate(valueB)) {
            valueA = new Date(valueA).getTime();
            valueB = new Date(valueB).getTime();
        }
        
        // Comparar
        if (currentClientesSortDirection === 'asc') {
            return valueA < valueB ? -1 : valueA > valueB ? 1 : 0;
        } else {
            return valueA > valueB ? -1 : valueA < valueB ? 1 : 0;
        }
    });
    
    // Reordenar filas
    rows.forEach(row => tbody.appendChild(row));
}

// Función para buscar en tabla de clientes
function searchClientesTable() {
    const input = document.getElementById('searchClientes');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('clientesTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let show = false;
        const cells = row.querySelectorAll('td');
        
        cells.forEach((cell, index) => {
            // No buscar en columna de acciones (índice 7)
            if (index !== 7) {
                const cellText = cell.textContent.toLowerCase();
                if (cellText.indexOf(filter) > -1) {
                    show = true;
                }
            }
        });
        
        row.style.display = show ? '' : 'none';
    });
}

// Función para restablecer orden de clientes
function resetClientesSort() {
    const table = document.getElementById('clientesTable');
    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('thead th');
    
    // Resetear iconos
    headers.forEach((header, index) => {
        header.classList.remove('sort-asc', 'sort-desc');
        const icon = header.querySelector('.sort-icon');
        if (icon) icon.textContent = '⇅';
    });
    
    // Restaurar datos originales
    tbody.innerHTML = '';
    originalClientesData.forEach(rowData => {
        const row = document.createElement('tr');
        rowData.forEach(cellData => {
            const cell = document.createElement('td');
            cell.innerHTML = cellData.html;
            if (cellData.sort) {
                cell.setAttribute('data-sort', cellData.sort);
            }
            row.appendChild(cell);
        });
        tbody.appendChild(row);
    });
    
    currentClientesSortColumn = 0;
    currentClientesSortDirection = 'asc';
}

// FUNCIÓN DE EXPORTAR A EXCEL (igual que en panel.php)
function exportToExcel() {
    // Crear una tabla HTML para exportar
    const tabla = document.getElementById('clientesTable');
    const tablaHTML = tabla.outerHTML;
    
    // Crear contenido para Excel
    const excelContent = `
        <html xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
            <meta charset="UTF-8">
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Clientes</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
        </head>
        <body>
            ${tablaHTML}
        </body>
        </html>
    `;
    
    // Crear blob y descargar
    const blob = new Blob([excelContent], {
        type: 'application/vnd.ms-excel'
    });
    
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `clientes_wedding_connect_${new Date().toISOString().split('T')[0]}.xls`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}


// Función auxiliar para verificar si es fecha
function isDate(value) {
    if (!value) return false;
    // Verificar formato ISO (YYYY-MM-DD)
    const isoRegex = /^\d{4}-\d{2}-\d{2}/;
    if (isoRegex.test(value)) return true;
    
    // Verificar si puede convertirse a fecha
    const date = new Date(value);
    return date instanceof Date && !isNaN(date);
}

// FUNCIÓN: Imprimir tabla
function imprimirTabla() {
    showToast('🖨️ Preparando impresión...', 'info');
    
    const ventana = window.open('', '_blank', 'width=900,height=600');
    
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
                body { margin: 0; }
                table { font-size: 12px; }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>📋 Lista de Clientes - Wedding Connect</h1>
            <div class="info">
                <strong>Fecha del reporte:</strong> ${new Date().toLocaleDateString('es-ES', { 
                    year: 'numeric', month: 'long', day: 'numeric' 
                })}
            </div>
            <div class="info">
                <strong>Total de clientes:</strong> ${$('#clientesTable tbody tr').length}
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Tipo Boda</th>
                    <th>Fecha Evento</th>
                    <th>Registro</th>
                </tr>
            </thead>
            <tbody>`;
    
    // Agregar filas
    $('#clientesTable tbody tr').each(function() {
        const $row = $(this);
        
        // ID real
        const id = $row.find('td:eq(0) .badge').data('original-id') || 
                   $row.find('td:eq(0) .badge').text().trim().replace('#', '') || 
                   $row.find('td:eq(0)').text().trim();
        
        let nombre = $row.find('td:eq(1) strong').text().trim();
        if (!nombre) {
            const nombreCell = $row.find('td:eq(1)').clone();
            nombreCell.find('button, .btn-link, br, small').remove();
            nombre = nombreCell.text().trim();
        }
        
        const email = $row.find('td:eq(2) a').first().text().trim() || 
                     $row.find('td:eq(2)').text().trim().replace('Copiar', '').trim();
        
        const telefono = $row.find('td:eq(3) a').text().trim() || 
                        $row.find('td:eq(3)').text().trim();
        
        const tipoBoda = $row.find('td:eq(4) .badge').text().trim() || 
                        $row.find('td:eq(4)').text().trim();
        
        let fechaEvento = $row.find('td:eq(5)').text().trim();
        fechaEvento = fechaEvento.replace(/bi-[a-z-]+/g, '')
                                 .replace(/text-[a-z]+/g, '')
                                 .replace(/\s+/g, ' ')
                                 .trim();
        
        const registro = $row.find('td:eq(6)').text().trim();
        
        html += `
                <tr>
                    <td>${id}</td>
                    <td>${nombre}</td>
                    <td>${email}</td>
                    <td>${telefono}</td>
                    <td>${tipoBoda}</td>
                    <td>${fechaEvento}</td>
                    <td>${registro}</td>
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
    
    ventana.document.open();
    ventana.document.write(html);
    ventana.document.close();
    
    showToast('✅ Ventana de impresión abierta', 'success');
}