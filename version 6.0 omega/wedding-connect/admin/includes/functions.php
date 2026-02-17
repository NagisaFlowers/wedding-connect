<?php
// admin/includes/functions.php - COMPLETO Y FUNCIONAL
require_once __DIR__ . '/../../config/database.php';

function formatearTipoEvento($tipo_evento_id) {
    return obtenerNombreTipoEvento($tipo_evento_id);
}

function procesarAcciones($tab) {
    global $mensaje, $error_mensaje;
    
    if (!isset($_SESSION['admin_id'])) return;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cambiar_password'])) {
        try {
            $db = getDB();
            $admin_id = $_SESSION['admin_id'];
            $password_actual = $_POST['password_actual'] ?? '';
            $password_nuevo = $_POST['password_nuevo'] ?? '';
            $password_confirmar = $_POST['password_confirmar'] ?? '';
            
            if (empty($password_actual) || empty($password_nuevo) || empty($password_confirmar)) {
                throw new Exception("Todos los campos son obligatorios");
            }
            
            if ($password_actual === $password_nuevo) {
                throw new Exception("La nueva contraseña no puede ser igual a la actual");
            }
            
            if ($password_nuevo !== $password_confirmar) {
                throw new Exception("Las contraseñas nuevas no coinciden");
            }
            
            if (strlen($password_nuevo) < 4) {
                throw new Exception("La contraseña debe tener al menos 4 caracteres");
            }
            
            if (!verificarPasswordActual($admin_id, $password_actual)) {
                throw new Exception("La contraseña actual es incorrecta");
            }
            
            if (cambiarPassword($admin_id, $password_nuevo)) {
                header("Location: admin.php?tab=" . $tab . "&success_password=1");
                exit();
            } else {
                throw new Exception("Error al actualizar la contraseña");
            }
            
        } catch (Exception $e) {
            $error_mensaje = "Error: " . $e->getMessage();
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && !isset($_POST['actualizar_cliente'])) {
        try {
            $db = getDB();
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tipo_evento_id = $_POST['tipo_evento_id'] ?? '';
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $mensaje_cliente = $_POST['mensaje'] ?? '';
            
            if (empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento_id) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("El formato del correo no es válido");
            }
            
            if (strtotime($fecha_evento) < strtotime(date('Y-m-d'))) {
                throw new Exception("La fecha del evento debe ser hoy o una fecha futura");
            }
            
            $stmt = $db->prepare("INSERT INTO clientes (nombre, correo, telefono, tipo_evento_id, fecha_evento, mensaje, fecha_registro) 
                                 VALUES (?, ?, ?, ?, ?, ?, NOW())");
            
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento_id, $fecha_evento, $mensaje_cliente]);
            
            header("Location: admin.php?tab=" . $tab . "&success=1");
            exit();
            
        } catch (Exception $e) {
            $error_mensaje = "Error al guardar cliente: " . $e->getMessage();
        }
    }
    
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
            
            if (empty($cliente_id) || empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento_id) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("El formato del correo no es válido");
            }
            
            if (strtotime($fecha_evento) < strtotime(date('Y-m-d'))) {
                throw new Exception("La fecha del evento debe ser hoy o una fecha futura");
            }
            
            $stmt = $db->prepare("UPDATE clientes SET nombre = ?, correo = ?, telefono = ?, tipo_evento_id = ?, fecha_evento = ?, mensaje = ? WHERE id = ?");
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento_id, $fecha_evento, $mensaje_cliente, $cliente_id]);
            
            header("Location: admin.php?tab=" . $tab . "&success=2");
            exit();
            
        } catch (Exception $e) {
            $error_mensaje = "Error al actualizar cliente: " . $e->getMessage();
        }
    }
    
    if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
        try {
            $db = getDB();
            $id_eliminar = $_GET['eliminar'];
            
            $stmt = $db->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$id_eliminar]);
            
            $mensaje = "Cliente eliminado correctamente";
            
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header("Location: admin.php?tab=" . $tab . "&deleted=1");
                exit();
            }
            
        } catch (Exception $e) {
            $error_mensaje = "Error al eliminar cliente: " . $e->getMessage();
        }
    }
    
    if (isset($_GET['success'])) {
        if ($_GET['success'] == 1) $mensaje = "Cliente guardado exitosamente";
        elseif ($_GET['success'] == 2) $mensaje = "Cliente actualizado exitosamente";
    }
    
    if (isset($_GET['success_password'])) $mensaje = "¡Contraseña actualizada exitosamente!";
    if (isset($_GET['deleted'])) $mensaje = "Cliente eliminado correctamente";
}

function obtenerDatosDashboard() {
    try {
        $db = getDB();
        return [
            'clientes_dashboard' => $db->query("SELECT c.*, t.nombre as tipo_nombre 
                                               FROM clientes c 
                                               JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                               ORDER BY c.id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC)
        ];
    } catch (Exception $e) {
        return ['clientes_dashboard' => []];
    }
}

function obtenerDatosClientes() {
    try {
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
        
        return ['clientes' => $clientes, 'busqueda' => $busqueda];
    } catch (Exception $e) {
        return ['clientes' => [], 'busqueda' => ''];
    }
}

function obtenerDatosEventos() {
    try {
        $db = getDB();
        $eventos = $db->query("SELECT c.*, t.nombre as tipo_nombre 
                              FROM clientes c 
                              JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                              ORDER BY c.fecha_evento DESC, c.id DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        $eventos_stats = $db->query("SELECT COUNT(*) as total_eventos,
                                            SUM(CASE WHEN fecha_evento > CURDATE() THEN 1 ELSE 0 END) as eventos_futuros,
                                            SUM(CASE WHEN fecha_evento = CURDATE() THEN 1 ELSE 0 END) as eventos_hoy,
                                            SUM(CASE WHEN fecha_evento < CURDATE() THEN 1 ELSE 0 END) as eventos_pasados
                                     FROM clientes")->fetch(PDO::FETCH_ASSOC);
        
        return ['eventos' => $eventos, 'eventos_stats' => $eventos_stats];
    } catch (Exception $e) {
        return ['eventos' => [], 'eventos_stats' => []];
    }
}

function obtenerDatosReportes() {
    try {
        $db = getDB();
        $reportes_stats = $db->query("SELECT t.nombre, t.codigo, COUNT(*) as cantidad,
                                             ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 2) as porcentaje
                                      FROM clientes c 
                                      JOIN tipos_evento t ON c.tipo_evento_id = t.id 
                                      GROUP BY c.tipo_evento_id 
                                      ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        return ['reportes_stats' => $reportes_stats];
    } catch (Exception $e) {
        return ['reportes_stats' => []];
    }
}
?>