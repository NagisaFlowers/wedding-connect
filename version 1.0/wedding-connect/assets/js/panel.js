/**
 * assets/js/panel.js - CORREGIDO
 * Scripts para el panel de administración de Wedding Connect
 */

class PanelAdmin {
    constructor() {
        this.init();
    }
    
    init() {
        // QUITAR LOADING INMEDIATAMENTE
        this.hideLoading();
        
        this.initDataTable();
        this.setupEventListeners();
        this.showWelcomeMessage();
        this.setupSearch();
        this.setupStatsAnimations();
    }
    
    hideLoading() {
        // Quitar overlay de carga inmediatamente
        $('.loading-overlay').fadeOut(300);
        $('.loading-overlay').remove();
    }
    
    initDataTable() {
        if ($.fn.DataTable && $('#clientesTable').length) {
            try {
                $('#clientesTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    pageLength: 10,
                    order: [[0, 'desc']],
                    responsive: true
                });
                console.log('DataTable inicializado correctamente');
            } catch (error) {
                console.error('Error al inicializar DataTable:', error);
            }
        } else {
            console.warn('DataTable no disponible o tabla no encontrada');
        }
    }
    
    setupEventListeners() {
        // Confirmación para eliminar
        $(document).on('click', '.btn-eliminar', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
        
        // Modal de detalles
        $(document).on('show.bs.modal', '.modal', function() {
            $(this).find('.modal-content').addClass('animate-fade-in');
        });
        
        // Copiar email al portapapeles
        $(document).on('click', '.btn-copiar-email', function() {
            const email = $(this).data('email');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(email).then(() => {
                    this.showNotification('Email copiado al portapapeles', 'success');
                });
            } else {
                // Fallback para navegadores antiguos
                const tempInput = document.createElement('input');
                tempInput.value = email;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                this.showNotification('Email copiado al portapapeles', 'success');
            }
        }.bind(this));
    }
    
    showWelcomeMessage() {
        const hour = new Date().getHours();
        let greeting = '';
        
        if (hour < 12) greeting = '¡Buenos días!';
        else if (hour < 19) greeting = '¡Buenas tardes!';
        else greeting = '¡Buenas noches!';
        
        // Mostrar notificación de bienvenida después de 2 segundos
        setTimeout(() => {
            this.showNotification(`${greeting} Bienvenido al panel de administración`, 'info');
        }, 2000);
    }
    
    setupSearch() {
        // Búsqueda en tiempo real
        $('#searchInput').on('keyup', function() {
            const table = $('#clientesTable').DataTable();
            if (table) {
                table.search(this.value).draw();
            }
        });
    }
    
    setupStatsAnimations() {
        // Animación de números contadores
        $('.stat-number').each(function() {
            const $this = $(this);
            const text = $this.text().trim();
            const finalValue = parseInt(text.replace(/[^0-9]/g, ''));
            
            if (!isNaN(finalValue) && finalValue > 0) {
                $this.prop('Counter', 0).animate({
                    Counter: finalValue
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function(now) {
                        $this.text(Math.ceil(now));
                    }
                });
            }
        });
    }
    
    showNotification(message, type = 'info') {
        const types = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        };
        
        const alertClass = types[type] || 'alert-info';
        
        // Remover notificaciones anteriores
        $('.custom-alert').remove();
        
        // Crear nueva notificación
        const alertDiv = $('<div>').addClass(`alert ${alertClass} alert-dismissible fade show custom-alert`)
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'z-index': '9999',
                'max-width': '350px'
            })
            .html(`
                <i class="bi ${type === 'success' ? 'bi-check-circle' : 
                              type === 'error' ? 'bi-exclamation-circle' : 
                              'bi-info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `);
        
        $('body').append(alertDiv);
        
        // Auto-dismiss después de 4 segundos
        setTimeout(() => {
            alertDiv.alert('close');
        }, 4000);
    }
}

// Inicializar cuando el DOM esté listo
$(document).ready(function() {
    console.log('DOM cargado, inicializando PanelAdmin...');
    
    // Verificar que jQuery esté cargado
    if (typeof jQuery === 'undefined') {
        console.error('jQuery no está cargado');
        // Quitar loading overlay manualmente
        document.querySelector('.loading-overlay')?.remove();
        return;
    }
    
    try {
        const panel = new PanelAdmin();
        console.log('PanelAdmin inicializado correctamente');
        
        // Actualizar fecha y hora
        function updateDateTime() {
            const now = new Date();
            const options = { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            $('#currentDateTime').text(now.toLocaleDateString('es-ES', options));
        }
        
        // Inicializar fecha/hora
        if ($('#currentDateTime').length) {
            updateDateTime();
            setInterval(updateDateTime, 60000); // Actualizar cada minuto
        }
        
    } catch (error) {
        console.error('Error al inicializar PanelAdmin:', error);
        // Asegurarse de quitar el loading si hay error
        $('.loading-overlay').fadeOut(300).remove();
    }
});

// También quitar loading si hay error en la carga de la página
$(window).on('load', function() {
    console.log('Página completamente cargada');
    // Asegurar que el loading se quite
    setTimeout(function() {
        $('.loading-overlay').fadeOut(300).remove();
    }, 1000);
});

// Fallback: quitar loading después de 5 segundos máximo
setTimeout(function() {
    $('.loading-overlay').fadeOut(300).remove();
}, 5000);