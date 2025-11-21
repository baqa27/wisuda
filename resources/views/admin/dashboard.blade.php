@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
        Dashboard Admin
    </h1>
    <p class="text-gray-600 text-lg mt-2">Selamat datang di Sistem Wisuda - Kelola Pendaftaran & Verifikasi</p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Mahasiswa -->
    <div class="auth-card p-6 border-l-4 border-l-[#0061DF] hover:shadow-lg transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-2">Total Mahasiswa</p>
                <p class="text-4xl font-bold text-[#0A0061]">{{ $stats['total_mahasiswa'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Terdaftar dalam sistem</p>
            </div>
            <div class="icon-container bg-blue-100">
                <i class="fas fa-users text-[#0061DF] text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="auth-card p-6 border-l-4 border-l-[#0061DF] hover:shadow-lg transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-2">Menunggu Verifikasi</p>
                <p class="text-4xl font-bold text-[#0A0061]">
                    {{ $stats['yudisium_menunggu'] + $stats['wisuda_menunggu'] }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Pembayaran & dokumen</p>
            </div>
            <div class="icon-container bg-yellow-100">
                <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Siap Wisuda -->
    <div class="auth-card p-6 border-l-4 border-l-[#0061DF] hover:shadow-lg transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-2">Siap Wisuda</p>
                <p class="text-4xl font-bold text-[#0A0061]">{{ $stats['siap_wisuda'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Lengkap semua dokumen</p>
            </div>
            <div class="icon-container bg-green-100">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

    <!-- Verifikasi Panel -->
    <div class="auth-card overflow-hidden">
        <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-check-double"></i>
                Verifikasi
            </h2>
        </div>
        <div class="p-6 space-y-3">

            <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}"
               class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-[10px] transition border border-blue-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-credit-card text-[#0061DF] text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Pembayaran Yudisium</p>
                        <p class="text-xs text-gray-600">Verifikasi bukti pembayaran</p>
                    </div>
                </div>
                <span class="bg-[#0061DF] text-white px-3 py-1 rounded-full text-sm font-bold">
                    {{ $stats['yudisium_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}"
               class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-[10px] transition border border-green-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-pdf text-green-600 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Persyaratan Yudisium</p>
                        <p class="text-xs text-gray-600">Verifikasi dokumen persyaratan</p>
                    </div>
                </div>
                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                    {{ $stats['persyaratan_yudisium_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}"
               class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-[10px] transition border border-purple-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-credit-card text-purple-600 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Pembayaran Wisuda</p>
                        <p class="text-xs text-gray-600">Verifikasi bukti pembayaran</p>
                    </div>
                </div>
                <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                    {{ $stats['wisuda_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}"
               class="flex items-center justify-between p-4 bg-orange-50 hover:bg-orange-100 rounded-[10px] transition border border-orange-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-pdf text-orange-600 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-800">Persyaratan Wisuda</p>
                        <p class="text-xs text-gray-600">Verifikasi dokumen persyaratan</p>
                    </div>
                </div>
                <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                    {{ $stats['persyaratan_wisuda_menunggu'] }}
                </span>
            </a>

        </div>
    </div>

    <!-- Data & Laporan Panel -->
    <div class="auth-card overflow-hidden">
        <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-database"></i>
                Data & Laporan
            </h2>
        </div>
        <div class="p-6 space-y-3">

            <a href="{{ route('admin.manajemen-mahasiswa') }}"
               class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-gray-100 rounded-[10px] transition border border-gray-200">
                <i class="fas fa-list text-gray-700 text-lg"></i>
                <div>
                    <p class="font-semibold text-gray-800">Manajemen Mahasiswa</p>
                    <p class="text-xs text-gray-600">Kelola data mahasiswa terdaftar</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>

            <a href="{{ route('admin.data-final') }}"
               class="flex items-center gap-3 p-4 bg-indigo-50 hover:bg-indigo-100 rounded-[10px] transition border border-indigo-200">
                <i class="fas fa-graduation-cap text-indigo-600 text-lg"></i>
                <div>
                    <p class="font-semibold text-gray-800">Data Final Wisuda</p>
                    <p class="text-xs text-gray-600">Data mahasiswa siap wisuda</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>

            <a href="{{ route('admin.generate-qr') }}"
               class="flex items-center gap-3 p-4 bg-teal-50 hover:bg-teal-100 rounded-[10px] transition border border-teal-200">
                <i class="fas fa-qrcode text-teal-600 text-lg"></i>
                <div>
                    <p class="font-semibold text-gray-800">Generate QR Code</p>
                    <p class="text-xs text-gray-600">Buat QR code kehadiran wisuda</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>

            <a href="{{ route('admin.export-data-final') }}"
               class="flex items-center gap-3 p-4 bg-pink-50 hover:bg-pink-100 rounded-[10px] transition border border-pink-200">
                <i class="fas fa-download text-pink-600 text-lg"></i>
                <div>
                    <p class="font-semibold text-gray-800">Export Data</p>
                    <p class="text-xs text-gray-600">Download data final ke CSV</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
            </a>

        </div>
    </div>

</div>

<!-- Daftar Mahasiswa Terbaru -->
<div class="auth-card overflow-hidden">
    <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-6">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <i class="fas fa-user-clock"></i>
            Mahasiswa Terbaru
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-t">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIM</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMahasiswa as $mahasiswa)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $mahasiswa->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $mahasiswa->nim ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $mahasiswa->prodi ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        <span class="text-sm">{{ $mahasiswa->created_at->format('d/m/Y') }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
