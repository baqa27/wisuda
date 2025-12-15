<?php

namespace App\Http\Controllers;

use App\Models\QrPresensi;
use App\Models\User;
use App\Models\DataMahasiswaFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function showGenerateForm()
    {
        $qrList = QrPresensi::with('mahasiswa')->latest()->get();

        $readyMahasiswa = DataMahasiswaFinal::with('mahasiswa')
            ->where('status', 'siap_wisuda')
            ->get();

        $readyIds = $readyMahasiswa->pluck('mahasiswa_id');
        $qrIds = $qrList->pluck('mahasiswa_id');
        $missingIds = $readyIds->diff($qrIds);

        $readyWithoutQr = $readyMahasiswa->filter(function ($data) use ($missingIds) {
            return $missingIds->contains($data->mahasiswa_id);
        })->values();

        $lastGeneratedAt = QrPresensi::latest()->first()?->created_at;

        return view('admin.generate_qr', [
            'qrList' => $qrList,
            'readyCount' => $readyMahasiswa->count(),
            'missingCount' => $readyWithoutQr->count(),
            'readyWithoutQr' => $readyWithoutQr,
            'lastGeneratedAt' => $lastGeneratedAt,
        ]);
    }

    public function generateQrForAll(Request $request)
    {
        // Cek jika ada parameter mahasiswa_id untuk generate single
        if ($request->has('mahasiswa_id')) {
            return $this->generateSingleQr($request->mahasiswa_id);
        }

        // Ambil mahasiswa yang siap wisuda
        $mahasiswa = DataMahasiswaFinal::with('mahasiswa')
            ->where('status', 'siap_wisuda')
            ->get();

        if ($mahasiswa->isEmpty()) {
            return redirect()
                ->route('admin.generate-qr.form')
                ->with('info', 'Belum ada data tambahan mahasiswa yang siap wisuda.');
        }

        $generatedCount = 0;
        $qrList = [];

        foreach ($mahasiswa as $data) {
            $existing = QrPresensi::where('mahasiswa_id', $data->mahasiswa_id)->first();

            if (!$existing) {
                $newQr = $this->createQrPresensi($data->mahasiswa_id, $data->mahasiswa);
                if ($newQr) {
                    $qrList[] = $newQr;
                    $generatedCount++;
                }
            } else {
                $qrList[] = $existing;
            }
        }

        if ($generatedCount === 0) {
            return redirect()
                ->route('admin.generate-qr.form')
                ->with('info', 'Semua mahasiswa yang siap wisuda sudah memiliki QR.');
        }

        return redirect()
            ->route('admin.generate-qr.form')
            ->with([
                'success' => $generatedCount . ' QR baru berhasil dibuat.',
                'generated_count' => $generatedCount,
            ]);
    }

    private function generateSingleQr($mahasiswaId)
    {
        $mahasiswa = User::findOrFail($mahasiswaId);

        if (QrPresensi::where('mahasiswa_id', $mahasiswaId)->exists()) {
            return redirect()
                ->route('admin.generate-qr.form')
                ->with('info', 'QR Code sudah ada untuk mahasiswa ini.');
        }

        $newQr = $this->createQrPresensi($mahasiswaId, $mahasiswa);

        if (!$newQr) {
            return redirect()
                ->route('admin.generate-qr.form')
                ->with('error', 'Gagal membuat QR Code baru, coba ulangi beberapa saat lagi.');
        }

        return redirect()
            ->route('admin.generate-qr.form')
            ->with([
                'success' => 'QR Code berhasil dibuat untuk ' . $mahasiswa->name . '.',
                'generated_count' => 1,
            ]);
    }

    private function createQrPresensi($mahasiswaId, $mahasiswa)
    {
        try {
            // Generate unique token dan kode unik
            $token = $this->generateUniqueToken();
            $kodeUnik = $this->generateKodeUnik($mahasiswa->nim);

            // Buat payload
            $payloadData = [
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'nim' => $mahasiswa->nim,
                'timestamp' => now()->timestamp,
            ];

            $appUrl = config('app.url') ?? env('APP_URL');
            $checkinUrl = rtrim($appUrl, '/') . '/api/qr/checkin';
            $payload = json_encode(array_merge($payloadData, ['checkin_url' => $checkinUrl]));

            // 1. Generate Raw QR SVG (Clean)
            $rawQrSvg = QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($payload);

            // Bersihkan deklarasi XML jika ada
            $rawQrSvg = preg_replace('/^<\?xml[^>]*\?>/i', '', $rawQrSvg);

            // 2. Siapkan data mahasiswa untuk Card
            $nama = strtoupper($mahasiswa->name);
            $nim = $mahasiswa->nim;
            // Truncate nama jika terlalu panjang agar muat di kartu
            if (strlen($nama) > 20) {
                $nama = substr($nama, 0, 18) . '...';
            }

            // 3. Buat Wrapper SVG (Kartu Presensi) - Ukuran 500x700
            $cardSvg = <<<SVG
<svg width="500" height="700" viewBox="0 0 500 700" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <linearGradient id="gradTheme" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#0A0061;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#0061DF;stop-opacity:1" />
        </linearGradient>
        <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="2" dy="2" result="offsetblur"/>
            <feComponentTransfer>
                <feFuncA type="linear" slope="0.3"/>
            </feComponentTransfer>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>
        </filter>
    </defs>

    <!-- Background Card -->
    <rect x="5" y="5" width="490" height="690" rx="30" ry="30" fill="white" stroke="#e5e7eb" stroke-width="2" />
    
    <!-- Header Decor -->
    <path d="M 5,35 Q 250,100 495,35 L 495,5 A 30,30 0 0 0 465,5 L 35,5 A 30,30 0 0 0 5,5 Z" fill="url(#gradTheme)" />

    <!-- Border Gradient Frame -->
    <rect x="25" y="25" width="450" height="650" rx="20" ry="20" fill="none" stroke="url(#gradTheme)" stroke-width="4" stroke-opacity="0.3" />

    <!-- Header Text -->
    <text x="50%" y="100" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="34" font-weight="bold" fill="#0A0061" letter-spacing="2" filter="url(#shadow)">PRESENSI WISUDA</text>
    <text x="50%" y="130" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="16" fill="#666" letter-spacing="4">TICKET ACCESS</text>

    <!-- Separator Line -->
    <line x1="100" y1="150" x2="400" y2="150" stroke="#0061DF" stroke-width="2" stroke-linecap="round" />

    <!-- QR Container Area -->
    <!-- Center X: 250. QR size 300. Start X: 100. Start Y: 180 -->
    <rect x="90" y="170" width="320" height="320" rx="15" ry="15" fill="white" stroke="#0061DF" stroke-width="2" filter="url(#shadow)" />
    
    <!-- Embed Clean QR Code SVG -->
    <svg x="100" y="180" width="300" height="300">
        {$rawQrSvg}
    </svg>

    <!-- Student Info -->
    <text x="50%" y="540" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="26" font-weight="bold" fill="#222">{$nama}</text>
    <rect x="150" y="555" width="200" height="40" rx="20" ry="20" fill="#e0f2fe" />
    <text x="50%" y="583" text-anchor="middle" font-family="Courier New, monospace" font-size="22" font-weight="bold" fill="#0061DF">{$nim}</text>

    <!-- Footer Note -->
    <text x="50%" y="640" text-anchor="middle" font-family="Arial, sans-serif" font-size="13" fill="#777">Simpan & Tunjukkan QR ini kepada panitia</text>
    <text x="50%" y="660" text-anchor="middle" font-family="Arial, sans-serif" font-size="12" fill="#999">Generated on {$this->getCurrentDate()}</text>
</svg>
SVG;

            // Simpan file QR (SVG)
            $fileName = 'qr_' . $mahasiswa->nim . '_' . time() . '.svg';
            $filePath = 'qr_codes/' . $fileName;

            // Pastikan folder exists
            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
            }

            // Simpan file
            Storage::disk('public')->put($filePath, $cardSvg);

            // Buat record di database
            return QrPresensi::create([
                'mahasiswa_id' => $mahasiswaId,
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'file_qr' => $filePath,
                'status' => 'aktif',
                'expired_at' => null // Tidak ada expired date
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating QR: ' . $e->getMessage());
            return null;
        }
    }

    private function getCurrentDate()
    {
        return now()->format('d M Y H:i');
    }

    private function generateUniqueToken()
    {
        do {
            $token = bin2hex(random_bytes(16));
        } while (QrPresensi::where('token', $token)->exists());

        return $token;
    }

    private function generateKodeUnik($nim)
    {
        return substr($nim, -6) . '_' . time();
    }

    public function downloadQr($id)
    {
        $qr = QrPresensi::with('mahasiswa')->findOrFail($id);

        $filePath = $qr->file_qr;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File QR tidak ditemukan: ' . $filePath);
        }

        $fileName = 'qr_presensi_' . $qr->mahasiswa->nim . '.png';

        return response()->download(
            Storage::disk('public')->path($filePath),
            'qr_presensi_' . $qr->mahasiswa->nim . '.svg',
            [
                'Content-Type' => 'image/svg+xml',
                'Content-Disposition' => 'attachment; filename="qr_presensi_' . $qr->mahasiswa->nim . '.svg"'
            ]
        );
    }

    public function checkinPresensi(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'kode_unik' => 'required|string'
        ]);

        $qr = QrPresensi::with('mahasiswa')
            ->where('token', $request->token)
            ->where('kode_unik', $request->kode_unik)
            ->where('status', 'aktif')
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak valid, sudah digunakan, atau expired'
            ], 400);
        }

        // Update presensi
        $qr->update([
            'status' => 'digunakan',
            'waktu_checkin' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat',
            'data' => [
                'nama' => $qr->mahasiswa->name,
                'nim' => $qr->mahasiswa->nim,
                'prodi' => $qr->mahasiswa->prodi ?? '-',
                'waktu_checkin' => $qr->waktu_checkin->format('d/m/Y H:i:s'),
                'status' => $qr->status
            ]
        ]);
    }

    public function checkStatusPresensi($token)
    {
        $qr = QrPresensi::with('mahasiswa')->where('token', $token)->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $qr->mahasiswa->name,
                'nim' => $qr->mahasiswa->nim,
                'status' => $qr->status,
                'waktu_checkin' => $qr->waktu_checkin?->format('d/m/Y H:i:s'),
                'expired_at' => $qr->expired_at?->format('d/m/Y H:i:s'),
                'is_expired' => $qr->expired_at ? $qr->expired_at < now() : false,
                'is_used' => $qr->status === 'digunakan'
            ]
        ]);
    }

    public function listPresensi()
    {
        $presensi = QrPresensi::with('mahasiswa')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'nim' => $item->mahasiswa->nim,
                    'nama' => $item->mahasiswa->name,
                    'prodi' => $item->mahasiswa->prodi ?? '-',
                    'status' => $item->status,
                    'waktu_checkin' => $item->waktu_checkin?->format('d/m/Y H:i:s'),
                    'waktu_generate' => $item->created_at->format('d/m/Y H:i:s'),
                    'qr_url' => $item->file_qr ? Storage::url($item->file_qr) : null
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $presensi
        ]);
    }

    /**
     * Method untuk view QR di browser
     */
    public function viewQr($id)
    {
        $qr = QrPresensi::findOrFail($id);

        if (!Storage::disk('public')->exists($qr->file_qr)) {
            abort(404, 'QR Code tidak ditemukan');
        }

        return response()->file(Storage::disk('public')->path($qr->file_qr));
    }
}
