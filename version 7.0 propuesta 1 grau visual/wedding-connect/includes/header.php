<?php
// includes/header.php
/* ========================================
   Navbar para todos los archivos php
   ligados al index.php
======================================== */
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cristina Gallo Planner - Wedding & Event Planner</title>
    <meta name="description" content="Transformamos cada evento en una experiencia inolvidable. Bodas, XV años, baby showers y eventos empresariales.">
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logocristinagallo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Fuentes decorativas adicionales -->
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/brittany-signature" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- CSS Personalizado Condicional para que cada php tenga su propio estilo-->
    <?php if ($current_page == 'index.php'): ?>
        <link rel="stylesheet" href="assets/css/index.css">
    <?php elseif ($current_page == 'nosotros.php'): ?>
        <link rel="stylesheet" href="assets/css/nosotros.css">
    <?php elseif ($current_page == 'registro.php'): ?>
        <link rel="stylesheet" href="assets/css/registro.css">
    <?php elseif ($current_page == 'galeria.php'): ?>
        <link rel="stylesheet" href="assets/css/galeria.css">
    <?php elseif ($current_page == 'admin/login.php'): ?>
        <link rel="stylesheet" href="assets/css/login.css">    
    <?php elseif (in_array($current_page, ['politica-privacidad.php', 'terminos-condiciones.php'])): ?>
        <link rel="stylesheet" href="assets/css/legal.css">
    <?php else: ?>
        <!-- CSS por defecto para otras páginas -->
        <link rel="stylesheet" href="assets/css/index.css">
    <?php endif; ?>
</head>
<body>

<!-- Navbar Elegante -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span class="brand-icon">✦</span>
            <span class="brand-text">Cristina Gallo</span>
            <span class="brand-tagline">Planner</span>
        </a>
    
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" 
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'nosotros.php' ? 'active' : '' ?>" href="nosotros.php">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'galeria.php' ? 'active' : '' ?>" href="galeria.php">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'registro.php' ? 'active' : '' ?>" href="registro.php">Contacto</a>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'login.php' ? 'active' : '' ?>" href="admin/login.php"><i class="bi bi-shield-lock"> </i> Administrar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>