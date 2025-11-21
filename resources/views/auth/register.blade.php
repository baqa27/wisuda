@extends('layouts.app')

@section('title', 'Daftar - Sistem Akademik')

@section('content')
    <div class="w-full">
        <div class="grid grid-cols-1 lg:grid-cols-5 w-full min-h-screen bg-white overflow-hidden">

            <!-- Left Side - Info Card -->
            <div class="lg:col-span-2 p-10 flex flex-col justify-center text-white relative overflow-hidden">
                <div class="w-full h-full bg-linear-to-b from-[#0A0061] to-[#0061DF] rounded-[40px] p-10 relative overflow-hidden">

                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>

                    <div class="relative z-10">
                        <!-- Logo Top Left -->
                        <div class="mb-8">
                            <img src="/img/icon-top-l.png" class="w-14 h-14 mb-6" alt="Logo Sistem Akademik">
                        </div>

                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-3">Sistem Akademik</h2>
                            <p class="text-blue-100 text-base leading-relaxed">
                                Pendaftaran Yudisium dan Wisuda membuat lebih
                                Mudah serta efisien.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="lg:col-span-3 p-10 overflow-y-auto max-h-screen relative">

                <!-- Blue Blur -->
                <div class="absolute top-0 right-0 w-[250px] h-[250px] bg-blue-400 blur-[120px] opacity-40"></div>

                <div class="relative z-10 max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <!-- Logo Form -->
                        <div class="flex justify-center mb-8">
                            <img src="/img/icon-top-r.png" class="w-14 h-14 mb-6" alt="Logo Register">
                        </div>

                        <h1 class="text-5xl font-bold mb-3 bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
                            Buat akun anda
                        </h1>

                        <p class="text-gray-600 text-sm">
                            Isi data diri dengan lengkap dan benar
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 border-2 border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                       focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                       placeholder="Nama lengkap">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- NIM -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="2023162000">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="email@example.com">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Fakultas -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fakultas</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-university text-gray-400"></i>
                                    </div>
                                    <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="Fakultas Teknik dan Ilmu Komputer">
                                </div>
                            </div>

                            <!-- Prodi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Prodi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                    <input type="text" id="prodi" name="prodi" value="{{ old('prodi') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="Teknik Informatika">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Semester -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="number" id="semester" name="semester" value="{{ old('semester') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="8" min="1" max="14">
                                </div>
                            </div>

                            <!-- IPK -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">IPK</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chart-line text-gray-400"></i>
                                    </div>
                                    <input type="number" id="ipk" name="ipk" step="0.01" min="0" max="4" value="{{ old('ipk') }}" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="3.50">
                                </div>
                            </div>
                        </div>

                        <!-- No. HP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                       class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                       focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                       placeholder="08123456789">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password" required
                                           class="w-full pl-11 pr-12 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="••••••••••••">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                           class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                           placeholder="••••••••••••">
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white py-3 px-4 rounded-xl
                                hover:opacity-90 font-semibold transition-colors shadow-lg shadow-blue-500/30 mt-6">
                            Daftar
                        </button>

                        <div class="text-center pt-4">
                            <p class="text-gray-600 text-sm">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
