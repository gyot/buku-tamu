@extends('layouts.admin')

@section('title', 'Statistik Tamu')

@section('content')
<div class="container py-4">
    <h2 class="bi mb-4 fw-bold text-dark"> Statistik Kunjungan & Rekap Status Layanan Tamu</h2>

    <!-- Filter Keperluan & Tahun -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
        <div class="row gy-3 gx-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Filter Berdasarkan Keperluan</label>
                <select name="keperluan" class="form-select">
                    <option value="">-- Semua Keperluan --</option>
                    @foreach(\App\Models\BukuTamu::select('keperluan')->distinct()->pluck('keperluan') as $k)
                        <option value="{{ $k }}" {{ request('keperluan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter Tahun</label>
                <input type="text" id="tahunPicker" name="tahun" class="form-control" value="{{ $filterTahun }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 bi bi-search"> Filter</button>
            </div>
        </div>
    </form>

    <!-- Status filter -->
    @if($filterKeperluan)
        <div class="alert alert-info">Menampilkan statistik berdasarkan keperluan: <strong>{{ $filterKeperluan }}</strong></div>
    @else
        <div class="alert alert-secondary">Menampilkan <strong>seluruh data</strong> tanpa filter keperluan.</div>
    @endif

    <!-- Statistik Biodata -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-5">
        <div class="col">
            <div class="card shadow text-white border-0" style="background-color: #064089;">
                <div class="card-body">
                    <h6>Total Layanan Tamu yang Sudah Dikonfirmasi</h6>
                    <h3>{{ $totalBiodata ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow text-white border-0" style="background-color: #749DC8;">
                <div class="card-body">
                    <h6>Total Layanan Tamu yang Belum Dikonfirmasi</h6>
                    <h3>{{ $belumIsiBiodata ?? '-' }}</h3>
                </div>
            </div>
        </div>
        {{-- <div class="col">
            <div class="card shadow text-white border-0" style="background-color: #0A61C9;">
                <div class="card-body">
                    <h6>Belum Selesai</h6>
                    <h3>{{ $belumSelesai ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow text-white border-0" style="background-color: #749DC8;">
                <div class="card-body">
                    <h6>Proses</h6>
                    <h3>{{ $proses ?? '-' }}</h3>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card shadow border-0" style="background-color: #F1F7F9; color: #07326A;">
                <div class="card-body">
                    <h6>Selesai</h6>
                    <h3>{{ $selesai ?? '-' }}</h3>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Grafik Bar Jumlah Tamu -->
    <div class="card shadow border-0">
        <div class="card-header bg-white fw-bold text-dark">
            Grafik Jumlah Tamu per Bulan - Tahun {{ $filterTahun }}
        </div>
        <div class="card-body">
            <p class="fw-semibold mb-3" style="color: #0A61C9;">
                Total Jumlah Tamu: {{ array_sum($jumlahTamu ?? []) }}
            </p>
            <div class="table-responsive">
                <canvas id="grafikTamu" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Pie Charts -->
    <div class="row g-4 mt-5">
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white fw-bold text-dark">
                    Distribusi Status Layanan Tamu
                </div>
                <div class="card-body">
                    <canvas id="pieStatusChart" height="220"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white fw-bold text-dark">
                    Distribusi Keperluan Tamu
                </div>
                <div class="card-body">
                    <canvas id="pieKeperluanChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr("#tahunPicker", {
        dateFormat: "Y",
        defaultDate: "{{ $filterTahun }}"
    });

    const ctx = document.getElementById('grafikTamu').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bulan ?? []),
            datasets: [{
                label: 'Jumlah Tamu',
                data: @json($jumlahTamu ?? []),
                backgroundColor: '#0A61C9'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    const statusCtx = document.getElementById('pieStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: @json(array_keys($statusChart)),
            datasets: [{
                data: @json(array_values($statusChart)),
                backgroundColor: ['#F44336', '#FFC107', '#4CAF50']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const keperluanCtx = document.getElementById('pieKeperluanChart').getContext('2d');
    new Chart(keperluanCtx, {
        type: 'pie',
        data: {
            labels: @json(array_keys($keperluanChart)),
            datasets: [{
                data: @json(array_values($keperluanChart)),
                backgroundColor: [
                    '#0A61C9', '#4CAF50', '#FF9800', '#9C27B0', '#F44336',
                    '#03A9F4', '#8BC34A', '#FFEB3B', '#E91E63', '#795548'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
