<?php
$titulo = "Visión - Wedding Connect";
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
        .vision-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0 100px;
            margin-top: 76px;
        }
        .vision-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .vision-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: -50px;
            position: relative;
            z-index: 1;
        }
        .vision-icon {
            font-size: 4rem;
            color: #e91e63;
            margin-bottom: 2rem;
        }
        .goals-section {
            padding: 80px 0;
            background: white;
        }
        .goal-card {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            background: #f8f9fa;
            height: 100%;
            transition: transform 0.3s;
            border-left: 4px solid #e91e63;
        }
        .goal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(233, 30, 99, 0.1);
        }
        .goal-icon {
            font-size: 2.5rem;
            color: #e91e63;
            margin-bottom: 1.5rem;
        }
        .goal-number {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #e91e63;
            color: white;
            border-radius: 50%;
            line-height: 40px;
            font-weight: bold;
            margin-bottom: 15px;
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
        .vision-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }
        .vision-text p {
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
                        <a class="nav-link" href="mision.php">
                            <i class="bi bi-bullseye"></i> Misión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="vision.php">
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

    <!-- Hero Section de Visión -->
    <section class="vision-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Nuestra Visión</h1>
                    <p class="lead mb-0">La aspiración futura que nos impulsa a ser mejores cada día.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-eye" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido de Visión -->
    <section class="vision-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="vision-card">
                        <div class="text-center mb-5">
                            <i class="bi bi-eye vision-icon"></i>
                            <h2 class="section-title text-center">Declaración de Visión</h2>
                        </div>
                        <div class="vision-text">
                            <p>Ser el referente indiscutible y líder en la industria de la planificación de eventos, ser reconocidos por nuestra innovación constante, nuestra adherencia al más alto protocolo y nuestra capacidad infalible para crear experiencias emocionalmente resonantes y operativamente perfectas.</p>
                            <p class="mb-0">Aspiramos a ser la primera opción para quienes buscan excelencia, confianza y un partner creativo que eleve cualquier celebración o acto institucional a su máxima expresión.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Metas y Objetivos -->
    <section class="goals-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Nuestras Metas Estratégicas</h2>
                    <p class="lead text-muted">Los objetivos que nos guían hacia nuestro futuro ideal</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">1</div>
                        <div class="goal-icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <h4>Liderazgo en Innovación</h4>
                        <p>Ser pioneros en tendencias y tecnologías para eventos, estableciendo nuevos estándares en la industria.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">2</div>
                        <div class="goal-icon">
                            <i class="bi bi-hearts"></i>
                        </div>
                        <h4>Experiencias Únicas</h4>
                        <p>Crear momentos emocionalmente impactantes que trasciendan en la memoria de nuestros clientes.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">3</div>
                        <div class="goal-icon">
                            <i class="bi bi-globe-americas"></i>
                        </div>
                        <h4>Expansión Nacional</h4>
                        <p>Establecer presencia en las principales ciudades del país como sinónimo de excelencia en planificación.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">4</div>
                        <div class="goal-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4>Formación de Expertos</h4>
                        <p>Desarrollar el talento humano más capacitado y apasionado de la industria de eventos.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">5</div>
                        <div class="goal-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Confianza Absoluta</h4>
                        <p>Ser la primera opción por excelencia para quienes buscan seguridad y profesionalismo en sus eventos.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="goal-card">
                        <div class="goal-number">6</div>
                        <div class="goal-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Excelencia Sostenida</h4>
                        <p>Mantener los más altos estándares de calidad en cada proyecto, grande o pequeño.</p>
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