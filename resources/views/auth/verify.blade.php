@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div class="text-center">
            <i class="fas fa-envelope-open-text text-6xl text-[#0061DF] mb-4"></i>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Verifikasi Email Anda</h2>
            <p class="mt-2 text-sm text-gray-600">
                Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.
            </p>
        </div>

        @if (session('resent'))
            <div class="rounded-md bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 space-y-4">
            <p class="text-center text-sm text-gray-600">
                Tidak menerima email?
            </p>
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0061DF] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}" class="text-center mt-4">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 underline">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
