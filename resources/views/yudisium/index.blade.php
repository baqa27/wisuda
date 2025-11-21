@extends('layouts.mahasiswa')

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

                                @default
                                    <span class="text-red-600">Batal</span>
                            @endswitch
                        @else
                            <span class="text-gray-500">Menunggu pendaftaran</span>
                        @endif
                    </p>

                    {{-- Tombol Upload / Download --}}
                    @if ($pendaftaran && in_array($pendaftaran->status, ['menunggu_pembayaran', 'menunggu_verifikasi']))
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
                    @if ($pendaftaran && in_array($pendaftaran->status, ['menunggu_pembayaran', 'menunggu_verifikasi']))
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
                            @if ($pendaftaran && $pendaftaran->status == 'lunas')
                                <a href="{{ route('yudisium.persyaratan.form') }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Isi Persyaratan
                                </a>
                            @else
                                <span class="text-gray-500">Menunggu pembayaran lunas</span>
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

                    @if ($pendaftaran && $pendaftaran->status == 'lunas' && !$persyaratan)
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
            @if ($pendaftaran && $pendaftaran->status == 'lunas')
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
