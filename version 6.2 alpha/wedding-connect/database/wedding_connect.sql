-- --------------------------------------------------------
-- WEDDING CONNECT - Sistema de Event Planner version 6.0
-- --------------------------------------------------------

-- Crear base de datos si no existe
DROP DATABASE IF EXISTS wedding_connect;
CREATE DATABASE wedding_connect;
USE wedding_connect;

-- --------------------------------------------------------
-- TABLA: tipos_evento (NUEVA TABLA NORMALIZADA)
-- --------------------------------------------------------
CREATE TABLE tipos_evento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria ENUM('bodas', 'xv_anos', 'baby_shower', 'empresariales', 'municipales', 'anuales', 'otros') NOT NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLA: clientes (MODIFICADA PARA NORMALIZACIÓN)
-- --------------------------------------------------------
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_evento DATE NOT NULL,
    tipo_evento_id INT NOT NULL, -- Referencia a tipos_evento
    mensaje TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_evento_id) REFERENCES tipos_evento(id) ON DELETE RESTRICT
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLA: administradores
-- --------------------------------------------------------
CREATE TABLE administradores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nombre_completo VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP NULL,
    activo BOOLEAN DEFAULT TRUE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABLA: recuperacion_password (PARA RECUPERACIÓN DE CONTRASEÑAS)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS recuperacion_password (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    codigo VARCHAR(6) NOT NULL,
    expiracion DATETIME NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES administradores(id) ON DELETE CASCADE,
    INDEX idx_admin_id (admin_id),
    INDEX idx_codigo (codigo),
    INDEX idx_expiracion (expiracion)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

-- Evento para limpiar automáticamente códigos expirados
DELIMITER $$
CREATE EVENT IF NOT EXISTS limpiar_codigos_expirados
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DELETE FROM recuperacion_password WHERE expiracion < NOW();
END$$
DELIMITER ;

-- --------------------------------------------------------
-- INSERTAR TIPOS DE EVENTO
-- --------------------------------------------------------
INSERT INTO tipos_evento (codigo, nombre, categoria) VALUES
-- Bodas
('boda_civil', 'Boda Civil', 'bodas'),
('boda_religiosa', 'Boda Religiosa', 'bodas'),
('boda_destino', 'Boda Destino', 'bodas'),
('boda_intima', 'Boda Íntima', 'bodas'),
('boda_lujo', 'Boda de Lujo', 'bodas'),
('boda_tematica', 'Boda Temática', 'bodas'),
('boda_playa', 'Boda en Playa', 'bodas'),
('boda_campo', 'Boda en Campo', 'bodas'),
('boda_urbana', 'Boda Urbana', 'bodas'),
('boda_vintage', 'Boda Vintage', 'bodas'),

-- XV Años
('xv_anos', 'XV Años Tradicional', 'xv_anos'),
('xv_anos_tematica', 'XV Años Temático', 'xv_anos'),
('xv_anos_lujo', 'XV Años de Lujo', 'xv_anos'),
('xv_anos_intima', 'XV Años Íntimo', 'xv_anos'),

-- Baby Shower
('baby_shower', 'Baby Shower', 'baby_shower'),
('baby_shower_gender_reveal', 'Baby Shower (Gender Reveal)', 'baby_shower'),
('baby_shower_tematica', 'Baby Shower Temático', 'baby_shower'),

-- Eventos Empresariales
('evento_empresarial', 'Evento Empresarial', 'empresariales'),
('convencion', 'Convención', 'empresariales'),
('lanzamiento_producto', 'Lanzamiento de Producto', 'empresariales'),
('conferencia', 'Conferencia', 'empresariales'),
('seminario', 'Seminario', 'empresariales'),
('team_building', 'Team Building', 'empresariales'),
('fiesta_navidad_empresa', 'Fiesta de Navidad Empresarial', 'empresariales'),

-- Eventos Municipales
('evento_municipal', 'Evento Municipal', 'municipales'),
('feria_local', 'Feria Local', 'municipales'),
('festival_cultural', 'Festival Cultural', 'municipales'),
('concierto_publico', 'Concierto Público', 'municipales'),
('celebracion_aniversario_ciudad', 'Celebración Aniversario Ciudad', 'municipales'),
('evento_deportivo_municipal', 'Evento Deportivo Municipal', 'municipales'),

-- Eventos del Año
('cumpleanos', 'Cumpleaños', 'anuales'),
('aniversario', 'Aniversario', 'anuales'),
('graduacion', 'Graduación', 'anuales'),
('bautizo', 'Bautizo', 'anuales'),
('primera_comunion', 'Primera Comunión', 'anuales'),
('despedida_soltero', 'Despedida de Soltero/a', 'anuales'),
('fiesta_compromiso', 'Fiesta de Compromiso', 'anuales'),
('renovacion_votos', 'Renovación de Votos', 'anuales'),
('fiesta_halloween', 'Fiesta de Halloween', 'anuales'),
('fiesta_navidad', 'Fiesta de Navidad', 'anuales'),
('fiesta_ano_nuevo', 'Fiesta de Año Nuevo', 'anuales'),
('fiesta_pascua', 'Fiesta de Pascua', 'anuales'),

-- Otros eventos
('evento_religioso', 'Evento Religioso', 'otros'),
('evento_benefico', 'Evento Benéfico', 'otros'),
('evento_gala', 'Evento de Gala', 'otros'),
('evento_privado', 'Evento Privado', 'otros');

-- --------------------------------------------------------
-- INSERTAR DATOS DE EJEMPLO
-- --------------------------------------------------------

INSERT INTO administradores (username, password_hash, email, nombre_completo) VALUES
('administradora', '1234', 'cristinagallo.planner@gmail.com', '!Bienvenida¡ Cristina Gallo'),
('cristina', '1234', 'weddingconnectaguascalientes@gmail.com', '!Bienvenida¡ Cristina Gallo');


-- Obtener IDs de tipos de evento para las inserciones
SET @boda_civil_id = (SELECT id FROM tipos_evento WHERE codigo = 'boda_civil');
SET @boda_destino_id = (SELECT id FROM tipos_evento WHERE codigo = 'boda_destino');
SET @boda_religiosa_id = (SELECT id FROM tipos_evento WHERE codigo = 'boda_religiosa');
SET @boda_lujo_id = (SELECT id FROM tipos_evento WHERE codigo = 'boda_lujo');
SET @xv_anos_id = (SELECT id FROM tipos_evento WHERE codigo = 'xv_anos');
SET @xv_anos_tematica_id = (SELECT id FROM tipos_evento WHERE codigo = 'xv_anos_tematica');
SET @xv_anos_lujo_id = (SELECT id FROM tipos_evento WHERE codigo = 'xv_anos_lujo');
SET @baby_shower_id = (SELECT id FROM tipos_evento WHERE codigo = 'baby_shower');
SET @baby_shower_gender_id = (SELECT id FROM tipos_evento WHERE codigo = 'baby_shower_gender_reveal');
SET @evento_empresarial_id = (SELECT id FROM tipos_evento WHERE codigo = 'evento_empresarial');
SET @lanzamiento_producto_id = (SELECT id FROM tipos_evento WHERE codigo = 'lanzamiento_producto');
SET @conferencia_id = (SELECT id FROM tipos_evento WHERE codigo = 'conferencia');
SET @evento_municipal_id = (SELECT id FROM tipos_evento WHERE codigo = 'evento_municipal');
SET @festival_cultural_id = (SELECT id FROM tipos_evento WHERE codigo = 'festival_cultural');
SET @cumpleanos_id = (SELECT id FROM tipos_evento WHERE codigo = 'cumpleanos');
SET @aniversario_id = (SELECT id FROM tipos_evento WHERE codigo = 'aniversario');
SET @graduacion_id = (SELECT id FROM tipos_evento WHERE codigo = 'graduacion');
SET @bautizo_id = (SELECT id FROM tipos_evento WHERE codigo = 'bautizo');
SET @evento_benefico_id = (SELECT id FROM tipos_evento WHERE codigo = 'evento_benefico');
SET @evento_gala_id = (SELECT id FROM tipos_evento WHERE codigo = 'evento_gala');
