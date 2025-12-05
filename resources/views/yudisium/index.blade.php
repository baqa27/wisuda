@extends('layouts.mahasiswa_blank')

@section('title', 'Yudisium')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-x-hidden flex flex-col items-center">

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
        @php
            $canAccessWisuda = $persyaratan && $persyaratan->status === 'terverifikasi';
        @endphp
        <div class="absolute top-[35px] z-20 w-full flex justify-center px-4">
            <div class="flex flex-row justify-between md:justify-center items-center px-6 md:gap-[175px] w-full max-w-[1262px] h-[82px] bg-[#0061DF] rounded-[10px] shadow-lg overflow-hidden">
                <a href="{{ route('yudisium.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-medal text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Yudisium</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white">Home</span>
                </a>
                @if ($canAccessWisuda)
                    <a href="{{ route('wisuda.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                        <div class="w-6 h-6 relative flex justify-center items-center">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Wisuda</span>
                    </a>
                @else
                    <span class="flex flex-row items-center gap-2.5 opacity-60 cursor-not-allowed" title="Tunggu persyaratan terverifikasi">
                        <div class="w-6 h-6 relative flex justify-center items-center">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Wisuda Terkunci</span>
                    </span>
                @endif
            </div>
        </div>

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

@section('title', 'Yudisium')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
            Proses Yudisium
        </h1>
        <p class="text-gray-600 text-lg mt-2">Lengkapi tahapan yudisium untuk melanjutkan ke wisuda</p>
    </div>

    <!-- Progress Bar -->
    <div class="auth-card p-6 mb-6">
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-semibold text-gray-700">Progress Yudisium</span>
                <span class="text-sm font-bold text-[#0061DF]" id="progress-percentage">0%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] h-3 rounded-full transition-all duration-500" id="progress-bar" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Tahapan Yudisium -->
    <div class="auth-card p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Tahapan Yudisium</h2>
            @if (!$pendaftaran)
                <form method="POST" action="{{ route('yudisium.daftar') }}">
                    @csrf
                    <button type="submit"
                        class="btn-primary px-6 py-3 font-semibold flex items-center gap-2">
                        <i class="fas fa-plus"></i>Daftar Yudisium
                    </button>
                </form>
            @endif
        </div>

        <div class="space-y-6">
            {{-- =======================
                STEP 1 - PENDAFTARAN
            ======================= --}}
            <div class="flex items-start gap-4">
                <div class="shrink-0">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white text-lg
                        {{ $pendaftaran ? 'bg-green-500' : 'bg-gray-300' }}">
                        <i class="fas {{ $pendaftaran ? 'fa-check' : 'fa-1' }}"></i>
                    </div>
                </div>

                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 text-lg">Pendaftaran Yudisium</h3>
                    <p class="text-gray-600 mt-2">
                        @if ($pendaftaran)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] bg-green-100 text-green-700 font-semibold text-sm">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                            <span class="ml-2 text-gray-700">Kode: <strong class="font-mono">{{ $pendaftaran->kode_invoice }}</strong></span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] bg-gray-100 text-gray-700 font-semibold text-sm">
                                <i class="fas fa-clock"></i> Belum dimulai
                            </span>
                            <p class="text-sm text-gray-600 mt-2">Klik tombol "Daftar Yudisium" untuk memulai proses</p>
                        @endif
                    </p>
                </div>
            </div>

            {{-- =======================
                STEP 2 - UPLOAD BUKTI BAYAR
            ======================= --}}
            <div class="flex items-start">
                <div class="shrink-0">
                    @php
                        $status = $pendaftaran->status ?? null;
                        $icon = 'fa-money-bill-wave';
                        $bg = 'bg-gray-300';
                        if ($status === 'lunas') {
                            $icon = 'fa-check';
                            $bg = 'bg-green-500';
                        } elseif (in_array($status, ['menunggu_verifikasi', 'menunggu_pembayaran'])) {
                            $icon = 'fa-clock';
                            $bg = 'bg-yellow-500';
                        } elseif ($status === 'batal') {
                            $icon = 'fa-times';
                            $bg = 'bg-red-500';
                        }
                    @endphp
                    <div class="w-10 h-10 rounded-full {{ $bg }} flex items-center justify-center">
                        <i class="fas {{ $icon }} text-white text-sm"></i>
                    </div>
                </div>

                <div class="ml-4 flex-1">
                    <h3 class="font-medium text-gray-900">2. Upload Bukti Pembayaran</h3>
                    <p class="text-sm text-gray-600 mt-1">
                            @if ($pendaftaran)
                            @switch($pendaftaran->status)
                                @case('lunas')
                                    <span class="text-green-600">Lunas - Telah Diverifikasi</span> -
                                    Rp{{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}
                                @break

                                @case('menunggu_verifikasi')
                                    <span class="text-yellow-600">Menunggu Verifikasi Admin</span>
                                    <span class="ml-2 text-green-600">
                                        <i class="fas fa-check mr-1"></i>Bukti bayar sudah diupload
                                    </span>
                                @break

                                @case('menunggu_pembayaran')
                                    <span class="text-yellow-600">Menunggu Upload Bukti Bayar</span>
                                    @if (!$pendaftaran->bukti_bayar)
                                        <span class="ml-2 text-blue-600">
                                            <i class="fas fa-upload mr-1"></i>Silakan upload bukti transfer
                                        </span>
                                    @else
                                        <span class="ml-2 text-green-600">
                                            <i class="fas fa-check mr-1"></i>Bukti bayar sudah diupload
                                        </span>
                                    @endif
                                @break

                                @case('batal')
                                    <span class="text-red-600">Ditolak Admin - Upload ulang bukti bayar</span>
                                    @if ($pendaftaran->bukti_bayar)
                                        <span class="ml-2 text-red-500">
                                            <i class="fas fa-info-circle mr-1"></i>Bukti sebelumnya tidak valid
                                        </span>
                                    @endif
                                @break

                                @default
                                    <span class="text-gray-500">Status tidak dikenal</span>
                            @endswitch
                        @else
                            <span class="text-gray-500">Menunggu pendaftaran</span>
                        @endif
                    </p>

                    {{-- Tombol Upload / Download --}}
                    @if ($pendaftaran && in_array($pendaftaran->status, ['menunggu_pembayaran', 'menunggu_verifikasi', 'batal']))
                        <div class="mt-2 flex space-x-2">
                            <a href="{{ route('yudisium.upload-bukti', $pendaftaran->id) }}"
                                class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200 transition duration-200">
                                <i class="fas fa-upload mr-1"></i>
                                {{ $pendaftaran->bukti_bayar ? 'Upload Ulang Bukti Bayar' : 'Upload Bukti Bayar' }}
                            </a>

                            @if ($pendaftaran->bukti_bayar)
                                <a href="{{ route('yudisium.download-bukti', basename($pendaftaran->bukti_bayar)) }}"
                                    class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200 transition duration-200">
                                    <i class="fas fa-download mr-1"></i> Lihat Bukti Bayar
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Informasi Bank dan Nomor Rekening -->
                    @if ($pendaftaran && in_array($pendaftaran->status, ['menunggu_pembayaran', 'menunggu_verifikasi', 'batal']))
                        <div class="mt-3 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-800 mb-3">Transfer ke Rekening Berikut:</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
                                @php
                                    $banks = [
                                        ['kode' => 'BNI', 'warna' => 'red', 'rekening' => '1234-5678-9012-3456', 'nama' => 'Bank BNI'],
                                        ['kode' => 'BRI', 'warna' => 'blue', 'rekening' => '9876-5432-1098-7654', 'nama' => 'Bank BRI'],
                                        ['kode' => 'MDR', 'warna' => 'green', 'rekening' => '5678-1234-9012-3456', 'nama' => 'Bank Mandiri'],
                                        ['kode' => 'BCA', 'warna' => 'blue', 'rekening' => '2468-1357-8024-6813', 'nama' => 'Bank BCA'],
                                        ['kode' => 'CIMB', 'warna' => 'orange', 'rekening' => '8642-1753-9086-4217', 'nama' => 'Bank CIMB Niaga'],
                                        ['kode' => 'PMT', 'warna' => 'purple', 'rekening' => '7531-8642-9753-1864', 'nama' => 'Bank Permata'],
                                    ];
                                @endphp

                                @foreach ($banks as $bank)
                                    <div class="bank-option cursor-pointer p-3 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition duration-200"
                                        data-bank="{{ $bank['nama'] }}" data-rekening="{{ $bank['rekening'] }}">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-{{ $bank['warna'] }}-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-{{ $bank['warna'] }}-600 font-bold text-xs">{{ $bank['kode'] }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $bank['nama'] }}</div>
                                                <div class="text-sm text-gray-600">{{ $bank['rekening'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Informasi Bank yang Dipilih -->
                            <div id="selected-bank-info" class="hidden p-3 bg-white rounded-lg border border-green-200">
                                <h5 class="font-medium text-green-800 mb-2">Informasi Transfer:</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">Bank Tujuan:</span>
                                        <span id="selected-bank-name" class="text-gray-600 ml-2"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Nomor Rekening:</span>
                                        <span id="selected-rekening" class="text-gray-600 ml-2 font-mono"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Atas Nama:</span>
                                        <span class="text-gray-600 ml-2">UNIVERSITAS CONTOH</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Jumlah Transfer:</span>
                                        <span class="text-gray-600 ml-2 font-semibold">
                                            Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-green-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Harap transfer sesuai nominal dan sertakan kode invoice
                                    <strong>{{ $pendaftaran->kode_invoice }}</strong> dalam keterangan transfer.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- =======================
                STEP 3 - PERSYARATAN
            ======================= --}}
            <div class="flex items-start">
                <div class="shrink-0">
                    @php
                        $status = $persyaratan->status ?? null;
                        $bg = 'bg-gray-300';
                        $icon = 'fa-tasks';
                        if ($status === 'terverifikasi') {
                            $bg = 'bg-green-500';
                            $icon = 'fa-check';
                        } elseif ($status === 'menunggu') {
                            $bg = 'bg-yellow-500';
                            $icon = 'fa-clock';
                        } elseif ($status === 'revisi') {
                            $bg = 'bg-red-500';
                            $icon = 'fa-exclamation-triangle';
                        }
                    @endphp
                    <div class="w-10 h-10 rounded-full {{ $bg }} flex items-center justify-center">
                        <i class="fas {{ $icon }} text-white text-sm"></i>
                    </div>
                </div>

                <div class="ml-4 flex-1">
                    <h3 class="font-medium text-gray-900">3. Persyaratan Yudisium</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($persyaratan)
                            @if ($status === 'terverifikasi')
                                <span class="text-green-600">Terverifikasi</span>
                            @elseif($status === 'menunggu')
                                <span class="text-yellow-600">Menunggu Verifikasi Admin</span>
                            @elseif($status === 'revisi')
                                <span class="text-red-600">Perlu Revisi</span>
                                @if ($persyaratan->catatan_admin)
                                    <p class="text-red-500 text-sm mt-1 bg-red-50 p-2 rounded">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $persyaratan->catatan_admin }}
                                    </p>
                                @endif
                            @endif
                        @else
                            @if ($pendaftaran && $pendaftaran->status === 'lunas')
                                <a href="{{ route('yudisium.persyaratan.form') }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Isi Persyaratan
                                </a>
                            @else
                                <span class="text-gray-500">Menunggu pembayaran diselesaikan</span>
                            @endif
                        @endif
                    </p>

                    @if ($persyaratan && $status === 'revisi')
                        <div class="mt-2">
                            <a href="{{ route('yudisium.persyaratan.edit') }}"
                                class="inline-flex items-center bg-red-100 text-red-700 px-3 py-1 rounded text-sm hover:bg-red-200 transition duration-200">
                                <i class="fas fa-edit mr-1"></i>Edit Persyaratan
                            </a>
                        </div>
                    @endif

                    @if ($pendaftaran && $pendaftaran->status === 'lunas' && !$persyaratan)
                        <div class="mt-2">
                            <a href="{{ route('yudisium.persyaratan.form') }}"
                                class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200 transition duration-200">
                                <i class="fas fa-file-upload mr-1"></i>Upload Persyaratan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- =======================
        STATUS TERAKHIR
    ======================= --}}
    @if ($persyaratan && $persyaratan->status == 'terverifikasi')
        <div class="auth-card border-l-4 border-l-green-500 p-6 mb-6">
            <div class="flex items-start gap-4">
                <i class="fas fa-check-circle text-green-600 text-2xl mt-1"></i>
                <div class="flex-1">
                    <h3 class="font-bold text-green-800 text-lg">Yudisium Terverifikasi!</h3>
                    <p class="text-green-700 mt-1">Selamat! Yudisium Anda telah diverifikasi. Silakan lanjutkan ke proses wisuda.</p>
                    <a href="{{ route('wisuda.index') }}"
                        class="inline-block mt-4 btn-primary px-6 py-3 font-semibold">
                        <i class="fas fa-arrow-right mr-2"></i>Lanjut ke Wisuda
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- =======================
        INFORMASI UMUM
    ======================= --}}
    <div class="auth-card border-l-4 border-l-blue-500 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-info-circle text-blue-600"></i>Informasi Yudisium
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div class="flex items-start gap-2">
                <i class="fas fa-check-circle text-[#0061DF] mt-1 shrink-0"></i>
                <span>Yudisium adalah proses penilaian akhir untuk menentukan kelulusan mahasiswa</span>
            </div>
            <div class="flex items-start gap-2">
                <i class="fas fa-check-circle text-[#0061DF] mt-1 shrink-0"></i>
                <span>Proses verifikasi membutuhkan waktu 2-3 hari kerja</span>
            </div>
            <div class="flex items-start gap-2">
                <i class="fas fa-check-circle text-[#0061DF] mt-1 shrink-0"></i>
                <span>Pastikan semua dokumen yang diupload jelas dan terbaca</span>
            </div>
            <div class="flex items-start gap-2">
                <i class="fas fa-check-circle text-[#0061DF] mt-1 shrink-0"></i>
                <span>Dapat upload ulang bukti bayar kapan saja selama menunggu verifikasi</span>
            </div>
        </div>
    </div>

    {{-- =======================
        SCRIPT JS
    ======================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = document.getElementById('progress-percentage');

            let progress = 0;
            @if ($pendaftaran)
                progress += 33;
            @endif
            @if ($pendaftaran && $pendaftaran->status === 'lunas')
                progress += 33;
            @endif
            @if ($persyaratan && $persyaratan->status == 'terverifikasi')
                progress += 34;
            @endif

            progressBar.style.width = progress + '%';
            progressPercentage.textContent = progress + '%';

            // Inisialisasi pilihan bank
            const bankOptions = document.querySelectorAll('.bank-option');
            const selectedBankInfo = document.getElementById('selected-bank-info');
            const selectedBankName = document.getElementById('selected-bank-name');
            const selectedRekening = document.getElementById('selected-rekening');

            bankOptions.forEach(option => {
                option.addEventListener('click', () => {
                    bankOptions.forEach(opt => {
                        opt.classList.remove('border-blue-500', 'bg-blue-50');
                        opt.classList.add('border-gray-200');
                    });

                    option.classList.remove('border-gray-200');
                    option.classList.add('border-blue-500', 'bg-blue-50');

                    const bankName = option.getAttribute('data-bank');
                    const rekening = option.getAttribute('data-rekening');
                    selectedBankName.textContent = bankName;
                    selectedRekening.textContent = rekening;
                    selectedBankInfo.classList.remove('hidden');

                    // Simpan pilihan ke localStorage
                    localStorage.setItem('selectedBank', bankName);
                    localStorage.setItem('selectedRekening', rekening);
                });
            });

            // Load pilihan bank sebelumnya jika ada
            const savedBank = localStorage.getItem('selectedBank');
            const savedRekening = localStorage.getItem('selectedRekening');
            if (savedBank && savedRekening) {
                bankOptions.forEach(option => {
                    if (option.getAttribute('data-bank') === savedBank) {
                        option.click();
                    }
                });
            }
        });
    </script>
@endsection
