@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang di Sistem Wisuda</p>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Mahasiswa</p>
                <p class="text-2xl font-bold">{{ $stats['total_mahasiswa'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Menunggu Verifikasi</p>
                <p class="text-2xl font-bold">
                    {{ $stats['yudisium_menunggu'] + $stats['wisuda_menunggu'] }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Siap Wisuda</p>
                <p class="text-2xl font-bold">{{ $stats['siap_wisuda'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi</h2>
        <div class="space-y-3">

            <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}"
               class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                <div class="flex items-center">
                    <i class="fas fa-money-bill-wave text-blue-600 mr-3"></i>
                    <span>Pembayaran Yudisium</span>
                </div>
                <span class="badge bg-blue-600 text-white px-2 py-1 rounded-full text-sm">
                    {{ $stats['yudisium_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}"
               class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <div class="flex items-center">
                    <i class="fas fa-file-alt text-green-600 mr-3"></i>
                    <span>Persyaratan Yudisium</span>
                </div>
                <span class="badge bg-green-600 text-white px-2 py-1 rounded-full text-sm">
                    {{ $stats['persyaratan_yudisium_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}"
               class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                <div class="flex items-center">
                    <i class="fas fa-money-bill-wave text-purple-600 mr-3"></i>
                    <span>Pembayaran Wisuda</span>
                </div>
                <span class="badge bg-purple-600 text-white px-2 py-1 rounded-full text-sm">
                    {{ $stats['wisuda_menunggu'] }}
                </span>
            </a>

            <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}"
               class="flex items-center justify-between p-3 bg-orange-50 hover:bg-orange-100 rounded-lg transition">
                <div class="flex items-center">
                    <i class="fas fa-file-alt text-orange-600 mr-3"></i>
                    <span>Persyaratan Wisuda</span>
                </div>
                <span class="badge bg-orange-600 text-white px-2 py-1 rounded-full text-sm">
                    {{ $stats['persyaratan_wisuda_menunggu'] }}
                </span>
            </a>

        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Data & Laporan</h2>
        <div class="space-y-3">

            <a href="{{ route('admin.manajemen-mahasiswa') }}"
               class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-users text-gray-600 mr-3"></i>
                <span>Manajemen Mahasiswa</span>
            </a>

            <a href="{{ route('admin.data-final') }}"
               class="flex items-center p-3 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                <i class="fas fa-database text-indigo-600 mr-3"></i>
                <span>Data Final Wisuda</span>
            </a>

            <a href="{{ route('admin.generate-qr') }}"
               class="flex items-center p-3 bg-teal-50 hover:bg-teal-100 rounded-lg transition">
                <i class="fas fa-qrcode text-teal-600 mr-3"></i>
                <span>Generate QR Code</span>
            </a>

        </div>
    </div>

</div>

<!-- Daftar Mahasiswa Terbaru -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Mahasiswa Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">NIM</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Prodi</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMahasiswa as $mahasiswa)
                <tr class="border-t">
                    <td class="px-4 py-2 text-gray-900">{{ $mahasiswa->name }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $mahasiswa->nim ?? '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $mahasiswa->prodi ?? '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $mahasiswa->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
