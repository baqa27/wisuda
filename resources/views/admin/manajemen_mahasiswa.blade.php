@extends('layouts.admin')

@section('title', 'Manajemen Mahasiswa')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#056100] to-[#00DF1A] bg-clip-text text-transparent">
                Manajemen Mahasiswa
            </h1>
            <p class="text-gray-600 text-lg mt-2">Kelola data mahasiswa yang terdaftar dalam sistem</p>
        </div>
    </div>

    @if($mahasiswa->count() > 0)
        <div class="auth-card overflow-hidden">
            <div class="bg-gradient-to-r from-[#056100] to-[#00DF1A] p-6">
                <h2 class="text-lg font-bold text-white">Daftar Mahasiswa</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM & Prodi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">IPK</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Yudisium</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Wisuda</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Terdaftar</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($mahasiswa as $mhs)
                            <tr class="hover:bg-gray-50 transition border-b border-gray-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $mhs->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $mhs->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-[#056100]">{{ $mhs->nim ?? '-' }}</div>
                                    <div class="text-xs text-gray-600">{{ $mhs->prodi ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-[10px] text-sm font-bold bg-green-100 text-[#056100]">
                                        {{ $mhs->ipk ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($mhs->persyaratanYudisium)
                                        @if($mhs->persyaratanYudisium->status == 'terverifikasi')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                            </span>
                                        @elseif($mhs->persyaratanYudisium->status == 'revisi')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-red-100 text-red-700">
                                                <i class="fas fa-redo"></i> Revisi
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-gray-100 text-gray-700">
                                            <i class="fas fa-minus-circle"></i> Belum Daftar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($mhs->pendaftaranWisuda)
                                        @if($mhs->pendaftaranWisuda->status == 'lunas')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i> Lunas
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-[10px] text-xs font-semibold bg-gray-100 text-gray-700">
                                            <i class="fas fa-minus-circle"></i> Belum Daftar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                                    {{ $mhs->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.manajemen-mahasiswa.destroy', $mhs->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($mahasiswa->hasPages())
            <div class="mt-6 flex items-center justify-between px-6 py-4 border-t border-gray-200 auth-card">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $mahasiswa->firstItem() }}</span> hingga <span
                        class="font-semibold">{{ $mahasiswa->lastItem() }}</span> dari <span
                        class="font-semibold">{{ $mahasiswa->total() }}</span> mahasiswa
                </div>
                <div class="flex items-center gap-2">
                    {{ $mahasiswa->links() }}
                </div>
            </div>
        @endif

    @else
        <div class="auth-card p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-[10px] bg-gray-100 mb-4">
                <i class="fas fa-users text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Mahasiswa Terdaftar</h3>
            <p class="text-gray-600 text-sm">Mahasiswa akan muncul di halaman ini setelah mereka mendaftar di sistem.</p>
            <button onclick="openCreateModal()"
                class="mt-6 bg-[#0061DF] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition inline-flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Mahasiswa</span>
            </button>
        </div>
    @endif

    <!-- Infinite Modal for Create/Edit -->
    <div id="modalOverlay" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                onclick="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modalTitle">
                                Tambah Mahasiswa
                            </h3>
                            <div class="mt-4">
                                <form id="mahasiswaForm" method="POST" action="">
                                    @csrf
                                    <input type="hidden" name="_method" id="formMethod" value="POST">

                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                                Lengkap</label>
                                            <input type="text" name="name" id="name" required
                                                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email
                                                Address</label>
                                            <input type="email" name="email" id="email" required
                                                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-red-500 hidden" id="emailError"></p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                                                <input type="text" name="nim" id="nim" required
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                            <div>
                                                <label for="prodi" class="block text-sm font-medium text-gray-700">Program
                                                    Studi</label>
                                                <input type="text" name="prodi" id="prodi" required
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500" id="passwordHint">Minimal 6 karakter.</p>
                                        </div>
                                    </div>

                                    <div class="mt-5 sm:flex sm:flex-row-reverse gap-2">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Simpan
                                        </button>
                                        <button type="button" onclick="closeModal()"
                                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Mahasiswa';
            document.getElementById('mahasiswaForm').action = "{{ route('admin.manajemen-mahasiswa.store') }}";
            document.getElementById('formMethod').value = 'POST';

            // Reset form
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('nim').value = '';
            document.getElementById('prodi').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = true;
            document.getElementById('passwordHint').innerText = 'Minimal 6 karakter.';

            document.getElementById('modalOverlay').classList.remove('hidden');
        }

        function openEditModal(data) {
            document.getElementById('modalTitle').innerText = 'Edit Mahasiswa';
            // Dynamically set action URL
            let url = "{{ route('admin.manajemen-mahasiswa.update', ':id') }}";
            url = url.replace(':id', data.id);
            document.getElementById('mahasiswaForm').action = url;
            document.getElementById('formMethod').value = 'PUT';

            // Fill form
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('nim').value = data.nim || '';
            document.getElementById('prodi').value = data.prodi || '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = false;
            document.getElementById('passwordHint').innerText = 'Kosongkan jika tidak ingin mengubah password. (Min 6 karakter)';

            document.getElementById('modalOverlay').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.add('hidden');
        }
    </script>
@endsection