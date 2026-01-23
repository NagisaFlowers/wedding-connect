<?php
require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Services\AuthService;

$authService = new AuthService();
$authService->logout();

header("Location: index.php");
exit();
?>