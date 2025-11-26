@extends('layouts.mahasiswa')

@section('title', 'Pembayaran Wisuda')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('wisuda.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Wisuda
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Pembayaran Wisuda</h1>
            <p class="text-gray-600">Upload bukti pembayaran untuk proses wisuda</p>
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

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <!-- Informasi Pendaftaran -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pendaftaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium text-gray-700">Kode Invoice:</span>
                        <p class="text-gray-900">{{ $pendaftaran->kode_invoice }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Total Pembayaran:</span>
                        <p class="text-gray-900 font-semibold">Rp
                            {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $pendaftaran->status == 'menunggu_pembayaran'
                            ? 'bg-yellow-100 text-yellow-800'
                            : ($pendaftaran->status == 'menunggu_verifikasi'
                                ? 'bg-blue-100 text-blue-800'
                                : 'bg-green-100 text-green-800') }}">
                            {{ $pendaftaran->status == 'menunggu_pembayaran'
                                ? 'Menunggu Pembayaran'
                                : ($pendaftaran->status == 'menunggu_verifikasi'
                                    ? 'Menunggu Verifikasi'
                                    : 'Lunas') }}
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Tanggal Pendaftaran:</span>
                        <p class="text-gray-900">{{ $pendaftaran->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Upload Bukti Bayar -->
            @if ($pendaftaran->status == 'menunggu_pembayaran' || $pendaftaran->status == 'menunggu_verifikasi')
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Bukti Pembayaran</h3>

                    <form action="{{ route('wisuda.proses-pembayaran', $pendaftaran->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf


                        <div class="mb-4">
                            <label for="bukti_bayar" class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Transfer <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="bukti_bayar" id="bukti_bayar"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                accept=".pdf" required>
                            <p class="mt-1 text-xs text-gray-500">Format: PDF (Maks. 2MB)</p>
                            <div id="selected-file-preview" class="mt-3 p-3 border border-blue-200 rounded-lg bg-blue-50 text-sm text-blue-800 flex items-center gap-2" style="display:none;">
                                <i class="fas fa-file-pdf text-lg"></i>
                                <div>
                                    <p class="font-semibold">File siap diupload</p>
                                    <p id="selected-file-name" class="font-mono text-xs"></p>
                                </div>
                            </div>
                            @error('bukti_bayar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview existing bukti bayar -->
                        <!-- Di bagian preview bukti bayar, ganti menjadi: -->
                        @if ($pendaftaran->bukti_bayar)
                            <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-blue-800 mb-2">Bukti Bayar Saat Ini:</h4>
                                <a href="{{ route('admin.view.bukti-wisuda', basename($pendaftaran->bukti_bayar)) }}"
                                    target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye mr-2"></i> Lihat Bukti Bayar
                                </a>
                                <p class="text-sm text-blue-700 mt-1">Upload ulang jika ingin mengganti bukti bayar.</p>
                            </div>
                        @endif

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('wisuda.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-upload mr-2"></i>
                                {{ $pendaftaran->bukti_bayar ? 'Upload Ulang Bukti Bayar' : 'Upload Bukti Bayar' }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Informasi Pembayaran -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h3>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-blue-800 mb-3">Transfer ke Rekening Berikut:</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
                        @php
                            $banks = [
                                [
                                    'kode' => 'BNI',
                                    'warna' => 'red',
                                    'rekening' => '1234-5678-9012-3456',
                                    'nama' => 'Bank BNI',
                                ],
                                [
                                    'kode' => 'BRI',
                                    'warna' => 'blue',
                                    'rekening' => '9876-5432-1098-7654',
                                    'nama' => 'Bank BRI',
                                ],
                                [
                                    'kode' => 'MDR',
                                    'warna' => 'green',
                                    'rekening' => '5678-1234-9012-3456',
                                    'nama' => 'Bank Mandiri',
                                ],
                                [
                                    'kode' => 'BCA',
                                    'warna' => 'blue',
                                    'rekening' => '2468-1357-8024-6813',
                                    'nama' => 'Bank BCA',
                                ],
                                [
                                    'kode' => 'CIMB',
                                    'warna' => 'orange',
                                    'rekening' => '8642-1753-9086-4217',
                                    'nama' => 'Bank CIMB Niaga',
                                ],
                                [
                                    'kode' => 'PMT',
                                    'warna' => 'purple',
                                    'rekening' => '7531-8642-9753-1864',
                                    'nama' => 'Bank Permata',
                                ],
                            ];
                        @endphp

                        @foreach ($banks as $bank)
                            <div class="bank-option cursor-pointer p-3 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition duration-200"
                                data-bank="{{ $bank['nama'] }}" data-rekening="{{ $bank['rekening'] }}">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-{{ $bank['warna'] }}-100 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-{{ $bank['warna'] }}-600 font-bold text-xs">{{ $bank['kode'] }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $bank['nama'] }}</div>
                                        <div class="text-sm text-gray-600">{{ $bank['rekening'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Informasi Bank yang Dipilih -->
                    <div id="selected-bank-info" class="hidden p-3 bg-white rounded-lg border border-green-200">
                        <h5 class="font-medium text-green-800 mb-2">Informasi Transfer:</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Bank Tujuan:</span>
                                <span id="selected-bank-name" class="text-gray-600 ml-2"></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Nomor Rekening:</span>
                                <span id="selected-rekening" class="text-gray-600 ml-2 font-mono"></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Atas Nama:</span>
                                <span class="text-gray-600 ml-2">UNIVERSITAS CONTOH</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Jumlah Transfer:</span>
                                <span class="text-gray-600 ml-2 font-semibold">
                                    Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-green-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Harap transfer sesuai nominal dan sertakan kode invoice
                            <strong>{{ $pendaftaran->kode_invoice }}</strong> dalam keterangan transfer.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pembayaran -->
        @if ($pendaftaran->status == 'lunas')
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold text-green-800">Pembayaran Telah Diverifikasi!</h3>
                        <p class="text-green-700">Pembayaran wisuda Anda telah diverifikasi. Silakan lanjutkan ke tahap
                            berikutnya.</p>

                        @if ($pendaftaran->bukti_bayar)
                            <div class="mt-3">
                                <a href="{{ Storage::url('bukti_bayar/wisuda/' . $pendaftaran->bukti_bayar) }}"
                                    target="_blank"
                                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
                                    <i class="fas fa-eye mr-2"></i> Lihat Bukti Bayar
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Informasi Penting -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="font-semibold text-yellow-800 mb-3">Informasi Penting</h3>
            <ul class="text-sm text-yellow-700 space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-info-circle mt-1 mr-2"></i>
                    Pastikan bukti transfer jelas terbaca dan sesuai nominal
                </li>
                <li class="flex items-start">
                    <i class="fas fa-info-circle mt-1 mr-2"></i>
                    Proses verifikasi membutuhkan waktu 1-2 hari kerja
                </li>
                <li class="flex items-start">
                    <i class="fas fa-info-circle mt-1 mr-2"></i>
                    Anda dapat mengupload ulang bukti bayar selama status masih menunggu verifikasi
                </li>
                <li class="flex items-start">
                    <i class="fas fa-info-circle mt-1 mr-2"></i>
                    Setelah pembayaran diverifikasi, Anda dapat mengisi persyaratan wisuda
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi pilihan bank
            const bankOptions = document.querySelectorAll('.bank-option');
            const selectedBankInfo = document.getElementById('selected-bank-info');
            const selectedBankName = document.getElementById('selected-bank-name');
            const selectedRekening = document.getElementById('selected-rekening');

            bankOptions.forEach(option => {
                option.addEventListener('click', () => {
                    bankOptions.forEach(opt => {
                        opt.classList.remove('border-blue-500', 'bg-blue-50');
                        opt.classList.add('border-gray-200');
                    });

                    option.classList.remove('border-gray-200');
                    option.classList.add('border-blue-500', 'bg-blue-50');

                    const bankName = option.getAttribute('data-bank');
                    const rekening = option.getAttribute('data-rekening');
                    selectedBankName.textContent = bankName;
                    selectedRekening.textContent = rekening;
                    selectedBankInfo.classList.remove('hidden');

                    // Simpan pilihan ke localStorage
                    localStorage.setItem('selectedBankWisuda', bankName);
                    localStorage.setItem('selectedRekeningWisuda', rekening);
                });
            });

            // Load pilihan bank sebelumnya jika ada
            const savedBank = localStorage.getItem('selectedBankWisuda');
            const savedRekening = localStorage.getItem('selectedRekeningWisuda');
            if (savedBank && savedRekening) {
                bankOptions.forEach(option => {
                    if (option.getAttribute('data-bank') === savedBank) {
                        option.click();
                    }
                });
            }

            // Preview file sebelum upload
            const fileInput = document.getElementById('bukti_bayar');
            const filePreview = document.getElementById('selected-file-preview');
            const fileNameTarget = document.getElementById('selected-file-name');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validasi ukuran file (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran file maksimal 2MB');
                            e.target.value = '';
                            return;
                        }

                        // Validasi tipe file
                        const allowedTypes = ['application/pdf'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Hanya file PDF yang diizinkan');
                            e.target.value = '';
                            if (filePreview) {
                                filePreview.style.display = 'none';
                            }
                            return;
                        }

                        if (filePreview && fileNameTarget) {
                            fileNameTarget.textContent = file.name;
                            filePreview.style.display = 'flex';
                        }
                    } else if (filePreview) {
                        filePreview.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
`
