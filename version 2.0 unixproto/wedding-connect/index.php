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
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <!-- Navbar Bootstrap -->
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
                        <a class="nav-link btn btn-outline-primary ms-2" href="admin.php">
                            <i class="bi bi-shield-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Tu Boda Perfecta, Nuestra Pasión</h1>
                    <p class="lead mb-4">Planeación profesional de bodas que hace realidad tus sueños</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="registro.php" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-calendar-check"></i> Solicitar Cotización
                        </a>
                        <a href="#servicios" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-gem"></i> Ver Servicios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestros Servicios</h2>
                    <p class="lead text-muted">Todo lo que necesitas para el día más especial</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-palette"></i>
                            </div>
                            <h4 class="card-title">Decoración</h4>
                            <p class="card-text">Diseños únicos y personalizados que reflejan tu estilo</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Diseño de espacios</li>
                                <li><i class="bi bi-check-circle text-success"></i> Iluminación especial</li>
                                <li><i class="bi bi-check-circle text-success"></i> Centros de mesa</li>
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
                            <p class="card-text">Ambientación musical perfecta para cada momento</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> DJ profesional</li>
                                <li><i class="bi bi-check-circle text-success"></i> Bandas en vivo</li>
                                <li><i class="bi bi-check-circle text-success"></i> Playlist personalizada</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <h4 class="card-title">Fotografía & Video</h4>
                            <p class="card-text">Capturamos cada momento para la eternidad</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check-circle text-success"></i> Sesión pre-boda</li>
                                <li><i class="bi bi-check-circle text-success"></i> Cobertura completa</li>
                                <li><i class="bi bi-check-circle text-success"></i> Álbum de lujo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section id="galeria" class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Galería de Bodas</h2>
                    <p class="lead text-muted">Momentos mágicos que hemos creado</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             class="img-fluid rounded" alt="Boda en jardín">
                        <div class="gallery-overlay">
                            <h5 class="mb-0">Boda Jardín</h5>
                            <small>Decoración natural</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             class="img-fluid rounded" alt="Boda playa">
                        <div class="gallery-overlay">
                            <h5 class="mb-0">Boda Playa</h5>
                            <small>Atardecer mágico</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             class="img-fluid rounded" alt="Boda iglesia">
                        <div class="gallery-overlay">
                            <h5 class="mb-0">Boda Religiosa</h5>
                            <small>Ceremonia tradicional</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
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
    </section>

    <!-- CTA Section -->
    <section class="py-5 cta-section text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-4">¿Listos para comenzar?</h2>
                    <p class="lead mb-4">Déjanos hacer realidad la boda de tus sueños</p>
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
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-heart-fill"></i> Wedding Connect
                    </h4>
                    <p class="text-light">Creando momentos inolvidables desde 2010</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon bg-primary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon bg-danger">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon bg-primary">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 mb-3">
                    <h5 class="text-white mb-4">Contacto</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Enrique c rebsamen 405 bulevares 1a seccion AGS, AGS
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            +52 1 449 769 8371
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            cristinagallo.planner@gmail.com
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-3">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p class="text-light mb-3">Suscríbete para recibir tips y promociones</p>
                    <form class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu email" required>
                            <button class="btn btn-outline-light" type="submit">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="bg-light my-3">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2026 Wedding Connect. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                    <a href="#" class="text-light text-decoration-none">Términos y Condiciones</a>
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