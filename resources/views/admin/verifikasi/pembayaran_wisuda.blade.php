@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Wisuda')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-[#056100] to-[#00DF1A] bg-clip-text text-transparent">
            Verifikasi Pembayaran Wisuda
        </h1>
        <p class="text-gray-600 text-lg mt-2">Kelola dan verifikasi pembayaran wisuda dari mahasiswa</p>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="auth-card p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-[10px] bg-green-100 flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Pendaftar</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="auth-card p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-[10px] bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Lunas</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['lunas'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="auth-card p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-[10px] bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['menunggu_verifikasi'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="auth-card p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-[10px] bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-purple-600">Rp
                        {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($pembayaran->count() > 0)
        <div class="auth-card overflow-hidden">
            <div class="bg-gradient-to-r from-[#056100] to-[#00DF1A] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-credit-card"></i>
                    Daftar Pembayaran Wisuda
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-sm font-semibold text-gray-700">Invoice</th>
                            <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                            <th class="hidden lg:table-cell px-6 py-4 text-left text-sm font-semibold text-gray-700">Metode</th>
                            <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="hidden xl:table-cell px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Bayar</th>
                            <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pembayaran as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->mahasiswa->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->mahasiswa->nim }}</div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm font-mono text-[#056100] font-semibold max-w-[150px] truncate" title="{{ $item->kode_invoice }}">
                                    {{ $item->kode_invoice }}
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    @if($item->payment_method == 'midtrans')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            <i class="fas fa-credit-card"></i> Midtrans
                                        </span>
                                    @elseif($item->payment_method == 'manual')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                            <i class="fas fa-user-check"></i> Manual
                                        </span>
                                    @elseif($item->bukti_bayar)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                            <i class="fas fa-file-image"></i> Upload
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold">
                                            <i class="fas fa-minus"></i> -
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'lunas')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            <i class="fas fa-check-circle"></i> Lunas
                                        </span>
                                    @elseif($item->status == 'menunggu_verifikasi')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                            <i class="fas fa-clock"></i> <span class="hidden md:inline">Menunggu Verifikasi</span><span class="md:hidden">Verifikasi</span>
                                        </span>
                                    @elseif($item->status == 'menunggu_pembayaran')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                            <i class="fas fa-hourglass-half"></i> <span class="hidden md:inline">Menunggu Pembayaran</span><span class="md:hidden">Pending</span>
                                        </span>
                                    @elseif($item->status == 'batal')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            <i class="fas fa-times-circle"></i> Batal
                                        </span>
                                    @else
                                        <span class="text-gray-600">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td class="hidden xl:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($item->paid_at)
                                        <div class="text-sm">{{ $item->paid_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $item->paid_at->format('H:i') }}</div>
                                    @elseif($item->tanggal_bayar)
                                        <div class="text-sm">{{ $item->tanggal_bayar->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $item->tanggal_bayar->format('H:i') }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col md:flex-row items-center gap-2">
                                        {{-- Lihat Bukti Bayar --}}
                                        @if($item->bukti_bayar)
                                            <a href="{{ route('admin.view.bukti-wisuda', basename($item->bukti_bayar)) }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold text-xs transition">
                                                <i class="fas fa-eye"></i> <span class="hidden md:inline">Bukti</span>
                                            </a>
                                        @endif

                                        {{-- Tombol Approve/Reject hanya untuk yang menunggu verifikasi --}}
                                        @if($item->status == 'menunggu_verifikasi')
                                            <div class="flex flex-col md:flex-row items-start md:items-center gap-2">
                                                <form action="{{ route('admin.verifikasi.pembayaran-wisuda.update', $item->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="lunas">
                                                    <button type="submit"
                                                        class="w-full md:w-auto inline-flex items-center justify-center gap-1 px-3 py-2 rounded-[10px] bg-green-100 text-green-700 hover:bg-green-200 font-semibold text-xs transition">
                                                        <i class="fas fa-check"></i> <span class="hidden md:inline">Setujui</span><span class="md:hidden">OK</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.verifikasi.pembayaran-wisuda.update', $item->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="batal">
                                                    <button type="submit"
                                                        class="w-full md:w-auto inline-flex items-center justify-center gap-1 px-3 py-2 rounded-[10px] bg-red-100 text-red-700 hover:bg-red-200 font-semibold text-xs transition">
                                                        <i class="fas fa-times"></i> <span class="hidden md:inline">Tolak</span><span class="md:hidden">X</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
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
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tidak ada pembayaran</h3>
            <p class="text-gray-600 text-sm">Belum ada pendaftaran wisuda yang masuk.</p>
        </div>
    @endif
@endsection