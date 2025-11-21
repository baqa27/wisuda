@extends('layouts.mahasiswa')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-600 text-lg mt-2">
            Akses kapanpun dan dimanapun Demi kelancaran Yudisium dan Wisuda Anda
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- NIM Card -->
        <div class="auth-card p-6 border-l-4 border-l-[#0061DF]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">NIM</p>
                    <p class="text-2xl font-bold text-[#0A0061]">{{ Auth::user()->nim }}</p>
                </div>
                <div class="icon-container bg-blue-100">
                    <i class="fas fa-id-card text-[#0061DF]"></i>
                </div>
            </div>
        </div>

        <!-- IPK Card -->
        <div class="auth-card p-6 border-l-4 border-l-[#0061DF]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">IPK</p>
                    <p class="text-2xl font-bold text-[#0A0061]">{{ Auth::user()->ipk ?? '-' }}</p>
                </div>
                <div class="icon-container bg-blue-100">
                    <i class="fas fa-chart-line text-[#0061DF]"></i>
                </div>
            </div>
        </div>

        <!-- Prodi Card -->
        <div class="auth-card p-6 border-l-4 border-l-[#0061DF]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Program Studi</p>
                    <p class="text-lg font-bold text-[#0A0061] truncate">{{ Auth::user()->prodi ?? '-' }}</p>
                </div>
                <div class="icon-container bg-blue-100">
                    <i class="fas fa-book text-[#0061DF]"></i>
                </div>
            </div>
        </div>

        <!-- Phone Card -->
        <div class="auth-card p-6 border-l-4 border-l-[#0061DF]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">No. HP</p>
                    <p class="text-lg font-bold text-[#0A0061]">{{ Auth::user()->no_hp ?? '-' }}</p>
                </div>
                <div class="icon-container bg-blue-100">
                    <i class="fas fa-phone text-[#0061DF]"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Yudisium Card -->
        <div class="auth-card overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-certificate"></i>
                        Yudisium
                    </h2>
                </div>
                <p class="text-blue-100">Proses penilaian akhir untuk menentukan kelulusan Anda</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">
                    Lengkapi semua tahapan yudisium meliputi pembayaran, pengisian persyaratan, dan verifikasi dokumen.
                </p>
                <a href="{{ route('yudisium.index') }}"
                    class="btn-primary w-full text-center py-3 font-semibold transition-all hover:shadow-lg">
                    <i class="fas fa-arrow-right mr-2"></i>Kelola Yudisium
                </a>
            </div>
        </div>

        <!-- Wisuda Card -->
        <div class="auth-card overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-graduation-cap"></i>
                        Wisuda
                    </h2>
                </div>
                <p class="text-blue-100">Persiapan Anda untuk menghadiri upacara wisuda</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">
                    Daftar wisuda, upload persyaratan, dan isikan data tambahan untuk memastikan kehadiran Anda.
                </p>
                <a href="{{ route('wisuda.index') }}"
                    class="btn-primary w-full text-center py-3 font-semibold transition-all hover:shadow-lg">
                    <i class="fas fa-arrow-right mr-2"></i>Kelola Wisuda
                </a>
            </div>
        </div>
    </div>
@endsection
