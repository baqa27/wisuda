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

        return view('admin.generate_qr', compact('qrList', 'generatedCount'));
    }

    private function generateSingleQr($mahasiswaId)
    {
        $mahasiswa = User::findOrFail($mahasiswaId);

        if (QrPresensi::where('mahasiswa_id', $mahasiswaId)->exists()) {
            return back()->with('info', 'QR Code sudah ada untuk mahasiswa ini.');
        }

        $this->createQrPresensi($mahasiswaId, $mahasiswa);
        return back()->with('success', 'QR Code berhasil dibuat.');
    }

    private function createQrPresensi($mahasiswaId, $mahasiswa)
    {
        try {
            // Generate unique token dan kode unik
            $token = $this->generateUniqueToken();
            $kodeUnik = $this->generateKodeUnik($mahasiswa->nim);

            // Buat payload yang lebih sederhana untuk QR
            // Tambahkan juga URL API checkin agar pihak lain bisa langsung memanggil endpoint
            $payloadData = [
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'nim' => $mahasiswa->nim,
                'timestamp' => now()->timestamp,
            ];

            // Jika aplikasi memiliki URL app url di .env, gunakan itu; fallback ke route relative
            $appUrl = config('app.url') ?? env('APP_URL');
            $checkinUrl = rtrim($appUrl, '/') . '/api/qr/checkin';

            $payload = json_encode(array_merge($payloadData, ['checkin_url' => $checkinUrl]));

            // Generate QR Code sebagai SVG (kompatibel tanpa imagick)
            $qrImage = QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($payload);

            // Simpan file QR (SVG tidak memerlukan imagick)
            $fileName = 'qr_' . $mahasiswa->nim . '_' . time() . '.svg';
            $filePath = 'qr_codes/' . $fileName;

            // Pastikan folder exists
            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
            }

            // Simpan file
            Storage::disk('public')->put($filePath, $qrImage);

            // Buat record di database
            return QrPresensi::create([
                'mahasiswa_id' => $mahasiswaId,
                'token' => $token,
                'kode_unik' => $kodeUnik,
                'file_qr' => $filePath,
                'status' => 'aktif',
                'expired_at' => now()->addDays(7)
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
            ->where('expired_at', '>', now())
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
                'expired_at' => $qr->expired_at->format('d/m/Y H:i:s'),
                'is_expired' => $qr->expired_at < now(),
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
