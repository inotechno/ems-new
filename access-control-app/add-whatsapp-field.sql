-- Script untuk menambahkan field whatsapp_number ke tabel users
-- Jalankan script ini jika field whatsapp_number belum ada di tabel users

USE employee_system;

-- Cek apakah field whatsapp_number sudah ada
SET @column_exists = (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = 'employee_system'
  AND TABLE_NAME = 'users'
  AND COLUMN_NAME = 'whatsapp_number'
);

-- Jika field belum ada, tambahkan
SET @sql = IF(@column_exists = 0,
  'ALTER TABLE users ADD COLUMN whatsapp_number VARCHAR(20) AFTER email',
  'SELECT "Field whatsapp_number already exists" as message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Tampilkan struktur tabel users
DESCRIBE users; 