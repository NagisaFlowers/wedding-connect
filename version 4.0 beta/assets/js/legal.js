// JavaScript para páginas legales

document.addEventListener('DOMContentLoaded', function() {
    // 1. Animación para acordeones
    const accordionItems = document.querySelectorAll('.accordion-item');
    accordionItems.forEach(item => {
        item.addEventListener('shown.bs.collapse', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });

    // 2. Resaltar sección activa en tabs
    const privacyTabs = document.getElementById('privacyTabs');
    if (privacyTabs) {
        privacyTabs.addEventListener('shown.bs.tab', function(event) {
            const activeTab = event.target;
            const allTabs = privacyTabs.querySelectorAll('.nav-link');
            
            allTabs.forEach(tab => {
                tab.classList.remove('active-tab');
            });
            
            activeTab.classList.add('active-tab');
            
            // Animación suave al cambiar de tab
            const tabContent = document.querySelector('.tab-content');
            tabContent.style.opacity = '0';
            setTimeout(() => {
                tabContent.style.transition = 'opacity 0.3s ease';
                tabContent.style.opacity = '1';
            }, 10);
        });
    }

    // 3. Efecto hover en tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.cursor = 'default';
        });
    });

    // 4. Botón para ver ley PDF
    const viewLawBtn = document.getElementById('view-law-btn');
    if (viewLawBtn) {
        viewLawBtn.addEventListener('click', function(e) {
            // Confirmación antes de abrir PDF
            if (!confirm('Se abrirá el PDF oficial de la LFPDPPP en una nueva pestaña. ¿Continuar?')) {
                e.preventDefault();
            } else {
                // Tracking simulado (puedes implementar Google Analytics aquí)
                console.log('Usuario consultó ley LFPDPPP');
            }
        });
    }

    // 5. Scroll suave para anclas internas
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Solo para anclas internas
            if (href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const headerHeight = 76; // Altura del navbar fijo
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // 6. Mostrar/ocultar contenido extenso
    const toggleButtons = document.querySelectorAll('.toggle-content');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                if (targetElement.style.display === 'none' || targetElement.classList.contains('d-none')) {
                    targetElement.style.display = 'block';
                    targetElement.classList.remove('d-none');
                    this.innerHTML = '<i class="bi bi-chevron-up"></i> Ver menos';
                } else {
                    targetElement.style.display = 'none';
                    targetElement.classList.add('d-none');
                    this.innerHTML = '<i class="bi bi-chevron-down"></i> Ver más';
                }
            }
        });
    });

    // 7. Copiar enlace de sección
    document.querySelectorAll('h2, h3, h4').forEach(heading => {
        if (heading.id) {
            heading.style.cursor = 'pointer';
            heading.addEventListener('click', function() {
                const link = window.location.origin + window.location.pathname + '#' + this.id;
                
                // Copiar al portapapeles
                navigator.clipboard.writeText(link).then(() => {
                    // Feedback visual
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check"></i> Enlace copiado!';
                    this.style.color = 'var(--success)';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.color = '';
                    }, 2000);
                }).catch(err => {
                    console.error('Error al copiar: ', err);
                });
            });
        }
    });

    // 8. Contador de tiempo de lectura
    function calculateReadingTime() {
        const content = document.querySelector('.legal-content');
        if (!content) return;
        
        const text = content.textContent;
        const wordCount = text.trim().split(/\s+/).length;
        const readingTime = Math.ceil(wordCount / 200); // 200 palabras por minuto
        
        const readingTimeElement = document.getElementById('reading-time');
        if (readingTimeElement) {
            readingTimeElement.textContent = `Tiempo estimado de lectura: ${readingTime} min`;
        }
    }

    // Calcular tiempo de lectura después de cargar todo
    setTimeout(calculateReadingTime, 1000);

    // 9. Ajustar altura de acordeones
    function adjustAccordionHeights() {
        const accordionBodies = document.querySelectorAll('.accordion-collapse');
        accordionBodies.forEach(body => {
            if (body.classList.contains('show')) {
                body.style.maxHeight = body.scrollHeight + 'px';
            }
        });
    }

    // Recalcular cuando se expande un acordeón
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', adjustAccordionHeights);
    });

    // 10. Mostrar año actual en copyright
    const copyrightElements = document.querySelectorAll('footer p:contains("©")');
    const currentYear = new Date().getFullYear();
    
    copyrightElements.forEach(element => {
        element.textContent = element.textContent.replace(/2026/, currentYear.toString());
    });
});

// Añadir estilos dinámicos
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .active-tab {
            position: relative;
        }
        
        .active-tab::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px 3px 0 0;
        }
        
        .reading-time {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.9rem;
            color: #666;
            display: inline-block;
            margin-top: 10px;
        }
        
        /* Estilos para impresión */
        @media print {
            .navbar, .footer, .legal-badge, .btn {
                display: none !important;
            }
            
            .privacy-hero, .terms-hero {
                padding: 50px 0 !important;
                margin-top: 0 !important;
            }
            
            .card {
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }
            
            .accordion-button::after {
                display: none !important;
            }
            
            .accordion-collapse {
                display: block !important;
            }
        }
    </style>
`);