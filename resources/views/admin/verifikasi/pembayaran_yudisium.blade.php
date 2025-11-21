@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Yudisium')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
        Verifikasi Pembayaran Yudisium
    </h1>
    <p class="text-gray-600 text-lg mt-2">Verifikasi bukti pembayaran yudisium dari mahasiswa</p>
</div>

@if($pembayaran->count() > 0)
<div class="auth-card overflow-hidden">
    <!-- Header Stats -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm">
                <span class="font-semibold text-gray-700">Total Menunggu Verifikasi:</span>
                <span class="text-[#0061DF] font-bold ml-2">{{ $pembayaran->count() }}</span>
            </div>
            <div class="text-xs text-gray-500">
                Diperbarui: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Invoice</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Bukti Bayar</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pembayaran as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $item->mahasiswa->name }}</div>
                        <div class="text-xs text-gray-500">{{ $item->mahasiswa->nim }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-[#0061DF] font-semibold">
                        {{ $item->kode_invoice }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->bukti_bayar)
                            <a href="{{ route('admin.download.bukti-bayar', basename($item->bukti_bayar)) }}"
                               class="inline-flex items-center gap-1 text-[#0061DF] hover:text-[#0A0061] font-semibold text-sm transition">
                                <i class="fas fa-file-pdf"></i> Download
                            </a>
                        @else
                            <span class="inline-flex items-center gap-1 text-red-600 text-sm font-semibold">
                                <i class="fas fa-times-circle"></i> Belum upload
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.verifikasi.pembayaran-yudisium.update', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="lunas">
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-green-100 text-green-700 hover:bg-green-200 font-semibold text-xs transition">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.verifikasi.pembayaran-yudisium.update', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="batal">
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-red-100 text-red-700 hover:bg-red-200 font-semibold text-xs transition">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="auth-card text-center py-12">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-green-100 mb-4">
        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2">Tidak ada pembayaran yang menunggu verifikasi</h3>
    <p class="text-gray-600 text-sm">Semua pembayaran yudisium sudah diverifikasi.</p>
</div>
@endif
@endsection
