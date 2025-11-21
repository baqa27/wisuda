@extends('layouts.admin')

@section('title', 'Generate QR Code Presensi')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
        Generate QR Code Presensi
    </h1>
    <p class="text-gray-600 text-lg mt-2">Generate QR Code untuk mahasiswa yang sudah memenuhi syarat wisuda</p>
</div>

<!-- Notifikasi -->
@if(session('success'))
<div class="auth-card border-l-4 border-l-green-500 mb-6 p-4">
    <div class="flex items-center gap-3">
        <i class="fas fa-check-circle text-green-600 text-lg"></i>
        <span class="text-green-700 font-semibold">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('info'))
<div class="auth-card border-l-4 border-l-blue-500 mb-6 p-4">
    <div class="flex items-center gap-3">
        <i class="fas fa-info-circle text-blue-600 text-lg"></i>
        <span class="text-blue-700 font-semibold">{{ session('info') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="auth-card border-l-4 border-l-red-500 mb-6 p-4">
    <div class="flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
        <span class="text-red-700 font-semibold">{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Info API untuk Kelompok Lain -->
<div class="auth-card border-l-4 border-l-blue-500 mb-6 p-6">
    <h2 class="text-lg font-bold text-[#0A0061] mb-4 flex items-center gap-2">
        <i class="fas fa-mobile-alt"></i> API Integration Information
    </h2>
    <div class="space-y-3 text-sm text-gray-700 bg-gray-50 p-4 rounded-[10px] font-mono">
        <div>
            <span class="font-semibold text-[#0061DF]">Checkin:</span>
            <code class="block mt-1 text-xs bg-white p-2 rounded border border-gray-200">POST {{ url('/api/presensi/checkin') }}</code>
        </div>
        <div>
            <span class="font-semibold text-[#0061DF]">Body:</span>
            <code class="block mt-1 text-xs bg-white p-2 rounded border border-gray-200">{ "token": "xxx", "kode_unik": "xxx" }</code>
        </div>
        <div>
            <span class="font-semibold text-[#0061DF]">Status:</span>
            <code class="block mt-1 text-xs bg-white p-2 rounded border border-gray-200">GET {{ url('/api/presensi/status/{token}') }}</code>
        </div>
    </div>
</div>

<!-- Generate QR Section -->
<div class="auth-card mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6">
        <div>
            <h2 class="text-lg font-bold text-[#0A0061]">Generate QR Massal</h2>
            <p class="text-gray-600 text-sm mt-1">Generate QR untuk semua mahasiswa yang sudah lengkap persyaratannya</p>
        </div>
        <form action="{{ route('admin.generate-qr') }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary px-6 py-3 inline-flex items-center gap-2 text-sm whitespace-nowrap">
                <i class="fas fa-qrcode"></i>
                Generate All QR
            </button>
        </form>
    </div>
</div>

@if(isset($qrList) && count($qrList) > 0)
<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="auth-card border-l-4 border-l-blue-500 p-4">
        <div class="flex items-center gap-3">
            <div class="icon-container bg-blue-100">
                <i class="fas fa-users text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-600">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-gray-900">{{ count($qrList) }}</p>
            </div>
        </div>
    </div>
    <div class="auth-card border-l-4 border-l-green-500 p-4">
        <div class="flex items-center gap-3">
            <div class="icon-container bg-green-100">
                <i class="fas fa-qrcode text-green-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-600">QR Baru Digenerate</p>
                <p class="text-2xl font-bold text-gray-900">{{ $generatedCount ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="auth-card border-l-4 border-l-purple-500 p-4">
        <div class="flex items-center gap-3">
            <div class="icon-container bg-purple-100">
                <i class="fas fa-clock text-purple-600"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-600">Terakhir Update</p>
                <p class="text-sm font-bold text-gray-900">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- QR List Table -->
<div class="auth-card overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            Daftar QR Code ({{ count($qrList) }} mahasiswa)
            @if(isset($generatedCount) && $generatedCount > 0)
            <span class="text-sm font-semibold text-green-600 ml-2">
                ({{ $generatedCount }} baru)
            </span>
            @endif
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">QR Code</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Check-in</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($qrList as $index => $qr)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#0061DF]">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $qr->mahasiswa->nim }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $qr->mahasiswa->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-20 h-20 border-2 border-gray-200 rounded-[10px] bg-white p-2 flex items-center justify-center">
                            @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                <img src="{{ Storage::url($qr->file_qr) }}"
                                     alt="QR Code {{ $qr->mahasiswa->nim }}"
                                     class="w-full h-full object-contain"
                                     title="QR Code {{ $qr->mahasiswa->name }}">
                            @else
                                <div class="text-red-500 text-xs text-center">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div class="text-xs">Not Found</div>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusConfig = [
                                'aktif' => ['color' => 'green', 'icon' => 'check-circle', 'label' => 'Aktif'],
                                'digunakan' => ['color' => 'blue', 'icon' => 'user-check', 'label' => 'Digunakan'],
                                'expired' => ['color' => 'red', 'icon' => 'exclamation-triangle', 'label' => 'Expired']
                            ];
                            $config = $statusConfig[$qr->status] ?? ['color' => 'gray', 'icon' => 'question-circle', 'label' => 'Unknown'];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] text-xs font-semibold bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700">
                            <i class="fas fa-{{ $config['icon'] }}"></i>
                            {{ $config['label'] }}
                        </span>
                        @if($qr->expired_at && $qr->expired_at < now() && $qr->status == 'aktif')
                        <div class="text-xs text-red-600 font-semibold mt-1">
                            <i class="fas fa-times-circle"></i> Expired
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($qr->waktu_checkin)
                            <div class="flex items-center gap-1 text-gray-600">
                                <i class="fas fa-clock"></i>
                                {{ $qr->waktu_checkin->format('d/m/Y H:i') }}
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                            @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                <a href="{{ route('admin.download-qr', $qr->id) }}"
                                   class="inline-flex items-center gap-1 text-[#0061DF] hover:text-[#0A0061] font-semibold transition"
                                   title="Download QR Code">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <a href="{{ Storage::url($qr->file_qr) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-semibold transition"
                                   title="Lihat QR Code">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            @else
                                <span class="inline-flex items-center gap-1 text-red-600 text-xs font-semibold">
                                    <i class="fas fa-exclamation-circle"></i> Error
                                </span>
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
<!-- Empty State -->
<div class="auth-card text-center py-12">
    <div class="max-w-md mx-auto">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-gray-100 mb-4">
            <i class="fas fa-qrcode text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada QR Code</h3>
        <p class="text-gray-600 text-sm mb-6">Generate QR Code untuk mahasiswa yang sudah memenuhi syarat wisuda.</p>
        <form action="{{ route('admin.generate-qr') }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary px-6 py-3 inline-flex items-center gap-2 mx-auto">
                <i class="fas fa-qrcode"></i>
                Generate QR Code Sekarang
            </button>
        </form>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
// Auto hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('[class*="border-l-"]');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.transition = 'opacity 0.5s ease';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
    });
});
</script>
@endsection
