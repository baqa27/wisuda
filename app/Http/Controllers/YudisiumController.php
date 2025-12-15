<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranYudisium;
use App\Models\PersyaratanYudisium;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Payment;
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

    // Pembayaran melalui Midtrans akan ditangani di controller lain sesuai arsitektur aplikasi.
    public function checkout($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $payment->student->name,
                'email' => $payment->student->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.checkout', compact('snapToken', 'payment'));
    }

    /**
     * Show upload bukti bayar form
     */
    // public function showUploadBukti($id)
    // {
    //     $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', Auth::id())
    //         ->findOrFail($id);


    //     return view('yudisium.upload_bukti', compact('pendaftaran'));
    // }

    public function showUploadBukti($id)
    {
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        // Jika sudah lunas, redirect ke halaman sukses atau persyaratan
        if ($pendaftaran->status == 'lunas') {
            return redirect()->route('yudisium.persyaratan.form')
                ->with('info', 'Pembayaran Anda sudah lunas. Silakan lengkapi persyaratan.');
        }

        // Jika menunggu verifikasi, tampilkan pesan
        if ($pendaftaran->status == 'menunggu_verifikasi') {
            return redirect()->route('yudisium.index')
                ->with('info', 'Pembayaran Anda sedang diverifikasi oleh admin.');
        }

        $snapToken = null;

        // Hanya generate token jika status masih menunggu pembayaran
        if ($pendaftaran->status == 'menunggu_pembayaran') {
            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Generate unique order ID (tambahkan timestamp untuk menghindari duplicate)
            $orderId = $pendaftaran->kode_invoice . '-' . time();

            // Parameter transaksi
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $pendaftaran->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->no_hp ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'YUDISIUM-' . $pendaftaran->id,
                        'price' => (int) $pendaftaran->total_bayar,
                        'quantity' => 1,
                        'name' => 'Biaya Yudisium',
                    ]
                ],
                'callbacks' => [
                    'finish' => route('yudisium.success', $pendaftaran->id),
                ]
            ];

            // Generate Snap Token
            try {
                $snapToken = Snap::getSnapToken($params);
                \Log::info('Midtrans Snap Token generated for order: ' . $orderId);
            } catch (\Exception $e) {
                \Log::error('Midtrans Error: ' . $e->getMessage());
                $snapToken = null;
            }
        }

        return view('yudisium.upload_bukti', compact('pendaftaran', 'snapToken'));
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

        // Cek apakah sudah mendaftar
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', $mahasiswa->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('yudisium.index')
                ->with('error', 'Silakan daftar yudisium terlebih dahulu.');
        }

        // Jika status masih menunggu pembayaran, redirect ke halaman bayar
        if ($pendaftaran->status == 'menunggu_pembayaran') {
            return redirect()->route('yudisium.upload-bukti', $pendaftaran->id)
                ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu.');
        }

        // Jika status menunggu verifikasi (upload manual), redirect ke index dengan pesan
        if ($pendaftaran->status == 'menunggu_verifikasi') {
            return redirect()->route('yudisium.index')
                ->with('info', 'Pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu.');
        }

        // Jika status sudah lunas, boleh akses form persyaratan
        if ($pendaftaran->status !== 'lunas') {
            return redirect()->route('yudisium.index')
                ->with('error', 'Pembayaran harus lunas sebelum mengisi persyaratan.');
        }

        // Cek apakah sudah mengisi persyaratan
        $persyaratan = PersyaratanYudisium::where('mahasiswa_id', $mahasiswa->id)->first();
        if ($persyaratan) {
            return redirect()->route('yudisium.index')
                ->with('info', 'Anda sudah mengisi persyaratan yudisium.');
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

    /**
     * Handle payment success from Midtrans
     */
    public function paymentSuccess($id)
    {
        $pendaftaran = PendaftaranYudisium::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        // Jika status masih menunggu_pembayaran, update ke lunas
        // (Sebagai fallback jika webhook belum diterima)
        if ($pendaftaran->status == 'menunggu_pembayaran') {
            $pendaftaran->update([
                'status' => 'lunas',
                'payment_method' => 'midtrans',
                'paid_at' => now()
            ]);

            // Kirim notifikasi ke admin
            $this->sendPaymentNotificationToAdmin($pendaftaran);
        }

        return view('yudisium.payment_success', compact('pendaftaran'));
    }

    /**
     * Handle Midtrans notification webhook
     */
    public function handleMidtransNotification(Request $request)
    {
        try {
            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type ?? 'unknown';

            \Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType
            ]);

            // Extract kode_invoice dari order_id (format: KODE_INVOICE-timestamp)
            // Contoh: YUD-20251208-0001-1733654321 -> YUD-20251208-0001
            $parts = explode('-', $orderId);
            // Hapus bagian terakhir (timestamp)
            array_pop($parts);
            $kodeInvoice = implode('-', $parts);

            // Cari pendaftaran berdasarkan kode invoice
            $pendaftaran = PendaftaranYudisium::where('kode_invoice', $kodeInvoice)->first();

            // Jika tidak ditemukan, coba cari dengan order_id langsung (backward compatibility)
            if (!$pendaftaran) {
                $pendaftaran = PendaftaranYudisium::where('kode_invoice', $orderId)->first();
            }

            if (!$pendaftaran) {
                \Log::error('Pendaftaran not found for order_id: ' . $orderId . ' (kode_invoice: ' . $kodeInvoice . ')');
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Update status berdasarkan transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $pendaftaran->update([
                        'status' => 'lunas',
                        'payment_method' => 'midtrans',
                        'paid_at' => now()
                    ]);
                    $this->sendPaymentNotificationToAdmin($pendaftaran);
                }
            } elseif ($transactionStatus == 'settlement') {
                $pendaftaran->update([
                    'status' => 'lunas',
                    'payment_method' => 'midtrans',
                    'paid_at' => now()
                ]);
                $this->sendPaymentNotificationToAdmin($pendaftaran);
            } elseif ($transactionStatus == 'pending') {
                $pendaftaran->update([
                    'status' => 'menunggu_pembayaran'
                ]);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $pendaftaran->update([
                    'status' => 'dibatalkan'
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Send payment notification to admin
     */
    private function sendPaymentNotificationToAdmin($pendaftaran)
    {
        try {
            $mahasiswa = $pendaftaran->mahasiswa;
            $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');

            \Mail::send('emails.payment_notification', [
                'pendaftaran' => $pendaftaran,
                'mahasiswa' => $mahasiswa
            ], function ($message) use ($adminEmail, $mahasiswa) {
                $message->to($adminEmail)
                    ->subject('Pembayaran Yudisium Baru - ' . $mahasiswa->name);
            });

            \Log::info('Payment notification sent to admin for: ' . $pendaftaran->kode_invoice);
        } catch (\Exception $e) {
            \Log::error('Failed to send payment notification: ' . $e->getMessage());
        }
    }
}
