@extends('layouts.mahasiswa_blank')

@section('title', 'Persyaratan Wisuda')

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
                <h1 class="font-['Inter'] font-bold text-[24px] md:text-[32px] text-[#0061DF] mb-8 text-center">PERSYARATAN WISUDA</h1>

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

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('wisuda.persyaratan.simpan') }}" method="POST" enctype="multipart/form-data" class="w-full">
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

                        {{-- Data dari Yudisium (Read Only) --}}
                        @if($yudisium)
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Judul Tugas Akhir</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ $yudisium->judul_ta }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">Dosen Pembimbing</label>
                                <div class="w-full p-4 border border-[#0061DF] rounded-[10px] bg-gray-50">
                                    <span class="font-['Inter'] text-[16px] text-[#0061DF]">{{ $yudisium->dosen_pembimbing }}</span>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- Right Column: Uploads --}}
                    <div class="flex-1 flex flex-col gap-8">
                        
                        @php
                            // Mapping jenis persyaratan wisuda ke field yudisium
                            $yudisiumMapping = [
                                'toefl' => 'sertifikasi_toefl',
                                'tahfidz' => 'sertifikasi_tahfidz',
                                'bebas_perpus' => 'surat_bebas_perpustakaan'
                            ];
                        @endphp

                        @foreach($jenisPersyaratan as $key => $label)
                            @php
                                $existing = $persyaratan->where('jenis', $key)->first();
                                $isFromYudisium = false;
                                
                                // Cek apakah sudah ada di yudisium (Only if not explicitly uploaded/revised by user recently?)
                                // Priority: User manual upload > Yudisium auto-fill
                                // But if user hasn't uploaded anything, and Yudisium has it, we consider it fulfilled.
                                if (isset($yudisiumMapping[$key]) && $yudisium && $yudisium->{$yudisiumMapping[$key]}) {
                                    $isFromYudisium = true;
                                }
                            @endphp

                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">
                                    {{ $label }}
                                    @if($isFromYudisium)
                                        <span class="ml-2 text-sm text-green-600 font-normal bg-green-100 px-2 py-0.5 rounded-full border border-green-200">
                                            <i class="fas fa-check-circle mr-1"></i>Sudah dari Yudisium
                                        </span>
                                    @endif
                                </label>

                                @if($isFromYudisium)
                                    {{-- Tampilan jika sudah ada dari Yudisium --}}
                                    <div class="w-full p-4 bg-[#E8F5E9] border border-green-200 rounded-[10px] flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-green-800">Status: Terpenuhi</p>
                                            <p class="text-xs text-green-600">Dokumen diambil otomatis dari data Yudisium</p>
                                        </div>
                                        <a href="{{ route('yudisium.download', basename($yudisium->{$yudisiumMapping[$key]})) }}" target="_blank" class="ml-auto text-[#0061DF] hover:underline text-sm font-semibold">Lihat File</a>
                                        <input type="hidden" name="existing_{{ $key }}" value="1">
                                    </div>

                                @else
                                    {{-- Form Upload (Handles New, Menunggu, Revisi, Terverifikasi) --}}
                                    
                                    @php
                                        // Default Styling to match Yudisium Edit Form
                                        $statusColor = 'bg-[#D6D4FF] border-black'; 
                                        $icon = 'fas fa-folder-plus';
                                        $iconColor = 'text-[#0061DF]';
                                        $statusText = 'Upload ulang untuk mengganti';
                                        $subText = 'PDF maks 2MB';
                                        
                                        // We can still subtly indicate status if desired, but user requested uniformity.
                                        // However, if it's 'terverifikasi', we usually show a checkmark or just the file.
                                        // But Yudisium edit form allows re-uploading even verified files? 
                                        // Usually 'terverifikasi' shouldn't be changed easily, but let's stick to the requested visual.
                                        // For now, I will keep the "Terverifikasi" distinct to avoid confusion, 
                                        // but unify Revisi/Menunggu/New into the "Upload" style.
                                        
                                        if ($existing && $existing->status == 'terverifikasi') {
                                            $statusColor = 'bg-[#E8F5E9] border-green-500';
                                            $icon = 'fas fa-check-circle';
                                            $iconColor = 'text-green-500';
                                            $statusText = 'Terverifikasi';
                                            $subText = 'Dokumen valid';
                                        }
                                    @endphp

                                    <div class="relative w-full h-40 {{ $statusColor }} border border-dashed rounded-[10px] p-4 overflow-hidden group">
                                        {{-- Placeholder / Info --}}
                                        <div class="w-full h-full flex flex-col items-center justify-center text-center gap-1 pointer-events-none" id="placeholder-{{ $key }}">
                                            <i class="{{ $icon }} text-[40px] {{ $iconColor }}"></i>
                                            <span class="font-['Inter'] text-[12px] {{ $existing && $existing->status == 'terverifikasi' ? 'text-green-700 font-bold' : 'text-[#0061DF]' }}">
                                                {{ $statusText }}
                                            </span>
                                            <small class="text-[11px] {{ $existing && $existing->status == 'terverifikasi' ? 'text-green-600' : 'text-[#4B4F8F]' }}">
                                                {{ $subText }}
                                            </small>
                                        </div>

                                        {{-- Preview Wrapper --}}
                                        <div class="absolute inset-0 hidden px-4 py-4 z-20" id="preview-wrapper-{{ $key }}">
                                            <div class="w-full h-full bg-[#D6D4FF] flex flex-col items-center justify-center gap-4 text-center">
                                                <div class="w-full bg-white rounded-lg border border-[#0061DF]/30 shadow-sm p-4 flex items-center gap-3 text-left">
                                                    <i class="fas fa-file-pdf text-2xl text-[#BA1B1D]" id="preview-icon-{{ $key }}"></i>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-semibold text-[#0061DF] truncate" id="preview-name-{{ $key }}"></p>
                                                        <p class="text-xs text-gray-500" id="preview-info-{{ $key }}"></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="text-sm text-red-600 hover:underline" data-reset-preview="{{ $key }}">Batal pilih file</button>
                                            </div>
                                        </div>

                                        {{-- File Input --}}
                                        @if(!$existing || $existing->status != 'terverifikasi')
                                            <input type="file" id="input-{{ $key }}" data-preview-id="{{ $key }}" name="{{ $key }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer previewable-file z-10" accept=".pdf">
                                        @endif
                                    </div>
                                    
                                    {{-- Admin Note if Revisi --}}
                                    @if($existing && $existing->status == 'revisi' && $existing->catatan_admin)
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded border border-red-200 flex items-start gap-2">
                                            <i class="fas fa-exclamation-circle mt-0.5"></i>
                                            <div>
                                                <strong>Perlu Revisi:</strong> {{ $existing->catatan_admin }}
                                            </div>
                                        </div>
                                    @endif

                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-12 flex justify-center gap-4">
                    {{-- Tombol Kembali dihapus sesuai permintaan --}}
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
