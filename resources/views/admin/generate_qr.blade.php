@extends('layouts.admin')

@section('title', 'Generate QR Code Presensi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Generate QR Code Presensi</h1>
    <p class="text-gray-600">Generate QR Code untuk mahasiswa yang sudah memenuhi syarat wisuda</p>
</div>

<!-- Notifikasi -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-600 mr-2"></i>
        <span class="text-green-800">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('info'))
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
        <span class="text-blue-800">{{ session('info') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
        <span class="text-red-800">{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Info API untuk Kelompok Lain -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
    <h2 class="text-lg font-semibold text-blue-800 mb-3">📱 Informasi API untuk Kelompok Lain</h2>
    <div class="space-y-2 text-sm text-blue-700">
        <p><strong>Endpoint Checkin:</strong> <code>POST {{ url('/api/presensi/checkin') }}</code></p>
        <p><strong>Body Request:</strong> <code>{ "token": "xxx", "kode_unik": "xxx" }</code></p>
        <p><strong>Endpoint Status:</strong> <code>GET {{ url('/api/presensi/status/{token}') }}</code></p>
        <p><strong>Endpoint List:</strong> <code>GET {{ url('/api/presensi/list') }}</code></p>
    </div>
</div>

<!-- Generate QR Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Generate QR Massal</h2>
            <p class="text-gray-600">Generate QR untuk semua mahasiswa yang sudah lengkap persyaratannya</p>
        </div>
        <form action="{{ route('admin.generate-qr') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-qrcode mr-2"></i>
                Generate All QR
            </button>
        </form>
    </div>
</div>

@if(isset($qrList) && count($qrList) > 0)
<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-users text-blue-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ count($qrList) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-qrcode text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">QR Baru Digenerate</p>
                <p class="text-2xl font-bold text-gray-800">{{ $generatedCount ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i class="fas fa-clock text-purple-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Terakhir Update</p>
                <p class="text-sm font-bold text-gray-800">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- QR List Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-800">
            Daftar QR Code ({{ count($qrList) }} mahasiswa)
            @if(isset($generatedCount) && $generatedCount > 0)
            <span class="text-sm font-normal text-green-600 ml-2">
                ({{ $generatedCount }} baru digenerate)
            </span>
            @endif
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Check-in</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($qrList as $index => $qr)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $qr->mahasiswa->nim }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $qr->mahasiswa->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-20 h-20 border border-gray-300 rounded bg-white p-1 flex items-center justify-center">
                            @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                <img src="{{ Storage::url($qr->file_qr) }}"
                                     alt="QR Code {{ $qr->mahasiswa->nim }}"
                                     class="w-full h-full object-contain"
                                     title="QR Code {{ $qr->mahasiswa->name }}">
                            @else
                                <div class="text-red-500 text-xs text-center">
                                    <i class="fas fa-exclamation-triangle mb-1"></i>
                                    <div>QR Tidak Ditemukan</div>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusConfig = [
                                'aktif' => ['color' => 'green', 'icon' => 'check-circle'],
                                'digunakan' => ['color' => 'blue', 'icon' => 'user-check'],
                                'expired' => ['color' => 'red', 'icon' => 'exclamation-triangle']
                            ];
                            $config = $statusConfig[$qr->status] ?? ['color' => 'gray', 'icon' => 'question-circle'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                            <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                            {{ ucfirst($qr->status) }}
                        </span>
                        @if($qr->expired_at && $qr->expired_at < now() && $qr->status == 'aktif')
                        <div class="text-xs text-red-500 mt-1">
                            Expired
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($qr->waktu_checkin)
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1 text-gray-400"></i>
                                {{ $qr->waktu_checkin->format('d/m/Y H:i') }}
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            @if($qr->file_qr && Storage::disk('public')->exists($qr->file_qr))
                                <a href="{{ route('admin.download-qr', $qr->id) }}"
                                   class="text-blue-600 hover:text-blue-900 flex items-center"
                                   title="Download QR Code">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                                <a href="{{ Storage::url($qr->file_qr) }}"
                                   target="_blank"
                                   class="text-green-600 hover:text-green-900 flex items-center"
                                   title="Lihat QR Code">
                                    <i class="fas fa-external-link-alt mr-1"></i> View
                                </a>
                            @else
                                <span class="text-red-500 text-xs flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> File Error
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
<div class="bg-white rounded-lg shadow p-8 text-center">
    <div class="max-w-md mx-auto">
        <i class="fas fa-qrcode text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada QR Code</h3>
        <p class="text-gray-600 mb-6">Generate QR Code untuk mahasiswa yang sudah memenuhi syarat wisuda.</p>
        <form action="{{ route('admin.generate-qr') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center justify-center mx-auto transition duration-200">
                <i class="fas fa-qrcode mr-2"></i>
                Generate QR Code Sekarang
            </button>
        </form>
    </div>
</div>
@endif

<!-- Debug Info (Hanya tampil di local) -->
@if(app()->environment('local'))
<div class="mt-6 p-4 bg-gray-100 rounded-lg">
    <h4 class="font-semibold mb-2">Debug Info:</h4>
    <pre class="text-xs">{{ json_encode($qrList->pluck('file_qr'), JSON_PRETTY_PRINT) }}</pre>
</div>
@endif

@endsection

@section('scripts')
<script>
// Auto hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.bg-green-50, .bg-blue-50, .bg-red-50');
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
