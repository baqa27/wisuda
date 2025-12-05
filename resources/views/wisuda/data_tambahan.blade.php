@extends('layouts.mahasiswa_blank')

@section('title', 'Data Tambahan Wisuda')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-x-hidden flex flex-col items-center">

        {{-- Background Elements --}}
        <div class="absolute w-[886px] h-[886px] -left-[456px] top-[658px] pointer-events-none z-0 hidden md:block">
            <div class="absolute w-[206.67px] h-[886px] left-[339.66px] top-0 bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute w-[305.52px] h-[886px] left-0 top-[289.34px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>
        <div class="absolute w-[493px] h-[493px] left-[1259px] top-[308px] pointer-events-none z-0 hidden md:block">
            <div class="absolute w-[115px] h-[493px] left-[189px] top-0 bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute w-[170px] h-[493px] left-0 top-[161px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>

        {{-- Top Navigation Bar --}}
        <div class="absolute top-[35px] z-20 w-full flex justify-center px-4">
            <div class="flex flex-row justify-between md:justify-center items-center px-6 md:gap-[175px] w-full max-w-[1262px] h-[82px] bg-[#0061DF] rounded-[10px] shadow-lg overflow-hidden">
                <a href="{{ route('yudisium.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-medal text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Yudisium</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white">Home</span>
                </a>
                <a href="{{ route('wisuda.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Wisuda</span>
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="relative z-10 flex flex-col items-center w-full max-w-[1262px] pt-[150px] px-4 pb-20">
            
            {{-- Form Container --}}
            <div class="w-full bg-white rounded-[10px] shadow-lg p-8 md:p-12 border border-gray-200">
                <h1 class="font-['Inter'] font-bold text-[24px] md:text-[32px] text-[#0061DF] mb-8 text-center">DATA TAMBAHAN WISUDA</h1>

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('wisuda.data-tambahan.simpan') }}" method="POST">
                    @csrf
                    <div class="flex flex-col lg:flex-row gap-10">
                        {{-- Left Column: Data Orang Tua --}}
                        <div class="flex-1 flex flex-col gap-6">
                            <h2 class="font-['Inter'] font-bold text-[20px] text-[#0061DF] border-b-2 border-[#0061DF] pb-2">Data Orang Tua</h2>
                            
                            {{-- Nama Orang Tua 1 --}}
                            <div class="flex flex-col gap-2">
                                <label for="nama_ortu_1" class="font-['Inter'] font-semibold text-[16px] text-[#0061DF]">Nama Orang Tua 1 <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_ortu_1" id="nama_ortu_1" value="{{ old('nama_ortu_1') }}" 
                                    class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-[#0061DF]"
                                    placeholder="Masukkan nama orang tua" required>
                                @error('nama_ortu_1')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Orang Tua 2 --}}
                            <div class="flex flex-col gap-2">
                                <label for="nama_ortu_2" class="font-['Inter'] font-semibold text-[16px] text-[#0061DF]">Nama Orang Tua 2 <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_ortu_2" id="nama_ortu_2" value="{{ old('nama_ortu_2') }}" 
                                    class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-[#0061DF]"
                                    placeholder="Masukkan nama orang tua" required>
                                @error('nama_ortu_2')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Right Column: Data Tamu --}}
                        <div class="flex-1 flex flex-col gap-6">
                            <h2 class="font-['Inter'] font-bold text-[20px] text-[#0061DF] border-b-2 border-[#0061DF] pb-2">Data Tamu Undangan</h2>
                            
                            {{-- Nama Tamu 1 --}}
                            <div class="flex flex-col gap-2">
                                <label for="nama_tamu_1" class="font-['Inter'] font-semibold text-[16px] text-[#0061DF]">Nama Tamu 1 <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_tamu_1" id="nama_tamu_1" value="{{ old('nama_tamu_1') }}" 
                                    class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-[#0061DF]"
                                    placeholder="Masukkan nama tamu" required>
                                @error('nama_tamu_1')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Tamu 2 --}}
                            <div class="flex flex-col gap-2">
                                <label for="nama_tamu_2" class="font-['Inter'] font-semibold text-[16px] text-[#0061DF]">Nama Tamu 2 <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_tamu_2" id="nama_tamu_2" value="{{ old('nama_tamu_2') }}" 
                                    class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white focus:outline-none focus:ring-2 focus:ring-[#0061DF]"
                                    placeholder="Masukkan nama tamu" required>
                                @error('nama_tamu_2')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-[10px]">
                        <h4 class="font-semibold text-yellow-800 mb-2 flex items-center"><i class="fas fa-info-circle mr-2"></i> Informasi Penting</h4>
                        <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                            <li>Data yang sudah disimpan tidak dapat diubah kembali.</li>
                            <li>Pastikan nama ditulis dengan benar sesuai identitas.</li>
                            <li>Data ini akan digunakan untuk sertifikat dan dokumen wisuda.</li>
                            <li>Setelah mengisi data, Anda akan mendapatkan QR Code presensi.</li>
                        </ul>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row gap-4 justify-center">
                        <a href="{{ route('wisuda.index') }}" class="w-full md:w-[200px] h-[50px] border border-[#0061DF] rounded-[10px] text-[#0061DF] font-bold text-[18px] flex items-center justify-center hover:bg-blue-50 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="w-full md:w-[200px] h-[50px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[18px] flex items-center justify-center hover:shadow-lg transition-all">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

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
