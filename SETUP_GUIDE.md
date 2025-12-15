# 📋 PANDUAN SETUP SISTEM WISUDA

## 🎯 Fitur yang Telah Ditambahkan

### ✅ 1. Perbaikan Error
- ✓ Fixed `$snapToken` undefined error di view upload_bukti
- ✓ Fixed Midtrans server key configuration
- ✓ Generated Laravel APP_KEY
- ✓ Added payment_method dan paid_at columns

### ✅ 2. Integrasi Midtrans Payment Gateway
- ✓ Payment checkout dengan Midtrans Snap
- ✓ Webhook notification handler untuk update status pembayaran otomatis
- ✓ Payment success page
- ✓ Support multiple payment methods (Credit Card, Bank Transfer, E-Wallet, dll)

### ✅ 3. Email Verification dengan Gmail
- ✓ Kirim email verifikasi saat registrasi
- ✓ Verification token system
- ✓ Resend verification email
- ✓ Email template yang profesional

### ✅ 4. Notifikasi Admin
- ✓ Email notifikasi ke admin saat ada pembayaran baru
- ✓ Detail lengkap pembayaran di email
- ✓ Link langsung ke dashboard admin

---

## 🚀 Cara Setup

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Konfigurasi Environment

Copy file `.env.example` ke `.env`:
```bash
copy .env.example .env
```

Edit file `.env` dan isi konfigurasi berikut:

#### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_wisuda
DB_USERNAME=root
DB_PASSWORD=
```

#### Email (Gmail)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Sistem Wisuda"

ADMIN_EMAIL=admin@example.com
```

**Cara mendapatkan Gmail App Password:**
1. Buka https://myaccount.google.com/apppasswords
2. Login dengan akun Gmail Anda
3. Pilih "Mail" sebagai app
4. Pilih "Other" sebagai device, beri nama "Sistem Wisuda"
5. Copy password yang di-generate (16 karakter)
6. Paste ke `MAIL_PASSWORD` di file `.env`

#### Midtrans
```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

**Cara mendapatkan Midtrans Credentials:**
1. Daftar di https://dashboard.midtrans.com/
2. Login dan pilih environment "Sandbox" untuk testing
3. Buka menu "Settings" → "Access Keys"
4. Copy **Server Key** dan **Client Key**
5. Paste ke file `.env`

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Jalankan Migration

```bash
php artisan migrate
```

### 5. Create Storage Link

```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite (untuk assets):**
```bash
npm run dev
```

Aplikasi akan berjalan di: http://localhost:8000

---

## 🔧 Konfigurasi Midtrans Webhook

Untuk menerima notifikasi pembayaran dari Midtrans, Anda perlu setup webhook URL:

### Development (Local Testing)

1. Install ngrok: https://ngrok.com/download
2. Jalankan ngrok:
   ```bash
   ngrok http 8000
   ```
3. Copy URL yang diberikan (contoh: https://abc123.ngrok.io)
4. Buka Midtrans Dashboard → Settings → Configuration
5. Set **Payment Notification URL** ke:
   ```
   https://abc123.ngrok.io/midtrans/notification
   ```

### Production

Set **Payment Notification URL** di Midtrans Dashboard ke:
```
https://yourdomain.com/midtrans/notification
```

---

## 📧 Testing Email

### Menggunakan Mailtrap (Recommended untuk Development)

1. Daftar di https://mailtrap.io (gratis)
2. Buat inbox baru
3. Copy credentials SMTP
4. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-mailtrap-username
   MAIL_PASSWORD=your-mailtrap-password
   MAIL_ENCRYPTION=tls
   ```

### Menggunakan Gmail (Production)

Ikuti langkah di bagian "Email (Gmail)" di atas.

---

## 💳 Testing Midtrans Payment

Midtrans Sandbox menyediakan test cards untuk testing:

### Credit Card
- **Card Number:** 4811 1111 1111 1114
- **CVV:** 123
- **Exp Date:** 01/25

### GoPay
- Gunakan nomor HP: 081234567890
- PIN: 123456

### Bank Transfer
- Pilih bank apa saja
- Akan mendapat virtual account number untuk testing

Dokumentasi lengkap: https://docs.midtrans.com/docs/testing-payment

---

## 🎨 Fitur Email Verification

### Flow Verifikasi Email:

1. **User Register** → Sistem generate verification token
2. **Email Dikirim** → User menerima email dengan link verifikasi
3. **User Klik Link** → Token divalidasi dan email terverifikasi
4. **Success** → User dapat login dan menggunakan sistem

### Resend Verification Email:

Jika user tidak menerima email, mereka dapat request kirim ulang:
```
POST /resend-verification
```

---

## 📊 Monitoring Pembayaran

### Admin Dashboard

Admin akan menerima notifikasi email setiap ada pembayaran baru dengan detail:
- Kode Invoice
- Nama Mahasiswa & NIM
- Total Bayar
- Metode Pembayaran
- Tanggal Bayar
- Link ke Dashboard Admin

### Webhook Logs

Semua webhook notification dari Midtrans akan tercatat di:
```
storage/logs/laravel.log
```

---

## 🐛 Troubleshooting

### Email Tidak Terkirim

1. Cek konfigurasi SMTP di `.env`
2. Pastikan Gmail App Password sudah benar
3. Cek logs: `storage/logs/laravel.log`
4. Test koneksi SMTP:
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('test@example.com')->subject('Test');
   });
   ```

### Midtrans Payment Gagal

1. Pastikan Server Key dan Client Key sudah benar
2. Cek environment (Sandbox vs Production)
3. Pastikan webhook URL sudah di-set
4. Cek logs Midtrans di dashboard

### Migration Error

Jika ada error saat migrate:
```bash
php artisan migrate:fresh
```
⚠️ **Warning:** Ini akan menghapus semua data!

---

## 📝 Catatan Penting

1. **Jangan commit file `.env`** ke repository
2. **Gunakan Sandbox** untuk testing Midtrans
3. **Backup database** sebelum migrate di production
4. **Test email** sebelum deploy ke production
5. **Setup queue worker** untuk production:
   ```bash
   php artisan queue:work
   ```

---

## 🔐 Security Checklist

- [ ] APP_KEY sudah di-generate
- [ ] APP_DEBUG=false di production
- [ ] Database credentials aman
- [ ] Email credentials aman
- [ ] Midtrans credentials aman
- [ ] HTTPS enabled di production
- [ ] Webhook URL menggunakan HTTPS

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue atau hubungi developer.

**Happy Coding! 🚀**
