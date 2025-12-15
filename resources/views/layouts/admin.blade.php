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
    <!-- Navbar with Green Gradient -->
    <nav class="bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-lg">
        <div class="flex justify-between items-center py-4 px-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <span class="text-xl font-bold block">Sistem Wisuda</span>
                    <span class="text-xs text-green-100">Administrator</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-white font-bold text-base">{{ Auth::user()->name }}</p>
                    <p class="text-green-100 text-sm">Admin</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-white text-green-600 hover:bg-green-50 px-5 py-2 rounded-[10px] transition font-bold text-sm shadow-lg hover:shadow-xl flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar with Green Accent -->
        <div class="w-[355px] bg-white shadow-lg border-r-[3px] border-r-[#1A9E00] flex flex-col justify-center px-10 py-8">
            <nav class="space-y-6">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-5 px-5 py-4 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-th-large w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <div class="text-gray-500 font-semibold text-sm uppercase tracking-wider">Verifikasi</div>

                <a href="{{ route('admin.verifikasi.pembayaran-yudisium') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.verifikasi.pembayaran-yudisium' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-money-bill-wave w-6 text-center"></i>
                    <span>Pembayaran Yudisium</span>
                </a>

                <a href="{{ route('admin.verifikasi.persyaratan-yudisium') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.verifikasi.persyaratan-yudisium' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-alt w-6 text-center"></i>
                    <span>Persyaratan Yudisium</span>
                </a>

                <a href="{{ route('admin.verifikasi.pembayaran-wisuda') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.verifikasi.pembayaran-wisuda' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-money-bill-wave w-6 text-center"></i>
                    <span>Pembayaran Wisuda</span>
                </a>

                <a href="{{ route('admin.verifikasi.persyaratan-wisuda') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.verifikasi.persyaratan-wisuda' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-alt w-6 text-center"></i>
                    <span>Persyaratan Wisuda</span>
                </a>

                <div class="text-gray-500 font-semibold text-sm uppercase tracking-wider">Data</div>

                <a href="{{ route('admin.manajemen-mahasiswa') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.manajemen-mahasiswa' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-users w-6 text-center"></i>
                    <span>Management Mahasiswa</span>
                </a>

                <a href="{{ route('admin.data-final') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ Route::currentRouteName() === 'admin.data-final' ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-layer-group w-6 text-center"></i>
                    <span>Data Final</span>
                </a>

                <div class="text-gray-500 font-semibold text-sm uppercase tracking-wider">Presensi</div>

                <a href="{{ route('admin.generate-qr.form') }}" class="flex items-center gap-5 px-5 py-3 rounded-[10px] transition font-bold text-lg {{ str_contains(Route::currentRouteName(), 'admin.generate-qr') ? 'bg-linear-to-r from-[#056100] to-[#00DF1A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-qrcode w-6 text-center"></i>
                    <span>Generate QR</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            @if(session('success'))
                <div class="bg-white border-l-4 border-l-green-500 mb-6 p-4 flex items-center gap-3 rounded-lg shadow-sm">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    <span class="text-green-700 font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-white border-l-4 border-l-red-500 mb-6 p-4 flex items-center gap-3 rounded-lg shadow-sm">
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
