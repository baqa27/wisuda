@extends('layouts.mahasiswa')

@section('title', 'Form Persyaratan Yudisium')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('yudisium.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Yudisium
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Form Persyaratan Yudisium</h1>
        <p class="text-gray-600">Lengkapi persyaratan yudisium Anda</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div class="text-green-800">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('yudisium.persyaratan.simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Tugas Akhir -->
                <div class="md:col-span-2">
                    <label for="judul_ta" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Tugas Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul_ta" id="judul_ta"
                           value="{{ old('judul_ta') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan judul tugas akhir Anda"
                           required>
                    @error('judul_ta')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dosen Pembimbing -->
                <div class="md:col-span-2">
                    <label for="dosen_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">
                        Dosen Pembimbing <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="dosen_pembimbing" id="dosen_pembimbing"
                           value="{{ old('dosen_pembimbing') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan nama dosen pembimbing"
                           required>
                    @error('dosen_pembimbing')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File KTP -->
                <div>
                    <label for="file_ktp" class="block text-sm font-medium text-gray-700 mb-2">
                        File KTP <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="file_ktp" id="file_ktp"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>
                    <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, PNG (Maks. 2MB)</p>
                    @error('file_ktp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Ijazah -->
                <div>
                    <label for="file_ijazah" class="block text-sm font-medium text-gray-700 mb-2">
                        File Ijazah Terakhir (Opsional)
                    </label>
                    <input type="file" name="file_ijazah" id="file_ijazah"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, PNG (Maks. 2MB)</p>
                    @error('file_ijazah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('yudisium.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-save mr-2"></i> Simpan Persyaratan
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="font-semibold text-blue-800 mb-3">Informasi Penting</h3>
        <ul class="text-sm text-blue-700 space-y-2">
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Pastikan semua dokumen yang diupload jelas terbaca
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                File KTP wajib diupload dalam format PDF, JPG, atau PNG
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Verifikasi persyaratan membutuhkan waktu 2-3 hari kerja
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Jika perlu revisi, Anda dapat mengedit persyaratan nanti
            </li>
        </ul>
    </div>
</div>
@endsection
