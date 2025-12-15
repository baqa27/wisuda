# 🧪 PANDUAN TESTING SISTEM WISUDA

## ✅ Aplikasi Sudah Berjalan!

- **Laravel Server:** http://localhost:8000
- **Vite Dev Server:** Running ✓

---

## 📋 TESTING CHECKLIST

### 1️⃣ **Test Registrasi & Email Verification**

#### A. Registrasi User Baru
1. Buka browser: http://localhost:8000/register
2. Isi form registrasi:
   - Nama: Test User
   - Email: test@example.com
   - Password: password123
   - Confirm Password: password123
   - NIM: 123456789
   - Prodi: Teknik Informatika
   - IPK: 3.5
3. Klik **Register**

#### B. Cek Email Verification
**Jika Email Sudah Dikonfigurasi:**
- Cek inbox email yang didaftarkan
- Klik link verifikasi di email
- Email akan terverifikasi

**Jika Email Belum Dikonfigurasi:**
- Skip dulu, bisa test fitur lain
- Atau setup email dulu (lihat SETUP_GUIDE.md)

#### C. Login
1. Buka: http://localhost:8000/login
2. Login dengan:
   - Email: test@example.com
   - Password: password123
3. Klik **Login**
4. Akan redirect ke dashboard mahasiswa

---

### 2️⃣ **Test Pendaftaran Yudisium**

1. Setelah login, buka menu **Yudisium**
2. Klik tombol **Daftar Yudisium**
3. Sistem akan generate kode invoice
4. Redirect ke halaman pembayaran

---

### 3️⃣ **Test Pembayaran Midtrans**

#### A. Jika Midtrans Sudah Dikonfigurasi:

1. Di halaman pembayaran, akan muncul tombol:
   **💳 Bayar Yudisium Rp 150.000**

2. Klik tombol tersebut
3. Popup Midtrans akan muncul

4. **Test dengan Credit Card:**
   - Card Number: `4811 1111 1111 1114`
   - CVV: `123`
   - Exp Date: `01/25`
   - Klik **Pay**

5. **Test dengan GoPay:**
   - Pilih GoPay
   - Nomor HP: `081234567890`
   - PIN: `123456`

6. **Test dengan Bank Transfer:**
   - Pilih bank (misal: BCA)
   - Akan dapat virtual account number
   - Simulasi pembayaran di Midtrans Simulator

7. Setelah pembayaran berhasil:
   - Redirect ke success page
   - Status berubah jadi "lunas"
   - Admin menerima email notifikasi (jika email sudah setup)

#### B. Jika Midtrans Belum Dikonfigurasi:

1. Akan muncul warning:
   "Pembayaran online sementara tidak tersedia"

2. Gunakan **Upload Bukti Transfer Manual:**
   - Klik area upload
   - Pilih gambar bukti transfer (JPG/PNG, max 2MB)
   - Preview akan muncul
   - Klik **📤 Upload Bukti Pembayaran**

3. Status berubah jadi "menunggu_verifikasi"
4. Admin perlu approve manual

---

### 4️⃣ **Test Webhook Midtrans (Development)**

**Untuk test webhook di local, butuh ngrok:**

#### Setup ngrok:
```bash
# Download ngrok dari: https://ngrok.com/download
# Jalankan:
ngrok http 8000
```

#### Set Webhook URL:
1. Copy URL dari ngrok (contoh: https://abc123.ngrok.io)
2. Buka Midtrans Dashboard
3. Settings → Configuration
4. Payment Notification URL: `https://abc123.ngrok.io/midtrans/notification`
5. Save

#### Test Webhook:
1. Lakukan pembayaran test
2. Midtrans akan kirim notifikasi ke webhook
3. Cek logs: `storage/logs/laravel.log`
4. Status pembayaran akan update otomatis

---

### 5️⃣ **Test Email Notification ke Admin**

**Jika Email Sudah Dikonfigurasi:**

1. Lakukan pembayaran via Midtrans
2. Setelah payment success
3. Cek email admin (sesuai `ADMIN_EMAIL` di .env)
4. Email notifikasi akan berisi:
   - Kode Invoice
   - Nama & NIM Mahasiswa
   - Total Bayar
   - Metode Pembayaran
   - Tanggal Bayar
   - Link ke Dashboard Admin

**Jika Email Belum Dikonfigurasi:**
- Setup email dulu (lihat SETUP_GUIDE.md)
- Atau gunakan Mailtrap untuk testing

---

### 6️⃣ **Test Admin Dashboard**

#### A. Buat User Admin (Manual di Database)

**Via phpMyAdmin atau MySQL:**
```sql
INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES (
    'Admin', 
    'admin@example.com', 
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin', 
    NOW(), 
    NOW()
);
```
Password: `password`

#### B. Login sebagai Admin
1. Logout dari akun mahasiswa
2. Login dengan:
   - Email: admin@example.com
   - Password: password
3. Akan redirect ke Admin Dashboard

#### C. Verifikasi Pembayaran
1. Menu: **Verifikasi → Pembayaran Yudisium**
2. Lihat list pembayaran
3. Klik **Lihat Bukti** untuk lihat bukti transfer
4. Klik **Setujui** untuk approve
5. Status berubah jadi "lunas"

---

## 🐛 **Troubleshooting Testing**

### Error: "No application encryption key"
```bash
cd wisuda
php artisan key:generate
```

### Midtrans Popup Tidak Muncul
1. Cek browser console (F12)
2. Pastikan `MIDTRANS_CLIENT_KEY` sudah diisi di .env
3. Cek `storage/logs/laravel.log` untuk error

### Email Tidak Terkirim
1. Cek konfigurasi SMTP di .env
2. Test koneksi:
   ```bash
   php artisan tinker
   Mail::raw('Test', function($m) { 
       $m->to('test@example.com')->subject('Test'); 
   });
   ```
3. Cek logs: `storage/logs/laravel.log`

### Upload Bukti Gagal
1. Pastikan `storage/app/public` sudah di-link:
   ```bash
   php artisan storage:link
   ```
2. Cek permission folder storage

### Database Error
1. Cek koneksi database di .env
2. Pastikan database sudah dibuat
3. Jalankan migration:
   ```bash
   php artisan migrate
   ```

---

## 📊 **Monitoring & Logs**

### Laravel Logs
```bash
# Lihat logs real-time
tail -f storage/logs/laravel.log

# Atau buka file:
storage/logs/laravel.log
```

### Midtrans Logs
- Buka Midtrans Dashboard
- Menu: Transactions
- Lihat detail setiap transaksi

### Database
- Cek tabel `pendaftaran_yudisium`
- Kolom penting:
  - `status`: menunggu_pembayaran, lunas, dll
  - `payment_method`: midtrans, manual, dll
  - `paid_at`: timestamp pembayaran

---

## ✅ **Testing Checklist**

- [ ] Registrasi user berhasil
- [ ] Email verification terkirim (jika sudah setup)
- [ ] Login berhasil
- [ ] Daftar yudisium berhasil
- [ ] Halaman pembayaran muncul
- [ ] Midtrans button berfungsi (jika sudah setup)
- [ ] Popup Midtrans muncul
- [ ] Test payment berhasil
- [ ] Redirect ke success page
- [ ] Status berubah jadi "lunas"
- [ ] Email ke admin terkirim (jika sudah setup)
- [ ] Upload manual berfungsi
- [ ] Admin bisa login
- [ ] Admin bisa lihat list pembayaran
- [ ] Admin bisa approve pembayaran

---

## 🎯 **Skenario Testing Lengkap**

### Skenario 1: Payment via Midtrans (Happy Path)
```
1. User register → Email verification → Login
2. Daftar yudisium → Halaman pembayaran
3. Klik "Bayar dengan Midtrans"
4. Pilih Credit Card → Isi data test card
5. Payment success → Redirect ke success page
6. Webhook update status → Email ke admin
7. Admin cek dashboard → Pembayaran sudah lunas
```

### Skenario 2: Upload Manual (Alternative Path)
```
1. User login → Daftar yudisium
2. Upload bukti transfer manual
3. Status: menunggu_verifikasi
4. Admin login → Verifikasi pembayaran
5. Admin approve → Status: lunas
6. User bisa lanjut ke persyaratan
```

### Skenario 3: Payment Failed
```
1. User coba bayar via Midtrans
2. Payment gagal/cancel
3. User tetap di halaman pembayaran
4. Bisa coba lagi atau upload manual
```

---

## 📝 **Test Data**

### Midtrans Test Cards
- **Success:** 4811 1111 1111 1114
- **Failed:** 4911 1111 1111 1113
- **Challenge:** 4411 1111 1111 1118

### Test User
- Email: test@example.com
- Password: password123
- NIM: 123456789

### Admin
- Email: admin@example.com
- Password: password

---

## 🚀 **Next Steps Setelah Testing**

1. ✅ Setup email production (Gmail)
2. ✅ Setup Midtrans production credentials
3. ✅ Deploy ke server dengan HTTPS
4. ✅ Setup webhook production
5. ✅ Test di production environment

---

**Happy Testing! 🎉**

Jika ada error atau pertanyaan, cek `SETUP_GUIDE.md` atau tanya developer.
