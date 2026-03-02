<?php
// admin/backup_database.php
session_start();

// Verificar autenticación
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    die(json_encode(['error' => 'No autorizado']));
}

require_once '../config/database.php';

try {
    $db = getDB();
    
    // Obtener nombre de la base de datos
    $stmt = $db->query("SELECT DATABASE() as dbname");
    $dbname = $stmt->fetch(PDO::FETCH_ASSOC)['dbname'];
    
    // Obtener todas las tablas
    $tables = [];
    $stmt = $db->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    
    $output = "-- ===========================================\n";
    $output .= "-- Respaldo de Base de Datos: " . $dbname . "\n";
    $output .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
    $output .= "-- Generado por: " . ($_SESSION['admin_nombre'] ?? 'Administrador') . "\n";
    $output .= "-- ===========================================\n\n";
    
    // Estructura de cada tabla
    foreach ($tables as $table) {
        // Drop table if exists
        $output .= "DROP TABLE IF EXISTS `$table`;\n";
        
        // Create table
        $stmt = $db->query("SHOW CREATE TABLE `$table`");
        $create = $stmt->fetch(PDO::FETCH_ASSOC);
        $output .= $create['Create Table'] . ";\n\n";
        
        // Datos de la tabla
        $stmt = $db->query("SELECT * FROM `$table`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) {
            $columns = array_keys($rows[0]);
            $columnsList = "`" . implode("`, `", $columns) . "`";
            
            foreach ($rows as $row) {
                $values = array_map(function($value) use ($db) {
                    if ($value === null) return 'NULL';
                    return $db->quote($value);
                }, $row);
                
                $output .= "INSERT INTO `$table` ($columnsList) VALUES (" . implode(", ", $values) . ");\n";
            }
            $output .= "\n";
        }
    }
    
    // Agregar comentario final
    $output .= "-- ===========================================\n";
    $output .= "-- Respaldo completado: " . date('Y-m-d H:i:s') . "\n";
    $output .= "-- Total de tablas: " . count($tables) . "\n";
    $output .= "-- ===========================================\n";
    
    // Nombre del archivo
    $filename = 'backup_' . $dbname . '_' . date('Y-m-d_His') . '.sql';
    $tamano = strlen($output);
    
    // **REGISTRAR EL RESPALDO EN LA BASE DE DATOS (ANTES DE ENVIAR HEADERS)**
    try {
        // Verificar si la tabla respaldos existe
        $checkTable = $db->query("SHOW TABLES LIKE 'respaldos'");
        if ($checkTable->rowCount() > 0) {
            // Registrar respaldo
            $stmt = $db->prepare("INSERT INTO respaldos (admin_id, nombre_archivo, tamano) VALUES (?, ?, ?)");
            $stmt->execute([
                $_SESSION['admin_id'],
                $filename,
                $tamano
            ]);
            
            // Opcional: Obtener el ID del respaldo para mostrarlo
            $respaldo_id = $db->lastInsertId();
            
            // Puedes agregar un comentario en el backup con el ID
            $output .= "-- ID de respaldo en sistema: " . $respaldo_id . "\n";
            $output .= "-- ===========================================\n";
        } else {
            // La tabla no existe, solo registrar en log
            error_log("La tabla 'respaldos' no existe. No se pudo registrar el respaldo.");
        }
    } catch (Exception $e) {
        // Solo loggear error, no interrumpir descarga
        error_log("Error registrando respaldo en BD: " . $e->getMessage());
    }
    
    // Headers para descarga
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . $tamano);
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    
    echo $output;
    exit;
    
} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Error al generar respaldo: ' . $e->getMessage()]));
}
?>