<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Wisuda') - Admin</title>

    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                    <span class="text-xl font-bold">Admin Sistem Wisuda</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-blue-100">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 bg-gray-100 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="px-4 pt-4 text-sm font-semibold text-gray-500">VERIFIKASI</div>

                    <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Pembayaran Yudisium</span>
                    </a>
                    <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Persyaratan Yudisium</span>
                    </a>
                    <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Pembayaran Wisuda</span>
                    </a>
                    <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Persyaratan Wisuda</span>
                    </a>

                    <div class="px-4 pt-4 text-sm font-semibold text-gray-500">DATA</div>

                    <a href="{{ route('admin.manajemen-mahasiswa') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-users w-5"></i>
                        <span>Manajemen Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.data-final') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-database w-5"></i>
                        <span>Data Final</span>
                    </a>

                    <div class="px-4 pt-4 text-sm font-semibold text-gray-500">PRESENSI</div>

                    <a href="{{ route('admin.generate-qr') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded transition">
                        <i class="fas fa-qrcode w-5"></i>
                        <span>Generate QR</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
