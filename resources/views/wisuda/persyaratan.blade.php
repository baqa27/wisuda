@extends('layouts.mahasiswa')

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
                        <form action="{{ route('wisuda.persyaratan.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $key }}">

                            <div class="flex items-center space-x-2">
                                <input type="file"
                                       name="file"
                                       class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
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
