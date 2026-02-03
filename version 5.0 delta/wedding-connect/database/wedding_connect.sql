-- --------------------------------------------------------
-- WEDDING CONNECT - Sistema de Event Planner version 5.0
-- Base de datos normalizada - USUARIO: cristina / CONTRASEÑA: 1234
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

-- Insertar administrador CRISTINA
INSERT INTO administradores (username, password_hash, email, nombre_completo) VALUES
('cristina', '1234', 'cristinagallo.planner@gmail.com', '!Bienvenida¡ Cristina Gallo');

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

-- Insertar clientes de ejemplo usando IDs de tipos_evento
INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_evento_id, mensaje) VALUES
-- Bodas
('Ana García López', 'ana.garcia@email.com', '55-3214-8765', '2024-01-25', @boda_civil_id, 'Boda civil íntima en jardín.'),
('Carlos Martínez', 'carlos.m@empresa.com', '492-7654-3210', '2024-02-14', @boda_destino_id, 'Boda en la playa en Cancún.'),
('María Rodríguez', 'maria.r@hotmail.com', '449-9087-6543', '2024-03-05', @boda_religiosa_id, 'Ceremonia en iglesia.'),
('Roberto Sánchez', 'roberto.s@gmail.com', '55-6789-1234', '2024-04-10', @boda_lujo_id, 'Evento de gala en hotel 5 estrellas.'),

-- XV Años
('Valentina Hernández', 'valentina.h@email.com', '55-9988-7766', '2024-05-15', @xv_anos_id, 'XV años tradicional con 150 invitados.'),
('Camila López', 'camila.lopez@gmail.com', '492-3344-5566', '2024-06-20', @xv_anos_tematica_id, 'XV años temático de princesa.'),
('Diego Ramírez', 'diego.ramirez@outlook.com', '449-6677-8899', '2024-07-10', @xv_anos_lujo_id, 'XV años en salón de lujo.'),

-- Baby Shower
('Laura Fernández', 'laura.f@outlook.com', '492-4321-7890', '2024-08-12', @baby_shower_id, 'Baby shower para gemelos.'),
('Sofía González', 'sofia.g@hotmail.com', '55-3344-5566', '2024-09-05', @baby_shower_gender_id, 'Revelación de género con temática de superhéroes.'),

-- Eventos Empresariales
('Tech Solutions SA', 'eventos@techsolutions.com', '55-1234-5678', '2024-10-20', @evento_empresarial_id, 'Convención anual de la empresa.'),
('Innovate Corp', 'contacto@innovatecorp.com', '492-8765-4321', '2024-11-15', @lanzamiento_producto_id, 'Lanzamiento del nuevo smartphone.'),
('Marketing Digital MX', 'info@marketingdigital.mx', '449-5432-1098', '2024-12-05', @conferencia_id, 'Conferencia de marketing digital.'),

-- Eventos Municipales
('Municipio de San José', 'cultura@sanjose.gob.mx', '55-2468-1357', '2025-01-30', @evento_municipal_id, 'Feria de la primavera.'),
('Dirección de Cultura', 'cultura@ciudad.gob.mx', '492-9876-5432', '2025-02-25', @festival_cultural_id, 'Festival de música folklórica.'),

-- Eventos del Año
('Familia Pérez', 'familia.perez@email.com', '449-1357-2468', '2025-03-18', @cumpleanos_id, 'Cumpleaños 50 con temática años 80.'),
('Juan y Marta', 'juan.marta@gmail.com', '55-3698-1472', '2025-04-22', @aniversario_id, '25 años de matrimonio.'),
('Colegio Lincoln', 'eventos@lincoln.edu.mx', '492-2589-1473', '2025-05-30', @graduacion_id, 'Ceremonia de graduación bachillerato.'),
('Familia Rodríguez', 'fam.rodriguez@outlook.com', '449-7531-8642', '2025-06-15', @bautizo_id, 'Bautizo del primer nieto.'),

-- Otros eventos
('Fundación Ayuda', 'eventos@fundacionayuda.org', '55-1597-3579', '2025-07-20', @evento_benefico_id, 'Gala benéfica para recaudar fondos.'),
('Club Social Elite', 'reservaciones@clubelite.com', '492-9517-6248', '2025-08-30', @evento_gala_id, 'Cena de gala para miembros exclusivos.');