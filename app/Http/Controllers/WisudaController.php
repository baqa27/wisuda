<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranWisuda;
use App\Models\PersyaratanWisuda;
use App\Models\PersyaratanYudisium;
use App\Models\DataMahasiswaFinal;
use App\Models\QrPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WisudaController extends Controller
{
    public function index()
    {
        $mhs = Auth::user();

        $yudisiumTerverifikasi = PersyaratanYudisium::where('mahasiswa_id', $mhs->id)
            ->where('status', 'terverifikasi')
            ->exists();

        $pendaftaran = PendaftaranWisuda::where('mahasiswa_id', $mhs->id)->first();
        $persyaratan = PersyaratanWisuda::where('mahasiswa_id', $mhs->id)->get();
        $dataFinal = DataMahasiswaFinal::where('mahasiswa_id', $mhs->id)->first();
        $qrCode = QrPresensi::where('mahasiswa_id', $mhs->id)->first();

        return view('wisuda.index', compact('pendaftaran', 'persyaratan', 'dataFinal', 'qrCode', 'yudisiumTerverifikasi'));
    }

    public function daftarWisuda()
    {
        $mhs = Auth::user();

        $yudisium = PersyaratanYudisium::where('mahasiswa_id', $mhs->id)
            ->where('status', 'terverifikasi')
            ->first();

        if (!$yudisium) {
            return redirect()->route('wisuda.index')->with('error', 'Yudisium belum terverifikasi.');
        }

        if (PendaftaranWisuda::where('mahasiswa_id', $mhs->id)->exists()) {
            return redirect()->route('wisuda.index')->with('error', 'Anda sudah mendaftar wisuda.');
        }

        $pendaftaran = PendaftaranWisuda::create([
            'mahasiswa_id' => $mhs->id,
            'kode_invoice' => 'INV-WSD-' . time() . '-' . $mhs->nim,
            'total_bayar' => 450000,
            'status' => 'menunggu_pembayaran',
        ]);

        return redirect()->route('wisuda.upload-bukti', $pendaftaran->id)->with('success', 'Pendaftaran berhasil. Lakukan pembayaran.');
    }

    public function prosesPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pendaftaran = PendaftaranWisuda::where('mahasiswa_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_bayar/wisuda', 'public');

            $pendaftaran->update([
                'bukti_bayar' => $path,
                'status' => 'menunggu_verifikasi'
            ]);
        }

        return redirect()->route('wisuda.index')->with('success', 'Bukti pembayaran diupload.');
    }

    public function showPembayaran($id)
    {
        $pendaftaran = PendaftaranWisuda::where('mahasiswa_id', Auth::id())->findOrFail($id);
        return view('wisuda.upload_bukti', compact('pendaftaran'));
    }

    public function showFormPersyaratan()
    {
        $pendaftaran = PendaftaranWisuda::where('mahasiswa_id', Auth::id())
            ->where('status', 'lunas')
            ->firstOrFail();

        $persyaratan = PersyaratanWisuda::where('mahasiswa_id', Auth::id())->get();

        $jenisPersyaratan = [
            'toefl' => 'Sertifikat TOEFL',
            'sertifikasi' => 'Sertifikasi Kompetensi',
            'tahfidz' => 'Sertifikat Tahfidz',
            'bebas_perpus' => 'Bebas Perpustakaan',
            'foto_wisuda' => 'Foto Wisuda',
            'buku_kenangan' => 'Buku Kenangan (Opsional)'
        ];

        return view('wisuda.persyaratan', compact('jenisPersyaratan', 'pendaftaran', 'persyaratan'));
    }

    public function uploadPersyaratan(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:toefl,sertifikasi,tahfidz,bebas_perpus,foto_wisuda,buku_kenangan',
            'file' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048'
        ]);

        $mhs = Auth::user();

        $existing = PersyaratanWisuda::where('mahasiswa_id', $mhs->id)
            ->where('jenis', $request->jenis)
            ->first();

        if ($existing) {
            return back()->with('error', 'Jenis ini sudah diupload.');
        }

        $path = $request->file('file')->store('persyaratan_wisuda', 'public');

        PersyaratanWisuda::create([
            'mahasiswa_id' => $mhs->id,
            'jenis' => $request->jenis,
            'file_path' => $path,
            'status' => 'menunggu'
        ]);

        return redirect()->route('wisuda.persyaratan.form')->with('success', 'Persyaratan diupload.');
    }

    public function showFormDataTambahan()
    {
        $verif = PersyaratanWisuda::where('mahasiswa_id', Auth::id())
            ->whereIn('jenis', ['toefl', 'sertifikasi', 'tahfidz', 'bebas_perpus', 'foto_wisuda'])
            ->where('status', 'terverifikasi')
            ->count();

        if ($verif < 5) {
            return redirect()->route('wisuda.index')->with('error', 'Persyaratan belum lengkap.');
        }

        if (DataMahasiswaFinal::where('mahasiswa_id', Auth::id())->exists()) {
            return redirect()->route('wisuda.index')->with('info', 'Data sudah diisi.');
        }

        return view('wisuda.data_tambahan');
    }

    public function simpanDataTambahan(Request $request)
    {
        $request->validate([
            'nama_ortu_1' => 'required|string|max:100',
            'nama_ortu_2' => 'required|string|max:100',
            'nama_tamu_1' => 'required|string|max:100',
            'nama_tamu_2' => 'required|string|max:100',
        ]);

        $mhs = Auth::user();

        DataMahasiswaFinal::create([
            'mahasiswa_id' => $mhs->id,
            'nim' => $mhs->nim,
            'pas_foto' => $mhs->pas_foto ?? 'default.jpg',
            'nama' => $mhs->name,
            'prodi' => $mhs->prodi ?? '-',
            'ipk' => $mhs->ipk ?? 0,
            'nama_ortu_1' => $request->nama_ortu_1,
            'nama_ortu_2' => $request->nama_ortu_2,
            'nama_tamu_1' => $request->nama_tamu_1,
            'nama_tamu_2' => $request->nama_tamu_2,
            'status' => 'siap_wisuda'
        ]);

        return redirect()->route('wisuda.index')->with('success', 'Data tersimpan.');
    }

    public function downloadFileWisuda($filename)
    {
        $path = 'persyaratan_wisuda/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->download(Storage::disk('public')->path($path));
    }

    public function hapusPersyaratan($id)
    {
        $persyaratan = PersyaratanWisuda::where('mahasiswa_id', Auth::id())->findOrFail($id);

        if (Storage::disk('public')->exists($persyaratan->file_path)) {
            Storage::disk('public')->delete($persyaratan->file_path);
        }

        $persyaratan->delete();

        return back()->with('success', 'Dihapus.');
    }

    public function getStatusPersyaratan()
    {
        $mhs = Auth::user();
        $persyaratan = PersyaratanWisuda::where('mahasiswa_id', $mhs->id)->get();

        $total = $persyaratan->count();
        $verified = $persyaratan->where('status', 'terverifikasi')->count();

        return response()->json([
            'total' => $total,
            'terverifikasi' => $verified,
            'progress' => $total > 0 ? round(($verified / $total) * 100) : 0
        ]);
    }

    public function checkEligibility()
    {
        $mhs = Auth::user();

        $cek = [
            'yudisium' => PersyaratanYudisium::where('mahasiswa_id', $mhs->id)->where('status', 'terverifikasi')->exists(),
            'pendaftaran_wisuda' => PendaftaranWisuda::where('mahasiswa_id', $mhs->id)->where('status', 'lunas')->exists(),
            'persyaratan_wajib' => PersyaratanWisuda::where('mahasiswa_id', $mhs->id)->whereIn('jenis', ['toefl', 'sertifikasi', 'tahfidz', 'bebas_perpus', 'foto_wisuda'])->where('status', 'terverifikasi')->count() >= 5,
            'data_tambahan' => DataMahasiswaFinal::where('mahasiswa_id', $mhs->id)->exists()
        ];

        $eligible = !in_array(false, $cek, true);

        return response()->json([
            'eligibility' => $cek,
            'is_eligible' => $eligible,
            'qr_code' => $eligible ? QrPresensi::where('mahasiswa_id', $mhs->id)->first() : null
        ]);
    }
}
