# 📱 Panduan Integrasi QR Scan API - Sistem Wisuda

## Informasi Server

| Item | Nilai |
|------|-------|
| **Base URL** | `http://192.168.1.6:8000` |
| **Format** | JSON |
| **Content-Type** | `application/json` |

> ⚠️ IP dapat berubah! Hubungi tim wisuda untuk konfirmasi IP terbaru.

---

## 🚀 Quick Start

### 1. Test Koneksi
```bash
curl http://192.168.1.6:8000/api/qr/stats
```

### 2. Scan QR Code
QR Code berisi JSON dengan format:
```json
{
  "token": "abc123...",
  "kode_unik": "150108_1234567890",
  "mahasiswa": { ... },
  "keluarga": { ... }
}
```

### 3. Checkin Presensi
```bash
curl -X POST http://192.168.1.6:8000/api/qr/checkin \
  -H "Content-Type: application/json" \
  -d '{"token":"dari_qr", "kode_unik":"dari_qr"}'
```

---

## 📋 Daftar Endpoint

### 1️⃣ SCAN - Preview Data (Tanpa Checkin)
```
POST /api/qr/scan
```

**Request:**
```json
{
  "token": "32-char-token-dari-qr",
  "kode_unik": "kode-dari-qr"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "QR Code valid",
  "data": {
    "qr": {
      "token": "...",
      "status": "aktif",
      "is_used": false,
      "is_active": true
    },
    "mahasiswa": {
      "nim": "2023150108",
      "nama": "Muhammad Sultan Baqa",
      "email": "2023150108@student.wisuda.ac.id",
      "no_hp": "081234567890",
      "prodi": "Teknik Informatika",
      "ipk": 3.75,
      "semester": 4
    },
    "keluarga": {
      "ortu_1": "Nama Ayah",
      "ortu_2": "Nama Ibu",
      "tamu_1": "Nama Tamu 1",
      "tamu_2": "Nama Tamu 2"
    },
    "wisuda": {
      "status": "siap_wisuda"
    }
  }
}
```

---

### 2️⃣ VERIFY - Cek Validitas QR
```
POST /api/qr/verify
```

**Request:** Sama seperti SCAN

**Response:**
```json
{
  "success": true,
  "valid": true,
  "message": "QR valid dan aktif",
  "data": {
    "nim": "2023150108",
    "nama": "Muhammad Sultan Baqa",
    "status_qr": "aktif",
    "is_used": false,
    "is_expired": false,
    "is_active": true
  }
}
```

---

### 3️⃣ CHECKIN - Presensi ⭐ (Endpoint Utama)
```
POST /api/qr/checkin
```

**Request:**
```json
{
  "token": "32-char-token-dari-qr",
  "kode_unik": "kode-dari-qr"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Presensi berhasil dicatat!",
  "data": {
    "qr": {
      "status": "digunakan",
      "waktu_checkin": "2025-12-08 22:00:00"
    },
    "mahasiswa": {
      "nim": "2023150108",
      "nama": "Muhammad Sultan Baqa",
      "prodi": "Teknik Informatika"
    },
    "keluarga": { ... }
  }
}
```

**Response Error - Sudah Digunakan:**
```json
{
  "success": false,
  "message": "QR sudah digunakan sebelumnya",
  "error_code": "QR_ALREADY_USED",
  "data": {
    "nama": "Muhammad Sultan Baqa",
    "waktu_checkin": "2025-12-08 22:00:00"
  }
}
```

---

### 4️⃣ DETAIL - Info Lengkap dari Token
```
GET /api/qr/detail/{token}
```

**Contoh:**
```
GET /api/qr/detail/abc123def456...
```

---

### 5️⃣ STATUS - Cek Status Presensi
```
GET /api/qr/status/{token}
```

---

### 6️⃣ STATS - Statistik Keseluruhan
```
GET /api/qr/stats
```

**Response:**
```json
{
  "success": true,
  "data": {
    "statistik": {
      "total_qr": 100,
      "qr_aktif": 45,
      "qr_digunakan": 55,
      "persentase_hadir": 55.0
    },
    "recent_checkins": [
      {
        "nim": "2023150108",
        "nama": "Muhammad Sultan Baqa",
        "waktu_checkin": "2025-12-08 22:00:00"
      }
    ]
  }
}
```

---

### 7️⃣ LIST - Daftar Semua Presensi
```
GET /api/qr/list-presensi
```

---

## ❌ Error Codes

| Code | HTTP Status | Deskripsi |
|------|-------------|-----------|
| `QR_NOT_FOUND` | 404 | QR tidak ditemukan / token salah |
| `QR_ALREADY_USED` | 400 | QR sudah digunakan |
| `QR_EXPIRED` | 400 | QR sudah expired |

---

## 💻 Contoh Implementasi

### JavaScript (Fetch)
```javascript
const BASE_URL = "http://192.168.1.6:8000";

// Fungsi untuk checkin
async function checkinQR(qrData) {
  try {
    const response = await fetch(`${BASE_URL}/api/qr/checkin`, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json" 
      },
      body: JSON.stringify({
        token: qrData.token,
        kode_unik: qrData.kode_unik
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      console.log("✅ Presensi berhasil:", result.data.mahasiswa.nama);
    } else {
      console.log("❌ Gagal:", result.message);
    }
    
    return result;
  } catch (error) {
    console.error("Error:", error);
  }
}

// Cara pakai setelah scan QR
const qrContent = JSON.parse(scannedQRText);
checkinQR(qrContent);
```

### JavaScript (Axios)
```javascript
const axios = require('axios');

const BASE_URL = "http://192.168.1.6:8000";

async function checkinQR(token, kodeUnik) {
  try {
    const { data } = await axios.post(`${BASE_URL}/api/qr/checkin`, {
      token: token,
      kode_unik: kodeUnik
    });
    return data;
  } catch (error) {
    return error.response.data;
  }
}
```

### PHP (cURL)
```php
<?php
$baseUrl = "http://192.168.1.6:8000";

function checkinQR($token, $kodeUnik) {
    global $baseUrl;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$baseUrl/api/qr/checkin");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'token' => $token,
        'kode_unik' => $kodeUnik
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}
```

### Python (Requests)
```python
import requests

BASE_URL = "http://192.168.1.6:8000"

def checkin_qr(token, kode_unik):
    response = requests.post(
        f"{BASE_URL}/api/qr/checkin",
        json={
            "token": token,
            "kode_unik": kode_unik
        }
    )
    return response.json()

# Cara pakai
result = checkin_qr("token_dari_qr", "kode_dari_qr")
print(result)
```

---

## 📱 Flow Integrasi

```
┌─────────────────┐
│  Scan QR Code   │
│  (Kamera/File)  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Parse JSON     │
│  dari QR        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ POST /api/qr/   │
│    checkin      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Tampilkan Hasil │
│ (Sukses/Gagal)  │
└─────────────────┘
```

---

## 📞 Kontak Tim Wisuda

- **Developer:** Muhammad Sultan Baqa
- **NIM:** 2023150108
- **Email:** sultanbaqa25@gmail.com

---

> **Last Updated:** 2025-12-08 22:15 WIB
