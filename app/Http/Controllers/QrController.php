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
    // ==========================================
    // ADMIN DASHBOARD METHODS
    // ==========================================

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
        if ($request->has('mahasiswa_id')) {
            return $this->generateSingleQr($request->mahasiswa_id);
        }

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
                $newQr = $this->createQrPresensi($data->mahasiswa_id, $data->mahasiswa, $data);
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
        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $mahasiswaId)->first();

        if (QrPresensi::where('mahasiswa_id', $mahasiswaId)->exists()) {
            return redirect()
                ->route('admin.generate-qr.form')
                ->with('info', 'QR Code sudah ada untuk mahasiswa ini.');
        }

        $newQr = $this->createQrPresensi($mahasiswaId, $mahasiswa, $dataFinal);

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

    /**
     * Create QR with ENHANCED payload containing full mahasiswa data
     */
    private function createQrPresensi($mahasiswaId, $mahasiswa, $dataFinal = null)
    {
        try {
            $token = $this->generateUniqueToken();
            $kodeUnik = $this->generateKodeUnik($mahasiswa->nim);
            $appUrl = config('app.url') ?? env('APP_URL', 'http://localhost:8000');

            // ENHANCED PAYLOAD - Data lengkap mahasiswa
            $payloadData = [
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'mahasiswa' => [
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->name,
                    'email' => $mahasiswa->email,
                    'no_hp' => $mahasiswa->no_hp,
                    'prodi' => $mahasiswa->prodi ?? 'Teknik Informatika',
                    'ipk' => $mahasiswa->ipk ?? 0,
                    'semester' => $mahasiswa->semester ?? 8,
                ],
                'keluarga' => [
                    'ortu_1' => $dataFinal?->nama_ortu_1 ?? '-',
                    'ortu_2' => $dataFinal?->nama_ortu_2 ?? '-',
                    'tamu_1' => $dataFinal?->nama_tamu_1 ?? '-',
                    'tamu_2' => $dataFinal?->nama_tamu_2 ?? '-',
                ],
                'wisuda' => [
                    'status' => $dataFinal?->status ?? 'pending',
                    'generated_at' => now()->format('Y-m-d H:i:s'),
                ],
                'api' => [
                    'base_url' => rtrim($appUrl, '/'),
                    'checkin_url' => rtrim($appUrl, '/') . '/api/qr/checkin',
                    'verify_url' => rtrim($appUrl, '/') . '/api/qr/verify',
                    'detail_url' => rtrim($appUrl, '/') . '/api/qr/detail/' . $token,
                    'scan_url' => rtrim($appUrl, '/') . '/api/qr/scan',
                ],
            ];

            $payload = json_encode($payloadData);

            // Generate QR Code sebagai SVG
            $qrImage = QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($payload);

            $fileName = 'qr_' . $mahasiswa->nim . '_' . time() . '.svg';
            $filePath = 'qr_codes/' . $fileName;

            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
            }

            Storage::disk('public')->put($filePath, $qrImage);

            return QrPresensi::create([
                'mahasiswa_id' => $mahasiswaId,
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'file_qr' => $filePath,
                'status' => 'aktif',
                'expired_at' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating QR: ' . $e->getMessage());
            return null;
        }
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

        return response()->download(
            Storage::disk('public')->path($filePath),
            'qr_presensi_' . $qr->mahasiswa->nim . '.svg',
            [
                'Content-Type' => 'image/svg+xml',
                'Content-Disposition' => 'attachment; filename="qr_presensi_' . $qr->mahasiswa->nim . '.svg"'
            ]
        );
    }

    // ==========================================
    // PUBLIC API ENDPOINTS - For External Web
    // ==========================================

    /**
     * SCAN QR - Preview data without marking as used
     * POST /api/qr/scan
     */
    public function scanQr(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'kode_unik' => 'required|string'
        ]);

        $qr = QrPresensi::with(['mahasiswa'])
            ->where('token', $request->token)
            ->where('kode_unik', $request->kode_unik)
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau tidak ditemukan',
                'error_code' => 'QR_NOT_FOUND'
            ], 404);
        }

        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $qr->mahasiswa_id)->first();

        return response()->json([
            'success' => true,
            'message' => 'QR Code valid',
            'data' => $this->buildFullResponse($qr, $dataFinal)
        ]);
    }

    /**
     * VERIFY QR - Check validity and status
     * POST /api/qr/verify
     */
    public function verifyQr(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'kode_unik' => 'required|string'
        ]);

        $qr = QrPresensi::with(['mahasiswa'])
            ->where('token', $request->token)
            ->where('kode_unik', $request->kode_unik)
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'QR Code tidak valid',
                'error_code' => 'QR_NOT_FOUND'
            ], 404);
        }

        $isExpired = $qr->expired_at && $qr->expired_at < now();
        $isUsed = $qr->status === 'digunakan';
        $isActive = $qr->status === 'aktif' && !$isExpired;

        return response()->json([
            'success' => true,
            'valid' => $isActive,
            'message' => $isUsed ? 'QR sudah digunakan' : ($isExpired ? 'QR sudah expired' : 'QR valid dan aktif'),
            'data' => [
                'nim' => $qr->mahasiswa->nim,
                'nama' => $qr->mahasiswa->name,
                'status_qr' => $qr->status,
                'is_used' => $isUsed,
                'is_expired' => $isExpired,
                'is_active' => $isActive,
                'waktu_checkin' => $qr->waktu_checkin?->format('Y-m-d H:i:s'),
                'expired_at' => $qr->expired_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * GET QR DETAIL - Full mahasiswa info by token
     * GET /api/qr/detail/{token}
     */
    public function getQrDetail($token)
    {
        $qr = QrPresensi::with(['mahasiswa'])
            ->where('token', $token)
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak ditemukan',
                'error_code' => 'QR_NOT_FOUND'
            ], 404);
        }

        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $qr->mahasiswa_id)->first();

        return response()->json([
            'success' => true,
            'data' => $this->buildFullResponse($qr, $dataFinal)
        ]);
    }

    /**
     * CHECKIN - Mark QR as used
     * POST /api/qr/checkin
     */
    public function checkinPresensi(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'kode_unik' => 'required|string'
        ]);

        $qr = QrPresensi::with('mahasiswa')
            ->where('token', $request->token)
            ->where('kode_unik', $request->kode_unik)
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak valid atau tidak ditemukan',
                'error_code' => 'QR_NOT_FOUND'
            ], 404);
        }

        if ($qr->status === 'digunakan') {
            return response()->json([
                'success' => false,
                'message' => 'QR sudah digunakan sebelumnya',
                'error_code' => 'QR_ALREADY_USED',
                'data' => [
                    'nama' => $qr->mahasiswa->name,
                    'nim' => $qr->mahasiswa->nim,
                    'waktu_checkin' => $qr->waktu_checkin?->format('Y-m-d H:i:s'),
                ]
            ], 400);
        }

        if ($qr->expired_at && $qr->expired_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'QR sudah expired',
                'error_code' => 'QR_EXPIRED'
            ], 400);
        }

        // Update status to digunakan
        $qr->update([
            'status' => 'digunakan',
            'waktu_checkin' => now()
        ]);

        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $qr->mahasiswa_id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat!',
            'data' => $this->buildFullResponse($qr->fresh(), $dataFinal)
        ]);
    }

    /**
     * CHECK STATUS - Get presensi status by token
     * GET /api/qr/status/{token}
     */
    public function checkStatusPresensi($token)
    {
        $qr = QrPresensi::with('mahasiswa')->where('token', $token)->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR tidak ditemukan',
                'error_code' => 'QR_NOT_FOUND'
            ], 404);
        }

        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $qr->mahasiswa_id)->first();

        return response()->json([
            'success' => true,
            'data' => $this->buildFullResponse($qr, $dataFinal)
        ]);
    }

    /**
     * GET STATS - Overall presensi statistics
     * GET /api/qr/stats
     */
    public function getStats()
    {
        $total = QrPresensi::count();
        $aktif = QrPresensi::where('status', 'aktif')->count();
        $digunakan = QrPresensi::where('status', 'digunakan')->count();

        $recentCheckins = QrPresensi::with('mahasiswa')
            ->where('status', 'digunakan')
            ->orderBy('waktu_checkin', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'nim' => $item->mahasiswa->nim,
                    'nama' => $item->mahasiswa->name,
                    'prodi' => $item->mahasiswa->prodi ?? '-',
                    'waktu_checkin' => $item->waktu_checkin?->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'statistik' => [
                    'total_qr' => $total,
                    'qr_aktif' => $aktif,
                    'qr_digunakan' => $digunakan,
                    'persentase_hadir' => $total > 0 ? round(($digunakan / $total) * 100, 2) : 0,
                ],
                'recent_checkins' => $recentCheckins,
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * LIST ALL PRESENSI
     * GET /api/qr/list-presensi
     */
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
                    'waktu_checkin' => $item->waktu_checkin?->format('Y-m-d H:i:s'),
                    'waktu_generate' => $item->created_at->format('Y-m-d H:i:s'),
                    'qr_url' => $item->file_qr ? Storage::url($item->file_qr) : null
                ];
            });

        return response()->json([
            'success' => true,
            'count' => $presensi->count(),
            'data' => $presensi
        ]);
    }

    /**
     * VIEW QR FILE
     * GET /api/qr/file/{id}
     */
    public function viewQr($id)
    {
        $qr = QrPresensi::findOrFail($id);

        if (!Storage::disk('public')->exists($qr->file_qr)) {
            abort(404, 'QR Code tidak ditemukan');
        }

        return response()->file(Storage::disk('public')->path($qr->file_qr));
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Build full response data with mahasiswa and keluarga info
     */
    private function buildFullResponse($qr, $dataFinal = null)
    {
        $isExpired = $qr->expired_at && $qr->expired_at < now();
        $isUsed = $qr->status === 'digunakan';

        return [
            'qr' => [
                'token' => $qr->token,
                'kode_unik' => $qr->kode_unik,
                'status' => $qr->status,
                'is_used' => $isUsed,
                'is_expired' => $isExpired,
                'is_active' => $qr->status === 'aktif' && !$isExpired,
                'waktu_checkin' => $qr->waktu_checkin?->format('Y-m-d H:i:s'),
                'generated_at' => $qr->created_at->format('Y-m-d H:i:s'),
                'expired_at' => $qr->expired_at?->format('Y-m-d H:i:s'),
            ],
            'mahasiswa' => [
                'nim' => $qr->mahasiswa->nim,
                'nama' => $qr->mahasiswa->name,
                'email' => $qr->mahasiswa->email,
                'no_hp' => $qr->mahasiswa->no_hp,
                'prodi' => $qr->mahasiswa->prodi ?? 'Teknik Informatika',
                'ipk' => $qr->mahasiswa->ipk ?? 0,
                'semester' => $qr->mahasiswa->semester ?? 8,
            ],
            'keluarga' => [
                'ortu_1' => $dataFinal?->nama_ortu_1 ?? '-',
                'ortu_2' => $dataFinal?->nama_ortu_2 ?? '-',
                'tamu_1' => $dataFinal?->nama_tamu_1 ?? '-',
                'tamu_2' => $dataFinal?->nama_tamu_2 ?? '-',
            ],
            'wisuda' => [
                'status' => $dataFinal?->status ?? 'pending',
            ],
        ];
    }
}
