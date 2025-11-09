@extends('layouts.mahasiswa')

@section('title', 'Wisuda')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Proses Wisuda</h1>
        <p class="text-gray-600">Lengkapi tahapan wisuda untuk mendapatkan QR Presensi</p>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Tahapan Wisuda</h2>
            @if (!$pendaftaran && $yudisiumTerverifikasi)
                <form method="POST" action="{{ route('wisuda.daftar') }}">
                    @csrf
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Daftar Wisuda
                    </button>
                </form>
            @endif
        </div>

        <div class="space-y-6">
            <!-- Step 1: Pendaftaran -->
            <div class="flex items-start">
                <div class="shrink-0">
                    <div
                        class="w-10 h-10 rounded-full {{ $pendaftaran ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                        <i class="fas {{ $pendaftaran ? 'fa-check' : 'fa-file-alt' }} text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="font-medium text-gray-900">1. Pendaftaran Wisuda</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($pendaftaran)
                            <span class="text-green-600">Selesai</span> - Kode: {{ $pendaftaran->kode_invoice }}
                        @else
                            @if ($yudisiumTerverifikasi)
                                <span class="text-gray-500">Belum dimulai</span>
                            @else
                                <span class="text-red-500">Yudisium belum terverifikasi</span>
                            @endif
                        @endif
                    </p>
                </div>
            </div>

            <!-- Step 2: Pembayaran -->
            <div class="flex items-start">
                <div class="shrink-0">
                    <div
                        class="w-10 h-10 rounded-full
            {{ $pendaftaran && $pendaftaran->status == 'lunas' ? 'bg-green-500' : '' }}
            {{ $pendaftaran && $pendaftaran->status == 'menunggu_verifikasi' ? 'bg-yellow-500' : '' }}
            {{ $pendaftaran && $pendaftaran->status == 'menunggu_pembayaran' ? 'bg-gray-400' : '' }}
            {{ !$pendaftaran ? 'bg-gray-300' : '' }}
            flex items-center justify-center">
                        <i
                            class="fas
                {{ $pendaftaran && $pendaftaran->status == 'lunas' ? 'fa-check' : '' }}
                {{ $pendaftaran && $pendaftaran->status == 'menunggu_verifikasi' ? 'fa-clock' : '' }}
                {{ $pendaftaran && $pendaftaran->status == 'menunggu_pembayaran' ? 'fa-money-bill-wave' : '' }}
                {{ !$pendaftaran ? 'fa-money-bill-wave' : '' }}
                text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="font-medium text-gray-900">2. Pembayaran Wisuda</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($pendaftaran)
                            @if ($pendaftaran->status == 'lunas')
                                <span class="text-green-600">Lunas</span> - Rp
                                {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}
                            @elseif($pendaftaran->status == 'menunggu_verifikasi')
                                <span class="text-yellow-600">Menunggu Verifikasi Admin</span>
                                @if ($pendaftaran->bukti_bayar)
                                    <span class="ml-2 text-green-600">✓ Bukti bayar sudah diupload</span>
                                @else
                                    <span class="ml-2 text-red-600">✗ Belum upload bukti bayar</span>
                                @endif
                            @elseif($pendaftaran->status == 'menunggu_pembayaran')
                                <span class="text-blue-600">Menunggu Pembayaran</span>
                                <a href="{{ route('wisuda.upload-bukti', $pendaftaran->id) }}"
                                    class="ml-2 text-blue-600 hover:text-blue-800">
                                    Upload Bukti Bayar
                                </a>
                            @else
                                <span class="text-red-600">Batal</span>
                            @endif
                        @else
                            <span class="text-gray-500">Menunggu pendaftaran</span>
                        @endif
                    </p>
                </div>
            </div>
            <!-- Step 3: Persyaratan Wisuda -->
            <div class="flex items-start">
                <div class="shrink-0">
                    @php
                        $persyaratanCount = $persyaratan->count();
                        $persyaratanTerverifikasi = $persyaratan->where('status', 'terverifikasi')->count();
                        $allVerified = $persyaratanCount > 0 && $persyaratanCount == $persyaratanTerverifikasi;
                    @endphp
                    <div
                        class="w-10 h-10 rounded-full
                    {{ $allVerified ? 'bg-green-500' : '' }}
                    {{ $persyaratanCount > 0 && !$allVerified ? 'bg-yellow-500' : '' }}
                    {{ $persyaratanCount == 0 ? 'bg-gray-300' : '' }}
                    flex items-center justify-center">
                        <i
                            class="fas
                        {{ $allVerified ? 'fa-check' : '' }}
                        {{ $persyaratanCount > 0 && !$allVerified ? 'fa-clock' : '' }}
                        {{ $persyaratanCount == 0 ? 'fa-tasks' : '' }}
                        text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="font-medium text-gray-900">3. Persyaratan Wisuda</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($persyaratanCount > 0)
                            @if ($allVerified)
                                <span class="text-green-600">Semua Terverifikasi</span>
                                ({{ $persyaratanTerverifikasi }}/{{ $persyaratanCount }})
                            @else
                                <span class="text-yellow-600">Menunggu Verifikasi</span>
                                ({{ $persyaratanTerverifikasi }}/{{ $persyaratanCount }})
                            @endif
                            <a href="{{ route('wisuda.persyaratan.form') }}"
                                class="ml-2 text-blue-600 hover:text-blue-800">
                                Kelola Persyaratan
                            </a>
                        @else
                            @if ($pendaftaran && $pendaftaran->status == 'lunas')
                                <a href="{{ route('wisuda.persyaratan.form') }}" class="text-blue-600 hover:text-blue-800">
                                    Upload Persyaratan
                                </a>
                            @else
                                <span class="text-gray-500">Menunggu pembayaran lunas</span>
                            @endif
                        @endif
                    </p>
                </div>
            </div>

            <!-- Step 4: Data Tambahan -->
            <div class="flex items-start">
                <div class="shrink-0">
                    <div
                        class="w-10 h-10 rounded-full
                    {{ $dataFinal ? 'bg-green-500' : 'bg-gray-300' }}
                    flex items-center justify-center">
                        <i class="fas {{ $dataFinal ? 'fa-check' : 'fa-user-friends' }} text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="font-medium text-gray-900">4. Data Orang Tua & Tamu</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($dataFinal)
                            <span class="text-green-600">Selesai</span>
                        @else
                            @if ($allVerified)
                                <a href="{{ route('wisuda.data-tambahan') }}" class="text-blue-600 hover:text-blue-800">
                                    Isi Data Tambahan
                                </a>
                            @else
                                <span class="text-gray-500">Menunggu persyaratan terverifikasi</span>
                            @endif
                        @endif
                    </p>
                </div>
            </div>

            <!-- Step 5: QR Presensi -->
            <div class="flex items-start">
                <div class="shrink-0">
                    <div
                        class="w-10 h-10 rounded-full
                    {{ $qrCode ? 'bg-green-500' : 'bg-gray-300' }}
                    flex items-center justify-center">
                        <i class="fas {{ $qrCode ? 'fa-check' : 'fa-qrcode' }} text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="font-medium text-gray-900">5. QR Presensi</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if ($qrCode)
                            <span class="text-green-600">Siap</span>
                            @if ($qrCode->file_qr)
                                <a href="{{ Storage::url($qrCode->file_qr) }}" download
                                    class="ml-2 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download mr-1"></i>Download QR
                                </a>
                            @endif
                        @else
                            <span class="text-gray-500">Menunggu kelengkapan data</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Info -->
    @if ($dataFinal && $dataFinal->status == 'siap_wisuda')
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                <div>
                    <h3 class="font-semibold text-green-800">Siap Wisuda!</h3>
                    <p class="text-green-700">Selamat! Anda telah menyelesaikan semua persyaratan wisuda.</p>
                    @if ($qrCode && $qrCode->file_qr)
                        <a href="{{ Storage::url($qrCode->file_qr) }}" download
                            class="inline-block mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            <i class="fas fa-download mr-2"></i>Download QR Presensi
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Daftar Persyaratan -->
    @if ($persyaratan->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Persyaratan Wisuda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($persyaratan as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900">
                                @php
                                    $jenisLabels = [
                                        'toefl' => 'Sertifikat TOEFL',
                                        'sertifikasi' => 'Sertifikasi Kompetensi',
                                        'tahfidz' => 'Sertifikat Tahfidz',
                                        'bebas_perpus' => 'Bebas Perpustakaan',
                                        'foto_wisuda' => 'Foto Wisuda',
                                        'buku_kenangan' => 'Buku Kenangan',
                                    ];
                                @endphp
                                {{ $jenisLabels[$item->jenis] ?? $item->jenis }}
                            </h3>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $item->status == 'terverifikasi' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $item->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $item->status == 'revisi' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $item->status == 'terverifikasi' ? 'Terverifikasi' : '' }}
                                {{ $item->status == 'menunggu' ? 'Menunggu' : '' }}
                                {{ $item->status == 'revisi' ? 'Revisi' : '' }}
                            </span>
                        </div>
                        @if ($item->catatan_admin)
                            <p class="text-sm text-red-600 mt-1">{{ $item->catatan_admin }}</p>
                        @endif
                        <a href="{{ route('wisuda.download', basename($item->file_path)) }}"
                            class="mt-2 inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-download mr-1"></i> Download File
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
