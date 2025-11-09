@extends('layouts.admin')

@section('title', 'Verifikasi Persyaratan Yudisium')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Verifikasi Persyaratan Yudisium</h1>
        <p class="text-gray-600">Verifikasi persyaratan yudisium dari mahasiswa</p>
    </div>

    @if ($persyaratan->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                                TA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen
                                Pembimbing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Upload</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($persyaratan as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->mahasiswa->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->judul_ta }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->dosen_pembimbing }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.view.persyaratan-yudisium', basename($item->file_ktp)) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:text-blue-900 text-sm flex items-center mb-1">
                                        Lihat KTP
                                    </a>
                                    </a>
                                    @if ($item->file_ijazah)
                                        <a href="{{ route('admin.view.persyaratan-yudisium', basename($item->file_ijazah)) }}"
                                            target="_blank"
                                            class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                            Lihat Ijazah
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.verifikasi.persyaratan-yudisium.update', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="terverifikasi">
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm mr-2">
                                            Setujui
                                        </button>
                                    </form>
                                    <button type="button" onclick="showRevisiModal({{ $item->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        Revisi
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Revisi -->
        <div id="revisiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-semibold mb-4">Berikan Catatan Revisi</h3>
                <form id="revisiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="revisi">
                    <textarea name="catatan" rows="4" class="w-full border border-gray-300 rounded p-2 mb-4"
                        placeholder="Masukkan catatan revisi..." required></textarea>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="hideRevisiModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Kirim
                            Revisi</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function showRevisiModal(id) {
                const form = document.getElementById('revisiForm');
                form.action = `/admin/verifikasi/persyaratan-yudisium/${id}`;
                document.getElementById('revisiModal').classList.remove('hidden');
            }

            function hideRevisiModal() {
                document.getElementById('revisiModal').classList.add('hidden');
            }

            // Tutup modal ketika klik di luar
            document.getElementById('revisiModal').addEventListener('click', function(e) {
                if (e.target.id === 'revisiModal') {
                    hideRevisiModal();
                }
            });
        </script>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada persyaratan yang menunggu verifikasi</h3>
            <p class="text-gray-600">Semua persyaratan yudisium sudah diverifikasi.</p>
        </div>
    @endif
@endsection
