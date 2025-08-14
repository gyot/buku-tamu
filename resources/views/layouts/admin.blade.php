<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Tombol Toggle di atas -->
        <div class="d-flex justify-content-end mb-2 px-2">
            <button id="toggleSidebar" class="btn btn-sm text-white">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

        <!-- Logo -->
        <div class="d-flex justify-content-center mb-3">
            <img src="{{ asset('assets/image/logo_kemdikbud.png') }}" alt="Logo" class="sidebar-logo">
        </div>

        <!-- Menu -->
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill me-2"></i>
            <span class="link-text">Statistik Kunjungan</span>
        </a>
        <a href="{{ route('buku-tamus.index') }}" class="{{ request()->is('buku-tamus*') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark-fill me-2"></i>
            <span class="link-text">Data Tamu</span>
        </a>
        <a href="{{ route('biodata-tamus.index') }}" class="{{ request()->is('biodata-tamus*') ? 'active' : '' }}">
            <i class="bi bi-card-text me-2"></i>
            <span class="link-text">Layanan Tamu</span>
        </a>
        <a href="{{ route('rekapan.index') }}" class="{{ request()->is('rekapan*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open me-2"></i>
            <span class="link-text">Rekapan Tamu</span>
        </a>
        <a href="{{ route('sarana-infos.index') }}" class="{{ request()->is('sarana-infos*') ? 'active' : '' }}">
            <i class="bi bi-bank2 me-2"></i>
            <span class="link-text">Informasi Fasilitas Sarana & Prasarana</span>
        </a>
        
        <a href="{{ route('logout') }}" class="text-danger mt-2 px-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span class="link-text">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        @yield('content')
    </div>

    <!-- Script -->
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    </script>

</body>
</html>
