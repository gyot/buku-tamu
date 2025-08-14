@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="container py-5 text-center">
    <img src="{{ asset('assets/image/logo_kemdikbud.png') }}" alt="Logo" style="max-height: 80px;" class="mb-3">
    <h3 class="fw-bold text-primary mb-3">Terima kasih atas kunjungan Anda</h3>
    <p class="text-muted">Data Anda telah berhasil disimpan di sistem Buku Tamu Digital.</p>
    <a href="{{ route('landing') }}" class="btn btn-outline-primary mt-3">
        <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
    </a>
</div>
@endsection
