@extends('layouts.mahasiswa_blank')

@section('title', 'Yudisium')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-hidden flex flex-col items-center">

        {{-- Background Elements --}}
        <div class="absolute w-[886px] h-[886px] -left-[456px] top-[658px] pointer-events-none z-0 hidden md:block">
            <div class="absolute w-[206.67px] h-[886px] left-[339.66px] top-0 bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute w-[305.52px] h-[886px] left-0 top-[289.34px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>
        <div class="absolute w-[493px] h-[493px] left-[1259px] top-[308px] pointer-events-none z-0 hidden md:block">
            <div class="absolute w-[115px] h-[493px] left-[189px] top-0 bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute w-[170px] h-[493px] left-0 top-[161px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>

        {{-- Top Navigation Bar --}}
        <x-mahasiswa-navbar />

        {{-- Main Content --}}
        <div class="relative z-10 flex flex-col items-center w-full max-w-[1262px] pt-[150px] px-4 pb-20">

            {{-- Logic Display --}}
            @if (!$pendaftaran)
                {{-- State 1: Belum Daftar --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Pendaftaran Yudisium</h1>
                    <p class="font-['Inter'] text-[18px] text-gray-600 mb-8">Silakan melakukan pendaftaran untuk mengikuti proses yudisium.</p>

                    <form method="POST" action="{{ route('yudisium.daftar') }}">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>

            @elseif ($pendaftaran->status == 'menunggu_pembayaran')
                {{-- State 2: Menunggu Pembayaran --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Menunggu Pembayaran</h1>
                    <p class="font-['Inter'] text-[18px] text-gray-600 mb-8">Silakan selesaikan pembayaran untuk melanjutkan.</p>

                    <a href="{{ route('yudisium.upload-bukti', $pendaftaran->id) }}" class="px-8 py-4 bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                        Lanjutkan Pembayaran
                    </a>
                </div>

            @elseif ($pendaftaran->status == 'menunggu_verifikasi')
                {{-- State 3: Menunggu Verifikasi Pembayaran (Notification Style) --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-8">HALAMAN NOTIFIKASI PEMBAYARAN YUDISIUM</h1>

                    <div class="w-[100px] h-[100px] bg-yellow-400 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-white text-[50px]"></i>
                    </div>

                    <h2 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Menunggu Verifikasi</h2>
                    <p class="font-['Inter'] text-[18px] text-black mb-8">Bukti pembayaran Anda telah diterima dan sedang dicek admin. Harap tunggu sebelum melanjutkan ke persyaratan.</p>

                    <a href="{{ route('dashboard') }}" class="w-full max-w-[400px] h-[60px] flex items-center justify-center bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                        Kembali ke Dashboard
                    </a>
                </div>

            @elseif ($pendaftaran->status == 'batal')
                {{-- State 4: Pembayaran Ditolak Admin --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-red-400 rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-red-600 mb-4">Pembayaran Ditolak</h1>
                    <p class="font-['Inter'] text-[18px] text-gray-700 mb-6">Admin menolak bukti pembayaran Anda. Silakan unggah ulang bukti yang sesuai.</p>

                    <div class="w-[100px] h-[100px] bg-red-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-times text-white text-[50px]"></i>
                    </div>

                    <a href="{{ route('yudisium.upload-bukti', $pendaftaran->id) }}" class="px-8 py-4 bg-red-600 rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                        Upload Bukti Baru
                    </a>
                </div>

            @elseif ($pendaftaran->status == 'lunas' && !$persyaratan)
                {{-- State 4: Lunas, Belum Isi Persyaratan --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Pembayaran Terverifikasi</h1>
                    <p class="font-['Inter'] text-[18px] text-gray-600 mb-8">Silakan lengkapi persyaratan yudisium Anda.</p>

                    <a href="{{ route('yudisium.persyaratan.form') }}" class="px-8 py-4 bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                        Isi Persyaratan
                    </a>
                </div>

            @elseif ($persyaratan)
                {{-- State 5: Sudah Isi Persyaratan (Notification Style) --}}
                <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 flex flex-col items-center text-center">
                    <h1 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-8">HALAMAN NOTIFIKASI PENDAFTARAN YUDISIUM</h1>

                    @if($persyaratan->status == 'terverifikasi')
                        <div class="w-[100px] h-[100px] bg-[#0061DF] rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-check text-white text-[50px]"></i>
                        </div>
                        <h2 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Yudisium Selesai!</h2>
                        <p class="font-['Inter'] text-[18px] text-black mb-8">Selamat! Anda telah menyelesaikan proses Yudisium.</p>
                    @elseif($persyaratan->status == 'revisi')
                        <div class="w-[100px] h-[100px] bg-red-500 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-exclamation text-white text-[50px]"></i>
                        </div>
                        <h2 class="font-['Inter'] font-bold text-[32px] text-red-600 mb-4">Perlu Revisi</h2>
                        <p class="font-['Inter'] text-[18px] text-black mb-4">{{ $persyaratan->catatan_admin }}</p>
                        <a href="{{ route('yudisium.persyaratan.edit') }}" class="px-6 py-3 bg-red-600 rounded-[10px] text-white font-bold text-[18px] hover:shadow-lg transition-all mb-8">
                            Perbaiki Persyaratan
                        </a>
                    @else
                        <div class="w-[100px] h-[100px] bg-yellow-400 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-clock text-white text-[50px]"></i>
                        </div>
                        <h2 class="font-['Inter'] font-bold text-[32px] text-[#0061DF] mb-4">Menunggu Verifikasi</h2>
                        <p class="font-['Inter'] text-[18px] text-black mb-8">Data persyaratan Anda telah diterima dan sedang dicek admin. Harap tunggu konfirmasi sebelum melanjutkan ke wisuda.</p>
                    @endif

                    <a href="{{ route('dashboard') }}" class="w-full max-w-[400px] h-[60px] flex items-center justify-center bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[20px] hover:shadow-lg transition-all">
                        Kembali ke Dashboard
                    </a>
                </div>

            @endif

        </div>
    </div>
@endsection


