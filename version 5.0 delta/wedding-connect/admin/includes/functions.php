<?php
// admin/includes/functions.php - Funciones del sistema

// Incluir configuración de base de datos CON RUTA CORREGIDA
require_once __DIR__ . '/../../config/database.php';

// Función para formatear nombres de tipos de evento
function formatearTipoEvento($tipo_evento_id) {
    return obtenerNombreTipoEvento($tipo_evento_id);
}

// Procesar acciones del formulario
function procesarAcciones($tab) {
    global $mensaje, $error_mensaje;
    
    if (!isset($_SESSION['admin_id'])) return;
    
    // Insertar nuevo cliente
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && !isset($_POST['actualizar_cliente'])) {
        try {
            $db = getDB();
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tipo_evento_id = $_POST['tipo_evento_id'] ?? '';
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $mensaje_cliente = $_POST['mensaje'] ?? '';
            
            // Validar datos básicos
            if (empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento_id) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            // Insertar en la base de datos
            $stmt = $db->prepare("INSERT INTO clientes (nombre, correo, telefono, tipo_evento_id, fecha_evento, mensaje, fecha_registro) 
                                 VALUES (?, ?, ?, ?, ?, ?, NOW())");
            
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento_id, $fecha_evento, $mensaje_cliente]);
            
            // Redirigir para evitar reenvío del formulario
            header("Location: admin.php?tab=" . $tab . "&success=1");
            exit();
            
        } catch (Exception $e) {
            $error_mensaje = "Error al guardar cliente: " . $e->getMessage();
        }
    }
    
    // Actualizar cliente
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_cliente'])) {
        try {
            $db = getDB();
            $cliente_id = $_POST['cliente_id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tipo_evento_id = $_POST['tipo_evento_id'] ?? '';
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $mensaje_cliente = $_POST['mensaje'] ?? '';
            
            // Validar datos básicos
            if (empty($cliente_id) || empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento_id) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            // Validar que el cliente exista
            $stmt = $db->prepare("SELECT id FROM clientes WHERE id = ?");
            $stmt->execute([$cliente_id]);
            if (!$stmt->fetch()) {
                throw new Exception("Cliente no encontrado");
            }
            
            // Actualizar en la base de datos
            $stmt = $db->prepare("UPDATE clientes SET 
                                 nombre = ?, 
                                 correo = ?, 
                                 telefono = ?, 
                                 tipo_evento_id = ?, 
                                 fecha_evento = ?, 
                                 mensaje = ? 
                                 WHERE id = ?");
            
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento_id, $fecha_evento, $mensaje_cliente, $cliente_id]);
            
            // Redirigir para evitar reenvío del formulario
            header("Location: admin.php?tab=" . $tab . "&success=2");
            exit();
            
        } catch (Exception $e) {
            $error_mensaje = "Error al actualizar cliente: " . $e->getMessage();
        }
    }
    
    // Eliminar cliente
    if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
        try {
            $db = getDB();
            $id_eliminar = $_GET['eliminar'];
            $stmt = $db->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$id_eliminar]);
            $mensaje = "Cliente eliminado correctamente";
        } catch (Exception $e) {
            $error_mensaje = "Error al eliminar cliente: " . $e->getMessage();
        }
    }
    
    // Mostrar mensaje de éxito si existe
    if (isset($_GET['success'])) {
        if ($_GET['success'] == 1) {
            $mensaje = "Cliente guardado exitosamente";
        } elseif ($_GET['success'] == 2) {
            $mensaje = "Cliente actualizado exitosamente";
        }
    }
}

// Obtener estadísticas
function obtenerEstadisticas() {
    $db = getDB();
    return $db->query("SELECT 
        COUNT(*) as total_clientes,
        COUNT(DISTINCT tipo_evento_id) as tipos_evento,
        (SELECT MIN(fecha_evento) FROM clientes WHERE fecha_evento >= CURDATE()) as proximo_evento,
        MAX(fecha_evento) as ultimo_evento
        FROM clientes")->fetch(PDO::FETCH_ASSOC);
}

// Obtener datos para dashboard
function obtenerDatosDashboard() {
    $db = getDB();
    return [
        'clientes_dashboard' => $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                           FROM clientes c 
                                           JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                           ORDER BY c.id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC)
    ];
}

// Obtener datos para clientes
function obtenerDatosClientes() {
    $db = getDB();
    $busqueda = '';
    $clientes = [];
    
    if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
        $stmt = $db->prepare("SELECT c.*, t.nombre as tipo_nombre 
                             FROM clientes c 
                             JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                             WHERE c.nombre LIKE ? OR c.correo LIKE ? OR c.telefono LIKE ? 
                             ORDER BY c.id DESC");
        $searchTerm = "%$busqueda%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $clientes = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                               FROM clientes c 
                               JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                               ORDER BY c.id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return [
        'clientes' => $clientes,
        'busqueda' => $busqueda
    ];
}

// Obtener datos para eventos
function obtenerDatosEventos() {
    $db = getDB();
    $eventos = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                          FROM clientes c 
                          JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                          ORDER BY c.fecha_evento DESC, c.id DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    $eventos_stats = $db->query("SELECT 
        COUNT(*) as total_eventos,
        SUM(CASE WHEN fecha_evento > CURDATE() THEN 1 ELSE 0 END) as eventos_futuros,
        SUM(CASE WHEN fecha_evento = CURDATE() THEN 1 ELSE 0 END) as eventos_hoy,
        SUM(CASE WHEN fecha_evento < CURDATE() THEN 1 ELSE 0 END) as eventos_pasados
        FROM clientes")->fetch(PDO::FETCH_ASSOC);
    
    return [
        'eventos' => $eventos,
        'eventos_stats' => $eventos_stats
    ];
}

// Obtener datos para reportes
function obtenerDatosReportes() {
    $db = getDB();
    $reportes_stats = $db->query("SELECT 
        t.nombre,
        t.codigo,
        COUNT(*) as cantidad,
        ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 2) as porcentaje
        FROM clientes c 
        JOIN tipos_evento t ON c.tipo_evento_id = t.id 
        GROUP BY c.tipo_evento_id 
        ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'reportes_stats' => $reportes_stats
    ];
}
?>