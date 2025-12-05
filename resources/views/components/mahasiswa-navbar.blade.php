<nav class="fixed top-[35px] z-50 w-full px-4 flex justify-center">
    @php
        $user = Auth::user();
        $persyaratan = $user->persyaratanYudisium;
        $canAccessWisuda = $persyaratan && $persyaratan->status === 'terverifikasi';
    @endphp

    <div class="w-full max-w-[1262px] bg-[#0061DF] rounded-[10px] shadow-lg px-6 h-[82px] flex items-center justify-between">
        {{-- Navigation Links --}}
        <div class="flex items-center gap-4 md:gap-[60px] lg:gap-[100px] mx-auto">
            {{-- Daftar Yudisium --}}
            <a href="{{ route('yudisium.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                <div class="w-6 h-6 relative flex justify-center items-center">
                    <i class="fas fa-medal text-white text-xl"></i>
                </div>
                <span class="font-['Inter'] font-bold text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Yudisium</span>
            </a>

            {{-- Home --}}
            <a href="{{ route('dashboard') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity">
                <div class="w-6 h-6 relative flex justify-center items-center">
                    <i class="fas fa-home text-white text-xl"></i>
                </div>
                <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white">Home</span>
            </a>

            {{-- Daftar Wisuda --}}
            @if ($canAccessWisuda)
                <a href="{{ route('wisuda.index') }}" class="flex flex-row items-center gap-2.5 group hover:opacity-80 transition-opacity whitespace-nowrap">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Daftar Wisuda</span>
                </a>
            @else
                <span class="flex flex-row items-center gap-2.5 opacity-60 cursor-not-allowed" title="Tunggu persyaratan terverifikasi">
                    <div class="w-6 h-6 relative flex justify-center items-center">
                        <i class="fas fa-lock text-white text-xl"></i>
                    </div>
                    <span class="font-['Inter'] font-light text-[16px] md:text-[24px] leading-[29px] text-white hidden sm:inline">Wisuda Terkunci</span>
                </span>
            @endif
        </div>

        {{-- Logout Button --}}
        <div class="hidden lg:block absolute right-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-[8px] transition-colors shadow-md" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="font-bold text-sm">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>
