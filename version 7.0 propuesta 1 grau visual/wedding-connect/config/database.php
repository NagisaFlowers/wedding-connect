<?php
// config/database.php
class Database {
    private static $instance = null;
    private $conn;
    
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
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos");
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}

function getDB() {
    return Database::getInstance();
}

// ============ FUNCIONES DE LOGIN Y CONTRASEÑAS ============

function verificarLogin($username, $password) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM administradores WHERE username = ? AND activo = 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            $hash_guardado = $admin['password_hash'];
            
            if (strlen($hash_guardado) >= 60) {
                if (password_verify($password, $hash_guardado)) {
                    return $admin;
                }
            } else if ($password === $hash_guardado) {
                $nuevo_hash = password_hash($password, PASSWORD_DEFAULT);
                $update = $db->prepare("UPDATE administradores SET password_hash = ? WHERE id = ?");
                $update->execute([$nuevo_hash, $admin['id']]);
                return $admin;
            }
        }
        return false;
        
    } catch(PDOException $e) {
        error_log("Error en verificarLogin: " . $e->getMessage());
        return false;
    }
}

function verificarPasswordActual($admin_id, $password_actual) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT password_hash FROM administradores WHERE id = ? AND activo = 1");
        $stmt->execute([$admin_id]);
        $admin = $stmt->fetch();
        
        if (!$admin) return false;
        
        $hash_guardado = $admin['password_hash'];
        
        if (strlen($hash_guardado) >= 60) {
            return password_verify($password_actual, $hash_guardado);
        } else {
            return ($password_actual === $hash_guardado);
        }
        
    } catch(PDOException $e) {
        error_log("Error en verificarPasswordActual: " . $e->getMessage());
        return false;
    }
}

function cambiarPassword($admin_id, $nuevo_password) {
    try {
        $db = getDB();
        
        if (strlen($nuevo_password) < 4) {
            return ['success' => false, 'message' => 'La contraseña debe tener al menos 4 caracteres'];
        }
        
        $nuevo_hash = password_hash($nuevo_password, PASSWORD_DEFAULT);
        
        if (!$nuevo_hash) {
            return ['success' => false, 'message' => 'Error al generar el hash'];
        }
        
        $stmt = $db->prepare("UPDATE administradores SET password_hash = ?, ultimo_acceso = NOW() WHERE id = ?");
        $resultado = $stmt->execute([$nuevo_hash, $admin_id]);
        
        if ($resultado) {
            $db->prepare("DELETE FROM recuperacion_password WHERE admin_id = ?")->execute([$admin_id]);
            error_log("✅ Contraseña actualizada para admin ID: " . $admin_id);
            return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];
        }
        
        return ['success' => false, 'message' => 'Error al actualizar la contraseña'];
        
    } catch(PDOException $e) {
        error_log("Error en cambiarPassword: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error en la base de datos'];
    }
}

// ============ FUNCIONES DE RECUPERACIÓN DE CONTRASEÑA ============

function generarCodigoRecuperacion($email) {
    try {
        $db = getDB();
        
        $stmt = $db->prepare("SELECT id, username FROM administradores WHERE email = ? AND activo = 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        
        if (!$admin) {
            return ['success' => false, 'message' => 'No se encuentra el correo en el sistema'];
        }
        
        $codigo = sprintf("%06d", mt_rand(1, 999999));
        $expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        $delete = $db->prepare("DELETE FROM recuperacion_password WHERE admin_id = ?");
        $delete->execute([$admin['id']]);
        
        $insert = $db->prepare("INSERT INTO recuperacion_password (admin_id, codigo, expiracion) VALUES (?, ?, ?)");
        $insert->execute([$admin['id'], $codigo, $expiracion]);
        
        require_once __DIR__ . '/mail_config.php';
        $resultado_correo = enviarCorreoRecuperacion($email, $codigo);
        
        if ($resultado_correo['success']) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['recuperacion_admin_id'] = $admin['id'];
            $_SESSION['recuperacion_email'] = $email;
            
            return [
                'success' => true,
                'message' => 'Se ha enviado un código de verificación a ' . $email,
                'admin_id' => $admin['id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al enviar el correo. Intenta más tarde.'
            ];
        }
        
    } catch(Exception $e) {
        error_log("Error en generarCodigoRecuperacion: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error al procesar la solicitud'];
    }
}

function verificarCodigoRecuperacion($admin_id, $codigo) {
    try {
        $db = getDB();
        
        $stmt = $db->prepare("SELECT * FROM recuperacion_password 
                             WHERE admin_id = ? AND codigo = ? AND expiracion > NOW() 
                             ORDER BY id DESC LIMIT 1");
        $stmt->execute([$admin_id, $codigo]);
        $recuperacion = $stmt->fetch();
        
        if ($recuperacion) {
            return ['success' => true, 'message' => 'Código válido'];
        } else {
            return ['success' => false, 'message' => 'Código inválido o expirado'];
        }
        
    } catch(Exception $e) {
        return ['success' => false, 'message' => 'Error al verificar el código'];
    }
}

// ============ FUNCIONES DE CLIENTES ============

function obtenerClientes($limite = null, $busqueda = null) {
    try {
        $db = getDB();
        
        $sql = "SELECT c.*, t.nombre as tipo_nombre 
                FROM clientes c 
                JOIN tipos_evento t ON c.tipo_evento_id = t.id";
        
        if ($busqueda) {
            $sql .= " WHERE c.nombre LIKE ? OR c.correo LIKE ? OR c.telefono LIKE ?";
            $sql .= " ORDER BY c.id DESC";
            $busqueda_param = "%$busqueda%";
            
            if ($limite) {
                $sql .= " LIMIT ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$busqueda_param, $busqueda_param, $busqueda_param, $limite]);
            } else {
                $stmt = $db->prepare($sql);
                $stmt->execute([$busqueda_param, $busqueda_param, $busqueda_param]);
            }
        } else {
            $sql .= " ORDER BY c.id DESC";
            if ($limite) {
                $sql .= " LIMIT ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$limite]);
            } else {
                $stmt = $db->query($sql);
            }
        }
        
        return $stmt->fetchAll();
    } catch(Exception $e) {
        error_log("Error en obtenerClientes: " . $e->getMessage());
        return [];
    }
}

// ============ FUNCIONES DE TIPOS DE EVENTO ============

function obtenerTiposEvento($categoria = null) {
    try {
        $db = getDB();
        
        if ($categoria) {
            $stmt = $db->prepare("SELECT * FROM tipos_evento WHERE categoria = ? AND activo = 1 ORDER BY nombre");
            $stmt->execute([$categoria]);
            return $stmt->fetchAll();
        } else {
            return $db->query("SELECT * FROM tipos_evento WHERE activo = 1 ORDER BY categoria, nombre")->fetchAll();
        }
    } catch(Exception $e) {
        error_log("Error en obtenerTiposEvento: " . $e->getMessage());
        return [];
    }
}

function obtenerNombreTipoEvento($tipo_evento_id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT nombre FROM tipos_evento WHERE id = ?");
        $stmt->execute([$tipo_evento_id]);
        $result = $stmt->fetch();
        return $result ? $result['nombre'] : 'Desconocido';
    } catch(Exception $e) {
        return 'Desconocido';
    }
}

function getCategoriaLabel($categoria) {
    $labels = [
        'bodas' => '🎭 Bodas',
        'xv_anos' => '👸 XV Años',
        'baby_shower' => '🎀 Baby Shower',
        'empresariales' => '🏢 Eventos Empresariales',
        'municipales' => '🏛️ Eventos Municipales',
        'anuales' => '📅 Eventos del Año',
        'otros' => '🎪 Otros Eventos'
    ];
    return $labels[$categoria] ?? ucfirst($categoria);
}

// ============ FUNCIONES DE ESTADÍSTICAS ============

function obtenerEstadisticas() {
    try {
        $db = getDB();
        $stats = $db->query("SELECT 
            COUNT(*) as total_clientes,
            COUNT(DISTINCT tipo_evento_id) as tipos_evento,
            (SELECT fecha_evento FROM clientes WHERE fecha_evento >= CURDATE() ORDER BY fecha_evento ASC LIMIT 1) as proximo_evento,
            (SELECT fecha_evento FROM clientes ORDER BY fecha_evento DESC LIMIT 1) as ultimo_evento
            FROM clientes")->fetch(PDO::FETCH_ASSOC);
        
        return $stats ?: [
            'total_clientes' => 0,
            'tipos_evento' => 0,
            'proximo_evento' => null,
            'ultimo_evento' => null
        ];
    } catch(Exception $e) {
        error_log("Error en obtenerEstadisticas: " . $e->getMessage());
        return [
            'total_clientes' => 0,
            'tipos_evento' => 0,
            'proximo_evento' => null,
            'ultimo_evento' => null
        ];
    }
}

// ============ FUNCIONES PARA ADMINISTRADORES ============

function obtenerAdminPorId($admin_id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, email, nombre_completo, ultimo_acceso FROM administradores WHERE id = ? AND activo = 1");
        $stmt->execute([$admin_id]);
        return $stmt->fetch();
    } catch(Exception $e) {
        return false;
    }
}

function actualizarUltimoAcceso($admin_id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE administradores SET ultimo_acceso = NOW() WHERE id = ?");
        return $stmt->execute([$admin_id]);
    } catch(Exception $e) {
        return false;
    }
}

// ============ LIMPIAR CÓDIGOS EXPIRADOS ============

function limpiarCodigosExpirados() {
    try {
        $db = getDB();
        $db->prepare("DELETE FROM recuperacion_password WHERE expiracion < NOW()")->execute();
        return true;
    } catch(Exception $e) {
        return false;
    }
}

if (mt_rand(1, 100) <= 10) {
    limpiarCodigosExpirados();
}

?>