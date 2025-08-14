@extends('layouts.admin')

@section('title', 'Tambah Informasi Fasilitas Sarana & Prasarana')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">Tambah Informasi Fasilitas Sarana & Prasarana</h2>

    <form action="{{ route('sarana-infos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Fasilitas</label>
            <input type="text" name="sarana" class="form-control" required value="{{ old('sarana') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Sudah Dibooking" {{ old('status') == 'Sudah Dibooking' ? 'selected' : '' }}>Sudah Dibooking</option>
                <option value="Dalam Perawatan" {{ old('status') == 'Dalam Perawatan' ? 'selected' : '' }}>Dalam Perawatan</option>
                <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Mulai Penggunaan</label>
                <input type="date" name="mulai" class="form-control" id="tanggal_mulai" value="{{ old('mulai') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Selesai Penggunaan</label>
                <input type="date" name="sampai" class="form-control" id="tanggal_selesai" value="{{ old('sampai') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tampilkan di Halaman Utama Web?</label>
            <select name="ditampilkan" class="form-select">
                <option value="1" {{ old('ditampilkan') == '1' ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ old('ditampilkan') == '0' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('sarana-infos.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const mulaiInput = document.getElementById('tanggal_mulai');
    const selesaiInput = document.getElementById('tanggal_selesai');

    if (mulaiInput && selesaiInput) {
        mulaiInput.addEventListener('change', function () {
            selesaiInput.min = this.value;
            if (selesaiInput.value < this.value) {
                selesaiInput.value = this.value;
            }
        });
        if (mulaiInput.value) {
            selesaiInput.min = mulaiInput.value;
        }
    }
</script>
@endpush
