<?php
namespace App\Database\Queries;

use App\Core\Models\Administrador;
use App\Database\Connection;

class AdminQueries
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function findByUsername($username)
    {
        $stmt = $this->conn->prepare(
            "SELECT id, username, password_hash, nombre_completo 
             FROM administradores 
             WHERE username = :username"
        );
        
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch();

        if ($data) {
            return new Administrador($data);
        }

        return null;
    }
}