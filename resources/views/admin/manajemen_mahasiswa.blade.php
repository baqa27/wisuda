@extends('layouts.admin')

@section('title', 'Manajemen Mahasiswa')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
        Manajemen Mahasiswa
    </h1>
    <p class="text-gray-600 text-lg mt-2">Kelola data mahasiswa yang terdaftar dalam sistem</p>
</div>

@if($mahasiswa->count() > 0)
<div class="auth-card overflow-hidden">
    <div class="bg-linear-to-r from-[#0A0061] to-[#0061DF] p-6">
        <h2 class="text-lg font-bold text-white">Daftar Mahasiswa</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM & Prodi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">IPK</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Yudisium</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Wisuda</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Terdaftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($mahasiswa as $mhs)
                <tr class="hover:bg-gray-50 transition border-b border-gray-200">
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900">{{ $mhs->name }}</div>
                        <div class="text-xs text-gray-500">{{ $mhs->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-[#0061DF]">{{ $mhs->nim ?? '-' }}</div>
                        <div class="text-xs text-gray-600">{{ $mhs->prodi ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-[10px] text-sm font-bold bg-blue-100 text-[#0061DF]">
                            {{ $mhs->ipk ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($mhs->persyaratanYudisium)
                            @if($mhs->persyaratanYudisium->status == 'terverifikasi')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </span>
                            @elseif($mhs->persyaratanYudisium->status == 'revisi')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-redo"></i> Revisi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-gray-100 text-gray-700">
                                <i class="fas fa-minus-circle"></i> Belum Daftar
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($mhs->pendaftaranWisuda)
                            @if($mhs->pendaftaranWisuda->status == 'lunas')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle"></i> Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-gray-100 text-gray-700">
                                <i class="fas fa-minus-circle"></i> Belum Daftar
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                        {{ $mhs->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($mahasiswa->hasPages())
<div class="mt-6 flex items-center justify-between px-6 py-4 border-t border-gray-200 auth-card">
    <div class="text-sm text-gray-600">
        Menampilkan <span class="font-semibold">{{ $mahasiswa->firstItem() }}</span> hingga <span class="font-semibold">{{ $mahasiswa->lastItem() }}</span> dari <span class="font-semibold">{{ $mahasiswa->total() }}</span> mahasiswa
    </div>
    <div class="flex items-center gap-2">
        {{ $mahasiswa->links() }}
    </div>
</div>
@endif

@else
<div class="auth-card p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-gray-100 mb-4">
        <i class="fas fa-users text-gray-400 text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Mahasiswa Terdaftar</h3>
    <p class="text-gray-600 text-sm">Mahasiswa akan muncul di halaman ini setelah mereka mendaftar di sistem.</p>
</div>
@endif
@endsection
