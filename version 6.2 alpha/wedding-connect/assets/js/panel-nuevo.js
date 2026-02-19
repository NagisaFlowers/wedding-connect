// panel-nuevo.js - Funcionalidades del nuevo panel

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Panel nuevo cargado correctamente');
    
    // Inicializar tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    
    // Inicializar popovers
    const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
    popovers.forEach(popover => new bootstrap.Popover(popover));
    
    // Reloj en tiempo real
    function actualizarReloj() {
        const ahora = new Date();
        const fecha = ahora.toLocaleDateString('es-MX', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        const hora = ahora.toLocaleTimeString('es-MX', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        
        document.querySelectorAll('#liveDate').forEach(el => {
            el.textContent = fecha.charAt(0).toUpperCase() + fecha.slice(1);
        });
        document.querySelectorAll('#liveTime').forEach(el => {
            el.textContent = hora;
        });
    }
    
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
    
    // Botones de copiar email
    document.querySelectorAll('.btn-copiar-email').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const email = this.dataset.email;
            navigator.clipboard.writeText(email).then(() => {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                this.classList.add('btn-success');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-success');
                }, 2000);
            });
        });
    });
    
    // Confirmación para eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('¿Estás segura de eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });
    
    // Cerrar modales correctamente
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            setTimeout(() => {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                    backdrop.remove();
                });
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }, 300);
        });
    });
    
    // Mostrar notificaciones
    window.showToast = function(message, type = 'info') {
        const types = {
            success: { bg: '#2ecc71', icon: '✅' },
            error: { bg: '#e74c3c', icon: '❌' },
            warning: { bg: '#f39c12', icon: '⚠️' },
            info: { bg: '#3498db', icon: 'ℹ️' }
        };
        
        const config = types[type] || types.info;
        
        document.querySelectorAll('.toast-notification').forEach(el => el.remove());
        
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-left: 4px solid ${config.bg};
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            z-index: 99999;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
            font-family: 'Inter', sans-serif;
            max-width: 350px;
        `;
        
        toast.innerHTML = `
            <span style="font-size: 24px;">${config.icon}</span>
            <span style="font-size: 14px; color: #2c3e50;">${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    };
    
    // Animación slideOut
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});

// Función global para editar cliente
function cargarClienteParaEditar(clienteId) {
    showToast('⏳ Cargando datos del cliente...', 'info');
    
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
                    showToast('✅ Datos cargados correctamente', 'success');
                }, 300);
            } else {
                showToast('❌ Error al cargar los datos', 'error');
            }
        })
        .catch(() => {
            showToast('❌ Error de conexión', 'error');
        });
}

// Función para ver detalles del cliente
function viewClientDetails(clientId) {
    const modal = new bootstrap.Modal(document.getElementById('modalCliente' + clientId));
    modal.show();
}