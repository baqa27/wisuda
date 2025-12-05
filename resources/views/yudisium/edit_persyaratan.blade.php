@extends('layouts.mahasiswa_blank')

@section('title', 'Edit Persyaratan Yudisium')

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

                            @php
                                $dropzones = [
                                    ['id' => 'file_ktp', 'label' => 'File KTP', 'name' => 'file_ktp', 'hint' => 'PDF maks 2MB', 'accept' => '.pdf,application/pdf'],
                                    ['id' => 'sertifikasi_tahfidz', 'label' => 'Sertifikasi Tahfidz', 'name' => 'sertifikasi_tahfidz', 'hint' => 'PDF maks 2MB', 'accept' => '.pdf,application/pdf'],
                                    ['id' => 'sertifikasi_toefl', 'label' => 'Sertifikasi TOEFL', 'name' => 'sertifikasi_toefl', 'hint' => 'PDF maks 2MB', 'accept' => '.pdf,application/pdf'],
                                    ['id' => 'surat_bebas_perpustakaan', 'label' => 'Surat Bebas Perpustakaan', 'name' => 'surat_bebas_perpustakaan', 'hint' => 'PDF maks 2MB', 'accept' => '.pdf,application/pdf'],
                                    ['id' => 'file_ijazah', 'label' => 'File Ijazah (Opsional)', 'name' => 'file_ijazah', 'hint' => 'PDF maks 2MB', 'accept' => '.pdf,application/pdf'],
                                ];
                            @endphp

                            @foreach ($dropzones as $dropzone)
                                <div class="flex flex-col gap-2">
                                    <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">{{ $dropzone['label'] }}</label>
                                    <div class="relative w-full h-40 bg-[#D6D4FF] border border-dashed border-black rounded-[10px] p-4 overflow-hidden">
                                        <div class="w-full h-full flex flex-col items-center justify-center text-center gap-1 pointer-events-none" id="placeholder-{{ $dropzone['id'] }}">
                                            <i class="fas fa-folder-plus text-[40px] text-[#0061DF]"></i>
                                            <span class="font-['Inter'] text-[12px] text-[#0061DF]">Upload ulang untuk mengganti</span>
                                            <small class="text-[11px] text-[#4B4F8F]">{{ $dropzone['hint'] }}</small>
                                        </div>

                                        <div class="absolute inset-0 hidden px-4 py-4" id="preview-wrapper-{{ $dropzone['id'] }}">
                                            <div class="w-full h-full bg-[#D6D4FF] flex flex-col items-center justify-center gap-4 text-center">
                                                <div class="w-full bg-white rounded-lg border border-[#0061DF]/30 shadow-sm p-4 flex items-center gap-3 text-left">
                                                    <i class="fas fa-file-pdf text-2xl text-[#BA1B1D]" id="preview-icon-{{ $dropzone['id'] }}"></i>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-[#0061DF] truncate" id="preview-name-{{ $dropzone['id'] }}"></p>
                                                    <p class="text-xs text-gray-500" id="preview-info-{{ $dropzone['id'] }}"></p>
                                                </div>
                                            </div>
                                                <button type="button" class="text-sm text-red-600 hover:underline" data-reset-preview="{{ $dropzone['id'] }}">Batal pilih file</button>
                                            </div>
                                        </div>

                                        <input type="file" id="input-{{ $dropzone['id'] }}" data-preview-id="{{ $dropzone['id'] }}" name="{{ $dropzone['name'] }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer previewable-file" accept="{{ $dropzone['accept'] }}">
                                    </div>
                                </div>
                            @endforeach

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInputs = document.querySelectorAll('.previewable-file');
    const allowedMime = ['application/pdf'];
    const allowedExtensions = ['.pdf'];

    const togglePlaceholder = (previewId, show = true) => {
        const placeholder = document.getElementById(`placeholder-${previewId}`);
        if (!placeholder) return;
        placeholder.classList.toggle('hidden', !show);
    };

    const showPreview = (file, previewId) => {
        const wrapper = document.getElementById(`preview-wrapper-${previewId}`);
        const iconEl = document.getElementById(`preview-icon-${previewId}`);
        const nameEl = document.getElementById(`preview-name-${previewId}`);
        const infoEl = document.getElementById(`preview-info-${previewId}`);

        if (!wrapper || !iconEl || !nameEl || !infoEl) return;

        nameEl.textContent = file.name;
        infoEl.textContent = 'PDF siap diunggah';

        togglePlaceholder(previewId, false);
        wrapper.classList.remove('hidden');
    };

    const resetPreview = (previewId) => {
        const wrapper = document.getElementById(`preview-wrapper-${previewId}`);
        const iconEl = document.getElementById(`preview-icon-${previewId}`);
        const nameEl = document.getElementById(`preview-name-${previewId}`);
        const infoEl = document.getElementById(`preview-info-${previewId}`);
        const input = document.getElementById(`input-${previewId}`);

        if (wrapper) {
            wrapper.classList.add('hidden');
        }
        if (nameEl) {
            nameEl.textContent = '';
        }
        if (infoEl) {
            infoEl.textContent = '';
        }
        if (iconEl) {
            iconEl.classList.add('fa-file-pdf');
        }
        if (input) {
            input.value = '';
        }
        togglePlaceholder(previewId, true);
    };

    fileInputs.forEach(input => {
        input.addEventListener('change', event => {
            const file = event.target.files[0];
            const previewId = event.target.dataset.previewId;

            if (!previewId) return;

            if (!file) {
                resetPreview(previewId);
                return;
            }

            const isPdf = allowedMime.includes(file.type) || allowedExtensions.some(ext => file.name.toLowerCase().endsWith(ext));

            if (!isPdf) {
                alert('Harap unggah file berformat PDF.');
                event.target.value = '';
                resetPreview(previewId);
                return;
            }

            showPreview(file, previewId);
        });
    });

    document.querySelectorAll('[data-reset-preview]').forEach(button => {
        button.addEventListener('click', () => {
            const previewId = button.dataset.resetPreview;
            resetPreview(previewId);
        });
    });
});
</script>
@endpush

