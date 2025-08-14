@extends('layouts.app')

@section('title', 'Buku Tamu')

@section('content')
<div class="container py-4" style="background-color: #F1F7F9;">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="row g-4 align-items-stretch">

                <!-- FORM PENGUNJUNG -->
                <div class="col-md-8">
                    <div class="card shadow border-0" style="border-radius: 1rem;">
                        <div class="card-body px-4 py-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <h5 class="fw-bold" style="color: #064089; border-left: 5px solid #0A61C9; padding-left: 10px;">
                                    FORM BUKU TAMU
                                </h5>
                            </div>

                            <form action="{{ route('buku-tamus.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control shadow-sm" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Pengunjung</label>
                                    <input type="text" name="nama" class="form-control shadow-sm" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Instansi / Alamat</label>
                                    <input type="text" name="instansi" class="form-control shadow-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control shadow-sm" required maxlength="15" value="{{ old('no_hp') }}" oninput="validateHP(this)">
                                    <small id="hpWarning" class="text-danger d-none">Nomor HP hanya boleh angka dan maksimal 15 digit.</small>
                                    @error('no_hp')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="keperluan" class="form-label">Keperluan</label>
                                    <select name="keperluan" class="form-select" required>
                                        <option value="">-- Pilih Keperluan --</option>
                                        <option value="Layanan Data dan Informasi Mutu Pendidikan">Layanan Data dan Informasi Mutu Pendidikan</option>
                                        <option value="Layanan Pemetaan dan Supervisi Mutu Pendidikan">Layanan Pemetaan dan Supervisi Mutu Pendidikan</option>
                                        <option value="Layanan Kemitraan Penjaminan Mutu Pendidikan">Layanan Kemitraan Penjaminan Mutu Pendidikan</option>
                                        <option value="Layanan Sarana dan Prasarana">Layanan Sarana dan Prasarana</option>
                                        <option value="Kunjungan Kerja">Kunjungan Kerja</option>
                                        <option value="Silaturahmi">Silaturahmi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #0A61C9;">
                                        <i class="bi bi-send-fill"></i> Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- STATISTIK PENGUNJUNG -->
                <div class="col-md-4">
                    <div class="card shadow border-0 h-50" style="border-radius: 1rem;">
                        <div class="card-body px-4 py-4">

                            <div class="mb-4">
                                <h5 class="fw-bold" style="color: #064089; border-left: 5px solid #0A61C9; padding-left: 10px;">
                                    JUMLAH TAMU
                                </h5>
                            </div>
                            <ul class="list-group list-group-flush fs-6">
                                <li class="list-group-item d-flex justify-content-between bg-transparent border-bottom">
                                    <span>Hari Ini ({{ $statistik['hari_ini']['label'] }}):</span>
                                    <strong>{{ $statistik['hari_ini']['jumlah'] }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent border-bottom">
                                    <span>Kemarin ({{ $statistik['kemarin']['label'] }}):</span>
                                    <strong>{{ $statistik['kemarin']['jumlah'] }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span>Bulan Ini ({{ $statistik['bulan_ini']['label'] }}):</span>
                                    <strong>{{ $statistik['bulan_ini']['jumlah'] }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END STATISTIK -->

            </div>
        </div>
    </div>
</div>
@endsection
