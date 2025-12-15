# QR Scan API Documentation

API untuk sistem eksternal yang ingin mengintegrasikan fitur scan QR presensi wisuda.

## Base URL
```
http://your-domain.com/api/qr
```

---

## Endpoints

### 1. Scan QR (Preview)
Scan QR dan dapatkan data lengkap **tanpa** mengubah status.

```
POST /api/qr/scan
```

**Request Body:**
```json
{
  "token": "abc123...",
  "kode_unik": "150108_1234567890"
}
```

**Response:**
```json
{
  "success": true,
  "message": "QR Code valid",
  "data": {
    "qr": {
      "token": "abc123...",
      "kode_unik": "150108_1234567890",
      "status": "aktif",
      "is_used": false,
      "is_active": true,
      "waktu_checkin": null,
      "generated_at": "2025-12-08 22:00:00"
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
      "ortu_1": "Nama Orang Tua 1",
      "ortu_2": "Nama Orang Tua 2",
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

### 2. Verify QR
Cek apakah QR valid, expired, atau sudah digunakan.

```
POST /api/qr/verify
```

**Request Body:**
```json
{
  "token": "abc123...",
  "kode_unik": "150108_1234567890"
}
```

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

### 3. Checkin (Mark as Used)
Tandai QR sebagai **digunakan** untuk presensi.

```
POST /api/qr/checkin
```

**Request Body:**
```json
{
  "token": "abc123...",
  "kode_unik": "150108_1234567890"
}
```

**Success Response:**
```json
{
  "success": true,
  "message": "Presensi berhasil dicatat!",
  "data": { ... }
}
```

**Error - Already Used:**
```json
{
  "success": false,
  "message": "QR sudah digunakan sebelumnya",
  "error_code": "QR_ALREADY_USED"
}
```

---

### 4. Get Detail
Dapatkan data lengkap dari token QR.

```
GET /api/qr/detail/{token}
```

---

### 5. Get Status
Cek status presensi dari token QR.

```
GET /api/qr/status/{token}
```

---

### 6. Get Statistics
Statistik keseluruhan presensi wisuda.

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
    "recent_checkins": [...]
  }
}
```

---

### 7. List All Presensi
Daftar semua presensi yang terdaftar.

```
GET /api/qr/list-presensi
```

---

### 8. View QR File
Lihat/download file QR image.

```
GET /api/qr/file/{id}
```

---

## Error Codes

| Code | Description |
|------|-------------|
| `QR_NOT_FOUND` | QR tidak ditemukan atau invalid |
| `QR_ALREADY_USED` | QR sudah digunakan sebelumnya |
| `QR_EXPIRED` | QR sudah melewati tanggal expired |

---

## QR Code Content Structure

Isi QR Code dalam format JSON:

```json
{
  "token": "32-char-unique-token",
  "kode_unik": "nim_timestamp",
  "mahasiswa": {
    "nim": "2023150108",
    "nama": "Muhammad Sultan Baqa",
    "email": "...",
    "prodi": "Teknik Informatika",
    "ipk": 3.75,
    "semester": 4
  },
  "keluarga": {
    "ortu_1": "...",
    "ortu_2": "...",
    "tamu_1": "...",
    "tamu_2": "..."
  },
  "wisuda": {
    "status": "siap_wisuda",
    "generated_at": "2025-12-08 22:00:00"
  },
  "api": {
    "base_url": "http://localhost:8000",
    "checkin_url": "http://localhost:8000/api/qr/checkin",
    "verify_url": "http://localhost:8000/api/qr/verify",
    "detail_url": "http://localhost:8000/api/qr/detail/{token}",
    "scan_url": "http://localhost:8000/api/qr/scan"
  }
}
```

---

## Contoh Penggunaan (JavaScript)

```javascript
// Scan QR
async function scanQR(token, kodeUnik) {
  const response = await fetch('http://your-domain.com/api/qr/scan', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ token, kode_unik: kodeUnik })
  });
  return await response.json();
}

// Checkin
async function checkinQR(token, kodeUnik) {
  const response = await fetch('http://your-domain.com/api/qr/checkin', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ token, kode_unik: kodeUnik })
  });
  return await response.json();
}
```
