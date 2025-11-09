@extends('layouts.admin')

@section('title', 'Data Final Wisuda')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Final Wisuda</h1>
    <p class="text-gray-600">Data mahasiswa yang sudah menyelesaikan semua persyaratan wisuda</p>
</div>

@if($data->count() > 0)
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header Stats -->
    <div class="bg-gray-50 px-6 py-4 border-b">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Total Data:</span> {{ $data->total() }}
                </div>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Halaman:</span> {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Show:</span>
                <select onchange="window.location.href = this.value" class="text-sm border border-gray-300 rounded px-2 py-1">
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prodi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IPK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orang Tua</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $item->NIM }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                        <div class="text-sm text-gray-500">{{ $item->mahasiswa->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $item->prodi }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($item->IPK, 2) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="space-y-1">
                            <div>{{ $item->nama_ortu_1 }}</div>
                            <div>{{ $item->nama_ortu_2 }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="space-y-1">
                            <div>{{ $item->nama_tamu_1 }}</div>
                            <div>{{ $item->nama_tamu_2 }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="showDetailModal({{ $item->id }})"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('admin.generate-qr') }}?mahasiswa_id={{ $item->mahasiswa_id }}"
                           class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-qrcode"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($data->hasPages())
<div class="mt-4">
    {{ $data->links() }}
</div>
@endif

@else
<div class="bg-white rounded-lg shadow p-6 text-center">
    <i class="fas fa-database text-gray-400 text-4xl mb-4"></i>
    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada data final</h3>
    <p class="text-gray-600">Data akan muncul setelah mahasiswa menyelesaikan semua persyaratan dan mengisi data tambahan.</p>
</div>
@endif

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 max-h-96 overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Detail Mahasiswa</h3>
        <div id="modalContent">
            <!-- Content will be loaded via AJAX -->
        </div>
        <div class="mt-4 flex justify-end">
            <button type="button" onclick="hideDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
</div>

<script>
function showDetailModal(id) {
    // Load data via AJAX
    fetch(`/admin/data-final/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalContent').innerHTML = `
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">NIM:</span>
                        <span class="text-gray-600">${data.NIM}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Nama:</span>
                        <span class="text-gray-600">${data.nama}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Prodi:</span>
                        <span class="text-gray-600">${data.prodi}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">IPK:</span>
                        <span class="text-gray-600">${data.IPK}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Orang Tua 1:</span>
                        <span class="text-gray-600">${data.nama_ortu_1}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Orang Tua 2:</span>
                        <span class="text-gray-600">${data.nama_ortu_2}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Tamu 1:</span>
                        <span class="text-gray-600">${data.nama_tamu_1}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Tamu 2:</span>
                        <span class="text-gray-600">${data.nama_tamu_2}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="text-gray-600">${data.status}</span>
                    </div>
                </div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalContent').innerHTML = '<p class="text-red-600">Gagal memuat data.</p>';
            document.getElementById('detailModal').classList.remove('hidden');
        });
}

function hideDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Tutup modal ketika klik di luar
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target.id === 'detailModal') {
        hideDetailModal();
    }
});
</script>
@endsection
