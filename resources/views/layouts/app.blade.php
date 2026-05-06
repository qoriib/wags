<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT WAGS - Sistem Pakar')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    @yield('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="brand-logo">
                    <i data-lucide="gem"></i>
                </div>
                <h1 class="brand-name">PT WAGS</h1>
            </div>

            <nav class="nav-list">
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i data-lucide="layout-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('samples.create*') ? 'active' : '' }}">
                        <i data-lucide="clipboard-edit"></i>
                        <span>Input Data Uji</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('samples.index') }}" class="nav-link {{ request()->routeIs('samples.index') ? 'active' : '' }}">
                        <i data-lucide="file-text"></i>
                        <span>Laporan Uji</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </nav>

            <div style="margin-top: auto; padding-top: 2rem;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="nav-link" style="color: var(--danger);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-lucide="log-out"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="header-mobile-toggle" id="sidebarToggle">
                        <i data-lucide="menu"></i>
                    </button>
                    <div>
                        <h2 style="font-size: 1.5rem; font-weight: 700; letter-spacing: -0.02em;">@yield('header_title')</h2>
                        <p style="color: var(--text-muted); font-size: 0.9375rem; margin-top: 0.25rem;" class="hide-mobile">@yield('header_subtitle')</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="text-align: right;" class="hide-mobile">
                        <p style="font-weight: 700; font-size: 0.9375rem; color: var(--text-main);">Admin Internal</p>
                        <p style="color: var(--text-muted); font-size: 0.8125rem;">PT Wina Alam Gunung Semesta</p>
                    </div>
                    <div style="width: 48px; height: 48px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow);">
                        <i data-lucide="user" style="width: 24px; height: 24px; color: var(--text-muted);"></i>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="card animate-fade-in" style="background: var(--success-light); border-color: var(--success); color: var(--success); padding: 1.25rem; margin-bottom: 2rem; border-radius: var(--radius-sm);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                        <span style="font-weight: 600;">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="card animate-fade-in" style="background: var(--danger-light); border-color: var(--danger); color: var(--danger); padding: 1.25rem; margin-bottom: 2rem; border-radius: var(--radius-sm);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                        <span style="font-weight: 600;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <style>
        @media (max-width: 640px) {
            .hide-mobile { display: none; }
        }
    </style>

    <script>
        lucide.createIcons();

        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
    </script>
    @yield('scripts')
</body>
</html>
