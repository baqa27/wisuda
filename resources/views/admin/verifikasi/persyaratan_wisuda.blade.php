@extends('layouts.admin')

@section('title', 'Verifikasi Persyaratan Wisuda')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-[#056100] to-[#00DF1A] bg-clip-text text-transparent">
            Verifikasi Persyaratan Wisuda
        </h1>
        <p class="text-gray-600 text-lg mt-2">Verifikasi persyaratan wisuda dari mahasiswa</p>
    </div>

    @if ($mahasiswa->count() > 0)
        <div class="auth-card overflow-hidden">
            <!-- Header Stats -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <span class="font-semibold text-gray-700">Total Menunggu Verifikasi:</span>
                        <span class="text-[#056100] font-bold ml-2">{{ $mahasiswa->count() }}</span>
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
                        @foreach ($mahasiswa as $mhs)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $mhs->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $mhs->nim }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $mhs->prodi }}</p>
                                    {{-- Optional: Show TA Title if available via relation --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs text-gray-500">Email: {{ $mhs->email }}</span>
                                        {{-- If Phone is available --}}
                                        {{-- <span class="font-semibold text-gray-900 flex items-center gap-1"><i class="fas fa-phone text-[#056100]"></i> ...</span> --}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        // Mapping friendly names
                                        $jenisLabels = [
                                            'toefl' => 'Sertifikat TOEFL',
                                            'sertifikasi' => 'Sertifikasi Kompetensi',
                                            'tahfidz' => 'Sertifikat Tahfidz',
                                            'bebas_perpus' => 'Bebas Perpustakaan',
                                            'foto_wisuda' => 'Foto Wisuda',
                                            'buku_kenangan' => 'Buku Kenangan',
                                            'keuangan' => 'Bukti Pembayaran',
                                            'skpl' => 'SKPL' // Add other types as needed
                                        ];
                                    @endphp
                                    <div class="space-y-1">
                                        @foreach ($mhs->persyaratanWisuda as $item)
                                            @if($item->status == 'menunggu')
                                                <a href="{{ route('admin.download.persyaratan-wisuda', basename($item->file_path)) }}"
                                                    target="_blank"
                                                    class="flex items-center gap-2 text-[#056100] hover:text-[#00DF1A] font-semibold transition text-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span class="truncate max-w-[150px]">{{ $jenisLabels[$item->jenis] ?? $item->jenis }}</span>
                                                    <span class="text-[10px] bg-yellow-100 text-yellow-800 px-1 rounded">Baru</span>
                                                </a>
                                            @else
                                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>{{ $jenisLabels[$item->jenis] ?? $item->jenis }} ({{ ucfirst($item->status) }})</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @php
                                        $latest = $mhs->persyaratanWisuda->sortByDesc('updated_at')->first();
                                    @endphp
                                    <div class="flex flex-col">
                                        <span>{{ $latest ? $latest->updated_at->format('d/m/Y H:i') : '-' }}</span>
                                        @if($mhs->persyaratanWisuda->where('status', 'menunggu')->count() > 0)
                                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 w-fit">
                                                <i class="fas fa-clock"></i> {{ $mhs->persyaratanWisuda->where('status', 'menunggu')->count() }} Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 w-fit">
                                                <i class="fas fa-check"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        {{-- Setujui Semua Pending --}}
                                        <form action="{{ route('admin.verifikasi.persyaratan-wisuda.bulk-approve', $mhs->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-[10px] bg-green-100 text-green-700 hover:bg-green-200 font-semibold text-xs transition">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        {{-- Revisi Button - Opens Modal --}}
                                        <button type="button" onclick="showRevisiModal({{ $mhs->id }})"
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

        {{-- Revisi Modal - Simple like Yudisium --}}
        @foreach ($mahasiswa as $mhs)
            <div id="revisiModal-{{ $mhs->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 revisi-modal">
                <div class="auth-card w-full max-w-md">
                    <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-[#056100]">Berikan Catatan Revisi</h3>
                        <button type="button" onclick="hideRevisiModal({{ $mhs->id }})" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.verifikasi.persyaratan-wisuda.bulk-revise', $mhs->id) }}" method="POST" class="p-6">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Revisi</label>
                            <textarea name="catatan" rows="4" class="auth-input w-full"
                                placeholder="Masukkan catatan revisi..." required></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="hideRevisiModal({{ $mhs->id }})"
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
        @endforeach

        <script>
            function showRevisiModal(id) {
                document.getElementById('revisiModal-' + id).classList.remove('hidden');
                document.getElementById('revisiModal-' + id).classList.add('flex');
            }

            function hideRevisiModal(id) {
                document.getElementById('revisiModal-' + id).classList.add('hidden');
                document.getElementById('revisiModal-' + id).classList.remove('flex');
            }

            // Close modal on outside click
            document.querySelectorAll('.revisi-modal').forEach(modal => {
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
