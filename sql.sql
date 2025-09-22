-- Crear la base de datos 
CREATE DATABASE IF NOT EXISTS usuario_php;
USE usuario_php;

-- Crear tabla login_user
CREATE TABLE IF NOT EXISTS login_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



-- Crear tabla log_sistema
CREATE TABLE IF NOT EXISTS log_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sesion_id VARCHAR(64) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    inicio_sesion DATETIME NOT NULL,
    cierre_sesion DATETIME DEFAULT NULL
);



-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagen VARCHAR(255), -- ruta o nombre del archivo de la miniatura
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

