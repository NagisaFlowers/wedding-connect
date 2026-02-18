<?php
namespace App\Core\Models;

class Cliente
{
    private $id;
    private $nombre;
    private $correo;
    private $telefono;
    private $fecha_evento;
    private $tipo_boda;
    private $mensaje;
    private $fecha_registro;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->nombre = $data['nombre'] ?? '';
            $this->correo = $data['correo'] ?? '';
            $this->telefono = $data['telefono'] ?? '';
            $this->fecha_evento = $data['fecha_evento'] ?? '';
            $this->tipo_boda = $data['tipo_boda'] ?? '';
            $this->mensaje = $data['mensaje'] ?? '';
            $this->fecha_registro = $data['fecha_registro'] ?? date('Y-m-d H:i:s');
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getCorreo() { return $this->correo; }
    public function getTelefono() { return $this->telefono; }
    public function getFechaEvento() { return $this->fecha_evento; }
    public function getTipoBoda() { return $this->tipo_boda; }
    public function getMensaje() { return $this->mensaje; }
    public function getFechaRegistro() { return $this->fecha_registro; }

    // Setters
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setCorreo($correo) { $this->correo = $correo; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setFechaEvento($fecha) { $this->fecha_evento = $fecha; }
    public function setTipoBoda($tipo) { $this->tipo_boda = $tipo; }
    public function setMensaje($mensaje) { $this->mensaje = $mensaje; }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'fecha_evento' => $this->fecha_evento,
            'tipo_boda' => $this->tipo_boda,
            'mensaje' => $this->mensaje,
            'fecha_registro' => $this->fecha_registro
        ];
    }
}