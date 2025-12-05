@extends('layouts.mahasiswa_blank')

@section('title', 'Pendaftaran Yudisium')

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
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">8</span>
                                </div>
                            </div>

                            {{-- Judul TA --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Judul Tugas Akhir</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="judul_ta" value="{{ old('judul_ta') }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Judul TA" required>
                                </div>
                            </div>

                            {{-- Dosen Pembimbing --}}
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Dosen Pembimbing</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-white">
                                    <input type="text" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" class="w-full outline-none font-['Inter'] text-[16px] text-[#0061DF]" placeholder="Masukkan Nama Dosen Pembimbing" required>
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Uploads --}}
                        <div class="flex-1 flex flex-col gap-8">

                            @php
                                $uploadFields = [
                                    ['label' => 'File KTP', 'name' => 'file_ktp', 'id' => 'file_ktp', 'required' => true],
                                    ['label' => 'Sertifikasi Tahfidz', 'name' => 'sertifikasi_tahfidz', 'id' => 'sertifikasi_tahfidz', 'required' => false],
                                    ['label' => 'Sertifikasi TOEFL', 'name' => 'sertifikasi_toefl', 'id' => 'sertifikasi_toefl', 'required' => false],
                                    ['label' => 'Surat Bebas Perpustakaan', 'name' => 'surat_bebas_perpustakaan', 'id' => 'surat_bebas_perpustakaan', 'required' => false],
                                    ['label' => 'File Ijazah (Opsional)', 'name' => 'file_ijazah', 'id' => 'file_ijazah', 'required' => false],
                                ];
                            @endphp

                            @foreach($uploadFields as $field)
                                <div class="flex flex-col gap-2">
                                    <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">{{ $field['label'] }}</label>
                                    <div class="relative w-full h-40 bg-[#D6D4FF] border border-dashed border-black rounded-[10px] overflow-hidden">
                                        <input id="input-{{ $field['id'] }}" type="file" name="{{ $field['name'] }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input" data-preview="{{ $field['id'] }}" accept=".pdf,application/pdf" @if($field['required']) required @endif>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-[#0061DF] pointer-events-none" id="placeholder-{{ $field['id'] }}">
                                            <i class="fas fa-folder-plus text-[40px] mb-2"></i>
                                            <span class="font-['Inter'] text-[12px]">Klik atau seret file PDF (maks 2MB)</span>
                                        </div>
                                        <div class="absolute inset-0 hidden px-4 py-4" id="preview-{{ $field['id'] }}">
                                            <div class="flex flex-col items-center justify-center text-center h-full">
                                                <div class="flex items-center gap-4 p-4 bg-white/80 rounded-lg shadow w-full">
                                                    <div class="w-12 h-12 flex items-center justify-center bg-[#FFE7E7] rounded-lg">
                                                        <i class="fas fa-file-pdf text-[#D32F2F] text-2xl"></i>
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="selected-file-name font-semibold text-[#0A0A2A] text-sm truncate"></p>
                                                        <p class="text-xs text-gray-600">PDF siap diunggah</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="mt-4 text-sm text-red-600 hover:underline reset-upload" data-input="input-{{ $field['id'] }}">Batalkan pilihan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

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
document.addEventListener('DOMContentLoaded', () => {
    const allowedMimes = ['application/pdf'];

    document.querySelectorAll('.dragdrop-input').forEach((input) => {
        const previewId = input.dataset.preview;
        const placeholder = document.getElementById(`placeholder-${previewId}`);
        const previewPanel = document.getElementById(`preview-${previewId}`);
        const nameSlot = previewPanel ? previewPanel.querySelector('.selected-file-name') : null;
        const resetBtn = previewPanel ? previewPanel.querySelector('.reset-upload') : null;

        const resetView = () => {
            placeholder?.classList.remove('hidden');
            previewPanel?.classList.add('hidden');
            if (nameSlot) {
                nameSlot.textContent = '';
            }
        };

        input.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) {
                resetView();
                return;
            }

            const isPdf = allowedMimes.includes(file.type) || file.name.toLowerCase().endsWith('.pdf');

            if (!isPdf) {
                alert('Harap pilih file berformat PDF.');
                event.target.value = '';
                resetView();
                return;
            }

            placeholder?.classList.add('hidden');
            previewPanel?.classList.remove('hidden');
            if (nameSlot) {
                nameSlot.textContent = file.name;
            }
        });

        resetBtn?.addEventListener('click', () => {
            input.value = '';
            resetView();
        });
    });
});
</script>
@endpush
