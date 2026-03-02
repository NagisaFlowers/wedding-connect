// assets/js/index.js

// ===== ACTIVE LINK DETECTION =====
(function() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.php')) {
            link.classList.add('active');
        }
        
        if (link.classList.contains('dropdown-item') && href === currentPage) {
            link.classList.add('active');
        }
    });
})();

// ===== SMOOTH SCROLL =====
(function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const targetElement = document.querySelector(href);
            
            if (targetElement) {
                e.preventDefault();
                
                const navbarHeight = document.getElementById('mainNav').offsetHeight;
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
})();

// ===== BACK TO TOP BUTTON =====
(function() {
    const backToTop = document.getElementById('backToTop');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 500) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
})();

// ===== NEWSLETTER FORM =====
(function() {
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            
            // Aquí iría la lógica para enviar a la API
            console.log('Newsletter suscripción:', email);
            
            // Mostrar mensaje de éxito
            alert('¡Gracias por suscribirte! Pronto recibirás nuestras novedades.');
            this.reset();
        });
    }
})();

// ===== DROPDOWN HOVER EN ESCRITORIO =====
(function() {
    if (window.innerWidth >= 992) {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('mouseenter', function() {
                this.querySelector('.dropdown-menu').classList.add('show');
            });
            
            dropdown.addEventListener('mouseleave', function() {
                this.querySelector('.dropdown-menu').classList.remove('show');
            });
        });
    }
})();

// ===== PREVENIR COMPORTAMIENTO POR DEFECTO DE DROPDOWN EN CLICK =====
(function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth >= 992) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
})();

// ===== CERRAR MENÚ EN MÓVIL AL HACER CLICK =====
(function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('#navbarMain');
    
    if (navbarToggler && navbarCollapse) {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            });
        });
    }
})();