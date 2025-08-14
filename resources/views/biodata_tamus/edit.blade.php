@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Layanan Tamu</h1>

    <form action="{{ route('biodata-tamus.update', $biodata->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="page" value="{{ request('page') }}">

        <div class="mb-3">
            <label class="form-label">Nama Tamu</label>
            <input type="text" class="form-control" value="{{ $biodata->bukuTamu->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Instansi</label>
            <input type="text" class="form-control" value="{{ $biodata->bukuTamu->instansi }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Keperluan</label>
            <input type="text" class="form-control" value="{{ $biodata->bukuTamu->keperluan }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" class="form-control" value="{{ $biodata->bukuTamu->no_hp }}" disabled>
        </div>

        <div class="mb-3">
            <label for="permasalahan" class="form-label">Permasalahan</label>
            <textarea name="permasalahan" id="permasalahan" class="form-control" required>{{ $biodata->permasalahan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggapan" class="form-label">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control" required>{{ $biodata->tanggapan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Selesai" {{ $biodata->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Proses" {{ $biodata->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Belum Selesai" {{ $biodata->status == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
