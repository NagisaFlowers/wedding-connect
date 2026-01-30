<?php
// obtener_cliente.php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no válido']);
    exit();
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cliente) {
        // Convertir fechas al formato correcto para input date
        $cliente['fecha_evento'] = date('Y-m-d', strtotime($cliente['fecha_evento']));
        
        echo json_encode([
            'success' => true,
            'cliente' => $cliente
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cliente no encontrado']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>