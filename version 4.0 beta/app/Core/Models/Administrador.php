<?php
namespace App\Core\Models;

class Administrador
{
    private $id;
    private $username;
    private $password_hash;
    private $nombre_completo;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->username = $data['username'] ?? '';
            $this->password_hash = $data['password_hash'] ?? '';
            $this->nombre_completo = $data['nombre_completo'] ?? '';
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getNombreCompleto() { return $this->nombre_completo; }

    // Verificar contraseña
    public function verifyPassword($password)
    {
        // Para compatibilidad con tu sistema actual (contraseña en texto plano)
        return $password === $this->password_hash;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'nombre_completo' => $this->nombre_completo
        ];
    }
}