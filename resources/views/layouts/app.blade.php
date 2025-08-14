<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buku Tamu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('css/app-style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">


</head>
<body style="background-color: #f4f8fb">
    <nav class="navbar navbar-light bg-white border-bottom shadow-sm mb-4">
        <div class="container d-flex align-items-center">
            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" height="55">
        </div>
    </nav>

    <main class="container-fluid p-0">
        @yield('content')
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validasi input nomor HP hanya angka (max 15 digit)
        function validateHP(input) {
            const warning = document.getElementById('hpWarning');
            let value = input.value;

            value = value.replace(/[^0-9]/g, '');
            if (value.length > 15) value = value.slice(0, 15);
            input.value = value;

            if (!/^\d{0,15}$/.test(value)) {
                warning?.classList.remove('d-none');
            } else {
                warning?.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput && !tanggalInput.value) {
                const today = new Date().toISOString().split('T')[0];
                tanggalInput.value = today; // hanya sebagai default, tanpa batasan
            }
        });
    </script>
</body>
</html>
