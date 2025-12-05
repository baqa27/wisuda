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
