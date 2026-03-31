@extends('layouts.app')

@section('title', $query . ' İçin Sonuçlar - Umut Medikal')

@section('content')
<div class="page-layout-with-sidebar">
    <!-- SIDEBAR CATEGORIES -->
    @include('partials.sidebar')

    <!-- CONTENT AREA -->
    <section id="results-content">
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
            <h1 style="font-size: 1.4rem; margin-bottom: 0.5rem;">"{{ $query }}" İçin Sonuçlar</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">{{ $products->total() }} adet ürün bulundu.</p>
        </div>

        @if($products->count() > 0)
            <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                @foreach($products as $product)
                <div class="product-card" style="background: white; border: 1px solid #f0f0f0; border-radius: 8px; overflow: hidden; position: relative;">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <div style="height: 220px; overflow: hidden; background: #f9f9f9;">
                            <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/600x400?text=Urun+Resmi' }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                    </a>
                    <div class="product-info" style="padding: 1.2rem;">
                        <span style="font-size: 0.75rem; color: #999; font-weight: 700; display: block; margin-bottom: 0.5rem;">{{ $product->brand ? $product->brand->name : 'Markasız' }}</span>
                        <h3 class="product-title" style="font-size: 0.95rem; margin-bottom: 1rem; height: 40px; overflow: hidden;">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                        </h3>
                        
                        <div class="product-price-wrapper" style="margin-bottom: 1.5rem;">
                            <span class="current-price" style="font-size: 1.2rem; font-weight: 800; color: var(--primary-color);">{{ number_format($product->discounted_price ?? $product->price, 2) }} TL</span>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 0.6rem; font-size: 0.85rem;">Sepete Ekle</button>
                            </form>
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: white; border: 1px solid #eee; padding: 0.6rem; border-radius: 6px; cursor: pointer; color: #ff4757;">
                                    <i class="fa{{ in_array($product->id, session('wishlist', [])) ? 's' : 'r' }} fa-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 5rem 0; background: white; border-radius: 12px; box-shadow: var(--shadow);">
                <i class="fas fa-search" style="font-size: 4rem; color: #eee; margin-bottom: 2rem;"></i>
                <h2>Üzgünüz, sonuç bulunamadı.</h2>
                <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto; padding: 1rem 2rem; margin-top: 2rem;">Ana Sayfaya Dön</a>
            </div>
        @endif
    </section>
</div>
@endsection
