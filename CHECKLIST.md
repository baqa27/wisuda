# ✅ CHECKLIST SETUP SISTEM WISUDA

## 📋 Pre-Installation

- [ ] PHP >= 8.2 terinstall
- [ ] Composer terinstall
- [ ] Node.js & NPM terinstall
- [ ] MySQL/MariaDB terinstall dan berjalan
- [ ] Git terinstall (optional)

---

## 🔧 Installation Steps

### 1. Dependencies
- [ ] `composer install` berhasil
- [ ] `npm install` berhasil
- [ ] Tidak ada error saat install

### 2. Environment Setup
- [ ] File `.env` sudah dibuat (copy dari `.env.example`)
- [ ] Database credentials sudah diisi
- [ ] APP_KEY sudah di-generate (`php artisan key:generate`)

### 3. Database
- [ ] Database sudah dibuat di MySQL
- [ ] Migration berhasil (`php artisan migrate`)
- [ ] Tidak ada error migration
- [ ] Storage link sudah dibuat (`php artisan storage:link`)

---

## 📧 Email Configuration

### Gmail Setup
- [ ] Gmail account sudah disiapkan
- [ ] 2-Factor Authentication sudah aktif
- [ ] App Password sudah di-generate
- [ ] Credentials sudah diisi di `.env`:
  - [ ] `MAIL_USERNAME`
  - [ ] `MAIL_PASSWORD`
  - [ ] `MAIL_FROM_ADDRESS`
  - [ ] `ADMIN_EMAIL`

### Test Email
- [ ] Test email berhasil terkirim
- [ ] Email verification berfungsi
- [ ] Email notification admin berfungsi

---

## 💳 Midtrans Configuration

### Account Setup
- [ ] Akun Midtrans sudah dibuat
- [ ] Environment Sandbox sudah dipilih
- [ ] Server Key sudah di-copy
- [ ] Client Key sudah di-copy

### Environment Variables
- [ ] `MIDTRANS_SERVER_KEY` sudah diisi
- [ ] `MIDTRANS_CLIENT_KEY` sudah diisi
- [ ] `MIDTRANS_IS_PRODUCTION=false` (untuk testing)

### Webhook Setup (Development)
- [ ] ngrok terinstall (untuk local testing)
- [ ] ngrok berjalan: `ngrok http 8000`
- [ ] Webhook URL sudah di-set di Midtrans Dashboard
- [ ] Format: `https://xxx.ngrok.io/midtrans/notification`

### Test Payment
- [ ] Payment button muncul di halaman
- [ ] Midtrans popup terbuka
- [ ] Test payment berhasil (gunakan test card)
- [ ] Webhook notification diterima
- [ ] Status pembayaran terupdate otomatis
- [ ] Email ke admin terkirim

---

## 🧪 Testing Checklist

### User Registration & Verification
- [ ] User bisa register
- [ ] Email verifikasi terkirim
- [ ] Link verifikasi berfungsi
- [ ] Email terverifikasi di database
- [ ] Resend verification berfungsi

### Payment Flow
- [ ] User bisa daftar yudisium
- [ ] Halaman pembayaran muncul
- [ ] Midtrans button berfungsi
- [ ] Popup Midtrans muncul
- [ ] Payment berhasil
- [ ] Redirect ke success page
- [ ] Status berubah jadi "lunas"
- [ ] Admin menerima email notifikasi

### Upload Manual
- [ ] Upload bukti bayar berfungsi
- [ ] File tersimpan di storage
- [ ] Status berubah jadi "menunggu_verifikasi"

### Admin Features
- [ ] Admin bisa login
- [ ] Admin bisa lihat list pembayaran
- [ ] Admin bisa verifikasi pembayaran
- [ ] Admin bisa lihat bukti bayar

---

## 🔐 Security Checklist

- [ ] `.env` tidak di-commit ke git
- [ ] `.gitignore` sudah benar
- [ ] APP_KEY sudah di-generate
- [ ] Database password aman
- [ ] Email credentials aman
- [ ] Midtrans credentials aman

---

## 🚀 Production Checklist

### Before Deploy
- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Database backup dibuat
- [ ] `.env.example` sudah update
- [ ] Dokumentasi lengkap

### Midtrans Production
- [ ] Ganti ke Production credentials
- [ ] `MIDTRANS_IS_PRODUCTION=true`
- [ ] Webhook URL production sudah di-set
- [ ] Test payment production

### Server Setup
- [ ] HTTPS enabled (SSL certificate)
- [ ] Domain sudah pointing
- [ ] Webhook URL menggunakan HTTPS
- [ ] Queue worker running (`php artisan queue:work`)
- [ ] Cron job untuk schedule (jika ada)

### Email Production
- [ ] SMTP production sudah di-set
- [ ] Email sending limit cukup
- [ ] SPF/DKIM configured (optional)

---

## 📊 Monitoring

### Logs
- [ ] Laravel logs: `storage/logs/laravel.log`
- [ ] Midtrans logs di dashboard
- [ ] Email logs (jika ada)

### Performance
- [ ] Config cache: `php artisan config:cache`
- [ ] Route cache: `php artisan route:cache`
- [ ] View cache: `php artisan view:cache`

---

## 🐛 Common Issues

### Email tidak terkirim
- [ ] Cek SMTP credentials
- [ ] Cek firewall/port 587
- [ ] Cek logs: `storage/logs/laravel.log`
- [ ] Test dengan Mailtrap dulu

### Midtrans error
- [ ] Cek Server Key & Client Key
- [ ] Cek environment (Sandbox vs Production)
- [ ] Cek webhook URL
- [ ] Cek logs Midtrans

### Migration error
- [ ] Cek database connection
- [ ] Cek database exists
- [ ] Cek user permissions
- [ ] Try: `php artisan migrate:fresh` (⚠️ hapus data!)

---

## ✅ Final Verification

- [ ] Semua fitur berfungsi
- [ ] Tidak ada error di logs
- [ ] Performance acceptable
- [ ] UI/UX smooth
- [ ] Mobile responsive
- [ ] Browser compatibility tested

---

## 📝 Notes

**Tanggal Setup:** _______________

**Versi Laravel:** 12.x

**Versi PHP:** 8.2+

**Database:** MySQL/MariaDB

**Issues Found:**
- 
- 
- 

**Resolved:**
- 
- 
- 

---

**Setup by:** _______________

**Date:** _______________

**Status:** [ ] Development [ ] Staging [ ] Production
