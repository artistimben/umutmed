@extends('layouts.app')

@section('title', 'Umut Medikal - Anasayfa')

@section('content')
<div class="page-layout-with-sidebar">
    <!-- SIDEBAR CATEGORIES -->
    @include('partials.sidebar')

    <!-- CONTENT AREA -->
    <section id="products-content">
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.4rem; margin: 0;">
                @if($categorySlug)
                    {{ \App\Models\Category::where('slug', $categorySlug)->first()->name ?? 'Ürünler' }} Sonuçları
                @else
                    Sizin İçin Seçtiklerimiz
                @endif
            </h2>
            <div style="font-size: 0.9rem; color: #999;">
                {{ $featuredProducts->count() }} ürün listeleniyor
            </div>
        </div>

        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
            @foreach($featuredProducts as $product)
            <div class="product-card" style="background: white; border: 1px solid #f0f0f0; transition: transform 0.3s, box-shadow 0.3s; border-radius: 8px; overflow: hidden; position: relative;">
                <!-- Wishlist Toggle -->
                <div style="position: absolute; top: 1rem; right: 1rem; z-index: 10;">
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: white; border: 1px solid #efefef; padding: 0.6rem; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer; color: #ff4757;">
                            <i class="fa{{ in_array($product->id, session('wishlist', [])) ? 's' : 'r' }} fa-heart"></i>
                        </button>
                    </form>
                </div>

                <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none; color: inherit;">
                    <div style="height: 220px; overflow: hidden; background: #f9f9f9;">
                        <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/600x400?text=Urun+Resmi' }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.3s;">
                    </div>
                </a>

                <div class="product-info" style="padding: 1.2rem;">
                    <span style="font-size: 0.75rem; color: #999; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 0.5rem;">{{ $product->brand ? $product->brand->name : 'Markasız' }}</span>
                    <h3 class="product-title" style="font-size: 0.95rem; margin-bottom: 1rem; height: 40px; overflow: hidden; line-height: 1.3;">
                        <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none; color: #333;">{{ $product->title }}</a>
                    </h3>
                    
                    <div class="product-price-wrapper" style="display: flex; align-items: flex-end; gap: 0.8rem; margin-bottom: 1.5rem;">
                        <span class="current-price" style="font-size: 1.2rem; font-weight: 800; color: var(--primary-color);">{{ number_format($product->discounted_price ?? $product->price, 2) }} TL</span>
                        @if($product->discounted_price)
                            <span class="old-price" style="font-size: 0.9rem; text-decoration: line-through; color: #bbb; margin-bottom: 2px;">{{ number_format($product->price, 2) }} TL</span>
                        @endif
                    </div>
                    
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 6px; padding: 0.8rem; font-size: 0.9rem; font-weight: 700; text-transform: none;">Sepete Ekle</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- CATEGORY HIGHLIGHT SECTIONS -->
    @foreach($categories->take(3) as $cat)
        @php $catProducts = $cat->products()->with('mainImage')->limit(4)->get(); @endphp
        @if($catProducts->count() > 0)
            <section class="category-highlight" style="margin-top: 4rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                    <h2 style="font-size: 1.5rem; color: #333;">{{ $cat->name }}</h2>
                    <a href="{{ route('products.category', $cat->slug) }}" style="color: var(--primary-color); font-weight: 700; font-size: 0.9rem;">Hepsini Gör <i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                    @foreach($catProducts as $product)
                        <div class="product-card" style="background: white; border: 1px solid #f0f0f0; border-radius: 8px; overflow: hidden;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <div style="height: 200px; background: #f9f9f9;">
                                    <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/600x400?text=Urun' }}" style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                            </a>
                            <div style="padding: 1rem;">
                                <h3 style="font-size: 0.9rem; margin-bottom: 0.5rem; height: 35px; overflow: hidden;">{{ $product->title }}</h3>
                                <span style="font-weight: 800; color: var(--primary-color);">{{ number_format($product->price, 2) }} TL</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach
</div>
@endsection
