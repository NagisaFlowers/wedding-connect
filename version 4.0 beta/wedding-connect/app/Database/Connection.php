<?php
namespace App\Database;

class Connection
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            // Configuración por defecto
            $host = 'localhost';
            $dbname = 'wedding_connect';
            $db_user = 'root';
            $db_pass = '';

            $this->conn = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $db_user,
                $db_pass
            );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance->conn;
    }
}