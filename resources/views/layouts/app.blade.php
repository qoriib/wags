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
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
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
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('samples.create*') ? 'active' : '' }}">
                        <i data-lucide="clipboard-edit"></i>
                        Input Data Uji
                    </a>
                </li>
                <li>
                    <a href="{{ route('samples.index') }}" class="nav-link {{ request()->routeIs('samples.index') ? 'active' : '' }}">
                        <i data-lucide="file-text"></i>
                        Laporan Uji
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        Pengaturan
                    </a>
                </li>
            </nav>

            <div style="margin-top: auto; padding-top: 2rem;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="nav-link" style="color: var(--danger);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-lucide="log-out"></i>
                    Keluar
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 600;">@yield('header_title')</h2>
                    <p style="color: var(--text-muted); font-size: 0.875rem;">@yield('header_subtitle')</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="text-align: right;">
                        <p style="font-weight: 600; font-size: 0.875rem;">Admin Internal</p>
                        <p style="color: var(--text-muted); font-size: 0.75rem;">PT Wina Alam Gunung Semesta</p>
                    </div>
                    <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="user" style="width: 20px; height: 20px; color: var(--text-muted);"></i>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="card animate-fade-in" style="background: var(--success-light); border-color: var(--success); color: var(--success); padding: 1rem; margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="card animate-fade-in" style="background: var(--danger-light); border-color: var(--danger); color: var(--danger); padding: 1rem; margin-bottom: 1.5rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
