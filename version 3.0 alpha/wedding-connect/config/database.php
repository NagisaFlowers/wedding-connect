<?php
// Configuración de base de datos SIMPLIFICADA para Wedding Connect

class Database {
    private $host = "localhost";
    private $db_name = "wedding_connect";
    private $username = "root";      // Cambia si usas otro usuario
    private $password = "";          // Cambia si tienes contraseña
    public $conn;

    // Obtener conexión a la base de datos
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}

// Función helper para obtener conexión
function getDB() {
    $database = new Database();
    return $database->getConnection();
}

// Función para verificar login de administrador
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
?>