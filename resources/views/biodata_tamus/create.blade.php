@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Layanan Tamu</h1>

    <form action="{{ route('biodata-tamus.store') }}" method="POST">
        @csrf

        {{-- Hidden input untuk ID tamu --}}
        <input type="hidden" name="buku_tamu_id" value="{{ $bukuTamu->id }}">

        <input type="hidden" name="page" value="{{ request('page') }}">

        {{-- Informasi tamu yang ditampilkan (non-editable) --}}
        <div class="mb-3">
            <label class="form-label">Nama Tamu</label>
            <input type="text" class="form-control" value="{{ $bukuTamu->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Instansi/Alamat</label>
            <input type="text" class="form-control" value="{{ $bukuTamu->instansi }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Keperluan</label>
            <input type="text" class="form-control" value="{{ $bukuTamu->keperluan }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" class="form-control" value="{{ $bukuTamu->no_hp }}" disabled>
        </div>

        {{-- Form Biodata --}}
        <div class="mb-3">
            <label for="permasalahan" class="form-label">Permasalahan</label>
            <textarea name="permasalahan" id="permasalahan" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tanggapan" class="form-label">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Selesai">Selesai</option>
                <option value="Proses">Proses</option>
                <option value="Belum Selesai">Belum Selesai</option>
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
