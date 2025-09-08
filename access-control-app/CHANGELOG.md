# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-15

### Added
- ✅ Fitur perhitungan keterlambatan otomatis
- ✅ Pengiriman notifikasi WhatsApp
- ✅ Pengiriman notifikasi email
- ✅ Logging yang komprehensif dengan log4js
- ✅ Integrasi dengan database MySQL
- ✅ Setup otomatis database dan struktur tabel
- ✅ Konfigurasi environment variables dengan dotenv
- ✅ Dukungan PM2 untuk production deployment
- ✅ File testing untuk validasi aplikasi
- ✅ Dokumentasi lengkap dengan README
- ✅ Database schema dan migration scripts

### Features
- Penerimaan data absensi dari mesin fingerprint
- Perhitungan keterlambatan berdasarkan jam masuk standar (08:30)
- Format notifikasi yang informatif dengan detail keterlambatan
- Sistem role untuk user management
- Error handling yang robust
- Logging ke file dan console

### Technical Details
- Menggunakan ES6 modules
- Async/await untuk operasi database
- Moment.js untuk handling timezone
- Nodemailer untuk email notifications
- Axios untuk HTTP requests
- MySQL2 untuk database connection
- PM2 untuk process management

### Database Schema
- Tabel `users` dengan field `whatsapp_number`
- Tabel `employees` untuk data karyawan
- Tabel `attendances` untuk data absensi
- Tabel `sites` dan `machines` untuk konfigurasi
- Tabel `roles` dan `model_has_roles` untuk sistem role

### Configuration
- Environment variables untuk database, email, dan WhatsApp API
- Timezone Asia/Jakarta
- Logging configuration dengan rotation
- PM2 ecosystem configuration 