// assets/js/galeria.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Galería JS cargado correctamente');
    
    // ===== VARIABLES GLOBALES =====
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const modal = document.getElementById('gallery-modal');
    const modalImg = document.getElementById('modal-image');
    const modalCaption = document.getElementById('modal-caption');
    const closeBtn = document.querySelector('.modal-close');
    const prevBtn = document.querySelector('.modal-prev');
    const nextBtn = document.querySelector('.modal-next');
    
    let currentImages = [];
    let currentIndex = 0;
    
    // ===== FILTROS DE GALERÍA =====
    if (filterButtons.length > 0 && galleryItems.length > 0) {
        console.log(`✅ ${filterButtons.length} botones y ${galleryItems.length} items encontrados`);
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remover active de todos los botones
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Agregar active al botón clickeado
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                console.log('Filtrando por:', filterValue);
                
                galleryItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    
                    if (filterValue === 'all' || itemCategory === filterValue) {
                        item.style.display = 'block';
                        item.style.animation = 'none';
                        item.offsetHeight; // Forzar reflow
                        item.style.animation = 'fadeInUp 0.6s ease';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    } else {
        console.warn('⚠️ No se encontraron botones o items de galería');
    }
    
    // ===== FUNCIÓN PARA ABRIR MODAL =====
    function openModal(index) {
        if (currentImages.length === 0) return;
        
        const imgData = currentImages[index];
        modalImg.src = imgData.src;
        modalCaption.innerHTML = `<h3>${imgData.title}</h3><p>${imgData.desc}</p>`;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        currentIndex = index;
        console.log('Modal abierto:', imgData.title);
    }
    
    // ===== BOTONES DE ZOOM =====
    document.querySelectorAll('.gallery-zoom').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Recopilar todas las imágenes visibles
            const visibleItems = Array.from(galleryItems).filter(item => 
                item.style.display !== 'none'
            );
            
            currentImages = visibleItems.map(item => {
                const img = item.querySelector('img');
                const title = item.querySelector('h3')?.textContent || 'Sin título';
                const desc = item.querySelector('p')?.textContent || '';
                return {
                    src: img.src,
                    title: title,
                    desc: desc
                };
            });
            
            // Encontrar índice de la imagen actual
            const currentItem = btn.closest('.gallery-item');
            const currentSrc = currentItem.querySelector('img').src;
            currentIndex = currentImages.findIndex(img => img.src === currentSrc);
            
            openModal(currentIndex);
        });
    });
    
    // ===== CLICK EN ITEM DE GALERÍA =====
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const zoomBtn = this.querySelector('.gallery-zoom');
            if (zoomBtn) {
                zoomBtn.click();
            }
        });
    });
    
    // ===== CERRAR MODAL =====
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    
    // ===== CLICK FUERA DEL MODAL =====
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // ===== NAVEGACIÓN ENTRE IMÁGENES =====
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (currentImages.length > 0) {
                currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                const imgData = currentImages[currentIndex];
                modalImg.src = imgData.src;
                modalCaption.innerHTML = `<h3>${imgData.title}</h3><p>${imgData.desc}</p>`;
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (currentImages.length > 0) {
                currentIndex = (currentIndex + 1) % currentImages.length;
                const imgData = currentImages[currentIndex];
                modalImg.src = imgData.src;
                modalCaption.innerHTML = `<h3>${imgData.title}</h3><p>${imgData.desc}</p>`;
            }
        });
    }
    
    // ===== TECLADO =====
    document.addEventListener('keydown', function(e) {
        if (modal.style.display === 'block') {
            if (e.key === 'Escape') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            } else if (e.key === 'ArrowLeft') {
                if (prevBtn) prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                if (nextBtn) nextBtn.click();
            }
        }
    });
    
    // ===== PRECARGA DE IMÁGENES =====
    const images = document.querySelectorAll('.gallery-item img');
    images.forEach(img => {
        const src = img.getAttribute('src');
        if (src && !src.includes('placeholder')) {
            const preloadImg = new Image();
            preloadImg.src = src;
        }
    });
    
    // ===== ANIMACIÓN DE ENTRADA =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    galleryItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(item);
    });
    
    console.log('✅ Galería inicializada correctamente');
});