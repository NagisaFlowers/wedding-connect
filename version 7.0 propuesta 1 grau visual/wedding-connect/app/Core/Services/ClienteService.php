<?php
namespace App\Core\Services;

use App\Core\Models\Cliente;
use App\Database\Queries\ClienteQueries;

class ClienteService
{
    private $clienteQueries;

    public function __construct()
    {
        $this->clienteQueries = new ClienteQueries();
    }

    public function crearCliente($data)
    {
        // Validación básica
        if (empty($data['nombre']) || empty($data['correo']) || 
            empty($data['telefono']) || empty($data['fecha_evento']) || 
            empty($data['tipo_boda'])) {
            return ['success' => false, 'message' => 'Todos los campos marcados con * son obligatorios'];
        }

        $cliente = new Cliente($data);
        return $this->clienteQueries->guardar($cliente);
    }

    public function obtenerClientes()
    {
        return $this->clienteQueries->obtenerTodos();
    }

    public function obtenerClientePorId($id)
    {
        return $this->clienteQueries->obtenerPorId($id);
    }
}