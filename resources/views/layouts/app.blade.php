<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Umut Medikal - Güvenilir Sağlık Ürünleri')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @yield('styles')
</head>
<body>
    <header style="position: sticky; top: 0; z-index: 1001; background: white; border-bottom: 1px solid #f1f1f1;">
        <div class="container nav-wrapper" style="padding: 1rem 0;">
            <div style="display: flex; align-items: center; gap: 3rem; flex: 1;">
                <a href="{{ route('home') }}" class="logo" style="font-size: 2rem; letter-spacing: -1px;">UMUT<span style="color: var(--primary-color);">MEDİKAL</span></a>
                
                <form action="{{ route('products.search') }}" method="GET" style="position: relative; flex: 1; max-width: 600px;">
                    <input type="text" name="q" placeholder="Ürün, kategori veya marka ara..." value="{{ request('q') }}" style="padding: 0.8rem 3rem 0.8rem 1.5rem; border-radius: 6px; border: 2px solid #f1f1f1; width: 100%; background: #f9f9f9; font-size: 0.95rem; outline: none; transition: border-color 0.3s;">
                    <button type="submit" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); border: none; background: transparent; cursor: pointer; color: var(--primary-color); font-size: 1.2rem;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <nav class="nav-links" style="gap: 2rem;">
                <div class="nav-auth-group" style="display: flex; gap: 1.5rem; align-items: center;">
                    @guest
                        <a href="{{ route('login') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #333; font-weight: 600;">
                            <i class="far fa-user" style="font-size: 1.2rem;"></i> Giriş Yap
                        </a>
                    @else
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <a href="{{ route('dashboard') }}" style="font-weight: 700; color: var(--primary-color);">Hesabım</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="background: transparent; border: none; cursor: pointer; color: var(--text-muted); font-weight: 600;">Çıkış</button>
                            </form>
                        </div>
                    @endguest

                    <a href="{{ route('wishlist.index') }}" title="Favoriler" style="display: flex; align-items: center; gap: 0.5rem; color: #333;">
                        <i class="far fa-heart" style="font-size: 1.2rem;"></i> Favorilerim
                    </a>

                    <a href="{{ route('cart.index') }}" class="cart-icon" style="display: flex; align-items: center; gap: 0.5rem; color: #333; position: relative;">
                        <i class="fas fa-shopping-cart" style="font-size: 1.2rem;"></i> Sepetim
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge" style="top: -8px; right: -12px;">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Category Bar (Horizontal) -->
        <div style="background: white; border-top: 1px solid #f1f1f1; position: relative;" id="category-navigation">
            <div class="container" style="display: flex; align-items: center; gap: 2rem;">
                <!-- MEGA MENU TRIGGER -->
                <div class="mega-menu-wrapper" style="position: relative;">
                    <button class="mega-menu-trigger" style="background: var(--primary-color); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 0.8rem; border-radius: 4px 4px 0 0;">
                        <i class="fas fa-bars"></i> TÜM KATEGORİLER
                    </button>
                    
                    <!-- THE DROPDOWN (Mega Menu) -->
                    <div class="mega-menu-dropdown">
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; padding: 2rem;">
                            @foreach(\App\Models\Category::all()->chunk(ceil(\App\Models\Category::count() / 3)) as $chunk)
                                <div class="mega-column">
                                    @foreach($chunk as $cat)
                                        <a href="{{ route('products.category', $cat->slug) }}" class="mega-item">{{ $cat->name }}</a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TOP CATEGORIES -->
                <div class="top-categories-bar">
                    @foreach(\App\Models\Category::limit(8)->get() as $cat)
                        <a href="{{ route('products.category', $cat->slug) }}" class="category-nav-link">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <main class="container" style="padding: 2rem 0; min-height: 70vh;">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-about">
                <h3 class="footer-title">Umut Medikal</h3>
                <p>Müşterilerimize en kaliteli medikal ürünleri, en uygun fiyatlarla sunmayı amaçlıyoruz. Sağlığınız bizim için değerlidir.</p>
            </div>
            
            <div class="footer-nav">
                <h3 class="footer-title">Hızlı Bağlantılar</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Anasayfa</a></li>
                    <li><a href="{{ route('wishlist.index') }}">Favorilerim</a></li>
                    <li><a href="{{ route('contact.index') }}">İletişim</a></li>
                    <li><a href="{{ route('login') }}">Giriş Yap</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h3 class="footer-title">İletişim</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> İstanbul, Türkiye</li>
                    <li><i class="fas fa-envelope"></i> info@umutmedikal.com</li>
                    <li><i class="fas fa-phone"></i> +90 212 XXX XX XX</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; {{ date('Y') }} Umut Medikal. Tüm Hakları Saklıdır.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
