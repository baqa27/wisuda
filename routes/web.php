<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\WisudaController;
use App\Http\Controllers\YudisiumController;
use Illuminate\Support\Facades\Route;

// ==========================
// 🏠 HALAMAN UTAMA
// ==========================
Route::get('/', function () {
    return view('auth.login');
})->name('home');

// ==========================
// 🧍‍♂️ GUEST (Belum Login)
// ==========================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==========================
// 🔒 AUTH (Sudah Login)
// ==========================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ======================
    // 🎓 MAHASISWA ROUTES
    // ======================
    Route::middleware('role:mahasiswa')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        // ---- Yudisium ----
        Route::prefix('yudisium')->group(function () {
            Route::get('/', [YudisiumController::class, 'index'])->name('yudisium.index');
            Route::post('/daftar', [YudisiumController::class, 'daftarYudisium'])->name('yudisium.daftar');

            // Bukti Bayar
            Route::get('/upload-bukti/{id}', [YudisiumController::class, 'showUploadBukti'])->name('yudisium.upload-bukti');
            Route::put('/upload-bukti/{id}', [YudisiumController::class, 'prosesUploadBukti'])->name('yudisium.proses-upload-bukti');
            Route::get('/download-bukti/{filename}', [YudisiumController::class, 'downloadBuktiBayar'])->name('yudisium.download-bukti');

            // Persyaratan
            Route::get('/persyaratan', [YudisiumController::class, 'showFormPersyaratan'])->name('yudisium.persyaratan.form');
            Route::post('/persyaratan', [YudisiumController::class, 'simpanPersyaratan'])->name('yudisium.persyaratan.simpan');
            Route::get('/persyaratan/edit', [YudisiumController::class, 'editPersyaratan'])->name('yudisium.persyaratan.edit');
            Route::put('/persyaratan/update', [YudisiumController::class, 'updatePersyaratan'])->name('yudisium.persyaratan.update');

            // Download
            Route::get('/download/{filename}', [YudisiumController::class, 'downloadFile'])->name('yudisium.download');
        });

        // ---- Wisuda ----
        Route::prefix('wisuda')->group(function () {
            Route::get('/', [WisudaController::class, 'index'])->name('wisuda.index');
            Route::post('/daftar', [WisudaController::class, 'daftarWisuda'])->name('wisuda.daftar');

            // Pembayaran
            Route::get('/upload-bukti/{id}', [WisudaController::class, 'showPembayaran'])->name('wisuda.upload-bukti');
            Route::post('/upload-bukti/{id}', [WisudaController::class, 'prosesPembayaran'])->name('wisuda.proses-pembayaran');

            // Persyaratan
            Route::get('/persyaratan', [WisudaController::class, 'showFormPersyaratan'])->name('wisuda.persyaratan.form');
            Route::post('/persyaratan/upload', [WisudaController::class, 'uploadPersyaratan'])->name('wisuda.persyaratan.upload');
            Route::delete('/persyaratan/hapus/{id}', [WisudaController::class, 'hapusPersyaratan'])->name('wisuda.persyaratan.hapus');

            // Data Tambahan
            Route::get('/data-tambahan', [WisudaController::class, 'showFormDataTambahan'])->name('wisuda.data-tambahan');
            Route::post('/data-tambahan', [WisudaController::class, 'simpanDataTambahan'])->name('wisuda.data-tambahan.simpan');

            // Download
            Route::get('/download/{filename}', [WisudaController::class, 'downloadFileWisuda'])->name('wisuda.download');
        });
    });

    // ======================
    // 👨‍💼 ADMIN ROUTES
    // ======================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // ---- Verifikasi ----
        Route::prefix('verifikasi')->group(function () {
            // Yudisium
            Route::get('/pembayaran-yudisium', [AdminController::class, 'verifikasiPembayaranYudisium'])->name('admin.verifikasi.pembayaran-yudisium');
            Route::put('/pembayaran-yudisium/{id}', [AdminController::class, 'updatePembayaranYudisium'])->name('admin.verifikasi.pembayaran-yudisium.update');

            Route::get('/persyaratan-yudisium', [AdminController::class, 'verifikasiPersyaratanYudisium'])->name('admin.verifikasi.persyaratan-yudisium');
            Route::put('/persyaratan-yudisium/{id}', [AdminController::class, 'updatePersyaratanYudisium'])->name('admin.verifikasi.persyaratan-yudisium.update');

            // Wisuda
            Route::get('/pembayaran-wisuda', [AdminController::class, 'verifikasiPembayaranWisuda'])->name('admin.verifikasi.pembayaran-wisuda');
            Route::put('/pembayaran-wisuda/{id}', [AdminController::class, 'updatePembayaranWisuda'])->name('admin.verifikasi.pembayaran-wisuda.update');

            Route::get('/persyaratan-wisuda', [AdminController::class, 'verifikasiPersyaratanWisuda'])->name('admin.verifikasi.persyaratan-wisuda');
            Route::put('/persyaratan-wisuda/{id}', [AdminController::class, 'updatePersyaratanWisuda'])->name('admin.verifikasi.persyaratan-wisuda.update');
        });

        // ---- Download Files ----
        Route::prefix('download')->group(function () {
            Route::get('/bukti-bayar/{filename}', [AdminController::class, 'downloadBuktiBayar'])->name('admin.download.bukti-bayar');
            Route::get('/persyaratan-yudisium/{filename}', [AdminController::class, 'downloadFileYudisium'])->name('admin.download.persyaratan-yudisium');
            Route::get('/persyaratan-wisuda/{filename}', [AdminController::class, 'downloadFileWisuda'])->name('admin.download.persyaratan-wisuda');
        });

        // ---- View Files ----
        Route::prefix('view')->group(function () {
            Route::get('/bukti-bayar-wisuda/{filename}', [AdminController::class, 'viewBuktiBayarWisuda'])->name('admin.view.bukti-wisuda');
            Route::get('/bukti-bayar-yudisium/{filename}', [AdminController::class, 'viewBuktiBayarYudisium'])->name('admin.view.bukti-yudisium');
            Route::get('/persyaratan-yudisium/{filename}', [AdminController::class, 'viewFileYudisium'])->name('admin.view.persyaratan-yudisium');
            Route::get('/persyaratan-wisuda/{filename}', [AdminController::class, 'viewFileWisuda'])->name('admin.view.persyaratan-wisuda');
        });

        // ---- Data Management ----
        Route::get('/data-final', [AdminController::class, 'dataFinal'])->name('admin.data-final');
        Route::get('/manajemen-mahasiswa', [AdminController::class, 'manajemenMahasiswa'])->name('admin.manajemen-mahasiswa');
        Route::get('/export-data-final', [AdminController::class, 'exportDataFinal'])->name('admin.export-data-final');

        // ---- QR Code ----
        Route::prefix('qr')->group(function () {
            // ✅ PERBAIKAN: Route GET untuk menampilkan halaman QR
            Route::get('/generate', function() {
                $qrList = \App\Models\QrPresensi::with('mahasiswa')->latest()->get();
                return view('admin.generate_qr', compact('qrList'));
            })->name('admin.generate-qr.form');

            // ✅ PERBAIKAN: Route POST untuk proses generate QR
            Route::post('/generate', [QrController::class, 'generateQrForAll'])->name('admin.generate-qr');

            Route::get('/download/{id}', [QrController::class, 'downloadQr'])->name('admin.download-qr');
        });
    });
});

// ==========================
// 📱 API PRESENSI QR
// ==========================
Route::post('/api/presensi/checkin', [QrController::class, 'checkinPresensi'])->name('presensi.checkin');
