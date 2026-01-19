<?php
$titulo = "Nosotros - Wedding Connect";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            color: #e91e63 !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            color: #e91e63;
        }
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0 100px;
            margin-top: 76px;
        }
        .about-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .about-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: -50px;
            position: relative;
            z-index: 1;
        }
        .about-icon {
            font-size: 4rem;
            color: #e91e63;
            margin-bottom: 2rem;
        }
        .values-section {
            padding: 80px 0;
            background: white;
        }
        .value-card {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            background: #f8f9fa;
            height: 100%;
            transition: transform 0.3s;
            border-left: 4px solid #e91e63;
        }
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(233, 30, 99, 0.1);
        }
        .value-icon {
            font-size: 2.5rem;
            color: #e91e63;
            margin-bottom: 1.5rem;
        }
        .info-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .info-box {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
            border-top: 4px solid #e91e63;
        }
        .info-icon {
            font-size: 2rem;
            color: #e91e63;
            margin-bottom: 1rem;
        }
        .footer {
            background: #2c3e50;
            color: white;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            color: white;
            text-decoration: none;
        }
        .social-icon:hover {
            opacity: 0.8;
        }
        .section-title {
            color: #e91e63;
            font-weight: bold;
            margin-bottom: 2rem;
        }
        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }
        .about-text p {
            margin-bottom: 1.5rem;
        }
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #e91e63, #9b4dff);
            color: white;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
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
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="nosotros.php">
                            <i class="bi bi-people"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mision.php">
                            <i class="bi bi-bullseye"></i> Misión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vision.php">
                            <i class="bi bi-eye"></i> Visión
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

    <!-- Hero Section de Nosotros -->
    <section class="about-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Sobre Nosotros</h1>
                    <p class="lead mb-0">Más de una década creando experiencias únicas e inolvidables.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-buildings" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestra Historia -->
    <section class="about-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-card">
                        <div class="text-center mb-5">
                            <i class="bi bi-book-heart about-icon"></i>
                            <h2 class="section-title text-center">Nuestra Historia</h2>
                        </div>
                        <div class="about-text">
                            <p>Cristina Gallo Event Planner se remonta a la organización de pequeñas celebraciones en entornos íntimos como casas y jardines, donde desde un inicio se forjó una sólida reputación basada en la atención al detalle y la creatividad.</p>
                            <p>Este enfoque meticuloso, sumado a una apasionada dedicación por hacer de cada evento —especialmente cada boda— una experiencia única, generó un crecimiento orgánico impulsado por la recomendación boca a boca entre los clientes satisfechos.</p>
                            <p>Conforme el proyecto se perfeccionaba, se estructuró y expandió su alcance para atender de manera especializada las tres áreas principales de la industria: Eventos Sociales (con foco en bodas), Corporativos y Gubernamentales o Municipales.</p>
                            <p>Con una ejecución demostrable de más de 70 eventos anuales y un historial de éxito en cada uno de ellos, la constante innovación y el compromiso inquebrantable con la satisfacción del cliente han posicionado a la empresa como un líder y referente en el sector de la planificación de eventos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Años de Experiencia</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">70+</div>
                    <div class="stat-label">Eventos Anuales</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Bodas Realizadas</div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Satisfacción del Cliente</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestros Valores -->
    <section class="values-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestros Valores</h2>
                    <p class="lead text-muted">Los principios que guían nuestro trabajo</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <h4>Excelencia Operativa</h4>
                        <p>Compromiso con el más alto estándar de calidad en cada fase, garantizando el éxito total de cada evento.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h4>Pasión por el Detalle</h4>
                        <p>Creemos que la magia reside en los detalles. Nuestra meticulosidad y creatividad son el sello que hace único cada proyecto.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <h4>Innovación Constante</h4>
                        <p>Buscamos siempre nuevas ideas, diseños y soluciones para sorprender y mantenernos a la vanguardia.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Confianza y Protocolo</h4>
                        <p>Actuamos con profesionalidad, discreción y respeto por los protocolos oficiales y las tradiciones.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <h4>Compromiso con el Cliente</h4>
                        <p>Colocamos las necesidades y felicidad de nuestros clientes en el centro de todo lo que hacemos.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Trabajo en Equipo</h4>
                        <p>Coordinamos equipos especializados con liderazgo y sinergia para el éxito de cada evento.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
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
                               
                <div class="col-lg-3 mb-4">
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
                
                <div class="col-lg-3 mb-4">
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
            
            <hr class="bg-light my-4">
            
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
    
    <script>
        // Smooth scroll para navegación
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Activar enlace activo en navbar
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>