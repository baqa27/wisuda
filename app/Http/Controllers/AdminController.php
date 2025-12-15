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
use Illuminate\Support\Facades\Hash;

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
        // Ambil ID mahasiswa yang memiliki persyaratan dengan status 'menunggu'
        $mahasiswaIds = PersyaratanWisuda::where('status', 'menunggu')
            ->pluck('mahasiswa_id')
            ->unique();

        // Ambil data mahasiswa beserta persyaratannya
        $mahasiswa = User::whereIn('id', $mahasiswaIds)
            ->with(['persyaratanWisuda' => function ($query) {
                $query->orderBy('jenis');
            }])
            ->get();

        return view('admin.verifikasi.persyaratan_wisuda', compact('mahasiswa'));
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

    public function bulkApprovePersyaratanWisuda(Request $request, $mahasiswaId)
    {
        // Approve all pending requirements for this student
        $updated = PersyaratanWisuda::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'menunggu')
            ->update([
                'status' => 'terverifikasi',
                'catatan_admin' => null
            ]);

        return back()->with('success', $updated . ' persyaratan wisuda berhasil disetujui.');
    }

    public function bulkRevisePersyaratanWisuda(Request $request, $mahasiswaId)
    {
        $request->validate([
            'catatan' => 'required|string|max:500'
        ]);

        // Revise ALL pending documents for this student (like Yudisium)
        $updated = PersyaratanWisuda::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'menunggu')
            ->update([
                'status' => 'revisi',
                'catatan_admin' => $request->catatan
            ]);

        return back()->with('success', $updated . ' dokumen ditandai perlu revisi.');
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

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|string|unique:users,nim',
            'prodi' => 'required|string',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function updateMahasiswa(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nim' => 'required|string|unique:users,nim,' . $id,
            'prodi' => 'required|string',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroyMahasiswa($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Mahasiswa berhasil dihapus.');
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
        return $this->downloadFile('persyaratan_yudisium', $filename);
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
