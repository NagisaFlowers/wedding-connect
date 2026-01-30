<?php
namespace App\Core\Services;

use App\Core\Models\Administrador;
use App\Database\Queries\AdminQueries;

class AuthService
{
    private $adminQueries;

    public function __construct()
    {
        $this->adminQueries = new AdminQueries();
    }

    public function login($username, $password)
    {
        $admin = $this->adminQueries->findByUsername($username);
        
        if ($admin && $admin->verifyPassword($password)) {
            return $admin;
        }
        
        return false;
    }

    public function isAuthenticated()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_id']);
    }

    public function getCurrentAdmin()
    {
        if ($this->isAuthenticated()) {
            return [
                'id' => $_SESSION['admin_id'],
                'username' => $_SESSION['admin_username'],
                'nombre' => $_SESSION['admin_nombre']
            ];
        }
        return null;
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }
}