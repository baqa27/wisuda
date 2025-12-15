# 🔧 TROUBLESHOOTING: Pembayaran Midtrans Tidak Jalan

## 🔍 Diagnosa Masalah

Pembayaran Midtrans tidak jalan bisa disebabkan oleh beberapa hal:

### 1️⃣ **Midtrans Credentials Belum Diisi**

Cek file `.env` Anda, pastikan ada:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

**❌ SALAH (Masih default):**
```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
```

**✅ BENAR (Sudah diisi):**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-GqXaBC123xyz
MIDTRANS_CLIENT_KEY=SB-Mid-client-ABC123xyz
```

---

## 🚀 CARA SETUP MIDTRANS (Step by Step)

### **Step 1: Daftar Akun Midtrans**

1. Buka: https://dashboard.midtrans.com/register
2. Isi form registrasi:
   - Email bisnis Anda
   - Password
   - Nama bisnis: "Sistem Wisuda" (atau nama lain)
3. Verifikasi email
4. Login ke dashboard

### **Step 2: Pilih Environment Sandbox**

1. Setelah login, di pojok kiri atas ada dropdown
2. Pilih **"Sandbox"** (untuk testing)
3. Jangan pilih "Production" dulu

### **Step 3: Dapatkan Access Keys**

1. Di sidebar kiri, klik **"Settings"**
2. Klik **"Access Keys"**
3. Akan muncul:
   - **Server Key** (dimulai dengan `SB-Mid-server-`)
   - **Client Key** (dimulai dengan `SB-Mid-client-`)
4. **Copy kedua key tersebut**

### **Step 4: Isi ke File .env**

1. Buka file `.env` di folder `wisuda`
2. Cari baris yang ada `MIDTRANS_`
3. Ganti dengan key yang sudah di-copy:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-[paste-server-key-disini]
MIDTRANS_CLIENT_KEY=SB-Mid-client-[paste-client-key-disini]
MIDTRANS_IS_PRODUCTION=false
```

4. **Save file .env**

### **Step 5: Clear Config Cache**

Jalankan command ini:

```bash
cd wisuda
php artisan config:clear
php artisan cache:clear
```

### **Step 6: Restart Server**

1. Stop server Laravel (Ctrl+C di terminal)
2. Jalankan lagi:
   ```bash
   php artisan serve
   ```

---

## ✅ CEK APAKAH SUDAH BENAR

### **Test 1: Cek Konfigurasi**

Jalankan script checker:
```bash
php check_midtrans.php
```

Harus muncul:
```
✅ MIDTRANS_SERVER_KEY: SB-Mid-ser...
✅ MIDTRANS_CLIENT_KEY: SB-Mid-cli...
✅ MIDTRANS_IS_PRODUCTION: false
```

### **Test 2: Cek di Browser**

1. Buka halaman pembayaran yudisium
2. Buka Developer Console (F12)
3. Lihat tab **Console**
4. Seharusnya tidak ada error JavaScript
5. Tombol **"💳 Bayar Yudisium"** harus muncul

### **Test 3: Klik Tombol Bayar**

1. Klik tombol **"💳 Bayar Yudisium Rp 150.000"**
2. Popup Midtrans harus muncul
3. Jika tidak muncul, cek Console untuk error

---

## 🐛 TROUBLESHOOTING ERRORS

### **Error: "snapToken is null"**

**Penyebab:** Server Key salah atau tidak valid

**Solusi:**
1. Cek Server Key di .env
2. Pastikan dimulai dengan `SB-Mid-server-`
3. Copy ulang dari Midtrans Dashboard
4. Clear config: `php artisan config:clear`

### **Error: "Client key is invalid"**

**Penyebab:** Client Key salah

**Solusi:**
1. Cek Client Key di .env
2. Pastikan dimulai dengan `SB-Mid-client-`
3. Copy ulang dari Midtrans Dashboard

### **Error: Popup tidak muncul**

**Penyebab:** JavaScript error atau Snap.js tidak load

**Solusi:**
1. Buka Developer Console (F12)
2. Lihat error di tab Console
3. Pastikan internet connection stabil
4. Refresh halaman (Ctrl+F5)

### **Error: "Midtrans Error" di logs**

**Penyebab:** API request gagal

**Solusi:**
1. Cek `storage/logs/laravel.log`
2. Lihat detail error
3. Biasanya karena credentials salah
4. Atau amount tidak valid (harus integer)

---

## 📝 CHECKLIST SETUP MIDTRANS

- [ ] Sudah daftar akun Midtrans
- [ ] Sudah verifikasi email
- [ ] Sudah login ke dashboard
- [ ] Sudah pilih environment "Sandbox"
- [ ] Sudah copy Server Key
- [ ] Sudah copy Client Key
- [ ] Sudah isi ke file .env
- [ ] Sudah save file .env
- [ ] Sudah run `php artisan config:clear`
- [ ] Sudah restart server
- [ ] Tombol bayar sudah muncul
- [ ] Popup Midtrans sudah muncul saat diklik

---

## 🧪 TEST PAYMENT

Setelah setup benar, test dengan:

### **Credit Card Test:**
- Card Number: `4811 1111 1111 1114`
- CVV: `123`
- Exp Date: `01/25`
- 3DS Password: `112233`

### **GoPay Test:**
- Nomor HP: `081234567890`
- PIN: `123456`

### **Bank Transfer Test:**
- Pilih bank apa saja
- Akan dapat virtual account number
- Simulasi pembayaran di Midtrans Simulator

---

## 🔄 JIKA MASIH TIDAK JALAN

### **Option 1: Gunakan Upload Manual**

Jika Midtrans masih bermasalah, user bisa upload bukti transfer manual:
1. Scroll ke bawah di halaman pembayaran
2. Ada section "Upload Bukti Transfer Manual"
3. Upload foto bukti transfer
4. Admin akan verifikasi manual

### **Option 2: Debug Lebih Lanjut**

1. **Cek logs Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek browser console:**
   - Buka Developer Tools (F12)
   - Tab Console
   - Lihat error JavaScript

3. **Test API Midtrans:**
   ```bash
   php artisan tinker
   ```
   ```php
   Config::get('midtrans.server_key')
   Config::get('midtrans.client_key')
   ```

4. **Cek network request:**
   - F12 → Tab Network
   - Klik tombol bayar
   - Lihat request ke Midtrans API
   - Cek response

---

## 📞 BANTUAN LEBIH LANJUT

### **Dokumentasi Midtrans:**
- https://docs.midtrans.com/
- https://docs.midtrans.com/docs/snap-integration-guide

### **Support Midtrans:**
- Email: support@midtrans.com
- Live Chat di dashboard

### **Cek Status Midtrans:**
- https://status.midtrans.com/

---

## 💡 TIPS

1. **Gunakan Sandbox dulu** untuk testing, jangan langsung Production
2. **Save credentials** di tempat aman (password manager)
3. **Jangan commit .env** ke Git
4. **Test dengan berbagai metode** pembayaran
5. **Setup webhook** untuk auto-update status (lihat SETUP_GUIDE.md)

---

## ✅ VERIFIKASI FINAL

Jika semua sudah benar:

1. ✅ Tombol "Bayar Yudisium" muncul
2. ✅ Popup Midtrans muncul saat diklik
3. ✅ Bisa pilih metode pembayaran
4. ✅ Test payment berhasil
5. ✅ Redirect ke success page
6. ✅ Status berubah jadi "lunas"

---

**Jika masih ada masalah, screenshot error dan tanyakan ke developer!**
