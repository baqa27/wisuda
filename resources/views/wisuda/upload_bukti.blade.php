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
        <div class="absolute top-[35px] z-20 flex w-full justify-center px-4">
            <div class="flex h-[82px] w-full max-w-[1262px] flex-row items-center justify-between rounded-[10px] bg-[#0061DF] px-6 text-white shadow-lg overflow-hidden md:justify-center md:gap-[175px]">
                <a href="{{ route('yudisium.index') }}" class="flex flex-row items-center gap-2.5 font-['Inter'] text-[16px] font-light leading-[29px] transition-opacity hover:opacity-80 md:text-[24px]">
                    <i class="fas fa-medal text-xl"></i>
                    <span class="hidden sm:inline">Daftar Yudisium</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-row items-center gap-2.5 font-['Inter'] text-[16px] font-light leading-[29px] transition-opacity hover:opacity-80 md:text-[24px]">
                    <i class="fas fa-home text-xl"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('wisuda.index') }}" class="flex flex-row items-center gap-2.5 font-['Inter'] text-[16px] font-bold leading-[29px] transition-opacity hover:opacity-80 md:text-[24px]">
                    <i class="fas fa-graduation-cap text-xl"></i>
                    <span class="hidden sm:inline">Daftar Wisuda</span>
                </a>
            </div>
        </div>

        {{-- Main content --}}
        <div class="relative z-10 flex w-full max-w-[1262px] flex-col items-center px-4 pb-20 pt-[150px]">
            @if (session('success'))
                <div class="mb-6 w-full max-w-[1110px]">
                    <div class="flex w-full items-start gap-3 rounded-[10px] border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm">
                        <i class="fas fa-check-circle text-xl text-green-500"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 w-full max-w-[1110px]">
                    <div class="flex w-full items-start gap-3 rounded-[10px] border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                        <i class="fas fa-exclamation-circle text-xl text-red-500"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Detail pembayaran --}}
            <div class="mb-8 w-full max-w-[1110px] rounded-[10px] border-[3px] border-black bg-white p-5">
                <div class="mb-5 flex items-center gap-2.5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] text-[32px] font-semibold text-[#0061DF]">Detail Pembayaran</h2>
                </div>
                <div class="flex flex-col gap-2.5">
                    <div class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">Kode: {{ $pendaftaran->kode_invoice }}</span>
                    </div>
                    <div class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex h-[69px] w-full items-center justify-center rounded-[10px] border border-black bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)]">
                        <span class="font-['Inter'] text-[24px] font-semibold text-white">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            {{-- Pilih pembayaran & upload --}}
            <div class="w-full max-w-[1110px] rounded-[10px] border-[3px] border-black bg-white p-5">
                <div class="mb-5 flex items-center gap-2.5 border-b border-black pb-2">
                    <h2 class="font-['Inter'] text-[32px] font-semibold text-[#0061DF]">Pilih Pembayaran & Upload Bukti</h2>
                </div>

                <div class="mb-10 flex flex-wrap items-center justify-center gap-6">
                    <div class="flex h-[108px] w-[108px] items-center justify-center rounded-[15px] border-2 border-black/10 text-center font-bold text-[#008CEB] transition hover:border-[#008CEB]">DANA</div>
                    <div class="flex h-[108px] w-[108px] items-center justify-center rounded-[15px] border-2 border-black/10 text-center font-bold text-black transition hover:border-black">QRIS</div>
                    <div class="flex h-[108px] w-[108px] items-center justify-center rounded-[15px] border-2 border-black/10 text-center font-bold text-[#29458F] transition hover:border-[#29458F]">BRIZZI</div>
                </div>

                @if (in_array($pendaftaran->status, ['menunggu_pembayaran', 'menunggu_verifikasi']))
                    <form action="{{ route('wisuda.proses-pembayaran', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-5">
                        @csrf
                        <div class="w-full max-w-[500px] text-center">
                            <label class="mb-3 block font-['Inter'] text-[20px] font-semibold text-[#0061DF]">Upload Bukti Transfer</label>
                            <div id="upload-area" class="relative flex h-[220px] w-full cursor-pointer flex-col items-center justify-center rounded-[10px] border border-dashed border-black bg-[#D6D4FF] transition">
                                <input type="file" id="bukti_bayar_input" name="bukti_bayar" class="absolute inset-0 h-full w-full cursor-pointer opacity-0" accept="image/*,.pdf" required>
                                <div id="upload-placeholder" class="flex flex-col items-center gap-2 text-[#0061DF]">
                                    <i class="fas fa-cloud-upload-alt text-[50px]"></i>
                                    <span class="text-[14px]">Klik atau seret bukti bayar di sini</span>
                                    <span class="text-[12px] text-[#4c4f8f]">Format JPG/PNG/PDF • Maksimal 2MB</span>
                                </div>
                                <div id="upload-preview" class="hidden w-full text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <img id="preview-image" src="" alt="Preview" class="max-h-32 rounded-[10px] border border-white bg-white object-contain shadow-md">
                                        <div id="preview-file" class="hidden rounded-xl bg-white px-4 py-2 text-sm font-semibold text-[#0061DF]"></div>
                                        <button type="button" id="remove-preview" class="text-sm text-red-600 hover:underline">Ganti file</button>
                                    </div>
                                </div>
                            </div>
                            @error('bukti_bayar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($pendaftaran->bukti_bayar)
                            <div class="w-full max-w-[500px] rounded-[10px] border border-blue-200 bg-blue-50 p-4 text-left">
                                <h4 class="font-semibold text-blue-800">Bukti Bayar Saat Ini</h4>
                                <p class="mt-1 text-sm text-blue-700">Upload ulang untuk mengganti bukti sebelumnya.</p>
                                <a href="{{ route('admin.view.bukti-wisuda', basename($pendaftaran->bukti_bayar)) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 text-blue-600 hover:underline">
                                    <i class="fas fa-eye"></i> Lihat Bukti Bayar
                                </a>
                            </div>
                        @endif

                        <button type="submit" class="mt-4 flex h-[69px] w-full max-w-[1110px] items-center justify-center rounded-[10px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] text-[24px] font-bold text-white hover:shadow-lg">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                @else
                    <div class="flex h-[69px] w-full max-w-[1110px] items-center justify-center rounded-[10px] bg-green-100 text-center font-['Inter'] text-[20px] font-semibold text-green-700">
                        Pembayaran sudah diverifikasi.
                    </div>
                @endif
            </div>

            @if ($pendaftaran->status === 'lunas')
                <div class="mt-8 w-full max-w-[1110px] rounded-[10px] border border-green-200 bg-green-50 p-6">
                    <div class="flex items-start gap-4">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                        <div>
                            <h3 class="text-xl font-semibold text-green-800">Pembayaran Wisuda Terverifikasi</h3>
                            <p class="text-green-700">Silakan lanjutkan mengisi persyaratan wisuda untuk tahap berikutnya.</p>
                            @if ($pendaftaran->bukti_bayar)
                                <a href="{{ route('admin.view.bukti-wisuda', basename($pendaftaran->bukti_bayar)) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 rounded-[10px] bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                    <i class="fas fa-eye"></i> Lihat Bukti Bayar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-6 w-full max-w-[1110px] rounded-[10px] border border-yellow-200 bg-yellow-50 p-6">
                <h3 class="mb-3 text-lg font-semibold text-yellow-800">Informasi Penting</h3>
                <ul class="space-y-2 text-sm text-yellow-700">
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Pastikan nominal transfer sesuai tagihan dan cantumkan kode invoice pada keterangan.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Proses verifikasi membutuhkan waktu 1-2 hari kerja.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Anda dapat mengunggah ulang bukti bayar selama status belum diverifikasi.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-info-circle mt-1"></i>Setelah pembayaran diterima, lanjutkan ke menu persyaratan wisuda.</li>
                </ul>
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
            const previewFile = document.getElementById('preview-file');
            const removeButton = document.getElementById('remove-preview');

            if (!uploadArea || !fileInput) {
                return;
            }

            const resetPreview = () => {
                previewImage.src = '';
                previewImage.classList.remove('hidden');
                previewFile.textContent = '';
                previewFile.classList.add('hidden');
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
                    alert('Format harus JPG/PNG/PDF');
                    resetPreview();
                    return;
                }

                placeholder.classList.add('hidden');
                previewWrapper.classList.remove('hidden');

                if (file.type === 'application/pdf') {
                    previewImage.classList.add('hidden');
                    previewFile.textContent = file.name;
                    previewFile.classList.remove('hidden');
                } else {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        previewImage.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                    previewImage.classList.remove('hidden');
                    previewFile.classList.add('hidden');
                }
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
