<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>
@extends('layouts.mahasiswa')

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
