@extends('layouts.mahasiswa_blank')

@section('title', 'Wisuda')

@section('content')
    @php
        $persyaratanCount = $persyaratan->count();
        $persyaratanTerverifikasi = $persyaratan->where('status', 'terverifikasi')->count();
        $persyaratanMenunggu = $persyaratan->where('status', 'menunggu')->count();
        $persyaratanRevisi = $persyaratan->firstWhere('status', 'revisi');
        $persyaratanStatus = null;
        if ($persyaratanRevisi) {
            $persyaratanStatus = 'revisi';
        } elseif ($persyaratanCount > 0 && $persyaratanTerverifikasi === $persyaratanCount) {
            $persyaratanStatus = 'terverifikasi';
        } elseif ($persyaratanMenunggu > 0) {
            $persyaratanStatus = 'menunggu';
        }

        $canDownloadQr = $dataFinal && $dataFinal->status === 'siap_wisuda' && $qrCode && $qrCode->file_qr;
    @endphp

    <div class="relative flex min-h-screen w-full flex-col items-center overflow-hidden bg-white">
        {{-- Background Elements --}}
        <div class="pointer-events-none absolute -left-[456px] top-[658px] hidden h-[886px] w-[886px] md:block z-0">
            <div class="absolute left-[339.66px] top-0 h-[886px] w-[206.67px] bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute left-0 top-[289.34px] h-[886px] w-[305.52px] rotate-90 bg-[#0061DF] blur-[72px]"></div>
        </div>
        <div class="pointer-events-none absolute left-[1259px] top-[308px] hidden h-[493px] w-[493px] md:block z-0">
            <div class="absolute left-[189px] top-0 h-[493px] w-[115px] bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute left-0 top-[161px] h-[493px] w-[170px] rotate-90 bg-[#0061DF] blur-[72px]"></div>
        </div>

        {{-- Top Navbar --}}
        <x-mahasiswa-navbar />

        {{-- Main Content --}}
        <div class="relative z-40 flex w-full max-w-[1262px] flex-col items-center px-4 pb-20 pt-[150px]">
            @if (!$pendaftaran && !$yudisiumTerverifikasi)
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-red-200 bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-red-600">Yudisium Belum Terverifikasi</h1>
                    <p class="mb-8 font-['Inter'] text-[18px] text-gray-600">Silakan selesaikan dan verifikasi proses yudisium sebelum mendaftar wisuda.</p>
                    <a href="{{ route('yudisium.index') }}" class="flex h-[60px] w-full max-w-[320px] items-center justify-center rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Kembali ke Yudisium
                    </a>
                </div>
            @elseif (!$pendaftaran)
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-black bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Pendaftaran Wisuda</h1>
                    <p class="mb-8 font-['Inter'] text-[18px] text-gray-600">Silakan melakukan pendaftaran untuk mengikuti prosesi wisuda.</p>
                    <form method="POST" action="{{ route('wisuda.daftar') }}">
                        @csrf
                        <button type="submit" class="rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] px-8 py-4 font-['Inter'] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
            @elseif ($pendaftaran->status === 'menunggu_pembayaran')
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-black bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Menunggu Pembayaran</h1>
                    <p class="mb-8 font-['Inter'] text-[18px] text-gray-600">Segera lakukan pembayaran biaya wisuda untuk melanjutkan.</p>
                    <a href="{{ route('wisuda.upload-bukti', $pendaftaran->id) }}" class="rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] px-8 py-4 font-['Inter'] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Lanjutkan Pembayaran
                    </a>
                </div>
            @elseif ($pendaftaran->status === 'menunggu_verifikasi')
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-black bg-white p-10 text-center shadow-md">
                    <h1 class="mb-8 font-['Inter'] text-[32px] font-bold text-[#0061DF]">HALAMAN NOTIFIKASI PEMBAYARAN WISUDA</h1>
                    <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-full bg-yellow-400">
                        <i class="fas fa-clock text-[50px] text-white"></i>
                    </div>
                    <h2 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Menunggu Verifikasi</h2>
                    <p class="mb-8 font-['Inter'] text-[18px] text-black">Bukti pembayaran Anda telah diterima dan sedang diperiksa admin. Harap tunggu sebelum melengkapi persyaratan wisuda.</p>
                    <a href="{{ route('dashboard') }}" class="flex h-[60px] w-full max-w-[400px] items-center justify-center rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Kembali ke Dashboard
                    </a>
                </div>
            @elseif ($pendaftaran->status === 'batal')
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-red-400 bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-red-600">Pembayaran Ditolak</h1>
                    <p class="mb-6 font-['Inter'] text-[18px] text-gray-700">Admin menolak bukti pembayaran Anda. Unggah kembali bukti yang sesuai.</p>
                    <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-full bg-red-500">
                        <i class="fas fa-times text-[50px] text-white"></i>
                    </div>
                    <a href="{{ route('wisuda.upload-bukti', $pendaftaran->id) }}" class="rounded-[10px] bg-red-600 px-8 py-4 font-['Inter'] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Upload Bukti Baru
                    </a>
                </div>
            @elseif ($pendaftaran->status === 'lunas' && $persyaratanCount === 0)
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-black bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Pembayaran Terverifikasi</h1>
                    <p class="mb-8 font-['Inter'] text-[18px] text-gray-600">Silakan lengkapi seluruh persyaratan wisuda Anda.</p>
                    <a href="{{ route('wisuda.persyaratan.form') }}" class="rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] px-8 py-4 font-['Inter'] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Isi Persyaratan
                    </a>
                </div>
            @elseif ($persyaratanCount > 0)
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-black bg-white p-10 text-center shadow-md">
                    <h1 class="mb-8 font-['Inter'] text-[32px] font-bold text-[#0061DF]">HALAMAN NOTIFIKASI PENDAFTARAN WISUDA</h1>
                    @if ($persyaratanStatus === 'terverifikasi')
                        <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-full bg-[#0061DF]">
                            <i class="fas fa-check text-[50px] text-white"></i>
                        </div>
                        <h2 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Wisuda Siap!</h2>
                        <p class="mb-8 font-['Inter'] text-[18px] text-black">Selamat! Seluruh persyaratan wisuda telah terverifikasi.</p>
                        @if ($dataFinal)
                            <p class="mb-4 font-['Inter'] text-[16px] text-gray-600">Data orang tua & tamu sudah tersimpan.</p>
                        @else
                            <a href="{{ route('wisuda.data-tambahan') }}" class="mb-4 flex h-[50px] w-full max-w-[320px] items-center justify-center rounded-[10px] bg-green-500 text-[18px] font-semibold text-white transition hover:bg-green-600 hover:scale-105">
                                Isi Data Tambahan
                            </a>
                        @endif
                        @if ($canDownloadQr)
                            <div class="mb-8 w-full max-w-[400px] perspective-1000">
                                <div class="relative w-full overflow-hidden rounded-[20px] bg-white shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl">
                                    {{-- Ticket Header --}}
                                    <div class="bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] px-6 py-4 text-center">
                                        <h3 class="font-['Inter'] text-[14px] font-bold uppercase tracking-widest text-white opacity-80">Digital Ticket</h3>
                                        <h2 class="font-['Inter'] text-[24px] font-bold text-white">WISUDA <span class="text-yellow-400">2025</span></h2>
                                    </div>
                                    
                                    {{-- Ticket Body --}}
                                    <div class="relative flex flex-col items-center p-6 bg-white">
                                        {{-- Decorative Circles for "Ticket" look --}}
                                        <div class="absolute -left-3 top-0 h-6 w-6 -translate-y-1/2 rounded-full bg-gray-100"></div>
                                        <div class="absolute -right-3 top-0 h-6 w-6 -translate-y-1/2 rounded-full bg-gray-100"></div>
                                        
                                        {{-- QR Code Area --}}
                                        <div class="mb-4 rounded-[10px] border-2 border-dashed border-[#0061DF] p-3">
                                            <img src="{{ Storage::url($qrCode->file_qr) }}" 
                                                 alt="QR Code Presensi" 
                                                 class="h-[180px] w-[180px] object-contain">
                                        </div>
                                        
                                        {{-- Student Info --}}
                                        <div class="text-center">
                                            <h4 class="mb-1 font-['Inter'] text-[18px] font-bold text-[#0A0061]">{{ Auth::user()->name }}</h4>
                                            <p class="mb-1 font-['Inter'] text-[14px] font-medium text-gray-500">{{ Auth::user()->nim }}</p>
                                            <span class="inline-block rounded-full bg-blue-50 px-3 py-1 font-['Inter'] text-[12px] font-bold text-[#0061DF]">
                                                {{ Auth::user()->prodi ?? 'Mahasiswa' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Ticket Footer (Action) --}}
                                    <div class="border-t border-dashed border-gray-200 bg-gray-50 p-4">
                                        <a href="{{ Storage::url($qrCode->file_qr) }}" download class="flex w-full items-center justify-center gap-2 rounded-[10px] bg-[#0061DF] py-3 text-[14px] font-bold text-white transition hover:bg-[#0A0061]">
                                            <i class="fas fa-download"></i> Simpan Tiket
                                        </a>
                                        <p class="mt-2 text-center text-[10px] text-gray-400">Tunjukkan QR ini saat memasuki lokasi wisuda</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($dataFinal)
                            <div class="mb-4 w-full max-w-[400px] rounded-[10px] border border-dashed border-[#0061DF] bg-blue-50 px-6 py-4 font-['Inter'] text-[16px] text-[#0061DF] flex items-center justify-center gap-3">
                                <div class="animate-spin text-2xl"><i class="fas fa-circle-notch"></i></div>
                                <span>Sedang memproses QR Code Anda...</span>
                            </div>
                        @endif
                    @elseif ($persyaratanStatus === 'revisi')
                        <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-full bg-red-500">
                            <i class="fas fa-exclamation text-[50px] text-white"></i>
                        </div>
                        <h2 class="mb-4 font-['Inter'] text-[32px] font-bold text-red-600">Perlu Revisi</h2>
                        @if ($persyaratanRevisi && $persyaratanRevisi->catatan_admin)
                            <p class="mb-4 font-['Inter'] text-[18px] text-black">{{ $persyaratanRevisi->catatan_admin }}</p>
                        @else
                            <p class="mb-4 font-['Inter'] text-[18px] text-black">Silakan cek catatan admin pada berkas yang direvisi.</p>
                        @endif
                        <a href="{{ route('wisuda.persyaratan.form') }}" class="mb-6 rounded-[10px] bg-red-600 px-6 py-3 font-['Inter'] text-[18px] font-bold text-white transition hover:shadow-lg hover:scale-105">
                            Perbaiki Persyaratan
                        </a>
                    @else
                        <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-full bg-yellow-400">
                            <i class="fas fa-clock text-[50px] text-white"></i>
                        </div>
                        <h2 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Menunggu Verifikasi</h2>
                        <p class="mb-8 font-['Inter'] text-[18px] text-black">Data persyaratan Anda telah diterima dan sedang dicek admin. Mohon menunggu konfirmasi.</p>
                    @endif
                    <a href="{{ route('dashboard') }}" class="flex h-[60px] w-full max-w-[400px] items-center justify-center rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <div class="flex w-full max-w-[800px] flex-col items-center rounded-[10px] border-[3px] border-blue-200 bg-white p-10 text-center shadow-md">
                    <h1 class="mb-4 font-['Inter'] text-[32px] font-bold text-[#0061DF]">Data Tambahan</h1>
                    <p class="mb-8 font-['Inter'] text-[18px] text-gray-600">Lengkapi data orang tua dan tamu undangan untuk menerima QR presensi.</p>
                    <a href="{{ route('wisuda.data-tambahan') }}" class="rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] px-8 py-4 font-['Inter'] text-[20px] font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        Isi Data Tambahan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
