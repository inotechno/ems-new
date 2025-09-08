# Access Control Application

Aplikasi Node.js untuk sistem kontrol akses dengan fitur perhitungan keterlambatan dan pengiriman notifikasi WhatsApp/email.

## Fitur

- ✅ Penerimaan data absensi dari mesin fingerprint
- ✅ Perhitungan keterlambatan otomatis
- ✅ Pengiriman notifikasi WhatsApp
- ✅ Pengiriman notifikasi email
- ✅ Logging yang komprehensif
- ✅ Integrasi dengan database MySQL

## Instalasi

1. Clone repository ini
2. Install dependensi:
```bash
npm install
```

3. Setup database:
```bash
# Buat database MySQL
mysql -u root -p
CREATE DATABASE employee_system;
USE employee_system;
exit;

# Jalankan setup otomatis
npm run setup
```

Atau setup manual:
```bash
# Jalankan schema database
mysql -u root -p employee_system < database-schema.sql

# Jika field whatsapp_number belum ada di tabel users
mysql -u root -p employee_system < add-whatsapp-field.sql
```

4. Buat file `.env` dengan konfigurasi berikut:
```bash
# Copy dari example.env
cp example.env .env
# Edit file .env sesuai konfigurasi Anda
```
```env
# Database Configuration
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=employee_system

# Email Configuration
EMAIL_USER=your-email@gmail.com
EMAIL_PASSWORD=your-app-password

# WhatsApp API Configuration
WHATSAPP_API_URL=https://waha.tpm-facility.com/api/sendText
WHATSAPP_API_KEY=dutaMas26

# Server Configuration
HOST=127.0.0.1
PORT=7650

# Timezone
TZ=Asia/Jakarta
```

5. Buat folder logs:
```bash
mkdir logs
```

6. Install PM2 (opsional, untuk production):
```bash
npm install -g pm2
```

## Penggunaan

### Development
```bash
npm run dev
```

### Production
```bash
npm start
```

### Production dengan PM2
```bash
# Start aplikasi
npm run pm2:start

# Stop aplikasi
npm run pm2:stop

# Restart aplikasi
npm run pm2:restart

# Lihat logs
npm run pm2:logs

# Hapus aplikasi dari PM2
npm run pm2:delete
```

## Testing

Untuk testing aplikasi:

```bash
# Jalankan test
npm run test
```

Atau:
```bash
# Jalankan test manual
node test-example.js
```

## API Endpoints

### GET /
Health check endpoint

### POST /
Endpoint untuk menerima data absensi dari mesin fingerprint

**Request Body:**
```json
{
  "event_log": "{\"ipAddress\":\"192.168.1.100\",\"AccessControllerEvent\":{\"employeeNoString\":\"12345\",\"name\":\"John Doe\",\"serialNo\":\"001\"},\"dateTime\":\"2024-01-15T08:45:00Z\"}"
}
```

## Perhitungan Keterlambatan

Sistem akan menghitung keterlambatan berdasarkan:
- **Jam masuk standar:** 08:30
- **Batas toleransi:** 10:00
- **Zona waktu:** Asia/Jakarta

Jika karyawan absen setelah jam 08:30 dan sebelum jam 10:00, sistem akan:
1. Menghitung selisih waktu keterlambatan
2. Mengirim notifikasi WhatsApp (jika nomor tersedia)
3. Mengirim notifikasi email (jika email tersedia)

## Struktur Database

Pastikan database memiliki tabel berikut:

### Tabel `users`
- `id` (primary key)
- `username`
- `name`
- `email`
- `password`
- `whatsapp_number` (opsional)
- `created_at`

### Tabel `employees`
- `id` (primary key)
- `user_id` (foreign key ke users.id)
- `created_at`

### Tabel `attendances`
- `id` (primary key)
- `uid`
- `employee_id` (foreign key ke employees.id)
- `state`
- `timestamp`
- `type`
- `event_id`
- `site_id`
- `longitude`
- `latitude`
- `created_at`

### Tabel `sites`
- `id` (primary key)
- `name`
- `address`

### Tabel `machines`
- `id` (primary key)
- `ip`
- `active`

## Konfigurasi Email

Untuk menggunakan fitur email, pastikan:

1. Menggunakan Gmail dengan App Password
2. Atau konfigurasi SMTP server lain di `index.js`

## Konfigurasi WhatsApp

Sistem menggunakan API WhatsApp yang sudah dikonfigurasi:
- **URL:** https://waha.tpm-facility.com/api/sendText
- **API Key:** dutaMas26

## Logging

Sistem menggunakan log4js dengan konfigurasi:
- **Console logging:** Untuk development
- **File logging:** `logs/app.log`
- **Error logging:** `logs/error.log`

## Troubleshooting

### Error Database Connection
- Pastikan MySQL server berjalan
- Periksa konfigurasi database di `.env`

### Error Email
- Pastikan konfigurasi SMTP benar
- Untuk Gmail, gunakan App Password

### Error WhatsApp
- Periksa koneksi internet
- Pastikan API key valid

## Lisensi

MIT License 