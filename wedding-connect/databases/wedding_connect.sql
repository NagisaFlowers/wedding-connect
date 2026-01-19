-- --------------------------------------------------------
-- WEDDING CONNECT - Sistema de Wedding Planner
-- Base de datos básica - USUARIO: cristina / CONTRASEÑA: 1234
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
    tipo_boda ENUM('civil', 'religiosa', 'destino', 'intima', 'lujo') NOT NULL,
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
('cristina', '1234', 'cristina@weddingconnect.com', 'Cristina Administradora');

-- Insertar clientes de ejemplo
INSERT INTO clientes (nombre, correo, telefono, fecha_evento, tipo_boda, mensaje) VALUES
('Ana García López', 'ana.garcia@email.com', '555-1234-567', '2024-12-15', 'civil', 'Quiero una boda íntima en jardín con máximo 50 invitados.'),
('Carlos Martínez', 'carlos.m@empresa.com', '555-9876-543', '2025-02-14', 'destino', 'Boda en la playa en Cancún para 80 personas.'),
('María Rodríguez', 'maria.r@hotmail.com', '555-4567-890', '2024-11-30', 'religiosa', 'Ceremonia en iglesia con 150 invitados.'),
('Roberto Sánchez', 'roberto.s@gmail.com', '555-2345-678', '2025-03-22', 'lujo', 'Evento de gala en hotel 5 estrellas.'),
('Laura Fernández', 'laura.f@outlook.com', '555-8765-432', '2024-10-10', 'intima', 'Solo familia cercana, máximo 30 personas.'),
('Juan Pérez', 'juan.perez@gmail.com', '555-1111-222', '2024-09-15', 'civil', 'Boda sencilla en salón comunal'),
('Sofía González', 'sofia.g@hotmail.com', '555-3333-444', '2024-08-20', 'religiosa', 'Boda en catedral seguida de recepción'),
('Miguel Torres', 'miguel.t@empresa.com', '555-5555-666', '2024-07-25', 'destino', 'Boda en playa con ceremonia al atardecer');

-- --------------------------------------------------------
-- VERIFICACIÓN
-- --------------------------------------------------------
SELECT '=== BASE DE DATOS CREADA ===' AS Mensaje;
SELECT '=== TABLAS ===' AS Mensaje;
SHOW TABLES;

SELECT '=== ADMINISTRADOR ===' AS Mensaje;
SELECT username, email, nombre_completo FROM administradores;

SELECT '=== CLIENTES REGISTRADOS ===' AS Mensaje;
SELECT COUNT(*) AS total_clientes FROM clientes;

SELECT '=== MUESTRA DE CLIENTES ===' AS Mensaje;
SELECT id, nombre, correo, tipo_boda, fecha_evento FROM clientes LIMIT 5;