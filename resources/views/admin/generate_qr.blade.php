@extends('layouts.admin')

@section('title', 'Generate QR Code Presensi')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
        Generate QR Code
    </h1>
    <p class="text-gray-500 text-base mt-2">Kelola dan generate QR code presensi untuk mahasiswa wisuda.</p>
</div>

<!-- Notifikasi -->
@if(session('success'))
<div class="mb-8 rounded-xl border border-green-200 bg-green-50 p-4">
    <div class="flex items-center gap-3">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-200 text-green-700">
            <i class="fas fa-check text-sm"></i>
        </div>
        <p class="font-medium text-green-800">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-blue-100">
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Siap Wisuda</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $readyCount ?? 0 }}</h3>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-yellow-100">
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Belum Ada QR</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $missingCount ?? 0 }}</h3>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 transition-colors group-hover:bg-yellow-500 group-hover:text-white">
                <i class="fas fa-qrcode text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-purple-100">
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Terakhir Generate</p>
                <h3 class="text-lg font-bold text-gray-900 mt-1">
                    {{ isset($lastGeneratedAt) && $lastGeneratedAt ? $lastGeneratedAt->format('d M Y, H:i') : '-' }}
                </h3>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 transition-colors group-hover:bg-purple-600 group-hover:text-white">
                <i class="fas fa-history text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <!-- QR Action Card -->
    <div class="lg:col-span-2 rounded-2xl bg-white p-8 shadow-sm border border-gray-100 flex flex-col justify-center">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Generate QR Code Massal</h2>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">Secara otomatis membuat QR Code untuk semua mahasiswa yang telah memenuhi persyaratan wisuda namun belum memiliki QR Code.</p>
            </div>
        </div>
        
        <div>
            <form action="{{ route('admin.generate-qr') }}" method="POST">
                @csrf
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-8 py-4 font-semibold text-white transition-all hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 focus:ring-4 focus:ring-blue-100">
                    <i class="fas fa-magic mr-1"></i>
                    GENERATE SEKARANG
                </button>
            </form>
        </div>
    </div>

    <!-- Integration Info -->
    <div class="rounded-2xl bg-gray-900 p-6 shadow-lg text-white relative overflow-hidden flex flex-col justify-between min-h-[200px]">
        
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 p-3 opacity-10">
             <i class="fas fa-code text-9xl text-white"></i>
        </div>

        <div class="relative z-10">
            <h3 class="font-bold text-lg mb-1 text-white">API Integration</h3>
            <p class="text-gray-400 text-sm">Endpoint check-in presensi.</p>
        </div>
        
        <div class="mt-6 relative z-10">
            <div class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-2">Endpoint URL</div>
            <div class="bg-gray-800 rounded-lg p-3 ring-1 ring-white/10 flex items-center gap-3">
                <span class="text-xs font-bold text-green-400">POST</span>
                <code class="text-xs font-mono text-gray-300 truncate flex-1">{{ url('/api/presensi/checkin') }}</code>
                <button class="text-gray-500 hover:text-white transition" title="Copy" onclick="navigator.clipboard.writeText('{{ url('/api/presensi/checkin') }}')">
                    <i class="far fa-copy"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(isset($readyWithoutQr) && $readyWithoutQr->count() > 0)
<div class="mb-10">
    <div class="flex items-center justify-between mb-4 px-1">
        <h3 class="text-lg font-bold text-gray-900">Perlu Action Manual <span class="text-gray-400 text-sm font-normal ml-2">({{ $readyWithoutQr->count() }} mahasiswa)</span></h3>
    </div>
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left font-semibold text-gray-600 text-xs uppercase tracking-wider py-4 px-6">Mahasiswa</th>
                        <th class="text-left font-semibold text-gray-600 text-xs uppercase tracking-wider py-4 px-6">Prodi</th>
                        <th class="text-right font-semibold text-gray-600 text-xs uppercase tracking-wider py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($readyWithoutQr as $data)
                    <tr class="group hover:bg-gray-50/50 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs font-bold ring-2 ring-white">
                                    {{ substr($data->mahasiswa->name, 0, 1) }}
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $data->mahasiswa->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $data->mahasiswa->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-600">{{ $data->mahasiswa->prodi ?? '-' }}</td>
                        <td class="py-4 px-6 text-right">
                            <form action="{{ route('admin.generate-qr') }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="mahasiswa_id" value="{{ $data->mahasiswa_id }}">
                                <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                                    Generate
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if(isset($qrList) && count($qrList) > 0)
<div class="mb-10">
    <div class="flex items-center justify-between mb-4 px-1">
        <h3 class="text-lg font-bold text-gray-900">Data QR Code <span class="text-gray-400 text-sm font-normal ml-2">({{ count($qrList) }} total)</span></h3>
        <div class="flex gap-2">
            <!-- Filter buttons normally go here -->
        </div>
    </div>

    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Mahasiswa</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">QR Code</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Check-in</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($qrList as $qr)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 shrink-0 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm">
                                    {{ substr($qr->mahasiswa->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">{{ $qr->mahasiswa->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $qr->mahasiswa->nim }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center align-middle">
                            <div class="inline-flex justify-center">
                                <div class="h-12 w-12 rounded-lg bg-white p-1 border border-gray-100 shadow-sm transition-transform hover:scale-110">
                                    @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                        <img src="{{ Storage::url($qr->file_qr) }}" class="h-full w-full object-contain rounded-md" alt="QR">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                                            <i class="fas fa-image-slash text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusStyles = [
                                    'aktif' => 'bg-green-50 text-green-700 ring-green-600/20',
                                    'digunakan' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                    'expired' => 'bg-red-50 text-red-700 ring-red-600/20'
                                ];
                                $style = $statusStyles[$qr->status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $style }}">
                                {{ ucfirst($qr->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($qr->waktu_checkin)
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $qr->waktu_checkin->format('H:i') }}</span>
                                    <span class="text-xs text-gray-400">{{ $qr->waktu_checkin->format('d M Y') }}</span>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ Storage::url($qr->file_qr) }}" target="_blank" class="p-2 text-gray-400 hover:text-gray-600 transition rounded-lg hover:bg-gray-100" title="Lihat">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.download-qr', $qr->id) }}" class="p-2 text-gray-400 hover:text-blue-600 transition rounded-lg hover:bg-blue-50" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination would go here -->
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth auto-hide for notifications
    const notifications = document.querySelectorAll('[class*="border-green-200"]');
    if (notifications) {
        setTimeout(() => {
            notifications.forEach(n => {
                n.style.transition = 'all 0.5s ease';
                n.style.opacity = '0';
                n.style.transform = 'translateY(-10px)';
                setTimeout(() => n.remove(), 500);
            });
        }, 4000);
    }
});
</script>
@endsection
