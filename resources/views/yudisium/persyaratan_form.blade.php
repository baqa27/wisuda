@extends('layouts.mahasiswa_blank')

@section('title', 'Pendaftaran Yudisium')

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
                <h1 class="font-['Inter'] font-bold text-[24px] md:text-[32px] text-[#0061DF] mb-8 text-center">HALAMAN PENDAFTARAN YUDISIUM</h1>

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

                <form action="{{ route('yudisium.persyaratan.simpan') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf

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
                                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', Auth::user()->no_hp) }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="81234567890" required>
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
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">8</span> {{-- Hardcoded for now as per design, or dynamic if available --}}
                                </div>
                            </div>

                            {{-- Judul TA (Required by Controller) --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Judul Tugas Akhir</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="judul_ta" value="{{ old('judul_ta') }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Judul TA" required>
                                </div>
                            </div>

                            {{-- Dosen Pembimbing (Required by Controller) --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Dosen Pembimbing</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Nama Dosen Pembimbing" required>
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Uploads --}}
                        <div class="flex-1 flex flex-col gap-8">

                            {{-- File KTP (Required by Controller) --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">File KTP</label>
                                <div class="relative w-full h-[140px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden" data-target="file_ktp">
                                    <input type="file" name="file_ktp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="file_ktp" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center transition-opacity pointer-events-none" id="placeholder-file_ktp">
                                        <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                        <span class="font-['Inter'] text-[12px] text-[#0061DF]">Seret file anda atau klik untuk upload</span>
                                    </div>
                                    <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 pointer-events-none" id="success-file_ktp">
                                        <i class="fas fa-check-circle text-green-500 text-[36px] mb-2"></i>
                                        <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                        <p class="file-name text-xs text-green-600 font-mono"></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Sertifikasi Tahfidz --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Sertifikasi Tahfidz</label>
                                <div class="relative w-full h-[140px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden" data-target="sertifikasi_tahfidz">
                                    <input type="file" name="sertifikasi_tahfidz" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="sertifikasi_tahfidz" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center transition-opacity pointer-events-none" id="placeholder-sertifikasi_tahfidz">
                                        <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                        <span class="font-['Inter'] text-[12px] text-[#0061DF]">Seret file anda atau klik untuk upload</span>
                                    </div>
                                    <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 pointer-events-none" id="success-sertifikasi_tahfidz">
                                        <i class="fas fa-check-circle text-green-500 text-[36px] mb-2"></i>
                                        <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                        <p class="file-name text-xs text-green-600 font-mono"></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Sertifikasi TOEFL --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Sertifikasi TOEFL</label>
                                <div class="relative w-full h-[140px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden" data-target="sertifikasi_toefl">
                                    <input type="file" name="sertifikasi_toefl" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="sertifikasi_toefl" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center transition-opacity pointer-events-none" id="placeholder-sertifikasi_toefl">
                                        <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                        <span class="font-['Inter'] text-[12px] text-[#0061DF]">Seret file anda atau klik untuk upload</span>
                                    </div>
                                    <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 pointer-events-none" id="success-sertifikasi_toefl">
                                        <i class="fas fa-check-circle text-green-500 text-[36px] mb-2"></i>
                                        <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                        <p class="file-name text-xs text-green-600 font-mono"></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Surat Bebas Perpustakaan --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Surat Bebas Perpustakaan</label>
                                <div class="relative w-full h-[140px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden" data-target="surat_bebas_perpustakaan">
                                    <input type="file" name="surat_bebas_perpustakaan" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="surat_bebas_perpustakaan" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center transition-opacity pointer-events-none" id="placeholder-surat_bebas_perpustakaan">
                                        <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                        <span class="font-['Inter'] text-[12px] text-[#0061DF]">Seret file anda atau klik untuk upload</span>
                                    </div>
                                    <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 pointer-events-none" id="success-surat_bebas_perpustakaan">
                                        <i class="fas fa-check-circle text-green-500 text-[36px] mb-2"></i>
                                        <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                        <p class="file-name text-xs text-green-600 font-mono"></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Ijazah Terakhir --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Ijazah Terakhir</label>
                                <div class="relative w-full h-[140px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden" data-target="file_ijazah">
                                    <input type="file" name="file_ijazah" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="file_ijazah" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center transition-opacity pointer-events-none" id="placeholder-file_ijazah">
                                        <i class="fas fa-folder-plus text-[40px] text-[#0061DF] mb-2"></i>
                                        <span class="font-['Inter'] text-[12px] text-[#0061DF]">Seret file anda atau klik untuk upload</span>
                                    </div>
                                    <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 pointer-events-none" id="success-file_ijazah">
                                        <i class="fas fa-check-circle text-green-500 text-[36px] mb-2"></i>
                                        <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                        <p class="file-name text-xs text-green-600 font-mono"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-12 flex justify-center">
                        <button type="submit" class="w-full md:w-[200px] h-[50px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[18px] hover:shadow-lg transition-all">
                            Konfirmasi
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dragdrop-input').forEach(function (input) {
        var previewId = input.dataset.preview;
        var placeholder = document.getElementById('placeholder-' + previewId);
        var successState = document.getElementById('success-' + previewId);
        var fileNameSpan = successState ? successState.querySelector('.file-name') : null;

        input.addEventListener('change', function (event) {
            var file = event.target.files[0];

            if (!placeholder || !successState) {
                return;
            }

            if (file) {
                placeholder.classList.add('hidden');
                successState.classList.remove('hidden');
                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name;
                }
            } else {
                placeholder.classList.remove('hidden');
                successState.classList.add('hidden');
                if (fileNameSpan) {
                    fileNameSpan.textContent = '';
                }
            }
        });
    });
});
</script>
@endpush

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
