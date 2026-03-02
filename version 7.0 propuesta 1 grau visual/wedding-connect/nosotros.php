<?php
// nosotros.php - Página Nosotros
include 'includes/header.php';
?>

<!-- Hero Section para Nosotros -->
<section class="hero-section" style="background-image: url('assets/images/nosotros.jpeg');"><!-- fondo nosotros -->
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="hero-content" data-aos="fade-up">
                <span class="hero-subtitle">Wedding & Event Planner</span>
                <h1 class="display-4 fw-bold mb-4">Conoceme</h1>
                <p class="lead mb-4">Más de una década creando experiencias únicas e inolvidables.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#historia" class="btn-primary">Nuestra Historia</a>
                    <a href="#valores" class="btn-primary">Nuestros Valores</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN MIS OBJETIVOS (NUEVA) -->
<section class="about-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Mi Filosofía</span>
            <h2 class="section-title">Mis Objetivos</h2>
            <p class="section-description">La base de mi trabajo y compromiso contigo</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Objetivo 1: Hacer tu evento realidad -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card" style="text-align: center; padding: 3rem 2rem;">
                    <div class="service-icon" style="margin: 0 auto 2rem;">
                        <i class="bi bi-calendar-check" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="service-title" style="font-size: 2rem; margin-bottom: 1rem;">HACER TU EVENTO REALIDAD</h3>
                    <p class="service-description" style="font-size: 1.1rem;">Cada sueño merece hacerse realidad. Trabajo incansablemente para materializar la visión que tienes para tu evento especial.</p>
                </div>
            </div>
            
            <!-- Objetivo 2: Pensar fuera de la caja -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card" style="text-align: center; padding: 3rem 2rem;">
                    <div class="service-icon" style="margin: 0 auto 2rem;">
                        <i class="bi bi-lightbulb" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="service-title" style="font-size: 2rem; margin-bottom: 1rem;">PENSAR FUERA DE LA CAJA</h3>
                    <p class="service-description" style="font-size: 1.1rem;">La creatividad no tiene límites. Busco siempre ideas innovadoras y originales que hagan tu evento único y memorable.</p>
                </div>
            </div>
            
            <!-- Objetivo 3: Crear experiencias inolvidables -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card" style="text-align: center; padding: 3rem 2rem;">
                    <div class="service-icon" style="margin: 0 auto 2rem;">
                        <i class="bi bi-star" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="service-title" style="font-size: 2rem; margin-bottom: 1rem;">CREAR EXPERIENCIAS INOLVIDABLES</h3>
                    <p class="service-description" style="font-size: 1.1rem;">Más que eventos, creo recuerdos que perduran para siempre. Cada detalle está diseñado para emocionar y sorprender.</p>
                </div>
            </div>
        </div>
        
        <!-- Frase destacada -->
        <div class="row justify-content-center mt-5" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="about-quote" style="text-align: center; padding: 3rem;">
                    <i class="bi bi-quote" style="font-size: 3rem; color: var(--color-primary); opacity: 0.5;"></i>
                    <p style="font-size: 1.5rem; font-family: var(--font-serif); font-style: italic; margin: 1rem 0;">
                        "Hacer tu evento realidad es mi mayor satisfacción. Cada proyecto es un nuevo desafío que abrazo con la misma ilusión que el primero."
                    </p>
                    <p style="font-size: 1.2rem; color: var(--color-primary);">— Cristina Gallo</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nuestra Historia -->
<section id="historia" class="about-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center" data-aos="fade-up">
                <span class="section-tag">Trayectoria</span>
                <h2 class="section-title">Nuestra Historia</h2>
                <p class="section-description">Una trayectoria de excelencia y pasión por los eventos</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="service-card" style="padding: 3rem;">
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="service-icon" style="margin: 0 auto;">
                                <i class="bi bi-heart" style="font-size: 3rem;"></i>
                            </div>
                            <h4 style="font-size: 2rem; font-family: var(--font-serif); margin-top: 1rem;">Desde 2010</h4>
                        </div>
                        <div class="col-lg-8">
                            <div class="about-text">
                                <p class="mb-4">Cristina Gallo Event Planner se remonta a la organización de pequeñas celebraciones en entornos íntimos como casas y jardines, donde desde un inicio se forjó una sólida reputación basada en la atención al detalle y la creatividad.</p>
                                <p class="mb-4">Este enfoque meticuloso, sumado a una apasionada dedicación por hacer de cada evento —especialmente cada boda— una experiencia única, generó un crecimiento orgánico impulsado por la recomendación boca a boca entre los clientes satisfechos.</p>
                                <p class="mb-4">Con una ejecución demostrable de más de 70 eventos anuales y un historial de éxito en cada uno de ellos, la constante innovación y el compromiso inquebrantable con la satisfacción del cliente han posicionado a la empresa como un líder y referente en el sector de la planificación de eventos.</p>
                                <p class="mb-0">Nuestra área de servicio es Aguascalientes, México • Jalisco, México • Aguascalientes Centro, Aguascalientes, México • Zacatecas, México.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Misión y Visión -->
<section class="about-section">
    <div class="container">
        <div class="row g-4">
            <!-- Misión -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="service-card h-100" style="padding: 3rem;">
                    <div class="service-icon" style="margin: 0 auto 1.5rem;">
                        <i class="bi bi-bullseye" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="service-title text-center">Nuestra Misión</h3>
                    <div class="mission-text">
                        <p>Nuestra misión es hacer que su día sea especial y tenga todo lo que siempre soñaron, ¡y todo sin preocupaciones! Materializar la visión única de cada cliente, diseñando y ejecutando experiencias excepcionales en los ámbitos social, corporativo y gubernamental.</p>
                        <p class="mb-0">Nos comprometemos a superar expectativas a través de una planificación meticulosa, una logística impecable y un servicio apasionado, donde cada detalle es cuidado con excelencia.</p>
                    </div>
                </div>
            </div>
            
            <!-- Visión -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="service-card h-100" style="padding: 3rem;">
                    <div class="service-icon" style="margin: 0 auto 1.5rem;">
                        <i class="bi bi-eye" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="service-title text-center">Nuestra Visión</h3>
                    <div class="vision-text">
                        <p>Ser el referente indiscutible y líder en la industria de la planificación de eventos, ser reconocidos por nuestra innovación constante, nuestra adherencia al más alto protocolo y nuestra capacidad infalible para crear experiencias emocionalmente resonantes y operativamente perfectas.</p>
                        <p class="mb-0">Aspiramos a ser la primera opción para quienes buscan excelencia, confianza y un partner creativo que eleve cualquier celebración o acto institucional a su máxima expresión.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nuestros Valores -->
<section id="valores" class="services-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Principios</span>
            <h2 class="section-title">Nuestros Valores</h2>
            <p class="section-description">Los principios que guían nuestro trabajo y nos definen</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4 class="service-title">Excelencia Operativa</h4>
                    <p class="service-description">Compromiso con el más alto estándar de calidad en cada fase, garantizando el éxito total de cada evento.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h4 class="service-title">Pasión por el Detalle</h4>
                    <p class="service-description">Creemos que la magia reside en los detalles. Nuestra meticulosidad y creatividad son el sello que hace único cada proyecto.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4 class="service-title">Innovación Constante</h4>
                    <p class="service-description">Buscamos siempre nuevas ideas, diseños y soluciones para sorprender y mantenernos a la vanguardia.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="service-title">Confianza y Protocolo</h4>
                    <p class="service-description">Actuamos con profesionalidad, discreción y respeto por los protocolos oficiales y las tradiciones.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-emoji-smile"></i>
                    </div>
                    <h4 class="service-title">Compromiso con el Cliente</h4>
                    <p class="service-description">Colocamos las necesidades y felicidad de nuestros clientes en el centro de todo lo que hacemos.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="service-card h-100 text-center">
                    <div class="service-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="service-title">Trabajo en Equipo</h4>
                    <p class="service-description">Coordinamos equipos especializados con liderazgo y sinergia para el éxito de cada evento.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipo de Trabajo / Fundador -->
<section class="about-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-tag">Fundadora</span>
            <h2 class="section-title">Cristina Gallo</h2>
            <p class="section-description">La visión y experiencia detrás de Cristina Gallo Planner</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="service-card" style="padding: 3rem;">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="service-icon" style="margin: 0 auto;">
                                <i class="bi bi-person-badge" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="service-title mb-2">Cristina Gallo</h4>
                            <p class="text-muted mb-0">Fundadora y CEO</p>
                        </div>
                        <div class="col-md-8">
                            <p class="mb-3">Con más de 10 años de experiencia en la industria de eventos, Cristina Gallo ha transformado su visión en un referente de excelencia en planificación de bodas y eventos especiales.</p>
                            <p class="mb-0">Su pasión por los detalles y compromiso con la satisfacción del cliente han sido el motor detrás del crecimiento y éxito de la empresa, estableciendo nuevos estándares de calidad en el sector.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>