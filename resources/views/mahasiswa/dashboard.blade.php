@extends('layouts.mahasiswa_blank')

@section('title', 'Dashboard')

@section('content')
    <div class="relative w-full min-h-screen bg-white overflow-x-hidden flex flex-col items-center">

        {{-- Background Elements --}}
        {{-- Group 2 (Left) --}}
        <div class="absolute w-[886px] h-[886px] -left-[456px] top-[658px] pointer-events-none z-0 hidden md:block">
            {{-- Ellipse 1 --}}
            <div class="absolute w-[206.67px] h-[886px] left-[339.66px] top-0 bg-[#0061DF] blur-[72px]"></div>
            {{-- Ellipse 2 --}}
            <div class="absolute w-[305.52px] h-[886px] left-0 top-[289.34px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>

        {{-- Group 3 (Right) --}}
        <div class="absolute w-[493px] h-[493px] left-[1259px] top-[308px] pointer-events-none z-0 hidden md:block">
            {{-- Ellipse 1 --}}
            <div class="absolute w-[115px] h-[493px] left-[189px] top-0 bg-[#0061DF] blur-[72px]"></div>
            {{-- Ellipse 2 --}}
            <div class="absolute w-[170px] h-[493px] left-0 top-[161px] bg-[#0061DF] blur-[72px] rotate-90"></div>
        </div>

        {{-- Top Navigation Bar --}}
        <div class="absolute top-[35px] z-20 w-full flex justify-center px-4">
            <div class="flex flex-row justify-between md:justify-center items-center px-6 md:gap-[175px] w-full max-w-[1262px] h-[82px] bg-[#0061DF] rounded-[10px] shadow-lg overflow-hidden">

                {{-- Daftar Yudisium Link --}}
                <a href="{{ route('yudisium.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-64h-6tive flex justify-center items-center">
                        <i class="fas fa-medal text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Yudisium</span>
                </a>

                {{-- Home Link --}}
                <a href="{{ route('dashboard') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity">
                    <div class="w-64h-6tive flex justify-center items-center">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-white">Home</span>
                </a>

                {{-- Daftar Wisuda Link --}}
                <a href="{{ route('wisuda.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Wisuda</span>
                </a>

            </div>
        </div>

        {{-- Main Content Container --}}
        <div class="relative z-10 flex flex-col items-center w-full max-w-[1440px] pt-[120px] md:pt-[150px] px-4">

            {{-- Welcome Section --}}
            <div class="flex flex-col items-center gap-5 md:gap-[30px] w-full max-w-[1077px] mb-10 md:mb-[60px]">
                <h1 class="font-['Inter'] font-bold text-[32px] md:text-[64px] leading-tight md:leading-[77px] text-center text-[#0061DF] w-full">
                    Selamat Datang, {{ Auth::user()->name }}
                </h1>
                <p class="font-['Inter'] font-light text-[20px] md:text-[40px] leading-tight md:leading-12 text-center text-[#0061DF] w-full max-w-[925px]">
                    Akses kapanpun dan dimanapun Demi kelancaran Yudisium dan Wisuda Anda
                </p>
            </div>

            {{-- Status Table Section --}}
            <div class="flex flex-col items-start w-full max-w-[962px] mb-10 md:mb-20">
                {{-- Header --}}
                <div class="flex flex-row justify-center items-center w-full h-[49px] gap-0.5 md:gap-10">
                    <div class="flex-1 h-[49px] flex justify-center items-center bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-t-[10px]">
                        <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-center text-white">Status</span>
                    </div>
                    <div class="flex-1 h-[49px] flex justify-center items-center bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-t-[10px]">
                        <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-center text-white">Keterangan</span>
                    </div>
                </div>

                {{-- Yudisium Row --}}
                <div class="flex flex-row justify-center items-center w-full h-[50px] gap-0.5 md:gap-10[#CECECE] border-b border-[#090909]">
                    <div class="flex-1 h-[38px] flex justify-center items-center">
                        <span class="font-['Inter'] font-medium text-[14px] md:text-[15px] leading-[18px] text-center text-[#090909]">Yudisium</span>
                    </div>
                    <div class="flex-1 h-[38px] flex justify-center items-center gap-2.5">
                        @php
                            $statusYudisium = Auth::user()->pendaftaranYudisium?->status;
                            $isYudisiumSelesai = $statusYudisium === 'lunas';
                        @endphp
                        <span class="font-['Inter'] font-medium text-[14px] md:text-[15px] leading-[18px] text-center text-[#090909]">
                            {{ $isYudisiumSelesai ? 'Selesai' : 'Belum Dilengkapi' }}
                        </span>
                        <div class="w-2.5 h-2.5 rounded-full {{ $isYudisiumSelesai ? 'bg-[#00FF00]' : 'bg-[#FF0000]' }}"></div>
                    </div>
                </div>

                {{-- Wisuda Row --}}
                <div class="flex flex-row justify-center items-center w-full h-[50px] gap-0.5 md:gap-10 bg-[#CECECE]">
                    <div class="flex-1 h-[38px] flex justify-center items-center">
                        <span class="font-['Inter'] font-medium text-[14px] md:text-[15px] leading-[18px] text-center text-[#090909]">Wisuda</span>
                    </div>
                    <div class="flex-1 h-[38px] flex justify-center items-center gap-2.5">
                        @php
                            $statusWisuda = Auth::user()->pendaftaranWisuda?->status;
                            $isWisudaSelesai = $statusWisuda === 'lunas';
                        @endphp
                        <span class="font-['Inter'] font-medium text-[14px] md:text-[15px] leading-[18px] text-center text-[#090909]">
                            {{ $isWisudaSelesai ? 'Selesai' : 'Belum Dilengkapi' }}
                        </span>
                        <div class="w-2.5 h-2.5 rounded-full {{ $isWisudaSelesai ? 'bg-[#00FF00]' : 'bg-[#FF0000]' }}"></div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col items-center gap-5 md:gap-10 w-full max-w-[962px]">
                <div class="flex flex-col md:flex-row items-center gap-5 md:gap-[70px] w-full">
                    {{-- Daftar Yudisium Button --}}
                    <a href="{{ route('yudisium.index') }}" class="flex flex-row justify-center items-center p-5 gap-2.5 w-full md:w-[446px] h-[60px] md:h-[82px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] hover:shadow-lg transition-all">
                        <span class="font-['Inter'] font-bold text-[18px] md:text-[24px] leading-[29px] text-white">Daftar Yudisium</span>
                    </a>

                    {{-- Daftar Wisuda Button --}}
                    <a href="{{ route('wisuda.index') }}" class="flex flex-row justify-center items-center p-5 gap-2.5 w-full md:w-[446px] h-[60px] md:h-[82px] bg-[linear-gradient(95.08deg,#0A0061_-3.06%,#0061DF_95.31%)] rounded-[10px] hover:shadow-lg transition-all">
                        <span class="font-['Inter'] font-bold text-[18px] md:text-[24px] leading-[29px] text-white">Daftar Wisuda</span>
                    </a>
                </div>

                {{-- Disclaimer --}}
                <p class="font-['Inter'] font-light text-[14px] md:text-[20px] leading-6 text-center text-[#767676] w-full">
                    *Harap lakukan pembayaran terlebih dahulu sebelum melakukan pendaftaran
                </p>
            </div>

        </div>
    </div>
@endsection
