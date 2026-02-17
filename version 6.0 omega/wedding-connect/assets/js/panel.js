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
