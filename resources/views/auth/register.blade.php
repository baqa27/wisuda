@extends('layouts.app')

@section('title', 'Registrasi - Sistem Wisuda')

@section('content')
<div class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Sistem Wisuda</h1>
            <p class="text-gray-600 mt-2">Buat Akun Mahasiswa</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- NIM -->
            <div class="mb-4">
                <label for="nim" class="block text-gray-700 text-sm font-medium mb-2">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Program Studi -->
            <div class="mb-4">
                <label for="prodi" class="block text-gray-700 text-sm font-medium mb-2">Program Studi</label>
                <input type="text" id="prodi" name="prodi" value="{{ old('prodi') }}" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Fakultas -->
            <div class="mb-4">
                <label for="fakultas" class="block text-gray-700 text-sm font-medium mb-2">Fakultas</label>
                <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas') }}" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- IPK -->
            <div class="mb-4">
                <label for="ipk" class="block text-gray-700 text-sm font-medium mb-2">IPK</label>
                <input type="number" id="ipk" name="ipk" step="0.01" min="0" max="4" value="{{ old('ipk') }}" required
                    class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Nomor HP -->
            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 text-sm font-medium mb-2">No. HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-6 text-sm">
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
