<?php
// config/database.php - Configuración centralizada de base de datos

class Database {
    private static $instance = null;
    private $conn;
    
    // Configuración de conexión
    private $host = "localhost";
    private $db_name = "wedding_connect";
    private $username = "root";
    private $password = "";
    
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    // Método singleton para obtener instancia
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
    
    // Función helper para compatibilidad con código existente
    public static function getConnection() {
        return self::getInstance();
    }
}

// Funciones helper para compatibilidad
function getDB() {
    return Database::getConnection();
}

function verificarLogin($username, $password) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM administradores WHERE username = ? AND activo = 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        // Para pruebas simples, comparamos directamente
        if ($admin && $password === $admin['password_hash']) {
            return $admin;
        }
        
        return false;
    } catch(PDOException $e) {
        return false;
    }
}

// Función para obtener tipos de evento (para formularios)
function obtenerTiposEvento($categoria = null) {
    try {
        $db = getDB();
        
        if ($categoria) {
            $stmt = $db->prepare("SELECT * FROM tipos_evento WHERE categoria = ? AND activo = 1 ORDER BY nombre");
            $stmt->execute([$categoria]);
        } else {
            $stmt = $db->query("SELECT * FROM tipos_evento WHERE activo = 1 ORDER BY categoria, nombre");
        }
        
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// Función para formatear nombre de tipo de evento
function obtenerNombreTipoEvento($tipo_evento_id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT nombre FROM tipos_evento WHERE id = ?");
        $stmt->execute([$tipo_evento_id]);
        $result = $stmt->fetch();
        
        return $result ? $result['nombre'] : 'Desconocido';
    } catch(PDOException $e) {
        return 'Desconocido';
    }
}
?>