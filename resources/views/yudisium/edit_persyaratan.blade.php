@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Persyaratan Yudisium</h4>

    <form action="{{ url('yudisium/update-persyaratan') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Judul TA</label>
        <input type="text" name="judul_ta" value="{{ $persyaratan->judul_ta }}" class="form-control" required>

        <label>Dosen Pembimbing</label>
        <input type="text" name="dosen_pembimbing" value="{{ $persyaratan->dosen_pembimbing }}" class="form-control" required>

        <label>File KTP (opsional)</label>
        <input type="file" name="file_ktp" class="form-control">

        <label>File Ijazah (opsional)</label>
        <input type="file" name="file_ijazah" class="form-control">

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
