<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PendaftaranYudisium;
use App\Models\PersyaratanYudisium;
use App\Models\PendaftaranWisuda;
use App\Models\PersyaratanWisuda;
use App\Models\DataMahasiswaFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'yudisium_menunggu' => PendaftaranYudisium::where('status', 'menunggu_verifikasi')->count(),
            'wisuda_menunggu' => PendaftaranWisuda::where('status', 'menunggu_verifikasi')->count(),
            'persyaratan_yudisium_menunggu' => PersyaratanYudisium::where('status', 'menunggu')->count(),
            'persyaratan_wisuda_menunggu' => PersyaratanWisuda::where('status', 'menunggu')->count(),
            'siap_wisuda' => DataMahasiswaFinal::where('status', 'siap_wisuda')->count(),
        ];

        $recentMahasiswa = User::where('role', 'mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMahasiswa'));
    }

    /* Pembayaran Yudisium */
    public function verifikasiPembayaranYudisium()
    {
        $pembayaran = PendaftaranYudisium::with('mahasiswa')
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        return view('admin.verifikasi.pembayaran_yudisium', compact('pembayaran'));
    }

    public function updatePembayaranYudisium(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:lunas,batal']);

        PendaftaranYudisium::where('id', $id)
            ->update([
                'status' => $request->status,
                'tanggal_bayar' => $request->status == 'lunas' ? now() : null
            ]);

        return back()->with('success', 'Status pembayaran yudisium berhasil diperbarui.');
    }

    /* Persyaratan Yudisium */
    public function verifikasiPersyaratanYudisium()
    {
        $persyaratan = PersyaratanYudisium::with('mahasiswa')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('admin.verifikasi.persyaratan_yudisium', compact('persyaratan'));
    }

    public function updatePersyaratanYudisium(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,revisi',
            'catatan' => 'nullable|string|max:500'
        ]);

        PersyaratanYudisium::where('id', $id)
            ->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan
            ]);

        return back()->with('success', 'Persyaratan yudisium berhasil diperbarui.');
    }

    /* Pembayaran Wisuda */
    public function verifikasiPembayaranWisuda()
    {
        $pembayaran = PendaftaranWisuda::with('mahasiswa')
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        return view('admin.verifikasi.pembayaran_wisuda', compact('pembayaran'));
    }

    public function updatePembayaranWisuda(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:lunas,batal']);

        PendaftaranWisuda::where('id', $id)
            ->update([
                'status' => $request->status,
                'tanggal_bayar' => $request->status == 'lunas' ? now() : null
            ]);

        return back()->with('success', 'Status pembayaran wisuda berhasil diperbarui.');
    }

    /* Persyaratan Wisuda */
    public function verifikasiPersyaratanWisuda()
    {
        $persyaratan = PersyaratanWisuda::with('mahasiswa')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('admin.verifikasi.persyaratan_wisuda', compact('persyaratan'));
    }

    public function updatePersyaratanWisuda(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,revisi',
            'catatan' => 'nullable|string|max:500'
        ]);

        PersyaratanWisuda::where('id', $id)
            ->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan
            ]);

        return back()->with('success', 'Persyaratan wisuda berhasil diperbarui.');
    }

    /* Data Final */
    public function dataFinal()
    {
        $data = DataMahasiswaFinal::with('mahasiswa')
            ->latest()
            ->paginate(10);

        return view('admin.data_final', compact('data'));
    }

    /* Manajemen Mahasiswa */
    public function manajemenMahasiswa()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->with(['pendaftaranYudisium', 'persyaratanYudisium', 'pendaftaranWisuda'])
            ->latest()
            ->paginate(10);

        return view('admin.manajemen_mahasiswa', compact('mahasiswa'));
    }

    /* Download File */
    public function downloadFile($folder, $filename)
    {
        $filePath = $folder.'/'.$filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return response()->download(Storage::disk('public')->path($filePath));
    }

    /* Download Bukti Bayar */
    public function downloadBuktiBayar($filename)
    {
        return $this->downloadFile('bukti_bayar', $filename);
    }

    /* Download Persyaratan Yudisium */
    public function downloadFileYudisium($filename)
    {
        return $this->downloadFile('persyaratan/yudisium', $filename);
    }

    /* Download Persyaratan Wisuda */
    public function downloadFileWisuda($filename)
    {
        return $this->downloadFile('persyaratan/wisuda', $filename);
    }

    /* View Bukti Bayar Wisuda */
    public function viewBuktiBayarWisuda($filename)
    {
        return $this->downloadFile('bukti_bayar/wisuda', $filename);
    }

    /* View Bukti Bayar Yudisium */
    public function viewBuktiBayarYudisium($filename)
    {
        return $this->downloadFile('bukti_bayar/yudisium', $filename);
    }

    /* View Persyaratan Yudisium */
    public function viewFileYudisium($filename)
    {
        return $this->downloadFile('persyaratan/yudisium', $filename);
    }

    /* View Persyaratan Wisuda */
    public function viewFileWisuda($filename)
    {
        return $this->downloadFile('persyaratan/wisuda', $filename);
    }

    /* Export Data Final */
    public function exportDataFinal()
    {
        $data = DataMahasiswaFinal::with('mahasiswa')->get();

        // Create CSV
        $filename = 'data_final_' . now()->format('Y-m-d_His') . '.csv';
        $file = fopen('php://memory', 'w');

        fputcsv($file, ['ID', 'NIM', 'Nama', 'Prodi', 'Status', 'Tanggal', 'Catatan']);

        foreach ($data as $item) {
            fputcsv($file, [
                $item->id,
                $item->mahasiswa->nim,
                $item->mahasiswa->name,
                $item->mahasiswa->prodi,
                $item->status,
                $item->created_at,
                $item->catatan ?? '-'
            ]);
        }

        rewind($file);
        $content = stream_get_contents($file);
        fclose($file);

        return response($content, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
