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
        alertDiv.innerHTML = `
            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-exclamation-circle' : 'bi-info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
});