@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Yudisium')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Verifikasi Pembayaran Yudisium</h1>
    <p class="text-gray-600">Verifikasi bukti pembayaran yudisium dari mahasiswa</p>
</div>

@if($pembayaran->count() > 0)
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pembayaran as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $item->mahasiswa->name }}</div>
                        <div class="text-sm text-gray-500">{{ $item->mahasiswa->nim }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $item->kode_invoice }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->bukti_bayar)
                            <a href="{{ route('admin.download.bukti-bayar', basename($item->bukti_bayar)) }}"
                               class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        @else
                            <span class="text-red-500 text-sm">Belum upload</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <form action="{{ route('admin.verifikasi.pembayaran-yudisium.update', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="lunas">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm mr-2">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.verifikasi.pembayaran-yudisium.update', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="batal">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-lg shadow p-6 text-center">
    <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
    <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada pembayaran yang menunggu verifikasi</h3>
    <p class="text-gray-600">Semua pembayaran yudisium sudah diverifikasi.</p>
</div>
@endif
@endsection
