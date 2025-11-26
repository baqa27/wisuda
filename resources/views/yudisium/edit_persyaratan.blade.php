@extends('layouts.mahasiswa_blank')

@section('title', 'Edit Persyaratan Yudisium')

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
                <h1 class="font-['Inter'] font-bold text-[24px] md:text-[32px] text-[#0061DF] mb-8 text-center">EDIT PERSYARATAN YUDISIUM</h1>

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('yudisium.persyaratan.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col lg:flex-row gap-10">
                        {{-- Left Column: Data Mahasiswa --}}
                        <div class="flex-1 flex flex-col gap-6">
                            
                            {{-- Nama --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Nama</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ Auth::user()->name }}</span>
                                </div>
                            </div>

                            {{-- NIM --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">NIM</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ Auth::user()->nim }}</span>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Email</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ Auth::user()->email }}</span>
                                </div>
                            </div>

                            {{-- Nomor Whatsapp --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Nomor Whatsapp</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white flex items-center gap-2">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">+62</span>
                                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $persyaratan->no_whatsapp) }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="81234567890" required>
                                </div>
                            </div>

                            {{-- Fakultas --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Fakultas</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">Teknik dan Ilmu Komputer</span>
                                </div>
                            </div>

                            {{-- Prodi --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Prodi</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ Auth::user()->prodi }}</span>
                                </div>
                            </div>

                            {{-- Semester --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Semester</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">8</span>
                                </div>
                            </div>

                            {{-- Judul TA --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Judul Tugas Akhir</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="judul_ta" value="{{ old('judul_ta', $persyaratan->judul_ta) }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Judul TA" required>
                                </div>
                            </div>

                            {{-- Dosen Pembimbing --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Dosen Pembimbing</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="dosen_pembimbing" value="{{ old('dosen_pembimbing', $persyaratan->dosen_pembimbing) }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Nama Dosen Pembimbing" required>
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Uploads --}}
                        <div class="flex-1 flex flex-col gap-8">
                            
                            {{-- Helper for file status --}}
                            @php
                                function showFileStatus($path) {
                                    if ($path) {
                                        return '<span class="text-green-600 text-sm"><i class="fas fa-check-circle"></i> File sudah ada</span>';
                                    }
                                    return '<span class="text-gray-500 text-sm">Belum ada file</span>';
                                }
                            @endphp

                            {{-- File KTP --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">File KTP</label>
                                <div class="mb-1">{!! showFileStatus($persyaratan->file_ktp) !!}</div>
                                <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                                    <input type="file" name="file_ktp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                    <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                </div>
                            </div>

                            {{-- Sertifikasi Tahfidz --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Sertifikasi Tahfidz</label>
                                <div class="mb-1">{!! showFileStatus($persyaratan->sertifikasi_tahfidz) !!}</div>
                                <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                                    <input type="file" name="sertifikasi_tahfidz" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                    <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                </div>
                            </div>

                            {{-- Sertifikasi TOEFL --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Sertifikasi TOEFL</label>
                                <div class="mb-1">{!! showFileStatus($persyaratan->sertifikasi_toefl) !!}</div>
                                <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                                    <input type="file" name="sertifikasi_toefl" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                    <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                </div>
                            </div>

                            {{-- Surat Bebas Perpustakaan --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Surat Bebas Perpustakaan</label>
                                <div class="mb-1">{!! showFileStatus($persyaratan->surat_bebas_perpustakaan) !!}</div>
                                <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                                    <input type="file" name="surat_bebas_perpustakaan" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                    <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                </div>
                            </div>

                            {{-- File Ijazah (Optional) --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">File Ijazah (Opsional)</label>
                                <div class="mb-1">{!! showFileStatus($persyaratan->file_ijazah) !!}</div>
                                <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                                    <input type="file" name="file_ijazah" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                    <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-12 flex justify-center gap-4">
                        <a href="{{ route('yudisium.index') }}" class="w-full md:w-[200px] h-[50px] bg-gray-500 rounded-[10px] text-white font-bold text-[18px] flex items-center justify-center hover:shadow-lg transition-all">
                            Batal
                        </a>
                        <button type="submit" class="w-full md:w-[200px] h-[50px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[18px] hover:shadow-lg transition-all">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <h4>Edit Persyaratan Yudisium</h4>

    <form action="{{ url('yudisium/update-persyaratan') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Judul TA</label>
        <input type="text" name="judul_ta" value="{{ $persyaratan->judul_ta }}" class="form-control" required>

        <label>Dosen Pembimbing</label>
        <input type="text" name="dosen_pembimbing" value="{{ $persyaratan->dosen_pembimbing }}" class="form-control" required>

        <label>File KTP (opsional)</label>
        <input type="file" name="file_ktp" class="form-control">

        <label>File Ijazah (opsional)</label>
        <input type="file" name="file_ijazah" class="form-control">

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
