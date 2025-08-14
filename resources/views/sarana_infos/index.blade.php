@extends('layouts.admin') 

@section('title', 'Informasi Sarana & Prasarana')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-dark">
        <i class="bi"></i> Daftar Informasi Sarana & Prasarana
    </h2>

    <a href="{{ route('sarana-infos.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle me-1"></i> Tambah Informasi
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle table-hover table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Sarana</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Periode</th>
                    <th>Ditampilkan?</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $row)
                <tr>
                    <td class="text-center">{{ $data->firstItem() + $i }}</td>
                    <td>{{ $row->sarana }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                    <td class="text-nowrap">
                        {{ $row->mulai ? \Carbon\Carbon::parse($row->mulai)->format('d M Y') : '-' }}
                        s/d
                        {{ $row->sampai ? \Carbon\Carbon::parse($row->sampai)->format('d M Y') : '-' }}
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ $row->ditampilkan ? 'success' : 'secondary' }}">
                            {{ $row->ditampilkan ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td class="text-center text-nowrap">
                        <a href="{{ route('sarana-infos.edit', $row->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('sarana-infos.destroy', $row->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data informasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $data->links() }}
</div>
@endsection
