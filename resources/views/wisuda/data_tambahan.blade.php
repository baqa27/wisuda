@extends('layouts.mahasiswa_blank')

@section('title', 'Data Tambahan Wisuda')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-hidden flex flex-col items-center">

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
        <x-mahasiswa-navbar />

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


