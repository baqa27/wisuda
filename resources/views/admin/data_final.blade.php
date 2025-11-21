@extends('layouts.admin')

@section('title', 'Data Final Wisuda')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
            Data Final Wisuda
        </h1>
        <p class="text-gray-600 text-lg mt-2">Data mahasiswa yang menyelesaikan semua persyaratan wisuda</p>
    </div>
    <a href="{{ route('admin.export-data-final') }}"
       class="btn-primary px-6 py-3 inline-flex items-center gap-2 text-sm">
        <i class="fas fa-download"></i>
        Export CSV
    </a>
</div>

@if($data->count() > 0)
<div class="auth-card overflow-hidden">
    <!-- Header Stats -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-6 flex-wrap">
            <div class="text-sm">
                <span class="font-semibold text-gray-700">Total Data:</span>
                <span class="text-[#0061DF] font-bold ml-2">{{ $data->total() }}</span>
            </div>
            <div class="text-sm">
                <span class="font-semibold text-gray-700">Halaman:</span>
                <span class="text-[#0061DF] font-bold ml-2">{{ $data->currentPage() }}/{{ $data->lastPage() }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-700">Tampil:</span>
            <select onchange="window.location.href = this.value" class="text-sm border border-gray-300 rounded-[10px] px-3 py-2 focus:outline-none focus:border-[#0061DF]">
                <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per halaman</option>
                <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25 per halaman</option>
                <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per halaman</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">IPK</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Orang Tua</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tamu</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($data as $item)
                <tr class="hover:bg-gray-50 transition border-b border-gray-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#0A0061]">
                        {{ $item->NIM }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900">{{ $item->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $item->mahasiswa->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $item->prodi }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                        {{ number_format($item->IPK, 2) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <div class="space-y-0.5">
                            <div>{{ $item->nama_ortu_1 }}</div>
                            @if($item->nama_ortu_2)
                            <div>{{ $item->nama_ortu_2 }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <div class="space-y-0.5">
                            <div>{{ $item->nama_tamu_1 }}</div>
                            @if($item->nama_tamu_2)
                            <div>{{ $item->nama_tamu_2 }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-check-circle"></i>
                            Selesai
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="showDetailModal({{ $item->id }})"
                                class="text-[#0061DF] hover:text-[#0A0061] transition mr-4" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('admin.generate-qr') }}?mahasiswa_id={{ $item->mahasiswa_id }}"
                           class="text-green-600 hover:text-green-800 transition" title="Generate QR">
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
<div class="mt-6 flex items-center justify-between px-6 py-4 border-t border-gray-200">
    <div class="text-sm text-gray-600">
        Menampilkan <span class="font-semibold">{{ $data->firstItem() }}</span> hingga <span class="font-semibold">{{ $data->lastItem() }}</span> dari <span class="font-semibold">{{ $data->total() }}</span> data
    </div>
    <div class="flex items-center gap-2">
        {{ $data->links() }}
    </div>
</div>
@endif

@else
<div class="auth-card text-center py-12">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-gray-100 mb-4">
        <i class="fas fa-database text-gray-400 text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada data final</h3>
    <p class="text-gray-600 text-sm">Data akan muncul setelah mahasiswa menyelesaikan semua persyaratan dan mengisi data tambahan.</p>
</div>
@endif

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="auth-card w-full max-w-2xl max-h-96 overflow-y-auto">
        <div class="border-b border-gray-200 px-6 py-4 sticky top-0 bg-white flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#0A0061]">Detail Data Final</h3>
            <button type="button" onclick="hideDetailModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="modalContent" class="px-6 py-4">
            <!-- Content will be loaded via AJAX -->
        </div>
        <div class="border-t border-gray-200 px-6 py-4 flex justify-end gap-3 sticky bottom-0 bg-white">
            <button type="button" onclick="hideDetailModal()" class="px-4 py-2 border border-gray-300 rounded-[10px] text-gray-700 font-semibold hover:bg-gray-50">
                Tutup
            </button>
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
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">NIM</label>
                        <p class="text-sm font-semibold text-gray-900">${data.NIM}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama</label>
                        <p class="text-sm font-semibold text-gray-900">${data.nama}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Program Studi</label>
                        <p class="text-sm text-gray-700">${data.prodi}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">IPK</label>
                        <p class="text-sm font-semibold text-gray-900">${data.IPK}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Orang Tua 1</label>
                        <p class="text-sm text-gray-700">${data.nama_ortu_1}</p>
                    </div>
                    ${data.nama_ortu_2 ? `
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Orang Tua 2</label>
                        <p class="text-sm text-gray-700">${data.nama_ortu_2}</p>
                    </div>
                    ` : ''}
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tamu 1</label>
                        <p class="text-sm text-gray-700">${data.nama_tamu_1}</p>
                    </div>
                    ${data.nama_tamu_2 ? `
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tamu 2</label>
                        <p class="text-sm text-gray-700">${data.nama_tamu_2}</p>
                    </div>
                    ` : ''}
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-check-circle"></i>
                            Selesai
                        </span>
                    </div>
                </div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalContent').innerHTML = '<div class="p-4 bg-red-50 rounded-[10px] text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data.</div>';
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        });
}

function hideDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('detailModal').classList.remove('flex');
}

// Tutup modal ketika klik di luar
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target.id === 'detailModal') {
        hideDetailModal();
    }
});
</script>
@endsection
