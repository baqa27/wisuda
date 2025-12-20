@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-[#056100] to-[#00DF1A] bg-clip-text text-transparent">
            Dashboard Admin
        </h1>
        <p class="text-gray-600 text-lg mt-2">Selamat datang di Sistem Wisuda - Kelola Pendaftaran & Verifikasi</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="auth-card p-6 border-l-4 border-l-[#00DF1A] hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Mahasiswa</p>
                    <p class="text-4xl font-bold text-[#056100]">{{ $stats['total_mahasiswa'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">Terdaftar dalam sistem</p>
                </div>
                <div class="icon-container bg-green-100">
                    <i class="fas fa-users text-[#00DF1A] text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="auth-card p-6 border-l-4 border-l-yellow-500 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Menunggu Verifikasi</p>
                    <p class="text-4xl font-bold text-yellow-600">
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
        <div class="auth-card p-6 border-l-4 border-l-green-500 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Siap Wisuda</p>
                    <p class="text-4xl font-bold text-green-600">{{ $stats['siap_wisuda'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">Lengkap semua dokumen</p>
                </div>
                <div class="icon-container bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pembayaran Lunas -->
        <div class="auth-card p-6 border-l-4 border-l-green-500 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Pembayaran Lunas</p>
                    <p class="text-4xl font-bold text-green-600">{{ $stats['pembayaran_lunas'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-credit-card mr-1"></i>
                        {{ $stats['pembayaran_midtrans'] ?? 0 }} via Midtrans
                    </p>
                </div>
                <div class="icon-container bg-green-100">
                    <i class="fas fa-check-double text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="auth-card p-6 border-l-4 border-l-purple-500 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-purple-600">Rp
                        {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">Dari pembayaran yudisium</p>
                </div>
                <div class="icon-container bg-purple-100">
                    <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pembayaran Menunggu -->
        <div class="auth-card p-6 border-l-4 border-l-orange-500 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Perlu Verifikasi</p>
                    <p class="text-4xl font-bold text-orange-600">{{ $stats['yudisium_menunggu'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">Menunggu approve admin</p>
                </div>
                <div class="icon-container bg-orange-100">
                    <i class="fas fa-clock text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <!-- Verifikasi Panel -->
        <div class="auth-card overflow-hidden">
            <div class="bg-gradient-to-r from-[#056100] to-[#00DF1A] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-check-double"></i>
                    Verifikasi
                </h2>
            </div>
            <div class="p-6 space-y-3">

                <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}"
                    class="flex items-center justify-between p-4 bg-gray-50 hover:bg-green-50 rounded-[10px] transition border border-gray-200 hover:border-green-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-credit-card text-[#00DF1A] text-lg"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Pembayaran Yudisium</p>
                            <p class="text-xs text-gray-600">Verifikasi bukti pembayaran</p>
                        </div>
                    </div>
                    <span class="bg-[#00DF1A] text-white px-3 py-1 rounded-full text-sm font-bold">
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
            <div class="bg-gradient-to-r from-[#056100] to-[#00DF1A] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-database"></i>
                    Data & Laporan
                </h2>
            </div>
            <div class="p-6 space-y-3">

                <a href="{{ route('admin.manajemen-mahasiswa') }}"
                    class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-green-50 rounded-[10px] transition border border-gray-200 hover:border-green-200">
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
        <div class="bg-gradient-to-r from-[#056100] to-[#00DF1A] p-6">
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

    <!-- Pembayaran Terbaru -->
    @if(isset($recentPayments) && $recentPayments->count() > 0)
        <div class="auth-card overflow-hidden mt-8">
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-credit-card"></i>
                    Pembayaran Terbaru
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 border-t">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Invoice</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Metode</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPayments as $payment)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-medium">{{ $payment->mahasiswa->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-6 py-4 font-mono text-sm text-[#00DF1A] font-semibold">
                                    {{ $payment->kode_invoice }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 font-bold">
                                    Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->payment_method == 'midtrans')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                            <i class="fas fa-credit-card"></i> Midtrans
                                        </span>
                                    @elseif($payment->payment_method == 'manual')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                            <i class="fas fa-upload"></i> Manual
                                        </span>
                                    @elseif($payment->bukti_bayar)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                            <i class="fas fa-file-image"></i> Upload
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->status == 'lunas')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            <i class="fas fa-check-circle"></i> Lunas
                                        </span>
                                    @elseif($payment->status == 'menunggu_verifikasi')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @else
                                        <span class="text-gray-600">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    @if($payment->paid_at)
                                        {{ $payment->paid_at->format('d/m/Y H:i') }}
                                    @else
                                        {{ $payment->created_at->format('d/m/Y H:i') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t">
                <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}"
                    class="text-[#00DF1A] hover:underline font-semibold text-sm">
                    Lihat semua pembayaran →
                </a>
            </div>
        </div>
    @endif
@endsection