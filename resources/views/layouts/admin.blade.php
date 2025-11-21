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
    <nav class="bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                    <div>
                        <span class="text-xl font-bold block">Sistem Wisuda</span>
                        <span class="text-xs text-blue-200">Administrator</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-blue-200 text-xs">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-[#0061DF] hover:bg-blue-50 px-5 py-2 rounded-[10px] transition font-bold text-sm shadow-lg hover:shadow-xl">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg border-r-4 border-r-[#0061DF]">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                        @if(Route::currentRouteName() === 'admin.dashboard')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>

                    <div class="px-4 pt-3 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Verifikasi</div>

                    <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.verifikasi.pembayaran-yudisium' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Pembayaran Yudisium</span>
                        @if(Route::currentRouteName() === 'admin.verifikasi.pembayaran-yudisium')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>
                    <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.verifikasi.persyaratan-yudisium' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Persyaratan Yudisium</span>
                        @if(Route::currentRouteName() === 'admin.verifikasi.persyaratan-yudisium')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>
                    <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.verifikasi.pembayaran-wisuda' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Pembayaran Wisuda</span>
                        @if(Route::currentRouteName() === 'admin.verifikasi.pembayaran-wisuda')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>
                    <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.verifikasi.persyaratan-wisuda' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Persyaratan Wisuda</span>
                        @if(Route::currentRouteName() === 'admin.verifikasi.persyaratan-wisuda')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>

                    <div class="px-4 pt-3 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Data</div>

                    <a href="{{ route('admin.manajemen-mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.manajemen-mahasiswa' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-users w-5"></i>
                        <span>Manajemen Mahasiswa</span>
                        @if(Route::currentRouteName() === 'admin.manajemen-mahasiswa')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>
                    <a href="{{ route('admin.data-final') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.data-final' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-database w-5"></i>
                        <span>Data Final</span>
                        @if(Route::currentRouteName() === 'admin.data-final')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>

                    <div class="px-4 pt-3 mt-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Presensi</div>

                    <a href="{{ route('admin.generate-qr') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'admin.generate-qr' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-qrcode w-5"></i>
                        <span>Generate QR</span>
                        @if(Route::currentRouteName() === 'admin.generate-qr')
                        <i class="fas fa-check-circle ml-auto"></i>
                        @endif
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            @if(session('success'))
                <div class="auth-card border-l-4 border-l-green-500 mb-6 p-4 flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    <span class="text-green-700 font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="auth-card border-l-4 border-l-red-500 mb-6 p-4 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
                    <span class="text-red-700 font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
