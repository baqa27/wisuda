@extends('layouts.mahasiswa')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Mahasiswa</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">NIM</p>
                    <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->nim }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">IPK</p>
                    <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->ipk ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Program Studi</p>
                    <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->prodi ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-phone text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">No. HP</p>
                    <p class="text-lg font-semibold text-gray-900">{{ Auth::user()->no_hp ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Yudisium</h2>
                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
            </div>
            <p class="text-gray-600 mb-4">Lengkapi proses yudisium</p>
            <a href="{{ route('yudisium.index') }}"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded text-center block transition">
                Kelola Yudisium
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Wisuda</h2>
                <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
            </div>
            <p class="text-gray-600 mb-4">Lengkapi proses wisuda</p>
            <a href="{{ route('wisuda.index') }}"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded text-center block transition">
                Kelola Wisuda
            </a>
        </div>
    </div>
@endsection
