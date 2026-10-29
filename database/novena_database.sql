-- Novena Studio (Laravel) · esquema + datos iniciales para MySQL/MariaDB
-- Ejecutar: mysql -u root -p < novena_database.sql
-- Las sesiones y el caché de Laravel se guardan en archivos (SESSION_DRIVER=file, CACHE_STORE=file),
-- por eso solo se necesitan estas tres tablas.

CREATE DATABASE IF NOT EXISTS novena_database
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE novena_database;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(100) NOT NULL,
    email          VARCHAR(100) NOT NULL UNIQUE,
    password       VARCHAR(255) NOT NULL,
    role           ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at     TIMESTAMP NULL,
    updated_at     TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
    id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    slug          VARCHAR(100) NOT NULL UNIQUE,
    description   TEXT NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active     TINYINT(1) NOT NULL DEFAULT 1,
    created_at    TIMESTAMP NULL,
    updated_at    TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE products (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT NULL,
    price       DECIMAL(10, 2) NOT NULL,
    image_path  VARCHAR(255) NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    category_id BIGINT UNSIGNED NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id)
        REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Usuarios demo (contraseñas cifradas con bcrypt): admin@novena.com / admin123, user@novena.com / user123
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
    ('Administrador', 'admin@novena.com', '$2y$12$ES.1984C.7UV0CWJrFwqf.Ht4RGCHHwZwrgieXY0bO2MNezHJ.keq', 'admin', NOW(), NOW()),
    ('Usuario Demo',  'user@novena.com',  '$2y$12$ke7u7LPeOz6Mv/O5RTghQ.3v0dH5iidPmiysut6ny3dpNLhtU7Mla', 'user',  NOW(), NOW());

INSERT INTO categories (id, name, slug, description, display_order, is_active, created_at, updated_at) VALUES
    (1, 'Tazas',    'tazas',    'Tazas personalizadas',  1, 1, NOW(), NOW()),
    (2, 'Vasos',    'vasos',    'Vasos y termos',        2, 1, NOW(), NOW()),
    (3, 'Regalos',  'regalos',  'Regalos para la gente', 3, 1, NOW(), NOW()),
    (4, 'Detalles', 'detalles', 'Detalles de regalos',   4, 1, NOW(), NOW());

INSERT INTO products (name, description, price, image_path, is_featured, is_active, category_id, created_at, updated_at) VALUES
    ('Rosas', 'Regalo floral',                200.00, 'Recursos/Flores_1765211859.png',     0, 1, 4, NOW(), NOW()),
    ('Taza',  'Diseño de taza personalizado', 100.00, 'Recursos/producto1_1765211937.png', 0, 1, 1, NOW(), NOW());
