@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4 p-3">
            <div class="text-center mb-3">
                <img src="{{ asset('assets/image/logo_kemdikbud.png') }}" alt="Logo BPMP NTB" class="img-fluid mb-2" style="max-height: 80px;">
                <h5 class="fw-bold text-primary">BUKU TAMU BPMP NTB</h5>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="login" class="form-label">
                        <i class="bi bi-person-fill me-1"></i> Username
                    </label>
                    <input type="text" name="login" class="form-control rounded-pill" placeholder="Masukkan username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i> Password
                    </label>
                    <input type="password" name="password" class="form-control rounded-pill" placeholder="Masukkan password" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill fw-semibold">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
