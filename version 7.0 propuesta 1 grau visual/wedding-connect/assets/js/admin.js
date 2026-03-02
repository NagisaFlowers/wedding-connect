/**
 * Admin Login Script
 * Wedding Connect - Panel de Administración
 */

class AdminLogin {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.usernameInput = document.getElementById('username');
        this.passwordInput = document.getElementById('password');
        this.toggleBtn = document.getElementById('togglePassword');
        this.submitBtn = document.getElementById('submitBtn');
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.autoFocus();
        this.autoFillCredentials();
        this.shakeOnError();
    }
    
    setupEventListeners() {
        // Toggle password visibility
        if (this.toggleBtn) {
            this.toggleBtn.addEventListener('click', () => this.togglePasswordVisibility());
        }
        
        // Real-time validation
        if (this.usernameInput) {
            this.usernameInput.addEventListener('input', () => this.validateForm());
        }
        
        if (this.passwordInput) {
            this.passwordInput.addEventListener('input', () => this.validateForm());
        }
        
        // Form submission
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }
    
    togglePasswordVisibility() {
        if (this.passwordInput.type === 'password') {
            this.passwordInput.type = 'text';
            this.toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
            this.toggleBtn.setAttribute('aria-label', 'Ocultar contraseña');
        } else {
            this.passwordInput.type = 'password';
            this.toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
            this.toggleBtn.setAttribute('aria-label', 'Mostrar contraseña');
        }
    }
    
    autoFocus() {
        if (this.usernameInput) {
            setTimeout(() => {
                this.usernameInput.focus();
            }, 300);
        }
    }
    
    validateForm() {
        if (this.usernameInput && this.passwordInput && this.submitBtn) {
            const isValid = this.usernameInput.value.trim() !== '' && 
                           this.passwordInput.value.trim() !== '';
            this.submitBtn.disabled = !isValid;
            return isValid;
        }
        return false;
    }
    
    autoFillCredentials() {
        // Auto-completar solo en localhost para desarrollo
        const isLocalhost = window.location.hostname === 'localhost' || 
                           window.location.hostname === '127.0.0.1' ||
                           window.location.hostname === '';
        
        if (isLocalhost && this.usernameInput && this.passwordInput) {
            if (!this.usernameInput.value && !this.passwordInput.value) {
                this.usernameInput.value = 'cristina';
                this.passwordInput.value = '1234';
                this.validateForm();
                
                // Mostrar notificación
                this.showNotification('Credenciales de prueba cargadas automáticamente', 'info');
            }
        }
    }
    
    shakeOnError() {
        // Verificar si hay mensaje de error en PHP
        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(() => {
                const adminCard = document.querySelector('.admin-card');
                if (adminCard) {
                    adminCard.classList.add('shake');
                    setTimeout(() => {
                        adminCard.classList.remove('shake');
                    }, 500);
                }
            }, 300);
        }
    }
    
    handleSubmit(e) {
        if (!this.validateForm()) {
            e.preventDefault();
            this.showNotification('Por favor completa todos los campos', 'error');
            return;
        }
        
        // Mostrar estado de carga
        this.showLoadingState();
        
        // Aquí puedes agregar validación adicional si es necesario
        // Por ejemplo, verificar complejidad de contraseña
        
        // Simular delay de red (solo para demostración)
        setTimeout(() => {
            this.hideLoadingState();
        }, 1000);
    }
    
    showLoadingState() {
        if (this.submitBtn) {
            this.submitBtn.disabled = true;
            this.submitBtn.classList.add('btn-loading');
            this.submitBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Procesando...';
        }
    }
    
    hideLoadingState() {
        if (this.submitBtn) {
            this.submitBtn.disabled = false;
            this.submitBtn.classList.remove('btn-loading');
            this.submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión';
        }
    }
    
    showNotification(message, type = 'info') {
        const types = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        };
        
        const alertClass = types[type] || types.info;
        
        // Remover notificaciones existentes
        const existingAlert = document.querySelector('.custom-alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Crear nueva notificación
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show custom-alert position-fixed top-0 start-50 translate-middle-x mt-5`;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
        alertDiv.style.minWidth = '300px';
        alertDiv.style.textAlign = 'center';
        alertDiv.innerHTML = `
            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-exclamation-circle' : 'bi-info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-dismiss después de 3 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
    
    // Método para medir seguridad de contraseña
    measurePasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score += 1;
        if (/[a-z]/.test(password)) score += 1;
        if (/[A-Z]/.test(password)) score += 1;
        if (/[0-9]/.test(password)) score += 1;
        if (/[^A-Za-z0-9]/.test(password)) score += 1;
        
        return {
            score: score,
            level: score <= 2 ? 'Débil' : score <= 4 ? 'Media' : 'Fuerte'
        };
    }
}

/**
 * FUNCIONES PARA RESPALDO DE BASE DE DATOS - CORREGIDAS
 */

// Mostrar modal de confirmación
function backupDatabase() {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmBackup'));
    modal.show();
}

// Ejecutar el respaldo - VERSIÓN CORREGIDA QUE CIERRA EL MODAL
function ejecutarBackup() {
    // Cerrar modal de confirmación
    const confirmModal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmBackup'));
    if (confirmModal) {
        confirmModal.hide();
    }
    
    // Mostrar modal de progreso
    const progressModal = new bootstrap.Modal(document.getElementById('modalBackupProgress'));
    progressModal.show();
    
    // Actualizar estado
    document.getElementById('backupStatus').textContent = 'Generando archivo SQL...';
    
    // Crear un enlace temporal para la descarga
    const link = document.createElement('a');
    link.href = 'backup_database.php';
    link.style.display = 'none';
    
    // Agregar al DOM
    document.body.appendChild(link);
    
    // Variable para controlar si ya se cerró el modal
    let modalCerrado = false;
    
    // Función para cerrar el modal
    function cerrarModalProgreso() {
        if (!modalCerrado) {
            modalCerrado = true;
            
            // Actualizar estado
            document.getElementById('backupStatus').textContent = 'Respaldo completado';
            
            setTimeout(() => {
                // Cerrar modal de progreso
                const progressModalInstance = bootstrap.Modal.getInstance(document.getElementById('modalBackupProgress'));
                if (progressModalInstance) {
                    progressModalInstance.hide();
                }
                
                // Mostrar notificación de éxito
                if (window.showToast) {
                    window.showToast('✅ Respaldo completado exitosamente', 'success');
                } else {
                    // Fallback si showToast no existe
                    alert('✅ Respaldo completado exitosamente');
                }
                
                // Limpiar backdrop si queda alguno
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);
                
                // Remover el enlace
                if (link.parentNode) {
                    document.body.removeChild(link);
                }
            }, 1000);
        }
    }
    
    // Detectar cuando se inicia la descarga
    link.onclick = function() {
        // La descarga se inició, programar cierre del modal
        setTimeout(cerrarModalProgreso, 1500);
    };
    
    // Simular click para iniciar descarga
    link.click();
    
    // Plan B: Si por alguna razón no se detecta el click, cerrar después de 5 segundos
    setTimeout(() => {
        cerrarModalProgreso();
    }, 5000);
}

// Versión alternativa usando fetch (más confiable)
function ejecutarBackupFetch() {
    // Cerrar modal de confirmación
    const confirmModal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmBackup'));
    if (confirmModal) {
        confirmModal.hide();
    }
    
    // Mostrar modal de progreso
    const progressModal = new bootstrap.Modal(document.getElementById('modalBackupProgress'));
    progressModal.show();
    
    // Actualizar estado
    const statusElement = document.getElementById('backupStatus');
    statusElement.textContent = 'Generando archivo SQL...';
    
    // Usar fetch para obtener el archivo
    fetch('backup_database.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            statusElement.textContent = 'Preparando descarga...';
            return response.blob();
        })
        .then(blob => {
            // Crear URL del blob
            const url = window.URL.createObjectURL(blob);
            
            // Obtener nombre del archivo de la respuesta
            const contentDisposition = response.headers.get('Content-Disposition');
            let filename = 'backup_wedding_connect.sql';
            if (contentDisposition) {
                const match = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
                if (match && match[1]) {
                    filename = match[1].replace(/['"]/g, '');
                }
            }
            
            // Crear enlace de descarga
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            
            statusElement.textContent = 'Respaldo completado';
            
            // Limpiar
            setTimeout(() => {
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                // Cerrar modal de progreso
                setTimeout(() => {
                    const progressModalInstance = bootstrap.Modal.getInstance(document.getElementById('modalBackupProgress'));
                    if (progressModalInstance) {
                        progressModalInstance.hide();
                    }
                    
                    // Mostrar notificación
                    if (window.showToast) {
                        window.showToast('✅ Respaldo completado exitosamente', 'success');
                    }
                    
                    // Limpiar backdrops
                    setTimeout(() => {
                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 300);
                }, 500);
            }, 100);
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Mostrar error
            statusElement.textContent = 'Error al generar respaldo';
            
            setTimeout(() => {
                // Cerrar modal de progreso
                const progressModalInstance = bootstrap.Modal.getInstance(document.getElementById('modalBackupProgress'));
                if (progressModalInstance) {
                    progressModalInstance.hide();
                }
                
                // Mostrar error
                if (window.showToast) {
                    window.showToast('❌ Error al generar el respaldo', 'error');
                }
                
                // Limpiar backdrops
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);
            }, 1000);
        });
}

// Agregar atajo de teclado (Ctrl + B) para respaldo rápido
document.addEventListener('keydown', function(e) {
    // Solo si no está en un input o textarea
    if (e.ctrlKey && e.key === 'b' && !e.target.matches('input, textarea, select')) {
        e.preventDefault();
        backupDatabase();
    }
});

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const adminLogin = new AdminLogin();
    
    // Agregar indicador de seguridad de contraseña
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = adminLogin.measurePasswordStrength(this.value);
            
            // Actualizar o crear indicador visual
            let indicator = document.querySelector('.password-strength');
            if (!indicator && this.value) {
                indicator = document.createElement('div');
                indicator.className = 'password-strength mt-2';
                this.parentNode.appendChild(indicator);
            }
            
            if (indicator && this.value) {
                let color, text;
                switch(strength.level) {
                    case 'Débil':
                        color = '#dc3545';
                        text = 'Contraseña débil';
                        break;
                    case 'Media':
                        color = '#ffc107';
                        text = 'Contraseña media';
                        break;
                    case 'Fuerte':
                        color = '#28a745';
                        text = 'Contraseña fuerte';
                        break;
                    default:
                        color = '#6c757d';
                        text = 'Escribe una contraseña';
                }
                
                indicator.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="progress flex-grow-1 me-2" style="height: 5px;">
                            <div class="progress-bar" style="width: ${strength.score * 20}%; background-color: ${color};"></div>
                        </div>
                        <small style="color: ${color};">${text}</small>
                    </div>
                `;
            } else if (indicator && !this.value) {
                indicator.remove();
            }
        });
    }
    
    // Limpiar backdrops cuando se cierran modales
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
});