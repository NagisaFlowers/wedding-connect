/**
 * Validación del formulario de registro
 * Wedding Connect - Página de Registro
 */

class RegistroValidator {
    constructor() {
        this.form = document.getElementById('registrationForm');
        this.fechaInput = document.getElementById('fecha_evento');
        this.init();
    }
    
    init() {
        this.setMinDate();
        this.setupEventListeners();
    }
    
    setMinDate() {
        // Establecer fecha mínima como hoy
        const today = new Date().toISOString().split('T')[0];
        if (this.fechaInput) {
            this.fechaInput.min = today;
        }
    }
    
    setupEventListeners() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.validateForm(e));
            
            // Limpiar validación al cambiar campos
            const inputs = this.form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', () => this.clearValidation(input));
            });
        }
    }
    
    clearValidation(input) {
        input.classList.remove('is-invalid');
        const feedback = input.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.remove();
        }
    }
    
    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    isValidPhone(phone) {
        // Validar teléfono mexicano (10 dígitos)
        const re = /^[0-9]{10}$/;
        const cleanPhone = phone.replace(/\D/g, '');
        return re.test(cleanPhone);
    }
    
    validateForm(e) {
        let isValid = true;
        const errorMessages = [];
        
        // Validar campos requeridos
        const requiredFields = this.form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                this.showError(field, 'Este campo es obligatorio');
            }
        });
        
        // Validar email
        const emailField = document.getElementById('correo');
        if (emailField.value && !this.isValidEmail(emailField.value)) {
            isValid = false;
            this.showError(emailField, 'Por favor ingresa un email válido');
        }
        
        // Validar teléfono
        const phoneField = document.getElementById('telefono');
        if (phoneField.value) {
            const cleanPhone = phoneField.value.replace(/\D/g, '');
            if (cleanPhone.length < 10) {
                isValid = false;
                this.showError(phoneField, 'El teléfono debe tener al menos 10 dígitos');
            }
        }
        
        // Validar fecha
        if (this.fechaInput.value) {
            const selectedDate = new Date(this.fechaInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                isValid = false;
                this.showError(this.fechaInput, 'La fecha debe ser hoy o en el futuro');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Mostrar alerta de error general
            if (!this.form.querySelector('.general-error')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger alert-dismissible fade show general-error mt-3';
                errorDiv.innerHTML = `
                    <strong>Error:</strong> Por favor corrige los errores en el formulario.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                this.form.prepend(errorDiv);
                
                // Auto-dismiss después de 5 segundos
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 5000);
            }
            
            // Scroll al primer error
            const firstError = this.form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        } else {
            // Si el formulario es válido, limpiar localStorage antes de enviar
            localStorage.removeItem('weddingConnectFormData');
        }
    }
    
    showError(field, message) {
        field.classList.add('is-invalid');
        
        // Agregar mensaje de error si no existe
        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);
        }
    }
    
    // Formatear teléfono automáticamente
    static formatPhoneNumber(phone) {
        const cleaned = phone.replace(/\D/g, '');
        const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
        if (match) {
            return `(${match[1]}) ${match[2]}-${match[3]}`;
        }
        return phone;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hubo un registro exitoso (no restaurar datos)
    const registroExitosoInput = document.getElementById('registro_exitoso');
    
    // Inicializar validador
    const registroValidator = new RegistroValidator();
    
    // NO restaurar datos del localStorage si hubo un registro exitoso
    if (!registroExitosoInput || registroExitosoInput.value !== '1') {
        // Solo cargar datos guardados si NO hubo registro exitoso
        const formDataKey = 'weddingConnectFormData';
        const savedData = localStorage.getItem(formDataKey);
        
        if (savedData && registroValidator.form) {
            try {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const field = registroValidator.form.querySelector(`[name="${key}"]`);
                    if (field) {
                        field.value = data[key];
                    }
                });
            } catch (e) {
                console.error('Error loading saved form data:', e);
            }
        }
    } else {
        // Si hubo registro exitoso, limpiar localStorage
        localStorage.removeItem('weddingConnectFormData');
    }
    
    // Formatear teléfono mientras se escribe
    const phoneInput = document.getElementById('telefono');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            const formatted = RegistroValidator.formatPhoneNumber(e.target.value);
            if (formatted !== e.target.value) {
                e.target.value = formatted;
            }
        });
    }
    
    // Auto-completar mensaje basado en tipo de evento
    const tipoEventoSelect = document.getElementById('tipo_evento');
    const mensajeTextarea = document.getElementById('mensaje');
    
    if (tipoEventoSelect && mensajeTextarea) {
        tipoEventoSelect.addEventListener('change', function() {
            if (!mensajeTextarea.value.trim()) {
                const sugerencias = {
                    'boda': 'Estoy interesado/a en una boda, preferiblemente en un salón de eventos. Busco algo elegante y memorable.',
                    'xv_anios': 'Quiero organizar una fiesta de XV años para mi hija, buscando una celebración mágica con vals y decoración especial.',
                    'baby_shower': 'Estoy planeando un baby shower y necesito ayuda con la decoración temática, juegos y organización.',
                    'empresarial': 'Necesito organizar un evento corporativo para mi empresa, puede ser conferencia, team building o lanzamiento.',
                    'municipal': 'Requiero apoyo para la organización de un evento municipal como feria, festival o conmemoración oficial.',
                    'anual': 'Estoy interesado/a en organizar un evento de temporada (Día de Muertos, Navidad, Año Nuevo, etc.).',
                    'civil': 'Estoy interesado/a en una boda civil, preferiblemente en un salón de eventos. Busco algo elegante pero no demasiado formal.',
                    'religiosa': 'Quiero una boda religiosa, posiblemente en iglesia, seguida de una recepción con banquete y música.',
                    'destino': 'Me encantaría una boda en la playa o un destino especial. Busco algo íntimo y romántico.',
                    'intima': 'Preferiría una boda íntima con pocos invitados, algo personal y significativo.',
                    'lujo': 'Estoy planeando una boda de lujo con todos los detalles premium, desde la decoración hasta el entretenimiento.'
                };
                
                if (sugerencias[this.value]) {
                    mensajeTextarea.value = sugerencias[this.value];
                }
            }
        });
    }
    
    // Limpiar formulario con confirmación
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            if (this.form.checkValidity()) {
                const confirmar = confirm('¿Estás seguro de que quieres limpiar el formulario? Se perderán todos los datos ingresados.');
                if (!confirmar) {
                    e.preventDefault();
                }
            }
        });
    }
    
    // Guardar datos del formulario en localStorage temporalmente
    // SOLO si no hubo registro exitoso
    if (registroValidator.form && (!registroExitosoInput || registroExitosoInput.value !== '1')) {
        const formDataKey = 'weddingConnectFormData';
        
        // Guardar datos al cambiar
        registroValidator.form.addEventListener('input', function() {
            const formData = new FormData(registroValidator.form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            localStorage.setItem(formDataKey, JSON.stringify(data));
        });
        
        // Limpiar datos guardados al enviar exitosamente
        registroValidator.form.addEventListener('submit', function() {
            setTimeout(() => {
                localStorage.removeItem(formDataKey);
            }, 100);
        });
    }
});