@extends('layouts.mahasiswa')

@section('title', 'Data Orang Tua & Tamu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('wisuda.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Wisuda
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Data Orang Tua & Tamu</h1>
        <p class="text-gray-600">Isi data orang tua dan tamu yang akan menghadiri wisuda</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div class="text-green-800">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <div class="text-red-800">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('wisuda.data-tambahan.simpan') }}" method="POST">
            @csrf

            <!-- Data Orang Tua -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Orang Tua</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Orang Tua 1 -->
                    <div>
                        <label for="nama_ortu_1" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Orang Tua 1 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_ortu_1"
                               id="nama_ortu_1"
                               value="{{ old('nama_ortu_1') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama orang tua"
                               required>
                        @error('nama_ortu_1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Orang Tua 2 -->
                    <div>
                        <label for="nama_ortu_2" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Orang Tua 2 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_ortu_2"
                               id="nama_ortu_2"
                               value="{{ old('nama_ortu_2') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama orang tua"
                               required>
                        @error('nama_ortu_2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Tamu -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Tamu</h3>
                <p class="text-sm text-gray-600 mb-4">Masukkan nama tamu yang akan menghadiri wisuda (maksimal 2 orang)</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Tamu 1 -->
                    <div>
                        <label for="nama_tamu_1" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Tamu 1 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_tamu_1"
                               id="nama_tamu_1"
                               value="{{ old('nama_tamu_1') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama tamu"
                               required>
                        @error('nama_tamu_1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Tamu 2 -->
                    <div>
                        <label for="nama_tamu_2" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Tamu 2 <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_tamu_2"
                               id="nama_tamu_2"
                               value="{{ old('nama_tamu_2') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama tamu"
                               required>
                        @error('nama_tamu_2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Penting -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-yellow-800 mb-2">Informasi Penting</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        Data yang sudah disimpan tidak dapat diubah kembali
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        Pastikan nama ditulis dengan benar sesuai identitas
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        Data ini akan digunakan untuk sertifikat dan dokumen wisuda
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle mt-1 mr-2"></i>
                        Setelah mengisi data, Anda akan mendapatkan QR Code presensi
                    </li>
                </ul>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('wisuda.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Status Kelengkapan -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-6">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
            <div>
                <h3 class="font-semibold text-green-800">Hampir Selesai!</h3>
                <p class="text-green-700">Setelah mengisi data ini, Anda akan dinyatakan <strong>siap wisuda</strong> dan mendapatkan QR Code presensi.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi form
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi.');
            }
        });
    });
</script>
@endsection
