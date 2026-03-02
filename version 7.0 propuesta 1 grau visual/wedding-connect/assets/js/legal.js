// JavaScript para páginas legales - Armonizado con el sitio

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Animación para acordeones
    const accordionItems = document.querySelectorAll('.accordion-item');
    accordionItems.forEach(item => {
        item.addEventListener('shown.bs.collapse', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1)';
        });
    });

    // 2. Resaltar sección activa en tabs con animación mejorada
    const privacyTabs = document.getElementById('privacyTabs');
    if (privacyTabs) {
        privacyTabs.addEventListener('shown.bs.tab', function(event) {
            const activeTab = event.target;
            
            // Animación suave al cambiar de tab
            const tabContent = document.querySelector('.tab-content');
            tabContent.style.opacity = '0';
            tabContent.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                tabContent.style.transition = 'all 0.4s ease';
                tabContent.style.opacity = '1';
                tabContent.style.transform = 'translateY(0)';
            }, 50);
        });
    }

    // 3. Efecto hover mejorado en tarjetas
    const cards = document.querySelectorAll('.value-card, .info-box');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });

    // 4. Botón para ver ley PDF con confirmación mejorada
    const viewLawBtn = document.getElementById('view-law-btn');
    if (viewLawBtn) {
        viewLawBtn.addEventListener('click', function(e) {
            if (!confirm('📄 Se abrirá el PDF oficial de la LFPDPPP en una nueva pestaña.\n\n¿Deseas continuar?')) {
                e.preventDefault();
            } else {
                // Tracking para analytics (si existe)
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'click', {
                        'event_category': 'PDF',
                        'event_label': 'LFPDPPP',
                        'value': 1
                    });
                }
                console.log('ℹ️ Usuario consultó ley LFPDPPP');
            }
        });
    }

    // 5. Scroll suave mejorado para anclas internas
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const headerHeight = 76; // Altura del navbar fijo
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Actualizar URL sin recargar
                history.pushState(null, null, targetId);
            }
        });
    });

    // 6. Mostrar/ocultar contenido extenso (toggle mejorado)
    const toggleButtons = document.querySelectorAll('.toggle-content');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const isHidden = targetElement.style.display === 'none' || targetElement.classList.contains('d-none');
                
                if (isHidden) {
                    targetElement.style.display = 'block';
                    targetElement.classList.remove('d-none');
                    targetElement.style.animation = 'fadeInUp 0.6s ease-out';
                    this.innerHTML = '<i class="bi bi-chevron-up"></i> Ver menos';
                } else {
                    targetElement.style.animation = '';
                    targetElement.style.display = 'none';
                    targetElement.classList.add('d-none');
                    this.innerHTML = '<i class="bi bi-chevron-down"></i> Ver más';
                }
            }
        });
    });

    // 7. Copiar enlace de sección al hacer clic en encabezados
    document.querySelectorAll('h2[id], h3[id], h4[id]').forEach(heading => {
        heading.style.cursor = 'pointer';
        heading.title = 'Haz clic para copiar enlace a esta sección';
        
        heading.addEventListener('click', async function() {
            const link = window.location.origin + window.location.pathname + '#' + this.id;
            
            try {
                await navigator.clipboard.writeText(link);
                
                // Feedback visual mejorado
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-circle-fill" style="color: var(--color-primary);"></i> ¡Enlace copiado!';
                this.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                }, 2000);
                
                // Mostrar notificación toast si existe
                showToast('✅ Enlace copiado al portapapeles');
                
            } catch (err) {
                console.error('❌ Error al copiar: ', err);
                showToast('❌ No se pudo copiar el enlace', 'error');
            }
        });
    });

    // 8. Contador de tiempo de lectura mejorado
    function calculateReadingTime() {
        const content = document.querySelector('.about-section .service-card');
        if (!content) return;
        
        // Eliminar scripts y estilos del conteo
        const text = content.textContent
            .replace(/\s+/g, ' ')
            .replace(/<[^>]*>/g, '')
            .trim();
        
        const wordCount = text.split(/\s+/).length;
        const readingTime = Math.max(1, Math.ceil(wordCount / 200)); // Mínimo 1 minuto
        
        const readingTimeElement = document.getElementById('reading-time');
        if (readingTimeElement) {
            readingTimeElement.innerHTML = `
                <i class="bi bi-clock-history"></i> 
                Tiempo estimado de lectura: <strong>${readingTime} min</strong> 
                (${wordCount.toLocaleString()} palabras)
            `;
        }
    }

    // Calcular tiempo de lectura después de cargar todo
    setTimeout(calculateReadingTime, 500);

    // 9. Ajustar acordeones para mejor UX
    function adjustAccordionHeights() {
        document.querySelectorAll('.accordion-collapse.show').forEach(body => {
            body.style.maxHeight = body.scrollHeight + 'px';
        });
    }

    window.addEventListener('resize', adjustAccordionHeights);
    
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', () => {
            setTimeout(adjustAccordionHeights, 300);
        });
    });

    // 10. Actualizar año en copyright automáticamente
    function updateCopyrightYear() {
        const currentYear = new Date().getFullYear();
        document.querySelectorAll('footer p').forEach(element => {
            if (element.textContent.includes('©')) {
                element.innerHTML = element.innerHTML.replace(/2026/g, currentYear.toString());
            }
        });
    }
    updateCopyrightYear();

    // 11. Función para mostrar toasts (notificaciones)
    function showToast(message, type = 'success') {
        // Verificar si ya existe un contenedor de toast
        let toastContainer = document.querySelector('.toast-container');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Crear toast
        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        // Inicializar y mostrar toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();
        
        // Eliminar después de ocultar
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }

    // 12. Detectar si hay hash en URL y hacer scroll
    if (window.location.hash) {
        const targetElement = document.querySelector(window.location.hash);
        if (targetElement) {
            setTimeout(() => {
                const headerHeight = 76;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }, 500);
        }
    }

    // 13. Mejorar accesibilidad
    function enhanceAccessibility() {
        // Agregar atributos ARIA donde falten
        document.querySelectorAll('.accordion-button').forEach(button => {
            if (!button.getAttribute('aria-label')) {
                button.setAttribute('aria-label', 'Expandir sección');
            }
        });
        
        // Mejorar contraste en textos
        document.querySelectorAll('.text-muted').forEach(el => {
            el.style.color = 'var(--color-gray-dark)';
        });
    }
    enhanceAccessibility();
});

// Añadir estilos dinámicos adicionales
document.head.insertAdjacentHTML('beforeend', `
    <style>
        /* Estilos para toasts */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            background: var(--color-primary) !important;
            color: var(--color-dark) !important;
            border-radius: 0 !important;
            font-family: var(--font-sans);
        }
        
        .toast.bg-success {
            background: var(--color-primary) !important;
        }
        
        .toast.bg-danger {
            background: var(--color-secondary) !important;
        }
        
        /* Animación para cambio de tabs */
        .tab-pane {
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        
        /* Mejora para enlaces copiados */
        h2[id], h3[id], h4[id] {
            position: relative;
            transition: all 0.3s ease;
        }
        
        h2[id]:hover::before,
        h3[id]:hover::before,
        h4[id]:hover::before {
            content: '#';
            position: absolute;
            left: -20px;
            color: var(--color-primary);
            font-weight: bold;
            opacity: 0.7;
        }
        
        /* Estilo para el botón de ley */
        #view-law-btn {
            position: relative;
            overflow: hidden;
        }
        
        #view-law-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        #view-law-btn:active::after {
            width: 300px;
            height: 300px;
        }
        
        /* Mejora para cards */
        .value-card, .info-box {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        /* Indicador de lectura */
        #reading-time {
            display: inline-block;
            padding: 8px 20px;
            background: var(--color-light);
            border-left: 4px solid var(--color-primary);
            font-family: var(--font-sans);
            font-size: 0.9rem;
            color: var(--color-gray-dark);
            margin-top: 20px;
        }
        
        /* Scroll suave mejorado */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        
        /* Focus visible para accesibilidad */
        :focus-visible {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }
        
        /* Media query para prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
`);

//script legal para terminos y comdiciones 
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar los tabs de Bootstrap manualmente
    var triggerTabList = [].slice.call(document.querySelectorAll('.nav-tabs .nav-link'));
    triggerTabList.forEach(function(triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });
    
    // Calcular tiempo de lectura
    function calculateReadingTime() {
        // Obtener el texto del contenido principal
        const content = document.querySelector('.legal-content') || document.querySelector('.about-section');
        if (content) {
            const text = content.innerText || content.textContent;
            const wordCount = text.split(/\s+/).length;
            const readingTime = Math.ceil(wordCount / 200); // 200 palabras por minuto
            
            const readingTimeElement = document.getElementById('reading-time');
            if (readingTimeElement) {
                readingTimeElement.innerHTML = `<i class="bi bi-clock"></i> Tiempo de lectura aproximado: ${readingTime} ${readingTime === 1 ? 'minuto' : 'minutos'}`;
            }
        }
    }
    
    // Ejecutar cálculo de tiempo de lectura
    calculateReadingTime();
});
