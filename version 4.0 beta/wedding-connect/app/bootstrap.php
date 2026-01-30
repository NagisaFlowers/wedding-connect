<?php
// Bootstrap para cargar clases automáticamente
spl_autoload_register(function ($className) {
    $baseDir = __DIR__ . '/';
    
    // Convertir namespace a ruta de archivo
    $className = str_replace('App\\', '', $className);
    $file = $baseDir . str_replace('\\', '/', $className) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Incluir configuración
if (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}