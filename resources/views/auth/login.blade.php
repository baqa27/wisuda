@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-20 w-20 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white text-3xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                Sistem Wisuda
            </h2>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="sr-only">Email</label>
                <input id="email" name="email" type="email" required
                       class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Email" value="{{ old('email') }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" required
                       class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Password">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in
                </button>
            </div>
            <div class="text-center mt-6">
            <p class="text-gray-600">
             Belum punya akun?
             <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Daftar di sini</a>
            </p>
            </div>
            <div class="text-center text-sm text-gray-600">
                <p><strong>Demo:</strong></p>
                <p>Admin: admin@wisuda.ac.id / password</p>
                <p>Mahasiswa: ahmad@wisuda.ac.id / password</p>
            </div>
        </form>
    </div>
</div>
@endsection
