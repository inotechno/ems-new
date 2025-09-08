-- Database schema untuk Access Control Application
-- Pastikan database 'employee_system' sudah dibuat

USE employee_system;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255) NOT NULL,
    whatsapp_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel employees
CREATE TABLE IF NOT EXISTS employees (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel sites
CREATE TABLE IF NOT EXISTS sites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel machines
CREATE TABLE IF NOT EXISTS machines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL,
    active ENUM('yes', 'no') DEFAULT 'yes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel attendances
CREATE TABLE IF NOT EXISTS attendances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid VARCHAR(255) NOT NULL,
    employee_id VARCHAR(255) NOT NULL,
    state INT NOT NULL,
    timestamp DATETIME NOT NULL,
    type INT DEFAULT 1,
    event_id INT DEFAULT 4,
    site_id INT NOT NULL,
    longitude DECIMAL(10, 8),
    latitude DECIMAL(11, 8),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
    INDEX idx_uid_state (uid, state),
    INDEX idx_employee_timestamp (employee_id, timestamp)
);

-- Tabel roles (untuk sistem role)
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    guard_name VARCHAR(255) DEFAULT 'web',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel model_has_roles (untuk sistem role)
CREATE TABLE IF NOT EXISTS model_has_roles (
    role_id INT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    INDEX idx_model_has_roles_model_id_model_type_index (model_id, model_type)
);

-- Insert data awal
INSERT IGNORE INTO roles (id, name) VALUES 
(1, 'admin'),
(2, 'employee');

INSERT IGNORE INTO sites (id, name, address) VALUES 
(84, 'Main Office', 'Jakarta, Indonesia');

INSERT IGNORE INTO machines (id, ip, active) VALUES 
(1, '192.168.1.100', 'yes'),
(2, '192.168.1.101', 'yes');

-- Buat index untuk optimasi query
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_employees_user_id ON employees(user_id);
CREATE INDEX idx_attendances_timestamp ON attendances(timestamp);
CREATE INDEX idx_machines_ip ON machines(ip); 