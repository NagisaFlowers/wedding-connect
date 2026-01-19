<?php
$titulo = "Misión - Wedding Connect";
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
        .mission-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0 100px;
            margin-top: 76px;
        }
        .mission-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .mission-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: -50px;
            position: relative;
            z-index: 1;
        }
        .mission-icon {
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
        }
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .value-icon {
            font-size: 2.5rem;
            color: #e91e63;
            margin-bottom: 1.5rem;
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
        .mission-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }
        .mission-text p {
            margin-bottom: 1.5rem;
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
                        <a class="nav-link" href="nosotros.php">
                            <i class="bi bi-people"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="mision.php">
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

    <!-- Hero Section de Misión -->
    <section class="mission-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Nuestra Misión</h1>
                    <p class="lead mb-0">El propósito fundamental que guía cada uno de nuestros proyectos y servicios.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-compass" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido de Misión -->
    <section class="mission-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="mission-card">
                        <div class="text-center mb-5">
                            <i class="bi bi-bullseye mission-icon"></i>
                            <h2 class="section-title text-center">Declaración de Misión</h2>
                        </div>
                        <div class="mission-text">
                            <p class="mb-4">Nuestra misión es hacer que su día sea especial y tenga todo lo que siempre soñaron, ¡y todo sin preocupaciones! Materializar la visión única de cada cliente, diseñando y ejecutando experiencias excepcionales en los ámbitos social, corporativo y gubernamental.</p>
                            <p class="mb-4">Nos comprometemos a superar expectativas a través de una planificación meticulosa, una logística impecable y un servicio apasionado, donde cada detalle es cuidado con excelencia.</p>
                            <p class="mb-0">Convertimos sueños en realidad, celebraciones en recuerdos imperecederos y objetivos corporativos en eventos estratégicos de alto impacto.</p>
                        </div>
                    </div>
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
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4>Pasión</h4>
                        <p>Amamos lo que hacemos y transmitimos esa pasión en cada detalle de tu evento.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Excelencia</h4>
                        <p>Buscamos la perfección en cada aspecto, desde la planificación hasta la ejecución.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4>Compromiso</h4>
                        <p>Nos dedicamos completamente a hacer realidad la visión única de cada cliente.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Confianza</h4>
                        <p>Generamos relaciones basadas en la transparencia y la confianza mutua.</p>
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