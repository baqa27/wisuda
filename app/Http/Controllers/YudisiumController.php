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

            return redirect()->route('yudisium.index')->with('success', 'Bukti pembayaran berhasil diupload dan sedang menunggu verifikasi admin.');
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
            ->firstOrFail();

        if (!$pendaftaran->bukti_bayar) {
            return redirect()->route('yudisium.upload-bukti', $pendaftaran->id)
                ->with('error', 'Silakan upload bukti pembayaran terlebih dahulu.');
        }

        if ($pendaftaran->status !== 'lunas') {
            return redirect()->route('yudisium.index')->with('error', 'Pembayaran harus disetujui admin sebelum mengisi persyaratan.');
        }

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
            'no_whatsapp' => 'required|string|max:20',
            'file_ktp' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'sertifikasi_tahfidz' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'sertifikasi_toefl' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'surat_bebas_perpustakaan' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $mahasiswa = Auth::user();

        // Upload files
        $fileKtp = $request->file('file_ktp')->store('persyaratan_yudisium', 'public');
        $fileIjazah = $request->hasFile('file_ijazah')
            ? $request->file('file_ijazah')->store('persyaratan_yudisium', 'public')
            : null;
        $sertifikasiTahfidz = $request->hasFile('sertifikasi_tahfidz')
            ? $request->file('sertifikasi_tahfidz')->store('persyaratan_yudisium', 'public')
            : null;
        $sertifikasiToefl = $request->hasFile('sertifikasi_toefl')
            ? $request->file('sertifikasi_toefl')->store('persyaratan_yudisium', 'public')
            : null;
        $suratBebasPerpustakaan = $request->hasFile('surat_bebas_perpustakaan')
            ? $request->file('surat_bebas_perpustakaan')->store('persyaratan_yudisium', 'public')
            : null;

        PersyaratanYudisium::create([
            'mahasiswa_id' => $mahasiswa->id,
            'judul_ta' => $request->judul_ta,
            'dosen_pembimbing' => $request->dosen_pembimbing,
            'no_whatsapp' => $request->no_whatsapp,
            'file_ktp' => $fileKtp,
            'file_ijazah' => $fileIjazah,
            'sertifikasi_tahfidz' => $sertifikasiTahfidz,
            'sertifikasi_toefl' => $sertifikasiToefl,
            'surat_bebas_perpustakaan' => $suratBebasPerpustakaan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('yudisium.selesai')->with('success', 'Persyaratan yudisium berhasil disimpan.');

    }

    /**
     * Halaman selesai yudisium
     */
    public function selesai()
    {
        $mahasiswa = Auth::user();
        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', $mahasiswa->id)->firstOrFail();

        return view('yudisium.selesai', compact('persyaratan'));
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
        if ($persyaratan->status !== 'revisi') {
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
            'no_whatsapp' => 'required|string|max:20',
            'file_ktp' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'sertifikasi_tahfidz' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'sertifikasi_toefl' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'surat_bebas_perpustakaan' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        $data = [
            'judul_ta' => $request->judul_ta,
            'dosen_pembimbing' => $request->dosen_pembimbing,
            'no_whatsapp' => $request->no_whatsapp,
            'status' => 'menunggu',
            'catatan_admin' => null,
        ];

        // Helper function to handle file update
        $handleFileUpdate = function ($fieldName, $request, $persyaratan, &$data) {
            if ($request->hasFile($fieldName)) {
                if ($persyaratan->$fieldName && Storage::disk('public')->exists($persyaratan->$fieldName)) {
                    Storage::disk('public')->delete($persyaratan->$fieldName);
                }
                $data[$fieldName] = $request->file($fieldName)->store('persyaratan_yudisium', 'public');
            }
        };

        $handleFileUpdate('file_ktp', $request, $persyaratan, $data);
        $handleFileUpdate('file_ijazah', $request, $persyaratan, $data);
        $handleFileUpdate('sertifikasi_tahfidz', $request, $persyaratan, $data);
        $handleFileUpdate('sertifikasi_toefl', $request, $persyaratan, $data);
        $handleFileUpdate('surat_bebas_perpustakaan', $request, $persyaratan, $data);

        $persyaratan->update($data);

        return redirect()->route('yudisium.index')->with('success', 'Persyaratan yudisium berhasil diperbarui. Menunggu verifikasi ulang admin.');
    }
}
