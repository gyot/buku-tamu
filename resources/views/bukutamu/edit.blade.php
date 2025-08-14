@extends('layouts.app')

@section('title', 'Edit Data Tamu')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">Edit Data Tamu</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada kesalahan saat input.<br>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku-tamus.update', $bukuTamu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="page" value="{{ $page }}">

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                value="{{ old('tanggal', \Carbon\Carbon::parse($bukuTamu->tanggal)->format('Y-m-d')) }}"
                class="form-control shadow-sm" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pengunjung</label>
            <input type="text" name="nama" class="form-control shadow-sm"
                value="{{ old('nama', $bukuTamu->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="instansi" class="form-label">Instansi / Alamat</label>
            <input type="text" name="instansi" class="form-control shadow-sm"
                value="{{ old('instansi', $bukuTamu->instansi) }}">
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control shadow-sm"
                value="{{ old('no_hp', $bukuTamu->no_hp) }}" maxlength="15" oninput="validateHP(this)" required>
            <small id="hpWarning" class="text-danger d-none">Nomor HP hanya boleh angka dan maksimal 15 digit.</small>
            @error('no_hp')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="keperluan" class="form-label">Keperluan</label>
            <select name="keperluan" class="form-select shadow-sm" required>
                <option value="">-- Pilih Keperluan --</option>
                <option value="Layanan Data dan Informasi Mutu Pendidikan" {{ old('keperluan', $bukuTamu->keperluan) == 'Layanan Data dan Informasi Mutu Pendidikan' ? 'selected' : '' }}>Layanan Data dan Informasi Mutu Pendidikan</option>
                <option value="Layanan Pemetaan dan Supervisi Mutu Pendidikan" {{ old('keperluan', $bukuTamu->keperluan) == 'Layanan Pemetaan dan Supervisi Mutu Pendidikan' ? 'selected' : '' }}>Layanan Pemetaan dan Supervisi Mutu Pendidikan</option>
                <option value="Layanan Kemitraan Penjaminan Mutu Pendidikan" {{ old('keperluan', $bukuTamu->keperluan) == 'Layanan Kemitraan Penjaminan Mutu Pendidikan' ? 'selected' : '' }}>Layanan Kemitraan Penjaminan Mutu Pendidikan</option>
                <option value="Layanan Sarana dan Prasarana" {{ old('keperluan', $bukuTamu->keperluan) == 'Layanan Sarana dan Prasarana' ? 'selected' : '' }}>Layanan Sarana dan Prasarana</option>
                <option value="Kunjungan Kerja" {{ old('keperluan', $bukuTamu->keperluan) == 'Kunjungan Kerja' ? 'selected' : '' }}>Kunjungan Kerja</option>
                <option value="Silaturahmi" {{ old('keperluan', $bukuTamu->keperluan) == 'Silaturahmi' ? 'selected' : '' }}>Silaturahmi</option>
                <option value="Lainnya" {{ old('keperluan', $bukuTamu->keperluan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="d-flex justify-content-start gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
            <a href="{{ route('buku-tamus.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle me-1"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
