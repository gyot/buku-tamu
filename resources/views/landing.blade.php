@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-hero">
            <div class="hero-text">
                <h1>Selamat Datang di Sistem Informasi Buku Tamu</h1>
                <p>Balai Penjaminan Mutu Pendidikan Provinsi Nusa Tenggara Barat</p>
                <p class="small-text">Silakan klik tombol di bawah ini untuk mengisi buku tamu.</p>
                <a href="{{ route('buku-tamus.create') }}" class="btn btn-primary btn-isi">
                    <i class="bi bi-journal-text me-2"></i>Isi Buku Tamu
                </a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('assets/image/bpmp.jpg') }}" alt="BPMP NTB">
            </div>
        </div>
    </section>

    <!-- Langkah Pengisian Buku Tamu -->
    <div class="container text-center">
        <h2 class="section-title">Cara Mengisi Buku Tamu</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="step-number">1</div>
                        <div class="step-title">Klik Tombol "Isi Buku Tamu"</div>
                        <p class="step-desc">Tombol ini ada di bagian atas halaman ini.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="step-number">2</div>
                        <div class="step-title">Isi Data Diri & Keperluan</div>
                        <p class="step-desc">Lengkapi nama, instansi, nomor HP, dan keperluan kunjungan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="step-number">3</div>
                        <div class="step-title">Klik "Simpan Data"</div>
                        <p class="step-desc">Setelah itu data Anda akan tercatat dalam sistem kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Sarana -->
    <div class="container text-center">
        <h2 class="section-title">Informasi Fasilitas Sarana & Prasarana</h2>
        @if ($saranaInfo->isEmpty())
            <p>Belum ada informasi yang tersedia saat ini.</p>
        @else
            <div class="row justify-content-center">
                @foreach ($saranaInfo as $info)
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5>{{ $info->sarana }}</h5>
                                <span class="badge {{ $info->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">{{ $info->status }}</span>
                                <p class="text-muted mb-0">
                                  <i class="bi bi-calendar-event"></i>
                                  {{ \Carbon\Carbon::parse($info->mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($info->sampai)->format('d-m-Y') }}
                                </p>
                                <p class="mt-2 small">{{ $info->keterangan }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer-custom mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Balai Penjaminan Mutu Pendidikan<br>Provinsi Nusa Tenggara Barat (BPMP NTB)</h5>
                    <p>Jl. Panji Tilarnegara, No. 08 Mataram – NTB</p>
                    <div class="sosmed-icons">
                        <a href="https://facebook.com/bpmpntb" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.youtube.com/@bpmpntb6747" target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="https://instagram.com/bpmpntb" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/628113906669" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <iframe src="https://maps.google.com/maps?q=Jl.%20Panji%20Tilarnegara%20No.%2008%20Mataram&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="180" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p><i class="bi bi-telephone"></i> 628113906669</p>
                    <p><i class="bi bi-envelope"></i> ntblpmp@gmail.com</p>
                    <p><i class="bi bi-geo-alt"></i> Jl. Panji Tilarnegara, No. 08 Mataram – NTB</p>
                    <p><strong>Jam Layanan</strong><br>Senin – Jumat: 08.00 – 16.00 WIB</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2)">
            <p class="text-center mb-0">&copy; 2025 BPMP NTB. All rights reserved.</p>
        </div>
    </footer>
@endsection
