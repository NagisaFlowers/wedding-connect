<?php
// guardar_cliente.php
session_start();

// Verificar si es admin
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

// Configurar conexión a la base de datos
try {
    $host = 'localhost';
    $dbname = 'wedding_connect';
    $db_user = 'root';
    $db_pass = '';
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
    exit();
}

// Verificar si es POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Obtener y validar datos
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$tipo_boda = trim($_POST['tipo_boda'] ?? '');
$fecha_evento = trim($_POST['fecha_evento'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

// Validaciones básicas
if (empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_boda) || empty($fecha_evento)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados']);
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email no válido']);
    exit();
}

try {
    // Insertar cliente
    $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, telefono, tipo_boda, fecha_evento, mensaje, fecha_registro) 
                           VALUES (:nombre, :correo, :telefono, :tipo_boda, :fecha_evento, :mensaje, NOW())");
    
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':tipo_boda' => $tipo_boda,
        ':fecha_evento' => $fecha_evento,
        ':mensaje' => $mensaje
    ]);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Cliente guardado exitosamente'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al guardar: ' . $e->getMessage()
    ]);
}
?>