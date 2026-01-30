<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Connect - Wedding Planner</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- letras con estilo -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <!-- Navbar Bootstrap MODIFICADO -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-heart-fill"></i> Wedding Connect
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
           <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nosotros.php">
                            <i class="bi bi-people"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">
                            <i class="bi bi-calendar-plus"></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="admin/login.php">
                            <i class="bi bi-shield-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section (SIN CAMBIOS) -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Tu Evento Perfecto, Nuestra Pasión</h1>
                    <p class="lead mb-4">Planeación profesional de bodas y eventos que hace realidad tus sueños</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="registro.php" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-calendar-check"></i> Solicitar Cotización
                        </a>
                        <a href="#servicios" class="btn btn-primary dark btn-lg px-4">
                            <i class="bi bi-gem"></i> Ver Servicios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios AMPLIADOS -->
    <section id="servicios" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestros Servicios</h2>
                    <p class="lead text-muted">Todo lo que necesitas para el día más especial y otros eventos importantes</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Servicios de Bodas (existentes) -->
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <h4 class="card-title">Bodas</h4>
                            <p class="card-text">Decoración única y personalizada para tu boda perfecta</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Diseño de espacios</li>
                                <li><i class="bi bi-check-circle text-success"></i> Iluminación especial</li>
                                <li><i class="bi bi-check-circle text-success"></i> Centros de mesa</li>
                                <li><i class="bi bi-check-circle text-success"></i> Coordinación completa</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <h4 class="card-title">XV Años</h4>
                            <p class="card-text">Celebración mágica para tus quinceañera inolvidables</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Organización de ceremonia</li>
                                <li><i class="bi bi-check-circle text-success"></i> Vals y coreografías</li>
                                <li><i class="bi bi-check-circle text-success"></i> Banquete especial</li>
                                <li><i class="bi bi-check-circle text-success"></i> Souvenirs personalizados</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-balloon-heart"></i>
                            </div>
                            <h4 class="card-title">Baby Shower</h4>
                            <p class="card-text">Celebra la llegada del bebé con un evento único</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Decoración temática</li>
                                <li><i class="bi bi-check-circle text-success"></i> Juegos y actividades</li>
                                <li><i class="bi bi-check-circle text-success"></i> Buffet dulce y salado</li>
                                <li><i class="bi bi-check-circle text-success"></i> Lista de regalos</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h4 class="card-title">Eventos Empresariales</h4>
                            <p class="card-text">Organización profesional para tu empresa</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Conferencias y convenciones</li>
                                <li><i class="bi bi-check-circle text-success"></i> Team building</li>
                                <li><i class="bi bi-check-circle text-success"></i> Lanzamientos de producto</li>
                                <li><i class="bi bi-check-circle text-success"></i> Aniversarios corporativos</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Segunda fila de servicios -->
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h4 class="card-title">Eventos Municipales</h4>
                            <p class="card-text">Coordinación de eventos institucionales</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Ferias y exposiciones</li>
                                <li><i class="bi bi-check-circle text-success"></i> Festivales culturales</li>
                                <li><i class="bi bi-check-circle text-success"></i> Conmemoraciones oficiales</li>
                                <li><i class="bi bi-check-circle text-success"></i> Eventos deportivos</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-calendar-heart"></i>
                            </div>
                            <h4 class="card-title">Eventos del Año</h4>
                            <p class="card-text">Celebraciones de temporada especiales</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Día de Muertos</li>
                                <li><i class="bi bi-check-circle text-success"></i> Navidad y posadas</li>
                                <li><i class="bi bi-check-circle text-success"></i> Año Nuevo</li>
                                <li><i class="bi bi-check-circle text-success"></i> Día de la Independencia</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-egg-fried"></i>
                            </div>
                            <h4 class="card-title">Banquete</h4>
                            <p class="card-text">Menús gourmet diseñados por chefs expertos</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Catas personalizadas</li>
                                <li><i class="bi bi-check-circle text-success"></i> Opciones vegetarianas</li>
                                <li><i class="bi bi-check-circle text-success"></i> Pastelería artesanal</li>
                                <li><i class="bi bi-check-circle text-success"></i> Servicio de catering</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-music-note-beamed"></i>
                            </div>
                            <h4 class="card-title">Entretenimiento</h4>
                            <p class="card-text">Ambientación perfecta para cada momento</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> DJ profesional</li>
                                <li><i class="bi bi-check-circle text-success"></i> Bandas en vivo</li>
                                <li><i class="bi bi-check-circle text-success"></i> Playlist personalizada</li>
                                <li><i class="bi bi-check-circle text-success"></i> Show de luces</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carrusel de Galerías -->
    <section id="galeria" class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestras Galerías</h2>
                    <p class="lead text-muted">Momentos especiales que hemos creado para cada ocasión</p>
                </div>
            </div>
            
            <!-- Carrusel Bootstrap -->
            <div id="galeriaCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="3"></button>
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="4"></button>
                    <button type="button" data-bs-target="#galeriaCarousel" data-bs-slide-to="5"></button>
                </div>
                
                <div class="carousel-inner">
                    <!-- Galería de Bodas -->
                    <div class="carousel-item active">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de Bodas</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Boda en jardín">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Boda Jardín</h5>
                                            <small>Decoración natural</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Boda playa">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Boda Playa</h5>
                                            <small>Atardecer mágico</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Boda iglesia">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Boda Religiosa</h5>
                                            <small>Ceremonia tradicional</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Banquete">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Banquete</h5>
                                            <small>Cena elegante</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galería de XV Años -->
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de XV Años</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1530103862676-de8c9debad1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="XV años">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Ceremonia</h5>
                                            <small>Vals especial</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Decoración XV">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Decoración</h5>
                                            <small>Tema elegante</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1531058020387-3be344556be6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Pastel XV">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Pastel</h5>
                                            <small>Diseño único</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1519677100203-0f6c1a5b5b5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Fiesta XV">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Fiesta</h5>
                                            <small>Celebración completa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galería de Baby Shower -->
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de Baby Shower</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1579223720598-1117c786cf3c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Baby shower">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Decoración Temática</h5>
                                            <small>Colores pastel</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Juegos baby shower">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Juegos</h5>
                                            <small>Actividades divertidas</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1567306301408-9b74779a11af?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Mesa dulce">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Mesa Dulce</h5>
                                            <small>Postres temáticos</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1512496015856-1e2c9f6d8c2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Regalos">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Regalos</h5>
                                            <small>Presentación especial</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galería de Eventos Empresariales -->
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de Eventos Empresariales</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Conferencia">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Conferencias</h5>
                                            <small>Profesionalismo</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Team building">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Team Building</h5>
                                            <small>Actividades grupales</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Lanzamiento">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Lanzamientos</h5>
                                            <small>Productos nuevos</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1492684223066-dd23140edf6d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Aniversario">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Aniversarios</h5>
                                            <small>Cumpleaños empresa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galería de Eventos Municipales -->
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de Eventos Municipales</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Feria municipal">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Ferias</h5>
                                            <small>Eventos públicos</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Festival cultural">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Festivales</h5>
                                            <small>Cultura y tradición</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1542751110-97427bbecf20?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Evento deportivo">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Deportivos</h5>
                                            <small>Competencias</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Ceremonia oficial">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Ceremonias</h5>
                                            <small>Eventos oficiales</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galería de Eventos del Año -->
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="text-center mb-4">Galería de Eventos del Año</h3>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1508739773434-c26b3d09e071?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Día de Muertos">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Día de Muertos</h5>
                                            <small>Ofrendas y decoración</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1512389142860-9c449e58a543?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Navidad">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Navidad</h5>
                                            <small>Decoración festiva</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Año Nuevo">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Año Nuevo</h5>
                                            <small>Celebraciones</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="gallery-item">
                                        <img src="https://images.unsplash.com/photo-1575728250265-63b81961f18b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                                             class="img-fluid rounded" alt="Independencia">
                                        <div class="gallery-overlay">
                                            <h5 class="mb-0">Independencia</h5>
                                            <small>Fiestas patrias</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#galeriaCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galeriaCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 cta-section text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-4">¿Listos para comenzar?</h2>
                    <p class="lead mb-4">Déjanos hacer realidad el evento de tus sueños</p>
                    <a href="registro.php" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-heart-fill text-danger"></i> Solicitar Cotización Gratuita
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Primera columna -->
                <div class="col-lg-4 mb-4">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-heart-fill"></i> Wedding Connect
                    </h4>
                    <p class="text-light">Creando momentos inolvidables desde 2010</p>
                    <div class="mt-4">
                        <a href="https://www.facebook.com/PlannerCristinaGallo/" class="social-icon bg-primary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/cristinagallo_planner/" class="social-icon bg-danger">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/mar%C3%ADa-cristina-gallo-medina-020328191/?originalSubdomain=mx" class="social-icon bg-primary">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Segunda columna -->
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-4">Contacto</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Enrique c rebsamen 405 bulevares 1a seccion AGS, AGS
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            449 769 8371
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            cristinagallo.planner@gmail.com
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-light my-4">
            <!--actualiza año en automatico-->
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">
                        &copy; <?php echo date("Y"); ?> Wedding Connect. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="politica-privacidad.php" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                    <a href="terminos-condiciones.php" class="text-light text-decoration-none">Términos y Condiciones</a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Personalizado -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>