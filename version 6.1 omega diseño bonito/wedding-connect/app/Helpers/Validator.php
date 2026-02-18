<?php
namespace App\Helpers;

class Validator
{
    public static function validateCliente($data)
    {
        $errors = [];

        if (empty($data['nombre'])) {
            $errors['nombre'] = 'El nombre es requerido';
        }

        if (empty($data['correo'])) {
            $errors['correo'] = 'El correo es requerido';
        } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = 'El correo no es válido';
        }

        if (empty($data['telefono'])) {
            $errors['telefono'] = 'El teléfono es requerido';
        }

        if (empty($data['fecha_evento'])) {
            $errors['fecha_evento'] = 'La fecha del evento es requerida';
        } elseif (strtotime($data['fecha_evento']) < strtotime(date('Y-m-d'))) {
            $errors['fecha_evento'] = 'La fecha debe ser hoy o en el futuro';
        }

        if (empty($data['tipo_boda'])) {
            $errors['tipo_boda'] = 'El tipo de boda es requerido';
        }

        return $errors;
    }

    public static function validateLogin($username, $password)
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'El usuario es requerido';
        }

        if (empty($password)) {
            $errors['password'] = 'La contraseña es requerida';
        }

        return $errors;
    }
}