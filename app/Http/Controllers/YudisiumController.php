<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranYudisium;
use App\Models\PersyaratanYudisium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class YudisiumController extends Controller
{
    /**
     * Display yudisium index page for mahasiswa
     */
    public function index()
    {
        $mahasiswa = Auth::user();
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', $mahasiswa->id)->first();
        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('yudisium.index', compact('pendaftaran', 'persyaratan'));
    }

    /**
     * Process pendaftaran yudisium
     */
    public function daftarYudisium()
    {
        $mahasiswa = Auth::user();

        // Cek apakah sudah pernah daftar
        if (PendaftaranYudisium::where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return redirect()->route('yudisium.index')->with('error', 'Anda sudah mendaftar yudisium.');
        }

        // Buat pendaftaran yudisium
        $pendaftaran = PendaftaranYudisium::create([
            'mahasiswa_id' => $mahasiswa->id,
            'kode_invoice' => 'INV-YDS-' . time() . '-' . $mahasiswa->nim,
            'total_bayar' => 150000,
            'status' => 'menunggu_pembayaran',
        ]);

        return redirect()->route('yudisium.upload-bukti', $pendaftaran->id)->with('success', 'Pendaftaran yudisium berhasil! Silakan upload bukti pembayaran.');
    }

    /**
     * Show upload bukti bayar form
     */
    public function showUploadBukti($id)
    {
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        return view('yudisium.upload_bukti', compact('pendaftaran'));
    }

    /**
     * Process upload bukti pembayaran
     */
    public function prosesUploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        // Upload bukti bayar
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_bayar/yudisium', $filename, 'public');

            $pendaftaran->update([
                'bukti_bayar' => $filename,
                'status' => 'menunggu_verifikasi' // Status berubah menunggu verifikasi admin
            ]);

            return redirect()->route('yudisium.index')->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    /**
     * Download bukti bayar
     */
    public function downloadBuktiBayar($filename)
    {
        $filePath = 'bukti_bayar/yudisium/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File bukti bayar tidak ditemukan');
        }

        return response()->download(storage_path('app/public/' . $filePath));
    }

    /**
     * Show form persyaratan yudisium
     */
    public function showFormPersyaratan()
    {
        $mahasiswa = Auth::user();

        // Cek apakah pembayaran sudah lunas (sudah diverifikasi admin)
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'lunas')
            ->firstOrFail();

        // Cek apakah sudah mengisi persyaratan
        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', $mahasiswa->id)->first();
        if ($persyaratan) {
            return redirect()->route('yudisium.index')->with('info', 'Anda sudah mengisi persyaratan yudisium.');
        }

        return view('yudisium.persyaratan_form', compact('pendaftaran'));
    }

    /**
     * Simpan persyaratan yudisium
     */
    public function simpanPersyaratan(Request $request)
    {
        $request->validate([
            'judul_ta' => 'required|string|max:255',
            'dosen_pembimbing' => 'required|string|max:100',
            'file_ktp' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $mahasiswa = Auth::user();

        // Upload files
        $fileKtp = $request->file('file_ktp')->store('persyaratan_yudisium', 'public');
        $fileIjazah = $request->hasFile('file_ijazah')
            ? $request->file('file_ijazah')->store('persyaratan_yudisium', 'public')
            : null;

        PersyaratanYudisium::create([
            'mahasiswa_id' => $mahasiswa->id,
            'judul_ta' => $request->judul_ta,
            'dosen_pembimbing' => $request->dosen_pembimbing,
            'file_ktp' => $fileKtp,
            'file_ijazah' => $fileIjazah,
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('yudisium.index')->with('success', 'Persyaratan yudisium berhasil disimpan. Menunggu verifikasi admin.');
    }

    /**
     * Download file persyaratan yudisium
     */
    public function downloadFile($filename)
    {
        $filePath = 'persyaratan_yudisium/' . $filename;
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return response()->download(storage_path('app/public/' . $filePath));
    }

    /**
     * Edit persyaratan yudisium
     */
    public function editPersyaratan()
    {
        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa edit jika status revisi
        if ($persyaratan->status_verifikasi !== 'revisi') {
            return redirect()->route('yudisium.index')->with('error', 'Tidak dapat mengedit persyaratan.');
        }

        return view('yudisium.edit_persyaratan', compact('persyaratan'));
    }

    /**
     * Update persyaratan yudisium
     */
    public function updatePersyaratan(Request $request)
    {
        $request->validate([
            'judul_ta' => 'required|string|max:255',
            'dosen_pembimbing' => 'required|string|max:100',
            'file_ktp' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        $data = [
            'judul_ta' => $request->judul_ta,
            'dosen_pembimbing' => $request->dosen_pembimbing,
            'status_verifikasi' => 'menunggu',
            'catatan_admin' => null,
        ];

        // Update file KTP jika ada
        if ($request->hasFile('file_ktp')) {
            // Hapus file lama
            if (Storage::disk('public')->exists($persyaratan->file_ktp)) {
                Storage::disk('public')->delete($persyaratan->file_ktp);
            }
            $data['file_ktp'] = $request->file('file_ktp')->store('persyaratan_yudisium', 'public');
        }

        // Update file ijazah jika ada
        if ($request->hasFile('file_ijazah')) {
            // Hapus file lama jika ada
            if ($persyaratan->file_ijazah && Storage::disk('public')->exists($persyaratan->file_ijazah)) {
                Storage::disk('public')->delete($persyaratan->file_ijazah);
            }
            $data['file_ijazah'] = $request->file('file_ijazah')->store('persyaratan_yudisium', 'public');
        }

        $persyaratan->update($data);

        return redirect()->route('yudisium.index')->with('success', 'Persyaratan yudisium berhasil diperbarui. Menunggu verifikasi ulang admin.');
    }
}
