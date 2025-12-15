@extends('layouts.mahasiswa_blank')

@section('title', 'Pembayaran Wisuda Berhasil')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-hidden flex flex-col items-center">
        {{-- Background Elements --}}
        <div class="absolute w-[886px] h-[886px] -left-[456px] top-[658px] pointer-events-none z-0 hidden md:block">
            <div class="absolute w-[206.67px] h-[886px] left-[339.66px] top-0 bg-[#0061DF] blur-[72px]"></div>
            <div class="absolute w-[305.52px] h-[886px] left-0 top-[289.34px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>

        {{-- Top Navigation Bar --}}
        <x-mahasiswa-navbar />

        {{-- Main Content --}}
        <div class="relative z-10 flex flex-col items-center w-full max-w-[1262px] pt-[150px] px-4 pb-20">

            {{-- Success Card --}}
            <div class="w-full max-w-[800px] bg-white border-[3px] border-black rounded-[10px] p-10 text-center">
                {{-- Success Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 text-6xl"></i>
                    </div>
                </div>

                {{-- Success Message --}}
                <h1 class="font-['Inter'] font-bold text-[36px] text-[#0061DF] mb-4">
                    Pembayaran Wisuda Berhasil!
                </h1>

                <p class="font-['Inter'] text-[18px] text-gray-700 mb-8">
                    Terima kasih, pembayaran wisuda Anda telah berhasil diproses.
                </p>

                {{-- Payment Details --}}
                <div class="bg-gradient-to-r from-[#0A0061] to-[#0061DF] rounded-[10px] p-6 mb-8 text-white">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm opacity-80">Kode Invoice</p>
                            <p class="font-bold text-lg">{{ $pendaftaran->kode_invoice }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Total Bayar</p>
                            <p class="font-bold text-lg">Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Status</p>
                            <p class="font-bold text-lg">{{ ucfirst($pendaftaran->status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Tanggal Bayar</p>
                            <p class="font-bold text-lg">
                                {{ $pendaftaran->paid_at ? $pendaftaran->paid_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Next Steps --}}
                <div class="bg-blue-50 border-2 border-blue-200 rounded-[10px] p-6 mb-8 text-left">
                    <h3 class="font-['Inter'] font-bold text-[20px] text-[#0061DF] mb-3">
                        <i class="fas fa-info-circle mr-2"></i>Langkah Selanjutnya
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Pembayaran Anda akan diverifikasi oleh admin</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Setelah disetujui, Anda dapat melengkapi persyaratan wisuda</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Cek email Anda untuk notifikasi lebih lanjut</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard') }}"
                        class="px-8 py-3 bg-gradient-to-r from-[#0A0061] to-[#0061DF] text-white font-bold rounded-[10px] hover:shadow-lg transition-all text-center">
                        <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
                    </a>
                    @if($pendaftaran->status == 'lunas')
                        <a href="{{ route('wisuda.persyaratan.form') }}"
                            class="px-8 py-3 bg-green-500 text-white font-bold rounded-[10px] hover:shadow-lg transition-all text-center">
                            <i class="fas fa-file-alt mr-2"></i>Lengkapi Persyaratan
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection