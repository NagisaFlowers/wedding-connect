
// ANIMACIONES Y VALIDACIONES MEJORADAS
document.addEventListener('DOMContentLoaded', function() {
    // Efecto de entrada suave para los elementos
    const elements = document.querySelectorAll('.form-group, .btn-login');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            el.style.transition = 'all 0.5s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 300 + (index * 100));
    });
    
    // Validación en tiempo real
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    
    usernameInput.addEventListener('input', function() {
        if (this.value.trim().length > 0) {
            this.style.borderColor = 'var(--gold-light)';
            this.style.boxShadow = '0 5px 20px var(--shadow-light)';
        } else {
            this.style.borderColor = '#eee';
            this.style.boxShadow = 'none';
        }
    });
    
    passwordInput.addEventListener('input', function() {
        if (this.value.trim().length > 0) {
            this.style.borderColor = 'var(--gold-light)';
            this.style.boxShadow = '0 5px 20px var(--shadow-light)';
        } else {
            this.style.borderColor = '#eee';
            this.style.boxShadow = 'none';
        }
    });
    
    // Efecto de carga en el botón de login
    const loginForm = document.querySelector('.login-form');
    loginForm.addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-login');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Verificando credenciales...';
        btn.disabled = true;
        btn.style.opacity = '0.8';
        
        // Simular carga mínima para mejor UX
        setTimeout(() => {
            if (!e.defaultPrevented) {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.style.opacity = '1';
            }
        }, 2000);
    });
    
    // Efecto hover en los enlaces rápidos
    const quickLinks = document.querySelectorAll('.quick-link');
    quickLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Mostrar/ocultar contraseña (opcional)
    const togglePassword = document.createElement('span');
    togglePassword.innerHTML = '<i class="bi bi-eye"></i>';
    togglePassword.style.position = 'absolute';
    togglePassword.style.right = '15px';
    togglePassword.style.top = '50%';
    togglePassword.style.transform = 'translateY(-50%)';
    togglePassword.style.cursor = 'pointer';
    togglePassword.style.color = 'var(--gold-medium)';
    togglePassword.style.fontSize = '1.2rem';
    
    passwordInput.parentNode.appendChild(togglePassword);
    passwordInput.style.paddingRight = '50px';
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });
    
    // Efecto de focus mejorado
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.style.transform = 'scale(1)';
        });
    });
});

// Validación del formulario
document.querySelector('.login-form').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    
    if (!username || !password) {
        e.preventDefault();
        
        // Efecto de error
        if (!username) {
            document.getElementById('username').style.borderColor = '#ff6b6b';
            document.getElementById('username').style.boxShadow = '0 5px 20px rgba(255, 107, 107, 0.3)';
        }
        if (!password) {
            document.getElementById('password').style.borderColor = '#ff6b6b';
            document.getElementById('password').style.boxShadow = '0 5px 20px rgba(255, 107, 107, 0.3)';
        }
        
        // Crear mensaje de error animado
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = '<i class="bi bi-exclamation-circle-fill me-2"></i>Por favor completa todos los campos requeridos';
        
        // Eliminar mensaje anterior si existe
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Insertar nuevo mensaje
        const form = document.querySelector('.login-form');
        form.parentNode.insertBefore(errorDiv, form);
        
        // Scroll al error
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        return false;
    }
});


