@extends('layouts.admin')

@section('title', 'Verifikasi Persyaratan Yudisium')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-linear-to-r from-[#0A0061] to-[#0061DF] bg-clip-text text-transparent">
            Verifikasi Persyaratan Yudisium
        </h1>
        <p class="text-gray-600 text-lg mt-2">Verifikasi persyaratan yudisium dari mahasiswa</p>
    </div>

    @if ($persyaratan->count() > 0)
        <div class="auth-card overflow-hidden">
            <!-- Header Stats -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <span class="font-semibold text-gray-700">Total Menunggu Verifikasi:</span>
                        <span class="text-[#0061DF] font-bold ml-2">{{ $persyaratan->count() }}</span>
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
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Akademik</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kontak</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dokumen</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Diajukan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($persyaratan as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->mahasiswa->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $item->judul_ta }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Dospem: {{ $item->dosen_pembimbing }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-semibold text-gray-900 flex items-center gap-1">
                                            <i class="fas fa-phone text-[#0061DF]"></i>
                                            {{ $item->no_whatsapp ?? '-' }}
                                        </span>
                                        <span class="text-xs text-gray-500">Email: {{ $item->mahasiswa->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $files = [
                                            'KTP' => $item->file_ktp,
                                            'Ijazah' => $item->file_ijazah,
                                            'Sertifikat Tahfidz' => $item->sertifikasi_tahfidz,
                                            'Sertifikat TOEFL' => $item->sertifikasi_toefl,
                                            'Surat Bebas Perpustakaan' => $item->surat_bebas_perpustakaan,
                                        ];
                                    @endphp
                                    <div class="space-y-1">
                                        @foreach ($files as $label => $path)
                                            @if ($path)
                                                <a href="{{ route('admin.view.persyaratan-yudisium', basename($path)) }}"
                                                    target="_blank"
                                                    class="flex items-center gap-2 text-[#0061DF] hover:text-[#0A0061] font-semibold transition text-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>{{ $label }}</span>
                                                </a>
                                            @else
                                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>{{ $label }} belum diunggah</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex flex-col">
                                        <span>{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                                        </span>
                                        @if($item->catatan_admin)
                                            <span class="text-xs text-red-500 mt-1">Catatan terakhir: {{ $item->catatan_admin }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.verifikasi.persyaratan-yudisium.update', $item->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="terverifikasi">
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-green-100 text-green-700 hover:bg-green-200 font-semibold text-xs transition">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <button type="button" onclick="showRevisiModal({{ $item->id }})"
                                            class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-red-100 text-red-700 hover:bg-red-200 font-semibold text-xs transition">
                                            <i class="fas fa-redo"></i> Revisi
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Revisi -->
        <div id="revisiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
            <div class="auth-card w-full max-w-md">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#0A0061]">Berikan Catatan Revisi</h3>
                    <button type="button" onclick="hideRevisiModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form id="revisiForm" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="revisi">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Revisi</label>
                        <textarea name="catatan" rows="4" class="auth-input w-full"
                            placeholder="Masukkan catatan revisi..." required></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideRevisiModal()"
                            class="px-4 py-2 border border-gray-300 rounded-[10px] text-gray-700 font-semibold hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary px-4 py-2">
                            <i class="fas fa-paper-plane mr-1"></i> Kirim Revisi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function showRevisiModal(id) {
                const form = document.getElementById('revisiForm');
                form.action = `/admin/verifikasi/persyaratan-yudisium/${id}`;
                document.getElementById('revisiModal').classList.remove('hidden');
                document.getElementById('revisiModal').classList.add('flex');
            }

            function hideRevisiModal() {
                document.getElementById('revisiModal').classList.add('hidden');
                document.getElementById('revisiModal').classList.remove('flex');
            }

            // Tutup modal ketika klik di luar
            document.getElementById('revisiModal').addEventListener('click', function(e) {
                if (e.target.id === 'revisiModal') {
                    hideRevisiModal();
                }
            });
        </script>
    @else
        <div class="auth-card text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tidak ada persyaratan yang menunggu verifikasi</h3>
            <p class="text-gray-600 text-sm">Semua persyaratan yudisium sudah diverifikasi.</p>
        </div>
    @endif
@endsection
