@extends('layouts.mahasiswa_blank')

@section('title', 'Persyaratan Wisuda')

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
                <h1 class="font-['Inter'] font-bold text-[24px] md:text-[32px] text-[#0061DF] mb-8 text-center">HALAMAN PERSYARATAN WISUDA</h1>

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
                                
                                // Cek apakah sudah ada di yudisium
                                if (isset($yudisiumMapping[$key]) && $yudisium && $yudisium->{$yudisiumMapping[$key]}) {
                                    $isFromYudisium = true;
                                }
                            @endphp

                            <div class="flex flex-col gap-2">
                                <label class="font-['Inter'] font-semibold text-[20px] text-[#0061DF]">
                                    {{ $label }}
                                    @if($isFromYudisium)
                                        <span class="text-green-600 text-sm ml-2"><i class="fas fa-check-circle"></i> Sudah dari Yudisium</span>
                                    @endif
                                </label>

                                @if($isFromYudisium)
                                    {{-- Tampilan jika sudah ada dari Yudisium --}}
                                    <div class="w-full p-4 bg-green-50 border border-green-200 rounded-[10px] flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-green-800">Sudah Terpenuhi</p>
                                            <p class="text-sm text-green-600">File diambil dari data Yudisium</p>
                                        </div>
                                        <a href="{{ route('yudisium.download', basename($yudisium->{$yudisiumMapping[$key]})) }}" target="_blank" class="ml-auto text-blue-600 hover:underline text-sm">Lihat File</a>
                                    </div>
                                @elseif($existing)
                                    {{-- Tampilan jika sudah diupload di Wisuda --}}
                                    <div class="w-full p-4 bg-blue-50 border border-blue-200 rounded-[10px] flex items-center gap-3 relative z-10">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-blue-800">File Terupload</p>
                                            <p class="text-sm text-blue-600">{{ $existing->status == 'menunggu' ? 'Menunggu Verifikasi' : ucfirst($existing->status) }}</p>
                                        </div>
                                        <div class="ml-auto flex gap-2">
                                            <a href="{{ Storage::url($existing->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm relative z-20">Lihat</a>
                                            
                                            @if($existing->status !== 'terverifikasi')
                                                <form action="{{ route('wisuda.persyaratan.hapus', $existing->id) }}" method="POST" onsubmit="return confirm('Hapus file ini?')" class="relative z-20">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    {{-- Form Upload --}}
                                    <form action="{{ route('wisuda.persyaratan.upload') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $key }}">
                                        
                                        <div class="relative w-full h-[126px] bg-[#D6D4FF] border border-dashed border-black rounded-[10px] flex flex-col justify-center items-center cursor-pointer hover:bg-[#c4c1ff] transition-colors group" onclick="document.getElementById('file-{{ $key }}').click()">
                                            <input type="file" id="file-{{ $key }}" name="file" class="hidden" onchange="this.form.submit()" accept=".pdf,.jpg,.jpeg,.png">
                                            <i class="fas fa-cloud-upload-alt text-[40px] text-[#0061DF] mb-2"></i>
                                            <span class="font-['Inter'] text-[12px] text-[#0061DF]">Klik untuk upload {{ $label }}</span>
                                            <span class="text-[10px] text-[#4B4F8F] mt-1">PDF/JPG/PNG Maks 2MB</span>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="mt-12 flex justify-center">
                    <a href="{{ route('wisuda.index') }}" class="w-full md:w-[200px] h-[50px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] text-white font-bold text-[18px] flex items-center justify-center hover:shadow-lg transition-all">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('title', 'Upload Persyaratan Wisuda')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('wisuda.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Wisuda
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Upload Persyaratan Wisuda</h1>
        <p class="text-gray-600">Upload semua persyaratan yang diperlukan untuk wisuda</p>
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

    <!-- Informasi Status -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Persyaratan</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $uploadedTypes = $persyaratan->pluck('jenis')->toArray();
            @endphp

            @foreach($jenisPersyaratan as $key => $label)
                @php
                    $existing = $persyaratan->where('jenis', $key)->first();
                    $isRequired = !in_array($key, ['buku_kenangan']);
                @endphp

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">
                            {{ $label }}
                            @if($isRequired)
                                <span class="text-red-500 text-xs ml-1">*</span>
                            @else
                                <span class="text-gray-500 text-xs ml-1">(Opsional)</span>
                            @endif
                        </h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $existing && $existing->status == 'terverifikasi' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $existing && $existing->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $existing && $existing->status == 'revisi' ? 'bg-red-100 text-red-800' : '' }}
                            {{ !$existing ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ $existing ? ucfirst($existing->status) : 'Belum Upload' }}
                        </span>
                    </div>

                    @if($existing)
                        @if($existing->catatan_admin)
                            <p class="text-sm text-red-600 mt-1">{{ $existing->catatan_admin }}</p>
                        @endif

                        <div class="mt-2 flex space-x-2">
                            <a href="{{ Storage::url($existing->file_path) }}"
                               target="_blank"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-eye mr-1"></i> Lihat
                            </a>
                            <form action="{{ route('wisuda.persyaratan.hapus', $existing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm"
                                        onclick="return confirm('Hapus persyaratan ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @else
                        @php $dropzoneId = 'wisuda-' . $key; @endphp
                        <form action="{{ route('wisuda.persyaratan.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2 space-y-3">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $key }}">

                            <div class="relative w-full h-32 bg-blue-50 border border-dashed border-blue-400 rounded-lg overflow-hidden" data-target="{{ $dropzoneId }}">
                                <input type="file"
                                       name="file"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer dragdrop-input"
                                       data-preview="{{ $dropzoneId }}"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3 pointer-events-none" id="placeholder-{{ $dropzoneId }}">
                                    <i class="fas fa-folder-plus text-3xl text-blue-500 mb-2"></i>
                                    <span class="text-sm text-blue-700">Seret file atau klik untuk upload</span>
                                </div>
                                <div class="absolute inset-0 hidden flex-col items-center justify-center text-center bg-green-50 px-3 pointer-events-none" id="success-{{ $dropzoneId }}">
                                    <i class="fas fa-check-circle text-green-500 text-3xl mb-1"></i>
                                    <p class="text-green-700 text-sm font-semibold">File siap diupload</p>
                                    <p class="file-name text-[10px] text-green-600"></p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500">Format: PDF/JPG/PNG · Maks 2MB</p>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium">
                                    <i class="fas fa-upload mr-1"></i> Upload
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Informasi Penting -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <h3 class="font-semibold text-yellow-800 mb-3">Informasi Penting</h3>
        <ul class="text-sm text-yellow-700 space-y-2">
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                File maksimal 2MB, format: PDF, JPG, JPEG, PNG
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Pastikan file jelas terbaca dan sesuai dengan jenis persyaratan
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Persyaratan dengan tanda * wajib diupload
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Proses verifikasi membutuhkan waktu 1-2 hari kerja
            </li>
            <li class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-2"></i>
                Jika status "Revisi", silakan upload ulang file yang sesuai
            </li>
        </ul>
    </div>

    <!-- Progress Persyaratan -->
    @if($persyaratan->count() > 0)
        @php
            $totalRequired = 5; // toefl, sertifikasi, tahfidz, bebas_perpus, foto_wisuda
            $completed = $persyaratan->whereIn('jenis', ['toefl', 'sertifikasi', 'tahfidz', 'bebas_perpus', 'foto_wisuda'])
                            ->where('status', 'terverifikasi')->count();
            $progress = ($completed / $totalRequired) * 100;
        @endphp

        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress Persyaratan Wajib</h3>

            <div class="mb-2 flex justify-between text-sm text-gray-600">
                <span>{{ $completed }} dari {{ $totalRequired }} persyaratan wajib terverifikasi</span>
                <span>{{ number_format($progress, 0) }}%</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
            </div>

            @if($completed >= $totalRequired)
                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="text-green-800 font-medium">Semua persyaratan wajib sudah terverifikasi!</span>
                        <a href="{{ route('wisuda.data-tambahan') }}" class="ml-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">
                            Lanjutkan ke Data Tambahan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endif
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
