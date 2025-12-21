@extends('layouts.app')

@section('title', 'Admin Login - Sistem Wisuda')

@section('content')
    <div class="w-full">
        <div class="grid grid-cols-1 lg:grid-cols-5 w-full min-h-screen bg-white overflow-hidden">

            <!-- Left Side - Info Card (Green Theme) -->
            <div class="lg:col-span-2 p-10 flex flex-col justify-center text-white relative overflow-hidden">
                <div
                    class="w-full h-full bg-gradient-to-b from-[#056100] to-[#00DF1A] rounded-[40px] p-10 relative overflow-hidden">

                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>

                    <div class="relative z-10">
                        <!-- Logo Top Left -->
                        <div class="mb-8">
                            <img src="/img/icon-top-l.png" class="w-14 h-14 mb-6" alt="Logo Sistem Akademik" style="filter: hue-rotate(-120deg);">
                        </div>

                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-3">Sistem Akademik</h2>
                            <p class="text-green-100 text-base leading-relaxed">
                                Pendaftaran Yudisium dan Wisuda membuat lebih
                                Mudah serta efisien.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="lg:col-span-3 p-10 overflow-y-auto max-h-screen relative">

                <!-- Green Blur -->
                <div class="absolute top-0 right-0 w-[250px] h-[250px] bg-green-400 blur-[120px] opacity-40"></div>

                <div class="relative z-10 max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <!-- Logo Form -->
                        <div class="flex justify-center mb-8">
                            <img src="/img/icon-top-r.png" class="w-14 h-14 mb-6" alt="Logo Login" style="filter: hue-rotate(-120deg);">
                        </div>

                        <h1
                            class="text-5xl font-bold mb-3 bg-gradient-to-r from-[#056100] to-[#00DF1A] bg-clip-text text-transparent">
                            Admin Login
                        </h1>

                        <p class="text-gray-600 text-sm">
                            Masuk untuk mengelola data Yudisium dan Wisuda.
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

                    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all"
                                    placeholder="admin@university.ac.id">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required class="w-full pl-11 pr-12 py-3 border-2 border-gray-200 rounded-xl
                                           focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all"
                                    placeholder="***********">
                                <button type="button"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-[#056100] to-[#00DF1A] text-white py-3 px-4 rounded-xl
                                    hover:opacity-90 font-semibold transition-colors shadow-lg shadow-green-500/30">
                            Masuk sebagai Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle password visibility
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
@endpush