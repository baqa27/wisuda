<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Wisuda') - Mahasiswa</title>

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
                        <span class="text-xs text-blue-200">Mahasiswa</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-blue-200 text-xs">Mahasiswa</p>
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
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-r from-[#0A0061] to-[#0061DF] rounded-[10px] flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500 font-mono mt-1">{{ Auth::user()->nim }}</p>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'dashboard' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                        @if(Route::currentRouteName() === 'dashboard')
                        <i class="fas fa-check-circle ml-auto text-lg"></i>
                        @endif
                    </a>
                    <a href="{{ route('yudisium.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'yudisium.index' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Yudisium</span>
                        @if(Route::currentRouteName() === 'yudisium.index')
                        <i class="fas fa-check-circle ml-auto text-lg"></i>
                        @endif
                    </a>
                    <a href="{{ route('wisuda.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-[10px] transition font-medium {{ Route::currentRouteName() === 'wisuda.index' ? 'bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white shadow-md' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-graduation-cap w-5"></i>
                        <span>Wisuda</span>
                        @if(Route::currentRouteName() === 'wisuda.index')
                        <i class="fas fa-check-circle ml-auto text-lg"></i>
                        @endif
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="auth-card border-l-4 border-l-green-500 mb-6 p-4 flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    <span class="text-green-700 font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
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
