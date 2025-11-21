# 📱 API QR Code Presensi Wisuda - Dokumentasi Integrasi

## 🎯 Tujuan
Sistem QR code presensi ini dirancang untuk dapat digunakan oleh aplikasi/sistem lain. Setiap QR code yang di-generate berisi JSON payload yang memiliki:
- `token`: Identifier unik untuk QR
- `kode_unik`: Kode tambahan untuk validasi
- `nim`: NIM mahasiswa
- `timestamp`: Waktu pembuatan
- `checkin_url`: URL API endpoint untuk check-in

---

## 🔌 API Endpoints

### 1. Check-In Presensi
**Endpoint:** `POST /api/qr/checkin`

Mengirim token dan kode_unik yang ada di QR code untuk melakukan check-in.

**Request Body (JSON):**
```json
{
  "token": "a1b2c3d4e5f6...",
  "kode_unik": "123456_1731705600"
}
```

**Response (Sukses - 200):**
```json
{
  "success": true,
  "message": "Presensi berhasil dicatat",
  "data": {
    "nama": "John Doe",
    "nim": "2023150001",
    "prodi": "Teknik Informatika",
    "waktu_checkin": "15/11/2025 10:30:45",
    "status": "digunakan"
  }
}
```

**Response (Error - 400):**
```json
{
  "success": false,
  "message": "QR tidak valid, sudah digunakan, atau expired"
}
```

---

### 2. Cek Status QR
**Endpoint:** `GET /api/qr/status/{token}`

Melihat status QR tanpa melakukan check-in.

**Example URL:**
```
GET http://localhost:8000/api/qr/status/a1b2c3d4e5f6...
```

**Response (Sukses - 200):**
```json
{
  "success": true,
  "data": {
    "nama": "John Doe",
    "nim": "2023150001",
    "status": "aktif",
    "waktu_checkin": null,
    "expired_at": "22/11/2025 10:30:00",
    "is_expired": false,
    "is_used": false
  }
}
```

---

### 3. Lihat Semua Presensi
**Endpoint:** `GET /api/qr/list-presensi`

Melihat daftar lengkap semua presensi yang sudah terjadi (untuk laporan/dashboard).

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "nim": "2023150001",
      "nama": "John Doe",
      "prodi": "Teknik Informatika",
      "status": "digunakan",
      "waktu_checkin": "15/11/2025 10:30:45",
      "waktu_generate": "15/11/2025 08:00:00",
      "qr_url": "http://localhost:8000/storage/qr_codes/qr_2023150001_1731705600.png"
    },
    {
      "nim": "2023150002",
      "nama": "Jane Smith",
      "prodi": "Sistem Informasi",
      "status": "aktif",
      "waktu_checkin": null,
      "waktu_generate": "15/11/2025 08:00:00",
      "qr_url": "http://localhost:8000/storage/qr_codes/qr_2023150002_1731705601.png"
    }
  ]
}
```

---

### 4. Download File QR
**Endpoint:** `GET /api/qr/file/{id}`

Download file PNG QR code berdasarkan ID record di database.

**Example URL:**
```
GET http://localhost:8000/api/qr/file/1
```

**Response:** File PNG (bisa langsung ditampilkan atau disimpan)

---

## 💻 Contoh Implementasi di Aplikasi Lain

### JavaScript / Frontend
```javascript
// Kirim check-in request
async function submitQRCheckin(token, kodeUnik) {
  try {
    const response = await fetch('http://localhost:8000/api/qr/checkin', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        token: token,
        kode_unik: kodeUnik
      })
    });

    const result = await response.json();

    if (result.success) {
      console.log(`Presensi berhasil: ${result.data.nama}`);
      // Update UI / tampilkan pesan sukses
    } else {
      console.error(result.message);
      // Tampilkan error ke user
    }
  } catch (error) {
    console.error('Request error:', error);
  }
}

// Cek status QR
async function checkQRStatus(token) {
  try {
    const response = await fetch(`http://localhost:8000/api/qr/status/${token}`);
    const result = await response.json();
    console.log(result.data);
  } catch (error) {
    console.error('Request error:', error);
  }
}

// Ambil semua presensi
async function getPresensiList() {
  try {
    const response = await fetch('http://localhost:8000/api/qr/list-presensi');
    const result = await response.json();
    console.log(result.data);
  } catch (error) {
    console.error('Request error:', error);
  }
}
```

### Python
```python
import requests
import json

API_URL = "http://localhost:8000"

# Check-in dengan token dan kode_unik
def submit_qr_checkin(token, kode_unik):
    url = f"{API_URL}/api/qr/checkin"
    data = {
        "token": token,
        "kode_unik": kode_unik
    }
    response = requests.post(url, json=data)
    result = response.json()
    print(result)
    return result

# Cek status QR
def check_qr_status(token):
    url = f"{API_URL}/api/qr/status/{token}"
    response = requests.get(url)
    result = response.json()
    print(result)
    return result

# Lihat semua presensi
def get_presensi_list():
    url = f"{API_URL}/api/qr/list-presensi"
    response = requests.get(url)
    result = response.json()
    print(json.dumps(result, indent=2))
    return result

# Download file QR
def download_qr_file(qr_id):
    url = f"{API_URL}/api/qr/file/{qr_id}"
    response = requests.get(url)
    if response.status_code == 200:
        with open(f"qr_{qr_id}.png", "wb") as f:
            f.write(response.content)
        print(f"QR file saved as qr_{qr_id}.png")
```

### cURL (Command Line)
```bash
# Check-in
curl -X POST http://localhost:8000/api/qr/checkin \
  -H "Content-Type: application/json" \
  -d '{"token":"a1b2c3d4e5f6...","kode_unik":"123456_1731705600"}'

# Cek status
curl http://localhost:8000/api/qr/status/a1b2c3d4e5f6...

# Lihat presensi
curl http://localhost:8000/api/qr/list-presensi

# Download QR file
curl -o qr_1.png http://localhost:8000/api/qr/file/1
```

---

## 📊 QR Code Payload Structure

Ketika QR code di-scan, payload JSON-nya terlihat seperti ini:

```json
{
  "token": "f1e2d3c4b5a6789d0e1f2a3b4c5d6e7f",
  "kode_unik": "150001_1731705600",
  "nim": "2023150001",
  "timestamp": 1731705600,
  "checkin_url": "http://localhost:8000/api/qr/checkin"
}
```

**Penjelasan:**
- `token`: String acak 32 karakter untuk identifikasi unik QR
- `kode_unik`: Gabungan 6 digit terakhir NIM + timestamp pembuatan
- `nim`: NIM mahasiswa pemilik QR
- `timestamp`: Unix timestamp saat QR dibuat
- `checkin_url`: URL untuk mengirim check-in (dapat dipanggil langsung dari mobile app/scanner)

---

## 🔐 Keamanan

### Fitur Keamanan
1. **Token Unik**: Setiap QR memiliki token 128-bit (32 hex chars) yang unik
2. **Validasi Ganda**: Memerlukan token + kode_unik untuk check-in
3. **Expiry Time**: QR otomatis kadaluarsa setelah 7 hari
4. **Status Tracking**: QR berubah status menjadi "digunakan" setelah 1x check-in
5. **Timestamp Recording**: Setiap check-in merekam waktu secara akurat

### Best Practice
- ✅ Jangan share token/kode_unik publik
- ✅ Validate hasil API response di aplikasi client
- ✅ Implement retry logic dengan exponential backoff
- ✅ Cache hasil presensi untuk offline mode jika diperlukan
- ✅ Encrypt token jika disimpan di client-side

---

## 🚀 Testing

### Test Check-In
1. Admin generate QR code dari halaman admin
2. Scan QR code dan extract token + kode_unik
3. Kirim POST request ke `/api/qr/checkin`
4. Verifikasi status berubah menjadi "digunakan"

### Test Status
1. Kirim GET request ke `/api/qr/status/{token}`
2. Verifikasi status "aktif" atau "digunakan"
3. Verifikasi expiry time tidak terlampaui

---

## 📝 Notes

- Semua response berisi `success` boolean untuk memudahkan error handling
- Error message dalam Bahasa Indonesia untuk kemudahan pengguna
- Timestamp menggunakan format `d/m/Y H:i:s` (Indonesian format)
- QR file disimpan di `storage/app/public/qr_codes/`

---

**Dokumentasi Last Updated:** 15 November 2025  
**API Version:** 1.0.0
