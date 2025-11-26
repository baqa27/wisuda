@extends('layouts.mahasiswa')

@section('title', 'Yudisium Selesai')

@section('content')
@php
    $status = $persyaratan->status;
    $statusOptions = [
        'terverifikasi' => [
            'title' => 'Yudisium Telah Selesai',
            'message' => 'Selamat! Semua persyaratan Anda sudah disetujui. Anda bisa melanjutkan ke proses wisuda.',
            'icon' => 'fa-check-double',
            'bg' => 'bg-green-100',
            'color' => 'text-green-600'
        ],
        'revisi' => [
            'title' => 'Perlu Revisi Dokumen',
            'message' => 'Beberapa persyaratan perlu diperbaiki sesuai catatan admin di bawah.',
            'icon' => 'fa-exclamation-triangle',
            'bg' => 'bg-red-100',
            'color' => 'text-red-600'
        ],
        'menunggu' => [
            'title' => 'Menunggu Verifikasi Admin',
            'message' => 'Persyaratan sudah terkirim dan sedang diperiksa. Mohon tunggu konfirmasi admin sebelum melanjutkan.',
            'icon' => 'fa-clock',
            'bg' => 'bg-yellow-100',
            'color' => 'text-yellow-600'
        ]
    ];
    $statusConfig = $statusOptions[$status] ?? $statusOptions['menunggu'];
@endphp

<div class="auth-card text-center p-10 max-w-3xl mx-auto">
    <div class="w-24 h-24 rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['color'] }} flex items-center justify-center text-4xl mx-auto mb-6">
        <i class="fas {{ $statusConfig['icon'] }}"></i>
    </div>
    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $statusConfig['title'] }}</h1>
    <p class="text-gray-600 mb-8">{{ $statusConfig['message'] }}</p>

    <div class="grid gap-6 md:grid-cols-2 text-left mb-10">
        <div class="auth-card shadow-none border border-gray-100">
            <h2 class="text-sm font-semibold text-gray-500">Status Persyaratan</h2>
            <p class="text-lg font-bold text-gray-900 mt-1">{{ ucfirst($persyaratan->status) }}</p>
            @if($persyaratan->catatan_admin)
                <p class="text-sm text-red-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>{{ $persyaratan->catatan_admin }}
                </p>
            @endif
        </div>
        <div class="auth-card shadow-none border border-gray-100">
            <h2 class="text-sm font-semibold text-gray-500">Tanggal Pengajuan</h2>
            <p class="text-lg font-bold text-gray-900 mt-1">{{ $persyaratan->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-xs text-gray-500 mt-2">Harap monitor status secara berkala melalui halaman Yudisium.</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('yudisium.index') }}" class="btn-primary px-6 py-3 font-semibold inline-flex items-center gap-2">
            <i class="fas fa-list-check"></i>
            Lihat Status Yudisium
        </a>

        @if ($status === 'terverifikasi')
            <a href="{{ route('wisuda.index') }}" class="px-6 py-3 rounded-[10px] border border-[#0061DF] text-[#0061DF] font-semibold inline-flex items-center gap-2 hover:bg-blue-50 transition">
                <i class="fas fa-arrow-right"></i>
                Lanjut Ke Wisuda
            </a>
        @elseif ($status === 'revisi')
            <a href="{{ route('yudisium.persyaratan.edit') }}" class="px-6 py-3 rounded-[10px] border border-red-500 text-red-600 font-semibold inline-flex items-center gap-2 hover:bg-red-50 transition">
                <i class="fas fa-edit"></i>
                Perbaiki Persyaratan
            </a>
        @else
            <button type="button" class="px-6 py-3 rounded-[10px] border border-gray-200 text-gray-400 font-semibold inline-flex items-center gap-2 cursor-not-allowed"
                title="Menunggu verifikasi admin">
                <i class="fas fa-lock"></i>
                Wisuda terkunci
            </button>
        @endif
    </div>
</div>
@endsection
