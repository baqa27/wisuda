# 💳 FITUR PILIH METODE PEMBAYARAN

## ✨ Update Terbaru

Sistem pembayaran sekarang memiliki **UI yang lebih user-friendly** dengan pilihan metode pembayaran yang jelas!

---

## 🎨 Tampilan Baru

### **Sebelum:**
- Hanya ada 1 tombol "Bayar dengan Midtrans"
- User tidak tahu metode apa saja yang tersedia

### **Sesudah:**
- Ada 3 kartu pilihan metode pembayaran:
  - 💰 **DANA** (E-Wallet)
  - 📱 **QRIS** (Scan QR)
  - 🏦 **BANK** (Transfer Bank)
- User pilih metode dulu, baru klik "Konfirmasi"
- Popup Midtrans akan fokus ke metode yang dipilih

---

## 🚀 Cara Menggunakan

### **Step 1: Pilih Metode Pembayaran**

Di halaman pembayaran, akan muncul 3 kartu:

```
┌─────────┐  ┌─────────┐  ┌─────────┐
│  💰     │  │  📱     │  │  🏦     │
│  DANA   │  │  QRIS   │  │  BANK   │
└─────────┘  └─────────┘  └─────────┘
```

Klik salah satu kartu:
- Kartu akan **berubah warna biru** (selected)
- Tombol "Konfirmasi" akan **aktif**
- Muncul teks: "Metode: [nama metode]"

### **Step 2: Klik Konfirmasi**

Setelah pilih metode, klik tombol **"Konfirmasi"**

### **Step 3: Popup Midtrans Muncul**

Popup Midtrans akan muncul dengan metode yang sudah dipilih:

- **Pilih DANA** → Popup fokus ke GoPay, ShopeePay, DANA
- **Pilih QRIS** → Popup fokus ke QRIS
- **Pilih BANK** → Popup fokus ke Transfer Bank (BCA, Mandiri, BNI, dll)

### **Step 4: Bayar**

Pilih metode spesifik di popup Midtrans dan selesaikan pembayaran.

---

## 🎯 Metode Pembayaran yang Tersedia

### 1️⃣ **E-Wallet (DANA)**
Ketika dipilih, akan muncul:
- GoPay
- ShopeePay  
- OVO (via QRIS)
- DANA (via QRIS)
- LinkAja (via QRIS)

### 2️⃣ **QRIS**
Ketika dipilih, akan muncul:
- QRIS (Universal QR Code)
- Bisa dibayar dengan semua e-wallet yang support QRIS

### 3️⃣ **Transfer Bank**
Ketika dipilih, akan muncul:
- BCA Virtual Account
- Mandiri Virtual Account
- BNI Virtual Account
- BRI Virtual Account
- Permata Virtual Account
- Bank lainnya

---

## 💡 Keuntungan Fitur Ini

✅ **User-Friendly**
- User tahu metode apa saja yang tersedia
- Tidak bingung saat popup Midtrans muncul

✅ **Lebih Cepat**
- Popup langsung fokus ke metode yang dipilih
- Tidak perlu scroll mencari metode

✅ **Visual yang Jelas**
- Kartu dengan icon yang mudah dipahami
- Feedback visual saat dipilih (warna biru)

✅ **Flexible**
- Masih bisa pilih metode spesifik di popup
- Tidak membatasi pilihan user

---

## 🎨 Customization

### **Mengubah Icon**

Edit file `upload_bukti.blade.php`, cari bagian payment cards:

```html
<!-- DANA Card -->
<div class="payment-method-card" data-method="ewallet">
    <div class="text-[#008CEB] text-[48px] mb-2">
        <i class="fas fa-wallet"></i> <!-- Ganti icon di sini -->
    </div>
    <span>DANA</span>
</div>
```

Icon yang bisa digunakan (Font Awesome):
- `fa-wallet` - Dompet
- `fa-qrcode` - QR Code
- `fa-university` - Bank
- `fa-credit-card` - Kartu Kredit
- `fa-mobile-alt` - HP

### **Menambah Metode Baru**

Tambahkan kartu baru:

```html
<div class="payment-method-card" data-method="credit_card">
    <div class="text-[#FF6B6B] text-[48px] mb-2">
        <i class="fas fa-credit-card"></i>
    </div>
    <span>KARTU</span>
</div>
```

Update JavaScript:

```javascript
const methodNames = {
    'ewallet': 'E-Wallet',
    'qris': 'QRIS',
    'bank_transfer': 'Transfer Bank',
    'credit_card': 'Kartu Kredit' // Tambah ini
};

// Tambah kondisi di enabledPayments
if (selectedMethod === 'credit_card') {
    snapOptions.enabledPayments = ['credit_card'];
}
```

---

## 🧪 Testing

### **Test 1: Pilih DANA**
1. Klik kartu DANA
2. Kartu berubah biru
3. Klik Konfirmasi
4. Popup muncul dengan fokus ke GoPay/ShopeePay
5. Pilih GoPay
6. Test dengan nomor: `081234567890`, PIN: `123456`

### **Test 2: Pilih QRIS**
1. Klik kartu QRIS
2. Klik Konfirmasi
3. Popup muncul dengan QR Code
4. Scan dengan app e-wallet
5. Bayar

### **Test 3: Pilih Bank**
1. Klik kartu BANK
2. Klik Konfirmasi
3. Popup muncul dengan pilihan bank
4. Pilih BCA
5. Dapat virtual account number
6. Simulasi pembayaran

---

## 🐛 Troubleshooting

### **Tombol Konfirmasi Tidak Aktif**

**Penyebab:** Belum pilih metode

**Solusi:** Klik salah satu kartu metode pembayaran

### **Kartu Tidak Bisa Diklik**

**Penyebab:** JavaScript error

**Solusi:**
1. Buka Developer Console (F12)
2. Lihat error di tab Console
3. Refresh halaman (Ctrl+F5)

### **Popup Tidak Muncul**

**Penyebab:** Midtrans credentials salah

**Solusi:**
1. Cek file `.env`
2. Pastikan `MIDTRANS_CLIENT_KEY` sudah benar
3. Clear cache: `php artisan config:clear`

---

## 📊 Flow Diagram

```
User masuk halaman pembayaran
         ↓
Lihat 3 kartu metode (DANA, QRIS, BANK)
         ↓
Klik salah satu kartu
         ↓
Kartu berubah biru (selected)
         ↓
Tombol "Konfirmasi" aktif
         ↓
Klik "Konfirmasi"
         ↓
Popup Midtrans muncul
         ↓
Fokus ke metode yang dipilih
         ↓
User pilih metode spesifik & bayar
         ↓
Pembayaran berhasil
         ↓
Redirect ke success page
```

---

## 🎯 Best Practices

1. **Pilih metode yang paling sering digunakan**
   - Jika target user mahasiswa, QRIS & E-Wallet lebih populer
   - Jika target user umum, Bank Transfer lebih familiar

2. **Berikan informasi yang jelas**
   - Jelaskan setiap metode
   - Berikan contoh (misal: "DANA, OVO, GoPay")

3. **Test semua metode**
   - Pastikan semua metode berfungsi
   - Test di berbagai device (mobile, desktop)

4. **Monitor penggunaan**
   - Cek metode mana yang paling banyak digunakan
   - Optimalkan berdasarkan data

---

## 📝 Changelog

**v2.0 - 7 Desember 2025**
- ✅ Added payment method selection cards
- ✅ Added visual feedback for selected method
- ✅ Added enable/disable state for confirm button
- ✅ Added method filtering in Midtrans popup
- ✅ Improved UX with centered layout

**v1.0 - Sebelumnya**
- Basic Midtrans integration
- Single payment button

---

**Fitur ini membuat proses pembayaran lebih intuitif dan user-friendly! 🎉**
