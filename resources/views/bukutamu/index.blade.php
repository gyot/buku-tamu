@extends('layouts.admin')

@section('title', 'Data Tamu')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">
        <i class="bi"></i> Daftar Data Tamu
    </h2>

    {{-- Form Pencarian dan Filter --}}
    <form method="GET" action="{{ route('buku-tamus.index') }}" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Pencarian</label>
            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari Nama, Instansi, Keperluan">
        </div>
        <div class="col-md-3">
            <label class="form-label">Filter Bulan</label>
            <input type="month" name="bulan" value="{{ request('bulan') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('buku-tamus.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Instansi/Alamat</th>
                            <th>Keperluan</th>
                            <th>Nomor HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($bukuTamus as $index => $tamu)
                        <tr>
                            <td>{{ $bukuTamus->firstItem() + $index }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td class="text-start">{{ $tamu->nama }}</td>
                            <td class="text-start">{{ $tamu->instansi }}</td>
                            <td class="text-start">{{ $tamu->keperluan }}</td>
                            <td>{{ $tamu->no_hp }}</td>
                            <td>
                                <a href="{{ route('buku-tamus.edit', ['buku_tamu' => $tamu->id, 'page' => request('page')]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('buku-tamus.destroy', $tamu->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Hapus data ini?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $bukuTamus->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
