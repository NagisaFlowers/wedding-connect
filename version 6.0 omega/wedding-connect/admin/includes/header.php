<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Wedding Connect</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- letras con estilo -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">    
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="../assets/css/dark-mode.css">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../assets/css/panel.css">
    <style>
        /* Fix para el fondo negro del modal */
        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }
        
        /* Estilos responsivos para tablas */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-container { width: 100%; overflow: hidden; }
        
        @media (max-width: 768px) {
            .stat-card { margin-bottom: 15px; }
            .stat-number { font-size: 1.5rem; }
            .search-box { margin-top: 15px; width: 100%; }
            .col-lg-10 { padding-left: 15px; padding-right: 15px; }
            .navbar-admin { padding: 10px 0; }
        }
        
        @media (max-width: 576px) {
            .h3 { font-size: 1.5rem; }
            .modal-dialog { margin: 10px; }
            .modal-content { padding: 10px; }
        }
        
        /* Mejoras específicas para tabla de eventos */
        #eventosTable { font-size: 0.9rem; }
        #eventosTable td { max-width: 150px; overflow: hidden; text-overflow: ellipsis; }
        
        /* Estilos para el botón de modo oscuro */
        #darkModeToggle {
            color: var(--text-primary, #333);
            transition: transform 0.3s ease;
        }
        #darkModeToggle:hover {
            transform: scale(1.1);
            color: var(--link-color, #d4af37);
        }
        [data-theme="dark"] #darkModeToggle {
            color: #fff;
        }
    </style>
</head>
<body class="admin-body">
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-admin fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="admin.php">
                <i class="bi bi-shield-lock"></i> Wedding Connect
            </a>
            
            <div class="d-flex align-items-center">
                <!-- Botón de modo oscuro -->
                <button class="btn btn-link text-white me-3" id="darkModeToggle" title="Alternar modo oscuro" style="font-size: 1.2rem; text-decoration: none;">
                    <i class="bi bi-moon-fill" id="darkModeIcon"></i>
                </button>
                
                <div class="welcome-text me-3 d-none d-md-block">
                    <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador'); ?>
                </div>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Script para restaurar tema antes de que la página se renderice -->
    <script>
        (function() {
            try {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                console.error('Error al cargar tema:', e);
            }
        })();
    </script>