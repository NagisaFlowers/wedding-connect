-- --------------------------------------------------------
-- WEDDING CONNECT - Sistema de Event Planner
-- Base de datos actualizada - USUARIO: cristina / CONTRASEÑA: 1234
-- --------------------------------------------------------

-- Crear base de datos si no existe
DROP DATABASE IF EXISTS wedding_connect;
CREATE DATABASE wedding_connect;
USE wedding_connect;

-- --------------------------------------------------------
-- TABLA: clientes
-- --------------------------------------------------------
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_evento DATE NOT NULL,
    tipo_boda ENUM(
        -- Bodas (mantenemos los existentes)
        'boda_civil', 'boda_religiosa', 'boda_destino', 'boda_intima', 'boda_lujo', 
        'boda_tematica', 'boda_playa', 'boda_campo', 'boda_urbana', 'boda_vintage',
        -- XV Años
        'xv_anos', 'xv_anos_tematica', 'xv_anos_lujo', 'xv_anos_in`wedding_connect`tima',
        -- Baby Shower
        'baby_shower', 'baby_shower_gender_reveal', 'baby_shower_tematica',
        -- Eventos Empresariales
        'evento_empresarial', 'convencion', 'lanzamiento_producto', 'conferencia',
        'seminario', 'team_building', 'fiesta_navidad_empresa',
        -- Eventos Municipales
        'evento_municipal', 'feria_local', 'festival_cultural', 'concierto_publico',
        'celebracion_aniversario_ciudad', 'evento_deportivo_municipal',
        -- Eventos del Año
        'cumpleanos', 'aniversario', 'graduacion', 'bautizo', 'primera_comunion',
        'despedida_soltero', 'fiesta_compromiso', 'renovacion_votos',
        'fiesta_halloween', 'fiesta_navidad', 'fiesta_ano_nuevo', 'fiesta_pascua',
        -- Otros
        'evento_religioso', 'evento_benefico', 'evento_gala', 'evento_privado'
    ) NOT NULL,
    mensaje TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
-- INSERTAR DATOS DE EJEMPLO
-- --------------------------------------------------------

-- Insertar administrador CRISTINA con contraseña 1234
INSERT INTO administradores (username, password_hash, email, nombre_completo) VALUES
('cristina', '1234', 'cristinagallo.planner@gmail.com', '!Bienvenida¡ Cristina Gallo');

-- Insertar clientes de ejemplo con DIVERSOS tipos de eventos
INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_boda, mensaje) VALUES
-- Bodas
('Ana García López', 'ana.garcia@email.com', '55-3214-8765', '2024-01-25', 'boda_civil', 'Boda civil íntima en jardín.'),
('Carlos Martínez', 'carlos.m@empresa.com', '492-7654-3210', '2024-02-14', 'boda_destino', 'Boda en la playa en Cancún.'),
('María Rodríguez', 'maria.r@hotmail.com', '449-9087-6543', '2024-03-05', 'boda_religiosa', 'Ceremonia en iglesia.'),
('Roberto Sánchez', 'roberto.s@gmail.com', '55-6789-1234', '2024-04-10', 'boda_lujo', 'Evento de gala en hotel 5 estrellas.'),

-- XV Años
('Valentina Hernández', 'valentina.h@email.com', '55-9988-7766', '2024-05-15', 'xv_anos', 'XV años tradicional con 150 invitados.'),
('Camila López', 'camila.lopez@gmail.com', '492-3344-5566', '2024-06-20', 'xv_anos_tematica', 'XV años temático de princesa.'),
('Diego Ramírez', 'diego.ramirez@outlook.com', '449-6677-8899', '2024-07-10', 'xv_anos_lujo', 'XV años en salón de lujo.'),

-- Baby Shower
('Laura Fernández', 'laura.f@outlook.com', '492-4321-7890', '2024-08-12', 'baby_shower', 'Baby shower para gemelos.'),
('Sofía González', 'sofia.g@hotmail.com', '55-3344-5566', '2024-09-05', 'baby_shower_gender_reveal', 'Revelación de género con temática de superhéroes.'),

-- Eventos Empresariales
('Tech Solutions SA', 'eventos@techsolutions.com', '55-1234-5678', '2024-10-20', 'evento_empresarial', 'Convención anual de la empresa.'),
('Innovate Corp', 'contacto@innovatecorp.com', '492-8765-4321', '2024-11-15', 'lanzamiento_producto', 'Lanzamiento del nuevo smartphone.'),
('Marketing Digital MX', 'info@marketingdigital.mx', '449-5432-1098', '2024-12-05', 'conferencia', 'Conferencia de marketing digital.'),

-- Eventos Municipales
('Municipio de San José', 'cultura@sanjose.gob.mx', '55-2468-1357', '2025-01-30', 'evento_municipal', 'Feria de la primavera.'),
('Dirección de Cultura', 'cultura@ciudad.gob.mx', '492-9876-5432', '2025-02-25', 'festival_cultural', 'Festival de música folklórica.'),

-- Eventos del Año
('Familia Pérez', 'familia.perez@email.com', '449-1357-2468', '2025-03-18', 'cumpleanos', 'Cumpleaños 50 con temática años 80.'),
('Juan y Marta', 'juan.marta@gmail.com', '55-3698-1472', '2025-04-22', 'aniversario', '25 años de matrimonio.'),
('Colegio Lincoln', 'eventos@lincoln.edu.mx', '492-2589-1473', '2025-05-30', 'graduacion', 'Ceremonia de graduación bachillerato.'),
('Familia Rodríguez', 'fam.rodriguez@outlook.com', '449-7531-8642', '2025-06-15', 'bautizo', 'Bautizo del primer nieto.'),

-- Otros eventos
('Fundación Ayuda', 'eventos@fundacionayuda.org', '55-1597-3579', '2025-07-20', 'evento_benefico', 'Gala benéfica para recaudar fondos.'),
('Club Social Elite', 'reservaciones@clubelite.com', '492-9517-6248', '2025-08-30', 'evento_gala', 'Cena de gala para miembros exclusivos.');

