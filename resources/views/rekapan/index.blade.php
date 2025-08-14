@extends('layouts.admin')

@section('title', 'Rekapan Tamu')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">
        <i class="bi"></i> Rekapan Tamu
    </h2>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('rekapan.index') }}" class="row g-2 mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Jenis Data</label>
            <select name="tipe_data" class="form-select">
                <option value="buku" {{ $tipe == 'buku' ? 'selected' : '' }}>Buku Tamu</option>
                <option value="biodata" {{ $tipe == 'biodata' ? 'selected' : '' }}>Layanan Tamu</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggalAwal }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </div>
    </form>

    @if (count($data))
    {{-- Export Section --}}
    <div class="mb-4" style="max-width: 100%;">
        <label class="form-label fw-semibold text-dark">Ekspor Laporan (Unduh sebagai file)</label>

        <div class="d-flex flex-wrap gap-2 align-items-end">
            {{-- Form Excel --}}
            <form method="POST" action="{{ route('rekapan.export') }}" class="d-flex align-items-end gap-2">
                @csrf
                <input type="hidden" name="tipe_data" value="{{ $tipe }}">
                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">

                {{-- <input type="text" name="filename" class="form-control" style="width: 250px;" placeholder="Nama file (opsional)"> --}}

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Download Excel
                </button>
            </form>

            {{-- Form PDF --}}
            <form method="POST" action="{{ route('rekapan.exportPdf') }}" target="_blank">
                @csrf
                <input type="hidden" name="tipe_data" value="{{ $tipe }}">
                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-filetype-pdf me-1"></i> Download PDF
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            @if ($tipe === 'biodata')
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Instansi/Alamat</th>
                                <th>Keperluan</th>
                                <th>Nomor HP</th>
                                <th>Permasalahan</th>
                                <th>Tanggapan</th>
                                <th>Status</th>
                            @else
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Instansi/Alamat</th>
                                <th>Keperluan</th>
                                <th>Nomor HP</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($data as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            @if ($tipe === 'biodata')
                                <td>{{ optional($item->bukuTamu)->tanggal ? \Carbon\Carbon::parse($item->bukuTamu->tanggal)->format('d-m-Y') : '-' }}</td>
                                <td class="text-start">{{ optional($item->bukuTamu)->nama }}</td>
                                <td class="text-start">{{ optional($item->bukuTamu)->instansi }}</td>
                                <td class="text-start">{{ optional($item->bukuTamu)->keperluan }}</td>
                                <td>{{ optional($item->bukuTamu)->no_hp }}</td>
                                <td class="text-start">{{ $item->permasalahan ?? '-' }}</td>
                                <td class="text-start">{{ $item->tanggapan ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'Selesai' ? 'success' : ($item->status == 'Proses' ? 'warning' : 'secondary') }}">
                                        {{ $item->status ?? '-' }}
                                    </span>
                                </td>
                            @else
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td class="text-start">{{ $item->nama }}</td>
                                <td class="text-start">{{ $item->instansi }}</td>
                                <td class="text-start">{{ $item->keperluan }}</td>
                                <td>{{ $item->no_hp }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info mt-4">Tidak ada data yang ditampilkan.</div>
    @endif
</div>
@endsection
