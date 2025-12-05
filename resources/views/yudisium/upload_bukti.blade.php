@extends('layouts.mahasiswa_blank')

@section('title', 'Pembayaran Yudisium')

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
            @if (session('success'))
                <div class="w-full max-w-[1110px] mb-6">
                    <div class="w-full rounded-[10px] border border-green-200 bg-green-50 px-5 py-4 flex items-start gap-3 shadow-sm">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="w-full max-w-[1110px] mb-6">
                    <div class="w-full rounded-[10px] border border-red-200 bg-red-50 px-5 py-4 flex items-start gap-3 shadow-sm">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Detail Pembayaran --}}
            <div class="w-full max-w-[1110px] bg-white border-[3px] border-black rounded-[10px] p-5 mb-8">
                <div class="flex items-center gap-2.5 mb-5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] font-semibold text-[32px] text-[#0061DF]">Detail Pembayaran</h2>
                </div>

                <div class="flex flex-col gap-2.5">
                    <div class="w-full h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] border border-black flex items-center justify-center">
                        <span class="font-['Inter'] font-semibold text-[24px] text-white">Kode: {{ $pendaftaran->kode_invoice }}</span>
                    </div>
                    <div class="w-full h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] border border-black flex items-center justify-center">
                        <span class="font-['Inter'] font-semibold text-[24px] text-white">Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] border border-black flex items-center justify-center">
                        <span class="font-['Inter'] font-semibold text-[24px] text-white">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            {{-- Pilih Pembayaran & Upload --}}
            <div class="w-full max-w-[1110px] bg-white border-[3px] border-black rounded-[10px] p-5">
                <div class="flex items-center gap-2.5 mb-5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] font-semibold text-[32px] text-[#0061DF]">Pilih Pembayaran & Upload Bukti</h2>
                </div>

                <div class="flex flex-row gap-10 mb-8 justify-center">
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-lg flex items-center justify-center cursor-pointer hover:border-[#008CEB] transition-colors">
                        <span class="font-bold text-[#008CEB]">DANA</span>
                    </div>
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-lg flex items-center justify-center cursor-pointer hover:border-black transition-colors">
                        <span class="font-bold text-black">QRIS</span>
                    </div>
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-lg flex items-center justify-center cursor-pointer hover:border-[#29458F] transition-colors">
                        <span class="font-bold text-[#29458F]">BRIZZI</span>
                    </div>
                </div>

                <form action="{{ route('yudisium.proses-upload-bukti', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-5">
                    @csrf
                    @method('PUT')

                    <div class="w-full max-w-[500px]">
                        <label class="block font-['Inter'] font-semibold text-[20px] text-[#0061DF] mb-2 text-center">Upload Bukti Transfer</label>
                        <div id="upload-area" class="relative w-full h-[220px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer transition-colors">
                            <input type="file" id="bukti_bayar_input" name="bukti_bayar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept="image/*">

                            <div id="upload-placeholder" class="flex flex-col items-center text-center gap-2">
                                <i class="fas fa-cloud-upload-alt text-[50px] text-[#0061DF]"></i>
                                <span class="font-['Inter'] text-[14px] text-[#0061DF]">Klik atau seret foto bukti bayar di sini</span>
                                <span class="text-[12px] text-[#4c4f8f]">Format JPG/PNG • Maksimal 2MB</span>
                            </div>

                            <div id="upload-preview" class="hidden w-full text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <img id="preview-image" src="" alt="Preview Bukti Bayar" class="max-h-32 rounded-[10px] border border-white shadow-md object-contain bg-white">
                                    <p id="preview-name" class="text-sm font-semibold text-[#0061DF] break-all"></p>
                                    <button type="button" id="remove-preview" class="text-sm text-red-600 hover:underline">Ganti foto</button>
                                </div>
                            </div>
                        </div>
                        @error('bukti_bayar')
                            <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                        @enderror

                    </div>

                    <button type="submit" class="w-full max-w-[1110px] h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] flex items-center justify-center hover:shadow-lg transition-all mt-4">
                        <span class="font-['Inter'] font-bold text-[24px] text-white">Konfirmasi Pembayaran</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('bukti_bayar_input');
    const placeholder = document.getElementById('upload-placeholder');
    const previewWrapper = document.getElementById('upload-preview');
    const previewImage = document.getElementById('preview-image');
    const previewName = document.getElementById('preview-name');
    const removeButton = document.getElementById('remove-preview');

    if (!uploadArea || !fileInput || !placeholder || !previewWrapper) {
        return;
    }

    const resetPreview = () => {
        previewImage.src = '';
        previewName.textContent = '';
        previewWrapper.classList.add('hidden');
        placeholder.classList.remove('hidden');
        uploadArea.classList.remove('bg-[#c4c1ff]', 'border-[#004bb0]');
        fileInput.value = '';
    };

    const showPreview = (file) => {
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            resetPreview();
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format harus JPG atau PNG');
            resetPreview();
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            previewImage.src = event.target.result;
        };
        reader.readAsDataURL(file);

        previewName.textContent = file.name;
        placeholder.classList.add('hidden');
        previewWrapper.classList.remove('hidden');
    };

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            showPreview(file);
        } else {
            resetPreview();
        }
    });

    if (removeButton) {
        removeButton.addEventListener('click', (event) => {
            event.preventDefault();
            resetPreview();
        });
    }

    ['dragenter', 'dragover'].forEach((evtName) => {
        uploadArea.addEventListener(evtName, (event) => {
            event.preventDefault();
            uploadArea.classList.add('bg-[#c4c1ff]', 'border-[#004bb0]');
        });
    });

    ['dragleave', 'drop'].forEach((evtName) => {
        uploadArea.addEventListener(evtName, (event) => {
            event.preventDefault();
            if (evtName === 'drop') {
                const file = event.dataTransfer.files[0];
                if (file) {
                    fileInput.files = event.dataTransfer.files;
                    showPreview(file);
                }
            }
            uploadArea.classList.remove('bg-[#c4c1ff]', 'border-[#004bb0]');
        });
    });
});
</script>
@endpush
