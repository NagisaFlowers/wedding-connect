<?php
// galeria.php - Página de Galería
include 'includes/header.php';
?>

<!-- Hero Section para Galería -->
<section class="hero-section" style="background-image: url('assets/images/galeria.jpg');"><!-- fondo galeria -->
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="hero-content" data-aos="fade-up">
                    <span class="hero-subtitle">Wedding & Event Planner</span>
                    <br>
                    <h1 class="hero-title-fancy">Nuestra Galería</h1>
                    <p class="hero-subtitle-fancy">Capturamos la magia de cada evento</p>
                    <div class="hero-buttons">
                        <a href="#galeria" class="btn-primary">Ver galería</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galería -->
<section id="galeria" class="gallery-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Nuestro trabajo</span>
            <h2 class="section-title">Galería de Eventos</h2>
            <p class="section-description">Explora un poco de los momentos mágicos que hemos creado para nuestros clientes, para mas detalles de mi trabajo visita mis redes sociales</p>
            <p class="section-description">que se encuentran al final de mi página y ver lo</p>
            <p class="section-description">que podemos hacer realidad juntos.</p>
        </div>
        
        <!-- Filtros de categoría -->
        <div class="gallery-filters text-center" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">Todos</button>
            <button class="filter-btn" data-filter="bodas">Bodas</button>
            <button class="filter-btn" data-filter="xv">XV Años</button>
            <button class="filter-btn" data-filter="baby">Baby Shower</button>
            <button class="filter-btn" data-filter="bautizo">Bautizo</button>
            <button class="filter-btn" data-filter="empresarial">Empresarial</button>
            <button class="filter-btn" data-filter="personalizado">Personalizados</button>
        </div>
        
        <!-- Grid de galería -->
        <div class="gallery-grid" id="gallery-grid">



            <!-- Bodas -->
            <div class="gallery-item" data-category="bodas" data-aos="fade-up">
                <img src="assets/images/bodas/01.jpg" alt="Boda 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Boda Claudia & Carlos</h3>
                        <p> Gran Reserva Sabinos Residencial</p>
                        <button class="gallery-zoom" data-img="assets/images/bodas/01.jpg" data-title="Boda Claudia & Carlos" data-desc=" Gran Reserva Sabinos Residencial">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="bodas" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/bodas/02.jpg" alt="Boda 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Boda Carolina & Miguel</h3>
                        <p>Rancho El Cristo.</p>
                        <button class="gallery-zoom" data-img="assets/images/bodas/02.jpg" data-title="Carolina & Miguel" data-desc="Rancho El Cristo.">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="bodas" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/bodas/03.jpg" alt="Boda 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Boda María & José</h3>
                        <p>Jardín Real</p>
                        <button class="gallery-zoom" data-img="assets/images/bodas/03.jpg" data-title="Boda María & José" data-desc="Jardín Real">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>

            
            <!-- XV Años -->
            <div class="gallery-item" data-category="xv" data-aos="fade-up">
                <img src="assets/images/xv/08.jpg" alt="XV Años 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>XV Años - Valeria</h3>
                        <p>Quinta Real</p>
                        <button class="gallery-zoom" data-img="assets/images/xv/08.jpg" data-title="XV Años - Valeria" data-desc="Quinta Real">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="xv" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/xv/09.jpg" alt="XV Años 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>XV Años - Daniela</h3>
                        <p>Salón Versalles</p>
                        <button class="gallery-zoom" data-img="assets/images/xv/09.jpg" data-title="XV Años - Daniela" data-desc="Salón Versalles">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="xv" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/xv/10.jpg" alt="XV Años 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>XV Años - Sofía</h3>
                        <p>Hacienda San Gabriel</p>
                        <button class="gallery-zoom" data-img="assets/images/xv/10.jpg" data-title="XV Años - Sofía" data-desc="Hacienda San Gabriel">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Baby Shower -->
            <div class="gallery-item" data-category="baby" data-aos="fade-up">
                <img src="assets/images/baby/04.jpg" alt="Baby Shower 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Baby Shower - Juan Pablo</h3>
                        <p>Salón Versalles</p>
                        <button class="gallery-zoom" data-img="assets/images/baby/04.jpg" data-title="Baby Shower - Mateo" data-desc="Salón Versalles">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="baby" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/baby/05.jpg" alt="Baby Shower 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Baby Shower - Valentina</h3>
                        <p>Jardín Real</p>
                        <button class="gallery-zoom" data-img="assets/images/baby/05.jpg" data-title="Baby Shower - Valentina" data-desc="Jardín Real">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="baby" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/baby/06.jpg" alt="Baby Shower 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Baby Shower - Miranda</h3>
                        <p>Quinta Real</p>
                        <button class="gallery-zoom" data-img="assets/images/baby/06.jpg" data-title="Baby Shower - Santiago" data-desc="Quinta Real">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bautizos -->
            <div class="gallery-item" data-category="bautizo" data-aos="fade-up">
                <img src="assets/images/bautizo/c.jpg" alt="Bautizo 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Bautizo - Carlos</h3>
                        <p>Aguascalientes Mexico</p>
                        <button class="gallery-zoom" data-img="assets/images/bautizo/c.jpg" data-title="Bautizo - Carlos" data-desc="Aguascalientes Mexico">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="bautizo" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/bautizo/a.jpg" alt="Bautizo 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Bautizo</h3>
                        <p>Aguacalientes</p>
                        <button class="gallery-zoom" data-img="assets/images/bautizo/a.jpg" data-title="Bautizo" data-desc="Aguacalientes">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="bautizo" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/bautizo/b.jpg" alt="Baby Shower 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Detalles</h3>
                        <p>Nuestro trabajo</p>
                        <button class="gallery-zoom" data-img="assets/images/bautizo/b.jpg" data-title="Detalles" data-desc="Nuestro trabajo">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>

            
            <!-- Empresarial -->
            <div class="gallery-item" data-category="empresarial" data-aos="fade-up">
                <img src="assets/images/empresa/11.jpg" alt="Empresarial 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Convención Anual</h3>
                        <p>Centro de Convenciones</p>
                        <button class="gallery-zoom" data-img="assets/images/empresa/11.jpg" data-title="Convención Anual" data-desc="Centro de Convenciones">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="empresarial" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/empresa/12.jpg" alt="Empresarial 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Inauguración</h3>
                        <p>Finverr</p>
                        <button class="gallery-zoom" data-img="assets/images/empresa/12.jpg" data-title="Inauguración" data-desc="Hotel Fiesta Americana">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="empresarial" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/empresa/14.jpg" alt="Empresarial 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Inauguracion</h3>
                        <p>Finverr</p>
                        <button class="gallery-zoom" data-img="assets/images/empresa/14.jpg" data-title="Coctel Empresarial" data-desc="Club de Industriales">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            
            <!-- Personalizados -->
            <div class="gallery-item" data-category="personalizado" data-aos="fade-up">
                <img src="assets/images/personalizado/18.jpg" alt="Evento Personalizado 1" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Fiesta Temática</h3>
                        <p>Años 90s</p>
                        <button class="gallery-zoom" data-img="assets/images/personalizado/18.jpg" data-title="Fiesta Temática" data-desc="Años 90s">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="gallery-item" data-category="personalizado" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/personalizado/15.jpg" alt="Evento Personalizado 2" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Celebración Navideña</h3>
                        <p>Salón de Eventos</p>
                        <button class="gallery-zoom" data-img="assets/images/personalizado/15.jpg" data-title="Celebración Navideña" data-desc="Salón de Eventos">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="personalizado" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/personalizado/e.jpeg" alt="Evento Personalizado 3" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Drinks y más</h3>
                        <p>Nosotros te hacemos tu evento soñado</p>
                        <button class="gallery-zoom" data-img="assets/images/personalizado/e.jpeg" data-title="Drinks" data-desc="Salón de Eventos">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="personalizado" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/personalizado/gracias.png" alt="Evento Personalizado 4" loading="lazy">
                <div class="gallery-overlay">
                    <div class="gallery-info">
                        <h3>Gracias</h3>
                        <p>Elegirme y formar parte de ti es todo un honor.</p>
                        <button class="gallery-zoom" data-img="assets/images/personalizado/gracias.png" data-title="Drinks" data-desc="Salón de Eventos">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>
</section>

<!-- Modal para zoom de imágenes -->
<div id="gallery-modal" class="gallery-modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modal-image">
    <div class="modal-caption" id="modal-caption"></div>
    <button class="modal-prev"><i class="bi bi-chevron-left"></i></button>
    <button class="modal-next"><i class="bi bi-chevron-right"></i></button>
</div>
