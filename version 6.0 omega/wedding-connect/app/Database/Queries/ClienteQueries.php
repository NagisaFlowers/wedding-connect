<?php
namespace App\Database\Queries;

use App\Core\Models\Cliente;
use App\Database\Connection;

class ClienteQueries
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function guardar(Cliente $cliente)
    {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_boda, mensaje) 
                 VALUES (:nombre, :correo, :telefono, :fecha_evento, :tipo_boda, :mensaje)"
            );

            $stmt->execute([
                ':nombre' => $cliente->getNombre(),
                ':correo' => $cliente->getCorreo(),
                ':telefono' => $cliente->getTelefono(),
                ':fecha_evento' => $cliente->getFechaEvento(),
                ':tipo_boda' => $cliente->getTipoBoda(),
                ':mensaje' => $cliente->getMensaje()
            ]);

            return [
                'success' => true,
                'message' => 'Cliente guardado exitosamente',
                'id' => $this->conn->lastInsertId()
            ];

        } catch (\PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }

    public function obtenerTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM clientes ORDER BY fecha_registro DESC");
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}