@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Header Section -->
<div class="mb-10">
    <h1 class="text-5xl font-bold text-[#02AC10]">
        Dashboard Admin
    </h1>
    <p class="text-gray-500 text-xl mt-2">Selamat datang di Sistem Wisuda - Kelola Pendaftaran & Verifikasi</p>
</div>

<!-- Statistik Cards Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
    <!-- Total Mahasiswa -->
    <div class="bg-white p-6 rounded-xl border border-[#E0EBE2] shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#738C77] text-sm font-normal mb-1">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-[#1F1F1F]">{{ $stats['total_mahasiswa'] }}</p>
            </div>
            <div class="w-14 h-14 bg-[#DCFFE6] rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#007D0B] text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="bg-white p-6 rounded-xl border border-[#E0EBE2] shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#8A8C73] text-sm font-normal mb-1">Menunggu Verifikasi</p>
                <p class="text-3xl font-bold text-[#1F1F1F]">
                    {{ $stats['yudisium_menunggu'] + $stats['wisuda_menunggu'] }}
                </p>
            </div>
            <div class="w-14 h-14 bg-[#FCFFDC] rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-[#7D7900] text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Siap Wisuda -->
    <div class="bg-white p-6 rounded-xl border border-[#E0E8EB] shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#73838C] text-sm font-normal mb-1">Siap Wisuda</p>
                <p class="text-3xl font-bold text-[#1F1F1F]">{{ $stats['siap_wisuda'] }}</p>
            </div>
            <div class="w-14 h-14 bg-[#DCF8FF] rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-[#006C7D] text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Two Column Panels -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

    <!-- Left Panel - Verifikasi -->
    <div class="bg-white rounded-xl border border-[#E0EBE2] shadow-sm overflow-hidden">
        <div class="bg-linear-to-r from-[#056100] to-[#00DF1A] px-5 py-4 flex items-center gap-3">
            <i class="fas fa-check-circle text-white text-xl opacity-80"></i>
            <h2 class="text-xl font-bold text-white">Verifikasi</h2>
        </div>
        <div class="p-6 space-y-4">

            <!-- Pembayaran Yudisium -->
            <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}"
               class="flex items-center justify-between p-4 bg-[#DDFFE3] hover:bg-green-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-money-bill-wave text-[#007D0B] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Pembayaran Yudisium</p>
                        <p class="text-xs text-gray-500">Verifikasi bukti pembayaran</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#007D0B] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['yudisium_menunggu'] }}
                </span>
            </a>

            <!-- Persyaratan Yudisium -->
            <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}"
               class="flex items-center justify-between p-4 bg-[#DDFAFF] hover:bg-cyan-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-file-alt text-[#00737D] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Persyaratan Yudisium</p>
                        <p class="text-xs text-gray-500">Verifikasi dokumen persyaratan</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#00737D] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['persyaratan_yudisium_menunggu'] }}
                </span>
            </a>

            <!-- Pembayaran Wisuda -->
            <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}"
               class="flex items-center justify-between p-4 bg-[#FEFFDD] hover:bg-yellow-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-money-bill-wave text-[#7B7D00] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Pembayaran Wisuda</p>
                        <p class="text-xs text-gray-500">Verifikasi bukti pembayaran</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#7B7D00] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['wisuda_menunggu'] }}
                </span>
            </a>

            <!-- Persyaratan Wisuda -->
            <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}"
               class="flex items-center justify-between p-4 bg-[#FFE0DD] hover:bg-red-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-file-alt text-[#7D1500] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Persyaratan Wisuda</p>
                        <p class="text-xs text-gray-500">Verifikasi dokumen persyaratan</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#7D1500] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['persyaratan_wisuda_menunggu'] }}
                </span>
            </a>

        </div>
    </div>

    <!-- Right Panel - Data & Laporan -->
    <div class="bg-white rounded-xl border border-[#E0EBE2] shadow-sm overflow-hidden">
        <div class="bg-linear-to-r from-[#056100] to-[#00DF1A] px-5 py-4 flex items-center gap-3">
            <i class="fas fa-database text-white text-xl opacity-80"></i>
            <h2 class="text-xl font-bold text-white">Data & Laporan</h2>
        </div>
        <div class="p-6 space-y-4">

            <!-- Manajemen Mahasiswa -->
            <a href="{{ route('admin.manajemen-mahasiswa') }}"
               class="flex items-center justify-between p-4 bg-[#DDFFE3] hover:bg-green-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-users text-[#007D0B] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Manajemen Mahasiswa</p>
                        <p class="text-xs text-gray-500">Kelola data Mahasiswa terdaftar</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#007D0B] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['total_mahasiswa'] }}
                </span>
            </a>

            <!-- Data Final -->
            <a href="{{ route('admin.data-final') }}"
               class="flex items-center justify-between p-4 bg-[#DDFAFF] hover:bg-cyan-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-layer-group text-[#00737D] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Data Final</p>
                        <p class="text-xs text-gray-500">Data Mahasiswa siap Wisuda</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#00737D] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    {{ $stats['siap_wisuda'] }}
                </span>
            </a>

            <!-- Generate QR -->
            <a href="{{ route('admin.generate-qr.form') }}"
               class="flex items-center justify-between p-4 bg-[#FEFFDD] hover:bg-yellow-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-qrcode text-[#7B7D00] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Generate QR</p>
                        <p class="text-xs text-gray-500">Buat QR code kehadiran Mahasiswa</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#7B7D00] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    0
                </span>
            </a>

            <!-- Export Data -->
            <a href="{{ route('admin.export-data-final') }}"
               class="flex items-center justify-between p-4 bg-[#FFE0DD] hover:bg-red-100 rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-download text-[#7D1500] text-xl"></i>
                    <div>
                        <p class="font-bold text-gray-700">Export Data</p>
                        <p class="text-xs text-gray-500">Download data final ke CSV</p>
                    </div>
                </div>
                <span class="w-8 h-8 bg-[#7D1500] text-white rounded-full flex items-center justify-center text-sm font-bold">
                    0
                </span>
            </a>

        </div>
    </div>

</div>
@endsection
