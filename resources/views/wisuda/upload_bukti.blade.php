@extends('layouts.mahasiswa_blank')

@section('title', 'Pembayaran Wisuda')

@section('content')
    <div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden bg-white">
        {{-- Background elements --}}
        <div class="pointer-events-none absolute -left-[456px] top-[658px] hidden h-[886px] w-[886px] md:block">
            <div class="absolute left-[339.66px] top-0 h-[886px] w-[206.67px] bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute left-0 top-[289.34px] h-[886px] w-[305.52px] rotate-90 bg-[#0061DF] blur-[72px]"></div>
        </div>
        <div class="pointer-events-none absolute left-[1259px] top-[308px] hidden h-[493px] w-[493px] md:block">
            <div class="absolute left-[189px] top-0 h-[493px] w-[115px] bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute left-0 top-[161px] h-[493px] w-[170px] rotate-90 bg-[#0061DF] blur-[72px]"></div>
        </div>

        {{-- Navigation bar --}}
        <x-mahasiswa-navbar />

        {{-- Main content --}}
        <div class="relative z-10 flex w-full max-w-[1262px] flex-col items-center px-4 pb-20 pt-[150px]">
            @if (session('success'))
                <div class="mb-6 w-full max-w-[1110px]">
                    <div
                        class="flex w-full items-start gap-3 rounded-[10px] border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm">
                        <i class="fas fa-check-circle text-xl text-green-500"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 w-full max-w-[1110px]">
                    <div
                        class="flex w-full items-start gap-3 rounded-[10px] border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                        <i class="fas fa-exclamation-circle text-xl text-red-500"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Detail pembayaran --}}
            <div class="mb-8 w-full max-w-[1110px] rounded-[10px] border-[3px] border-black bg-white p-5">
                <div class="mb-5 flex items-center gap-2.5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] text-[32px] font-semibold text-[#0061DF]">Detail Pembayaran Wisuda</h2>
                </div>
                <div class="flex flex-col gap-2.5">
                    <div
                        class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">Kode:
                            {{ $pendaftaran->kode_invoice }}</span>
                    </div>
                    <div
                        class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">Rp
                            {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div
                        class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            {{-- Pilih Pembayaran & Upload --}}
            <div class="w-full max-w-[1110px] bg-white border-[3px] border-black rounded-[10px] p-8">
                @if($snapToken)
                    {{-- Payment Method Selection --}}
                    <div class="mb-8">
                        <h2 class="font-['Inter'] font-semibold text-[28px] text-[#0061DF] text-center mb-6">Pilih Pembayaran
                        </h2>

                        {{-- Payment Method Cards --}}
                        <div class="flex justify-center gap-6 mb-8">
                            <div class="payment-method-card w-[140px] h-[140px] bg-white border-[3px] border-gray-300 rounded-[15px] flex flex-col items-center justify-center cursor-pointer hover:border-[#0061DF] hover:shadow-lg transition-all"
                                data-method="ewallet">
                                <div class="text-[#008CEB] text-[48px] mb-2">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <span class="font-['Inter'] font-bold text-[18px] text-gray-700">DANA</span>
                            </div>

                            <div class="payment-method-card w-[140px] h-[140px] bg-white border-[3px] border-gray-300 rounded-[15px] flex flex-col items-center justify-center cursor-pointer hover:border-[#0061DF] hover:shadow-lg transition-all"
                                data-method="qris">
                                <div class="text-gray-700 text-[48px] mb-2">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <span class="font-['Inter'] font-bold text-[18px] text-gray-700">QRIS</span>
                            </div>

                            <div class="payment-method-card w-[140px] h-[140px] bg-white border-[3px] border-gray-300 rounded-[15px] flex flex-col items-center justify-center cursor-pointer hover:border-[#0061DF] hover:shadow-lg transition-all"
                                data-method="bank_transfer">
                                <div class="text-[#29458F] text-[48px] mb-2">
                                    <i class="fas fa-university"></i>
                                </div>
                                <span class="font-['Inter'] font-bold text-[18px] text-gray-700">BANK</span>
                            </div>
                        </div>

                        {{-- Konfirmasi Button --}}
                        <button id="pay-button"
                            class="w-full max-w-[600px] mx-auto block h-[60px] bg-gradient-to-r from-[#0A0061] to-[#0061DF] rounded-[10px] flex items-center justify-center hover:shadow-lg transition-all opacity-50 cursor-not-allowed"
                            disabled>
                            <span class="font-['Inter'] font-bold text-[20px] text-white">Konfirmasi</span>
                        </button>
                        <p class="text-center mt-3 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Pilih metode pembayaran terlebih dahulu
                        </p>
                    </div>

                    <div class="text-center my-6">
                        <span class="text-gray-500">── ATAU ──</span>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Pembayaran online sementara tidak tersedia. Silakan upload bukti transfer manual.
                        </p>
                    </div>
                @endif

                {{-- Upload Bukti Transfer Manual --}}
                <form action="{{ route('wisuda.proses-pembayaran', $pendaftaran->id) }}" method="POST"
                    enctype="multipart/form-data" class="flex flex-col items-center gap-5">
                    @csrf

                    <div class="w-full max-w-[500px]">
                        <label class="block font-['Inter'] font-semibold text-[20px] text-[#0061DF] mb-2 text-center">Upload
                            Bukti Transfer Manual</label>
                        <div id="upload-area"
                            class="relative w-full h-[220px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer transition-colors">
                            <input type="file" id="bukti_bayar_input" name="bukti_bayar"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,.pdf">
                            <div id="upload-placeholder" class="flex flex-col items-center gap-2 text-[#0061DF]">
                                <i class="fas fa-cloud-upload-alt text-[50px]"></i>
                                <span class="text-[14px]">Klik atau seret file di sini</span>
                                <span class="text-[12px] text-[#4c4f8f]">Format JPG/PNG/PDF • Maksimal 2MB</span>
                            </div>
                            <div id="upload-preview" class="hidden flex flex-col items-center gap-3">
                                <img id="preview-image" src="" alt="Preview"
                                    class="max-h-32 rounded-[10px] border border-white bg-white object-contain shadow-md">
                                <span id="preview-name" class="text-sm text-[#0061DF] font-semibold"></span>
                                <button type="button" id="remove-preview"
                                    class="text-xs text-red-600 hover:underline flex items-center gap-1">
                                    <i class="fas fa-times"></i> Ganti file
                                </button>
                            </div>
                        </div>
                        @error('bukti_bayar')
                            <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                        @enderror

                    </div>

                    <button type="submit"
                        class="w-full max-w-[1110px] h-[69px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] flex items-center justify-center hover:shadow-lg transition-all mt-4">
                        <span class="font-['Inter'] font-bold text-[24px] text-white">📤 Upload Bukti Pembayaran</span>
                    </button>
                </form>
            </div>

            {{-- Informasi Penting --}}
            <div class="mt-6 w-full max-w-[1110px] rounded-[10px] border border-yellow-200 bg-yellow-50 p-6">
                <h3 class="mb-3 text-lg font-semibold text-yellow-800">Informasi Penting</h3>
                <ul class="space-y-2 text-sm text-yellow-700">
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Pastikan nominal transfer
                        sesuai tagihan dan cantumkan kode invoice pada keterangan.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Proses verifikasi membutuhkan
                        waktu 1-2 hari kerja.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Anda dapat mengunggah ulang
                        bukti bayar selama status belum diverifikasi.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Setelah pembayaran diterima,
                        lanjutkan ke menu persyaratan wisuda.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($snapToken)
        {{-- Snap.js --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let selectedMethod = null;
                const payButton = document.getElementById('pay-button');
                const methodCards = document.querySelectorAll('.payment-method-card');

                console.log('Midtrans Payment Script Loaded (Wisuda)');
                console.log('Found payment method cards:', methodCards.length);

                // Handle payment method selection
                methodCards.forEach(card => {
                    card.addEventListener('click', function () {
                        console.log('Card clicked:', this.dataset.method);

                        // Remove selected class from all cards
                        methodCards.forEach(c => {
                            c.classList.remove('border-[#0061DF]', 'bg-blue-50', 'shadow-lg');
                            c.classList.add('border-gray-300');
                        });

                        // Add selected class to clicked card
                        this.classList.remove('border-gray-300');
                        this.classList.add('border-[#0061DF]', 'bg-blue-50', 'shadow-lg');

                        // Store selected method
                        selectedMethod = this.dataset.method;
                        console.log('Selected method:', selectedMethod);

                        // Enable pay button
                        if (payButton) {
                            payButton.disabled = false;
                            payButton.classList.remove('opacity-50', 'cursor-not-allowed');
                            payButton.classList.add('cursor-pointer');

                            // Update button text
                            const methodNames = {
                                'ewallet': 'E-Wallet (DANA, OVO, GoPay)',
                                'qris': 'QRIS',
                                'bank_transfer': 'Transfer Bank'
                            };

                            const spanElement = payButton.querySelector('span');
                            if (spanElement) {
                                spanElement.textContent = 'Bayar Sekarang';
                            }

                            // Update info text
                            const infoText = payButton.nextElementSibling;
                            if (infoText) {
                                infoText.innerHTML = '<i class="fas fa-check-circle mr-1 text-green-500"></i>Metode dipilih: ' + methodNames[selectedMethod];
                                infoText.classList.remove('text-gray-500');
                                infoText.classList.add('text-green-600');
                            }
                        }
                    });
                });

                // Handle payment button click
                if (payButton) {
                    payButton.addEventListener('click', function () {
                        console.log('Pay button clicked, method:', selectedMethod);

                        if (!selectedMethod) {
                            alert('Silakan pilih metode pembayaran terlebih dahulu');
                            return;
                        }

                        // Open Midtrans popup
                        snap.pay('{{ $snapToken }}', {
                            onSuccess: function (result) {
                                console.log('Payment success:', result);
                                window.location.href = "{{ route('wisuda.success', $pendaftaran->id) }}";
                            },
                            onPending: function (result) {
                                console.log('Payment pending:', result);
                                alert("Pembayaran dalam proses. Silakan selesaikan pembayaran Anda.");
                                window.location.reload();
                            },
                            onError: function (result) {
                                console.log('Payment error:', result);
                                alert("Terjadi kesalahan saat pembayaran. Silakan coba lagi.");
                            },
                            onClose: function () {
                                console.log('Customer closed the popup without finishing the payment');
                            }
                        });
                    });
                }
            });
        </script>
    @endif

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

                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format harus JPG, PNG, atau PDF');
                    resetPreview();
                    return;
                }

                if (file.type === 'application/pdf') {
                    previewImage.classList.add('hidden');
                    previewName.textContent = '📄 ' + file.name;
                } else {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        previewImage.src = event.target.result;
                        previewImage.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                    previewName.textContent = file.name;
                }

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