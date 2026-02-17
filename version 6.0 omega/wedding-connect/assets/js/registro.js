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
        const today = new Date().toISOString().split('T')[0];
        if (this.fechaInput) {
            this.fechaInput.min = today;
        }
    }
    
    setupEventListeners() {
        if (!this.form) return;
        
        // Validar al enviar
        this.form.addEventListener('submit', (e) => this.validateForm(e));
        
        // Validar cada campo al perder el foco (blur) - ¡así es en tiempo real!
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            // Limpiar error mientras el usuario escribe
            input.addEventListener('input', () => this.clearValidation(input));
            input.addEventListener('change', () => this.clearValidation(input));
        });
    }
    
    clearValidation(input) {
        input.classList.remove('is-invalid');
        const feedback = input.parentNode.querySelector('.invalid-feedback');
        if (feedback) feedback.remove();
    }
    
    // Valida un campo específico y muestra error si corresponde
    validateField(field) {
        // Limpiar validación previa
        this.clearValidation(field);
        
        let errorMessage = null;
        
        // 1. Campo requerido vacío
        if (field.hasAttribute('required') && !field.value.trim()) {
            errorMessage = 'Este campo es obligatorio';
        }
        // 2. Nombre
        else if (field.id === 'nombre' && field.value.trim()) {
            const soloLetras = /^[a-zA-ZáéíóúñÑüÜ\s]+$/;
            if (!soloLetras.test(field.value)) {
                errorMessage = 'El nombre no puede contener números ni símbolos. Solo letras y espacios.';
            } else if (field.value.length > 30) {
                errorMessage = 'El nombre no puede tener más de 30 caracteres.';
            }
        }
        // 3. Correo
        else if (field.id === 'correo' && field.value.trim()) {
            const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailValido.test(field.value)) {
                errorMessage = 'Ingresa un correo electrónico válido (ej: nombre@dominio.com)';
            } else if (field.value.length > 50) {
                errorMessage = 'El correo no puede exceder los 50 caracteres.';
            }
        }
        // 4. Teléfono
        else if (field.id === 'telefono' && field.value.trim()) {
            const soloDigitos = field.value.replace(/\D/g, '');
            if (!/^\d{10}$/.test(soloDigitos)) {
                errorMessage = 'El teléfono debe contener exactamente 10 dígitos numéricos (sin letras ni símbolos).';
            }
        }
        // 5. Fecha
        else if (field.id === 'fecha_evento' && field.value) {
            const selectedDate = new Date(field.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                errorMessage = 'La fecha del evento debe ser hoy o una fecha futura.';
            }
        }
        // 6. Mensaje (límite 200 palabras)
        else if (field.id === 'mensaje' && field.value.trim()) {
            const wordCount = this.countWords(field.value);
            if (wordCount > 200) {
                errorMessage = 'El mensaje no puede exceder las 200 palabras.';
            }
        }
        
        if (errorMessage) {
            this.showError(field, errorMessage);
            return false;
        }
        return true;
    }
    
    countWords(text) {
        return text.trim().split(/\s+/).filter(word => word.length > 0).length;
    }
    
    validateForm(e) {
        let isValid = true;
        
        // Limpiar errores generales previos
        const generalError = this.form.querySelector('.general-error');
        if (generalError) generalError.remove();
        
        // Validar todos los campos (requeridos o con valor)
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            // Si es requerido o tiene contenido, validamos
            if (input.hasAttribute('required') || input.value.trim() !== '') {
                if (!this.validateField(input)) {
                    isValid = false;
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Mostrar alerta general
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger alert-dismissible fade show general-error mt-3';
            errorDiv.innerHTML = `
                <strong>Error:</strong> Por favor corrige los errores en el formulario.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            this.form.prepend(errorDiv);
            
            setTimeout(() => errorDiv.remove(), 5000);
            
            const firstError = this.form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        } else {
            localStorage.removeItem('weddingConnectFormData');
        }
    }
    
    showError(field, message) {
        this.clearValidation(field);
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.innerHTML = `<i class="bi bi-exclamation-circle-fill me-1"></i> ${message}`;
        field.parentNode.appendChild(errorDiv);
    }
    
    static formatPhoneNumber(phone) {
        const cleaned = phone.replace(/\D/g, '');
        const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
        return match ? `(${match[1]}) ${match[2]}-${match[3]}` : phone;
    }
}

// Inicialización al cargar el DOM
document.addEventListener('DOMContentLoaded', function() {
    const registroExitosoInput = document.getElementById('registro_exitoso');
    const registroValidator = new RegistroValidator();
    
    // Restaurar datos guardados si no hubo registro exitoso
    if (!registroExitosoInput || registroExitosoInput.value !== '1') {
        const savedData = localStorage.getItem('weddingConnectFormData');
        if (savedData && registroValidator.form) {
            try {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const field = registroValidator.form.querySelector(`[name="${key}"]`);
                    if (field) field.value = data[key];
                });
            } catch (e) {
                console.error('Error al cargar datos guardados:', e);
            }
        }
    } else {
        localStorage.removeItem('weddingConnectFormData');
    }
    
    // Formato automático de teléfono
    const phoneInput = document.getElementById('telefono');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            const formatted = RegistroValidator.formatPhoneNumber(e.target.value);
            if (formatted !== e.target.value) e.target.value = formatted;
        });
    }
    
    // AUTOCOMPLETADO DEL MENSAJE (CORREGIDO)
    const tipoEventoSelect = document.getElementById('tipo_evento_id');
    const mensajeTextarea = document.getElementById('mensaje');
    
    if (tipoEventoSelect && mensajeTextarea) {
        tipoEventoSelect.addEventListener('change', function() {
            // Solo autocompletar si el mensaje está vacío
            if (!mensajeTextarea.value.trim()) {
                // Obtenemos la clave desde el atributo data-clave de la opción seleccionada
                const selectedOption = this.options[this.selectedIndex];
                const clave = selectedOption.getAttribute('data-clave');
                
                // Mapa de claves a sugerencias (debe coincidir con las que pongas en data-clave)
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
                
                if (clave && sugerencias[clave]) {
                    mensajeTextarea.value = sugerencias[clave];
                }
            }
        });
    }
    
    // Guardado automático en localStorage
    if (registroValidator.form && (!registroExitosoInput || registroExitosoInput.value !== '1')) {
        const formDataKey = 'weddingConnectFormData';
        registroValidator.form.addEventListener('input', function() {
            const formData = new FormData(registroValidator.form);
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            localStorage.setItem(formDataKey, JSON.stringify(data));
        });
        registroValidator.form.addEventListener('submit', function() {
            setTimeout(() => localStorage.removeItem(formDataKey), 100);
        });
    }
});