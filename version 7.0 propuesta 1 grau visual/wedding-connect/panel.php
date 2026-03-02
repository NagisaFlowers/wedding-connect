<?php
// panel.php en la raíz - Redirección al panel organizado
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin/login.php");
    exit();
}

// Redirigir al panel organizado
header("Location: admin/admin.php");
exit();
?>