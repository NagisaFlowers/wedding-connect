<?php
// admin/logout.php - Cerrar sesión

// Incluir bootstrap desde la ubicación correcta (subir un nivel)
require_once __DIR__ . '/../app/bootstrap.php';

use App\Helpers\Session;

// Iniciar sesión si no está iniciada
Session::start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir a la página de login
header("Location: login.php");
exit();
?>