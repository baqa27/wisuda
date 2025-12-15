# 🚀 QUICK START GUIDE

## Mulai Cepat dalam 5 Menit!

### 1️⃣ Install Dependencies (2 menit)

```bash
composer install
npm install
```

### 2️⃣ Setup Environment (1 menit)

```bash
# Copy .env
copy .env.example .env

# Generate key
php artisan key:generate
```

### 3️⃣ Konfigurasi Database (1 menit)

Edit file `.env`:
```env
DB_DATABASE=sistem_wisuda
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE sistem_wisuda;
```

### 4️⃣ Migrate Database (30 detik)

```bash
php artisan migrate
php artisan storage:link
```

### 5️⃣ Jalankan Aplikasi (30 detik)

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

**Buka browser:** http://localhost:8000

---

## ✅ Selesai! Aplikasi Sudah Berjalan

### Default Login

**Admin:**
- Email: (buat manual di database atau via seeder)
- Password: (sesuai yang dibuat)

**Mahasiswa:**
- Daftar via halaman register

---

## 🔧 Konfigurasi Opsional (Untuk Fitur Lengkap)

### Email Verification

Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
ADMIN_EMAIL=admin@example.com
```

**Cara dapat App Password:**
1. Buka https://myaccount.google.com/apppasswords
2. Generate password
3. Copy ke `MAIL_PASSWORD`

### Midtrans Payment

Edit `.env`:
```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

**Cara dapat Credentials:**
1. Daftar di https://dashboard.midtrans.com/
2. Pilih "Sandbox"
3. Settings → Access Keys
4. Copy Server Key & Client Key

---

## 📚 Dokumentasi Lengkap

- **Setup Detail:** Lihat `SETUP_GUIDE.md`
- **Fitur Baru:** Lihat `FITUR_BARU.md`
- **Checklist:** Lihat `CHECKLIST.md`

---

## 🆘 Troubleshooting Cepat

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: Migration failed
```bash
# Pastikan database sudah dibuat
# Cek koneksi database di .env
php artisan migrate:fresh
```

### Error: Storage link
```bash
php artisan storage:link
```

### Email tidak terkirim
- Gunakan Mailtrap untuk testing: https://mailtrap.io
- Atau skip email verification dulu

### Midtrans tidak muncul
- Pastikan credentials sudah diisi
- Cek `storage/logs/laravel.log`

---

## 🎯 Next Steps

1. ✅ Test registrasi user
2. ✅ Test login
3. ✅ Test daftar yudisium
4. ✅ Setup email (opsional)
5. ✅ Setup Midtrans (opsional)
6. ✅ Baca dokumentasi lengkap

---

**Happy Coding! 🎉**
