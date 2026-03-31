<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umut Medikal - Satıcı Paneli</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @yield('styles')
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">UMUT <span style="color:white">PANEL</span></div>
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->is('admin-panel') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.products') }}" class="sidebar-nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Ürün Yönetimi
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.categories') }}" class="sidebar-nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Kategori Yönetimi
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.current_accounts') }}" class="sidebar-nav-link {{ request()->is('admin/current-accounts*') ? 'active' : '' }}">
                        <i class="fas fa-address-book"></i> Cari Hesaplar
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.settings') }}" class="sidebar-nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Mağaza Ayarları
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="fas fa-shopping-bag"></i> Siparişler
                    </a>
                </li>
                <hr style="border: 0.1px solid #374151; margin: 1.5rem 0;">
                <li class="sidebar-nav-item">
                    <form action="{{ route('admin.sync-trendyol') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-sync" style="width: 100%;">
                            <i class="fas fa-sync"></i> Trendyol'u Çek
                        </button>
                    </form>
                </li>
                <li class="sidebar-nav-item" style="margin-top: 5rem;">
                    <a href="{{ route('home') }}" class="sidebar-nav-link">
                        <i class="fas fa-external-link-alt"></i> Siteye Git
                    </a>
                </li>
            </ul>
        </aside>

        <main class="admin-main">
            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
