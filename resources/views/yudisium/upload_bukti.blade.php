<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>
@extends('layouts.mahasiswa_blank')

@section('title', 'Pembayaran Yudisium')

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
            
            {{-- Detail Pembayaran --}}
            <div class="w-full max-w-[1110px] bg-white border-[3px] border-black rounded-[10px] p-5 mb-8">
                <div class="flex items-center gap-2.5 mb-5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] font-semibold text-[32px] text-[#0061DF]">Detail Pembayaran</h2>
                </div>
                
                <div class="flex flex-col gap-2.5">
                    <div class="w-full h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] border border-black flex items-center justify-center">
                        <span class="font-['Inter'] font-semibold text-[24px] text-white">Pembayaran Yudisium</span>
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
                    {{-- DANA --}}
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-[8px] flex items-center justify-center cursor-pointer hover:border-[#008CEB] transition-colors">
                        <span class="font-bold text-[#008CEB]">DANA</span>
                    </div>
                    {{-- QRIS --}}
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-[8px] flex items-center justify-center cursor-pointer hover:border-black transition-colors">
                        <span class="font-bold text-black">QRIS</span>
                    </div>
                    {{-- BRIZZI --}}
                    <div class="w-[108px] h-[108px] border-2 border-black/10 rounded-[8px] flex items-center justify-center cursor-pointer hover:border-[#29458F] transition-colors">
                        <span class="font-bold text-[#29458F]">BRIZZI</span>
                    </div>
                </div>

                <form action="{{ route('yudisium.proses-upload-bukti', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-5">
                    @csrf
                    @method('PUT')

                    <div class="w-full max-w-[500px]">
                        <label class="block font-['Inter'] font-semibold text-[20px] text-[#0061DF] mb-2 text-center">Upload Bukti Transfer</label>
                        <div class="relative w-full h-[200px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group">
                            <input type="file" name="bukti_bayar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept="image/*">
                            <i class="fas fa-cloud-upload-alt text-[50px] text-[#0061DF] mb-2"></i>
                            <span class="font-['Inter'] text-[14px] text-[#0061DF]">Klik atau seret foto bukti bayar di sini</span>
                        </div>
                        @error('bukti_bayar')
                            <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
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

@section('title', 'Upload Bukti Pembayaran Yudisium')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('yudisium.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Yudisium
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Upload Bukti Pembayaran</h1>
        <p class="text-gray-600">Upload foto bukti transfer biaya yudisium</p>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Detail Pembayaran</h2>
                <p class="text-sm text-gray-600">Kode: {{ $pendaftaran->kode_invoice }}</p>
            </div>
            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                Menunggu Pembayaran
            </span>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 mb-2">Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</div>
                <p class="text-sm text-blue-700">Transfer ke rekening universitas</p>
            </div>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Bukti Transfer</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <div class="text-green-800">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                    <div class="text-red-800">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        <!-- Info Upload Ulang -->
        @if($pendaftaran->bukti_bayar)
        <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                <div>
                    <p class="text-yellow-800 font-medium">Anda sudah mengupload bukti bayar sebelumnya</p>
                    <p class="text-yellow-700 text-sm mt-1">Upload ulang akan mengganti file sebelumnya</p>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('yudisium.proses-upload-bukti', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Upload Area -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Bukti Transfer <span class="text-red-500">*</span>
                </label>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition duration-200 cursor-pointer"
                     id="upload-area">
                    <input type="file" name="bukti_bayar" id="bukti_bayar"
                           class="hidden" accept=".jpg,.jpeg,.png" required>

                    <div id="upload-placeholder">
                        <i class="fas fa-camera text-gray-400 text-4xl mb-3"></i>
                        <p class="text-lg font-medium text-gray-600">Klik untuk upload foto</p>
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                    </div>

                    <div id="file-preview" class="hidden">
                        <i class="fas fa-image text-green-500 text-4xl mb-3"></i>
                        <img id="preview-image" src="" class="mx-auto mb-3 max-h-32 rounded-lg shadow-sm">
                        <p class="text-sm font-medium text-gray-900" id="file-name"></p>
                        <button type="button" id="remove-file" class="text-red-600 text-sm hover:text-red-800 mt-2">
                            Ganti foto
                        </button>
                    </div>
                </div>

                @error('bukti_bayar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition duration-200 font-medium">
                    <i class="fas fa-upload mr-2"></i>
                    {{ $pendaftaran->bukti_bayar ? 'Upload Ulang Bukti Bayar' : 'Upload Bukti Bayar' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Bank -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mt-6">
        <h3 class="font-semibold text-gray-800 mb-3">Rekening Tujuan Transfer</h3>

        <div class="space-y-3">
            <div class="flex justify-between items-center p-3 bg-white rounded border">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-red-600 font-bold text-xs">BNI</span>
                    </div>
                    <span class="font-medium">Bank BNI</span>
                </div>
                <span class="font-mono text-gray-700">1234-5678-9012-3456</span>
            </div>

            <div class="flex justify-between items-center p-3 bg-white rounded border">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-blue-600 font-bold text-xs">BRI</span>
                    </div>
                    <span class="font-medium">Bank BRI</span>
                </div>
                <span class="font-mono text-gray-700">9876-5432-1098-7654</span>
            </div>

            <div class="flex justify-between items-center p-3 bg-white rounded border">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-green-600 font-bold text-xs">MDR</span>
                    </div>
                    <span class="font-medium">Bank Mandiri</span>
                </div>
                <span class="font-mono text-gray-700">5678-1234-9012-3456</span>
            </div>
        </div>

        <div class="mt-4 p-3 bg-yellow-50 rounded border border-yellow-200">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                <div class="text-sm text-yellow-700">
                    <strong>Transfer tepat:</strong> Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}<br>
                    <strong>Sertakan kode:</strong> {{ $pendaftaran->kode_invoice }} di keterangan transfer<br>
                    <strong>Upload bukti:</strong> Dapat diupload ulang jika ada kesalahan
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('bukti_bayar');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const filePreview = document.getElementById('file-preview');
    const previewImage = document.getElementById('preview-image');
    const fileName = document.getElementById('file-name');
    const removeFile = document.getElementById('remove-file');

    // Klik area upload
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    // File dipilih
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Cek ukuran file
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                this.value = '';
                return;
            }

            // Cek tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Hanya format JPG dan PNG yang diperbolehkan!');
                this.value = '';
                return;
            }

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);

            // Tampilkan preview
            fileName.textContent = file.name;
            uploadPlaceholder.classList.add('hidden');
            filePreview.classList.remove('hidden');
        }
    });

    // Ganti foto
    removeFile.addEventListener('click', function(e) {
        e.stopPropagation();
        fileInput.value = '';
        uploadPlaceholder.classList.remove('hidden');
        filePreview.classList.add('hidden');
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-400', 'bg-blue-50');

        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>

<style>
#upload-area {
    transition: all 0.3s ease;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#upload-area:hover {
    border-color: #3b82f6;
    background-color: #f8fafc;
}
</style>
@endsection
