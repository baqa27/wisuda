@extends('layouts.admin')

@section('title', 'Verifikasi Persyaratan Wisuda')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
            Verifikasi Persyaratan Wisuda
        </h1>
        <p class="text-gray-600 text-lg mt-2">Verifikasi persyaratan wisuda dikelompokkan per mahasiswa</p>
    </div>

    @if ($mahasiswa->count() > 0)
        <div class="auth-card overflow-hidden">
            <!-- Header Stats -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <span class="font-semibold text-gray-700">Total Mahasiswa Menunggu:</span>
                        <span class="text-[#0061DF] font-bold ml-2">{{ $mahasiswa->count() }}</span>
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
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Prodi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Berkas</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($mahasiswa as $mhs)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $mhs->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $mhs->nim }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $mhs->prodi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $pendingCount = $mhs->persyaratanWisuda->where('status', 'menunggu')->count();
                                        $verifiedCount = $mhs->persyaratanWisuda->where('status', 'terverifikasi')->count();
                                        $totalCount = $mhs->persyaratanWisuda->count();
                                    @endphp
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded-full w-fit">
                                            {{ $pendingCount }} Menunggu
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Total: {{ $totalCount }} Berkas
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" onclick="showDetailModal({{ $mhs->id }})"
                                        class="inline-flex items-center gap-1 px-4 py-2 rounded-[10px] bg-[#0061DF] text-white hover:bg-[#0A0061] font-semibold text-xs transition">
                                        <i class="fas fa-eye"></i> Periksa Berkas
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Detail Berkas -->
        @foreach ($mahasiswa as $mhs)
            <div id="detailModal-{{ $mhs->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 detail-modal">
                <div class="auth-card w-full max-w-4xl max-h-[90vh] overflow-y-auto flex flex-col">
                    <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 bg-white z-10">
                        <div>
                            <h3 class="text-lg font-bold text-[#0A0061]">Verifikasi Berkas Wisuda</h3>
                            <p class="text-sm text-gray-600">{{ $mhs->name }} ({{ $mhs->nim }})</p>
                        </div>
                        <button type="button" onclick="hideDetailModal({{ $mhs->id }})" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto">
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ($mhs->persyaratanWisuda as $item)
                                <div class="border border-gray-200 rounded-lg p-4 {{ $item->status == 'menunggu' ? 'bg-yellow-50 border-yellow-200' : 'bg-white' }}">
                                    <div class="flex flex-col md:flex-row justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800 mb-1">
                                                @php
                                                    $jenisLabels = [
                                                        'toefl' => 'Sertifikat TOEFL',
                                                        'sertifikasi' => 'Sertifikasi Kompetensi',
                                                        'tahfidz' => 'Sertifikat Tahfidz',
                                                        'bebas_perpus' => 'Bebas Perpustakaan',
                                                        'foto_wisuda' => 'Foto Wisuda',
                                                        'buku_kenangan' => 'Buku Kenangan',
                                                    ];
                                                @endphp
                                                {{ $jenisLabels[$item->jenis] ?? $item->jenis }}
                                            </h4>
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                                    {{ $item->status == 'menunggu' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                                    {{ $item->status == 'terverifikasi' ? 'bg-green-200 text-green-800' : '' }}
                                                    {{ $item->status == 'revisi' ? 'bg-red-200 text-red-800' : '' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <a href="{{ route('admin.download.persyaratan-wisuda', basename($item->file_path)) }}" target="_blank"
                                                class="inline-flex items-center gap-1 text-[#0061DF] hover:underline text-sm font-medium">
                                                <i class="fas fa-external-link-alt"></i> Lihat/Download File
                                            </a>
                                        </div>

                                        <div class="flex flex-col gap-2 min-w-[200px]">
                                            @if($item->status == 'menunggu')
                                                <form action="{{ route('admin.verifikasi.persyaratan-wisuda.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="terverifikasi">
                                                    <button type="submit" class="w-full px-3 py-2 rounded-[8px] bg-green-600 text-white hover:bg-green-700 font-semibold text-sm transition text-center">
                                                        <i class="fas fa-check mr-1"></i> Setujui
                                                    </button>
                                                </form>
                                                <button type="button" onclick="showRevisiForm({{ $item->id }})" class="w-full px-3 py-2 rounded-[8px] bg-red-600 text-white hover:bg-red-700 font-semibold text-sm transition text-center">
                                                    <i class="fas fa-redo mr-1"></i> Minta Revisi
                                                </button>
                                            @else
                                                <div class="text-sm text-gray-500 italic text-center py-2">
                                                    Sudah diproses
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Form Revisi (Hidden by default) -->
                                    <div id="revisiForm-{{ $item->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
                                        <form action="{{ route('admin.verifikasi.persyaratan-wisuda.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="revisi">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Revisi:</label>
                                            <textarea name="catatan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required placeholder="Jelaskan apa yang perlu diperbaiki..."></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button" onclick="hideRevisiForm({{ $item->id }})" class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                                                <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">Kirim Revisi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            function showDetailModal(id) {
                document.getElementById('detailModal-' + id).classList.remove('hidden');
                document.getElementById('detailModal-' + id).classList.add('flex');
            }

            function hideDetailModal(id) {
                document.getElementById('detailModal-' + id).classList.add('hidden');
                document.getElementById('detailModal-' + id).classList.remove('flex');
            }

            function showRevisiForm(itemId) {
                document.getElementById('revisiForm-' + itemId).classList.remove('hidden');
            }

            function hideRevisiForm(itemId) {
                document.getElementById('revisiForm-' + itemId).classList.add('hidden');
            }

            // Close modal on outside click
            document.querySelectorAll('.detail-modal').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        this.classList.remove('flex');
                    }
                });
            });
        </script>
    @else
        <div class="auth-card text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tidak ada persyaratan yang menunggu verifikasi</h3>
            <p class="text-gray-600 text-sm">Semua persyaratan wisuda sudah diverifikasi.</p>
        </div>
    @endif
@endsection
