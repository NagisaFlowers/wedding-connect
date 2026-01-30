<?php
// admin/includes/functions.php - Funciones del sistema

// Función para formatear nombres de tipos de evento
function formatearTipoEvento($tipo_boda) {
    // Reemplazar guiones bajos con espacios y capitalizar
    $tipo = str_replace('_', ' ', $tipo_boda);
    $tipo = ucwords($tipo);
    
    // Reemplazamientos específicos
    $reemplazos = [
        'Xv Anos' => 'XV Años',
        'Baby Shower Gender Reveal' => 'Baby Shower (Gender Reveal)',
        'Team Building' => 'Team Building',
        'Ano Nuevo' => 'Año Nuevo',
        'Boda Civil' => 'Boda Civil',
        'Boda Religiosa' => 'Boda Religiosa',
        'Boda Destino' => 'Boda Destino',
        'Boda Intima' => 'Boda Íntima',
        'Boda Lujo' => 'Boda de Lujo',
        'Boda Tematica' => 'Boda Temática',
        'Boda Playa' => 'Boda en Playa',
        'Boda Campo' => 'Boda en Campo',
        'Boda Urbana' => 'Boda Urbana',
        'Boda Vintage' => 'Boda Vintage',
    ];
    
    return $reemplazos[$tipo] ?? $tipo;
}

// Procesar acciones del formulario
function procesarAcciones(&$conn, $tab) {
    global $mensaje, $error_mensaje;
    
    // Insertar nuevo cliente
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && !isset($_POST['actualizar_cliente'])) {
        try {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tipo_evento = $_POST['tipo_evento'] ?? '';
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $mensaje_cliente = $_POST['mensaje'] ?? '';
            
            // Validar datos básicos
            if (empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            // Insertar en la base de datos
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, telefono, tipo_boda, fecha_evento, mensaje, fecha_registro) 
                                   VALUES (?, ?, ?, ?, ?, ?, NOW())");
            
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento, $fecha_evento, $mensaje_cliente]);
            
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
            $cliente_id = $_POST['cliente_id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tipo_evento = $_POST['tipo_evento'] ?? '';
            $fecha_evento = $_POST['fecha_evento'] ?? '';
            $mensaje_cliente = $_POST['mensaje'] ?? '';
            
            // Validar datos básicos
            if (empty($cliente_id) || empty($nombre) || empty($correo) || empty($telefono) || empty($tipo_evento) || empty($fecha_evento)) {
                throw new Exception("Todos los campos obligatorios deben ser completados");
            }
            
            // Validar que el cliente exista
            $stmt = $conn->prepare("SELECT id FROM clientes WHERE id = ?");
            $stmt->execute([$cliente_id]);
            if (!$stmt->fetch()) {
                throw new Exception("Cliente no encontrado");
            }
            
            // Actualizar en la base de datos
            $stmt = $conn->prepare("UPDATE clientes SET 
                                   nombre = ?, 
                                   correo = ?, 
                                   telefono = ?, 
                                   tipo_boda = ?, 
                                   fecha_evento = ?, 
                                   mensaje = ? 
                                   WHERE id = ?");
            
            $stmt->execute([$nombre, $correo, $telefono, $tipo_evento, $fecha_evento, $mensaje_cliente, $cliente_id]);
            
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
            $id_eliminar = $_GET['eliminar'];
            $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
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


//detalle el fecha dashboard
function obtenerEstadisticas($conn) {
    return $conn->query("SELECT 
        COUNT(*) as total_clientes,
        COUNT(DISTINCT tipo_boda) as tipos_evento,
        (SELECT MIN(fecha_evento) FROM clientes WHERE fecha_evento >= CURDATE()) as proximo_evento,
        MAX(fecha_evento) as ultimo_evento
        FROM clientes")->fetch(PDO::FETCH_ASSOC);
}

// Obtener datos para dashboard
function obtenerDatosDashboard($conn) {
    return [
        'clientes_dashboard' => $conn->query("SELECT * FROM clientes ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC)
    ];
}

// Obtener datos para clientes
function obtenerDatosClientes($conn) {
    $busqueda = '';
    $clientes = [];
    
    if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
        $stmt = $conn->prepare("SELECT * FROM clientes 
            WHERE nombre LIKE ? OR correo LIKE ? OR telefono LIKE ? 
            ORDER BY id DESC");
        $searchTerm = "%$busqueda%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $clientes = $conn->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return [
        'clientes' => $clientes,
        'busqueda' => $busqueda
    ];
}

// Obtener datos para eventos
function obtenerDatosEventos($conn) {
    $eventos = $conn->query("SELECT * FROM clientes ORDER BY fecha_evento DESC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    $eventos_stats = $conn->query("SELECT 
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
function obtenerDatosReportes($conn) {
    $reportes_stats = $conn->query("SELECT 
        tipo_boda,
        COUNT(*) as cantidad,
        ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM clientes)), 2) as porcentaje
        FROM clientes 
        GROUP BY tipo_boda 
        ORDER BY cantidad DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'reportes_stats' => $reportes_stats
    ];
}
?>