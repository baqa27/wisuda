@extends('layouts.app')

@section('title', 'Login - Sistem Akademik')

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
                            <img src="/img/icon-top-r.png" class="w-14 h-14 mb-6" alt="Logo Login">
                        </div>

                        <h1 class="text-5xl font-bold mb-3 bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
                            Masuk akun anda
                        </h1>

                        <p class="text-gray-600 text-sm">
                            Untuk mengakses Pendaftaran Yudisium, Wisuda dengan Baik dan mempercepat Kelulusan anda.
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

                    @if (session('status'))
                        <div class="bg-green-50 border-2 border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                            <p class="text-sm">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- NIM -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="email" name="email" value="{{ old('email') }}" required
                                       class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                       focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                                       placeholder="hito789@gmail.com">
                            </div>
                        </div>

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
                                       placeholder="***********">
                                <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-linear-to-r from-[#0A0061] to-[#0061DF] text-white py-3 px-4 rounded-xl
                                hover:opacity-90 font-semibold transition-colors shadow-lg shadow-blue-500/30">
                            Masuk
                        </button>

                        <div class="text-center pt-4">
                            <p class="text-gray-600 text-sm">
                                Belum memiliki akun?
                                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    Daftar
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
