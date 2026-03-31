@extends('layouts.app')

@section('title', $product->title . ' - Umut Medikal')

@section('content')
<div class="page-layout-with-sidebar">
    <!-- SIDEBAR CATEGORIES -->
    @include('partials.sidebar')

    <div id="product-detail-content">
        <div class="product-detail-layout" style="margin-top: 0;">
            <div class="detail-gallery">
                <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/800x600?text=Urun+Resmi' }}" alt="{{ $product->title }}" class="main-image" style="width: 100%; border-radius: 12px; box-shadow: var(--shadow);">
                
                <div class="thumbnail-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 20px;">
                    @foreach($product->images as $image)
                        <img src="{{ $image->image_url }}" alt="{{ $product->title }}" style="width: 100%; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 1px solid #ddd;">
                    @endforeach
                </div>
            </div>
            
            <div class="detail-info">
                <span class="product-category" style="font-size: 1rem; color: var(--accent-color); font-weight: 700; text-transform: uppercase;">{{ $product->category ? $product->category->name : 'Genel' }}</span>
                <h1 style="font-size: 2.2rem; margin: 1rem 0; line-height: 1.2;">{{ $product->title }}</h1>
                
                <div class="detail-meta">
                    <span>Marka: <strong>{{ $product->brand ? $product->brand->name : 'Umut Medikal' }}</strong></span>
                    <span>Stok: <strong>{{ $product->stock > 0 ? $product->stock . ' Adet' : 'Stokta Yok' }}</strong></span>
                </div>

                <div class="product-price-wrapper" style="margin: 2rem 0;">
                    <span class="current-price" style="font-size: 2.5rem;">{{ number_format($product->discounted_price ?? $product->price, 2) }} TL</span>
                </div>

                <p class="detail-description">
                    {!! nl2br(e($product->description)) !!}
                </p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 2rem;">
                    @csrf
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock ?? 100 }}" style="width: 80px; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1.1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1; padding: 1.2rem; font-size: 1.2rem;">Sepete Ekle</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- REVIEWS SECTION -->
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); margin: 3rem 0;">
            <h2 class="section-title" style="margin-top: 0; text-align: left; font-size: 1.5rem;">Ürün Değerlendirmeleri ({{ $product->reviews->count() }})</h2>
            <div class="reviews-list">
                @forelse($product->reviews as $review)
                    <div style="padding-bottom: 1.5rem; border-bottom: 1px solid #eee; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <p style="font-weight: 700;">{{ $review->name }}</p>
                            <div style="color: #ff9f43;">{{ str_repeat('⭐', $review->rating) }}</div>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p style="color: var(--text-muted);">Henüz yorum yapılmamış.</p>
                @endforelse
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <section id="related-products">
            <h2 class="section-title" style="text-align: left; font-size: 1.5rem;">Benzer Ürünler</h2>
            <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                @foreach($relatedProducts as $related)
                <div class="product-card" style="background: white; border: 1px solid #eee;">
                    <a href="{{ route('products.show', $related->slug) }}">
                        <div style="height: 180px;">
                            <img src="{{ $related->mainImage ? $related->mainImage->image_url : 'https://via.placeholder.com/600x400?text=Urun' }}" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                    </a>
                    <div style="padding: 1rem;">
                        <h3 style="font-size: 0.85rem; height: 35px; overflow: hidden;">{{ $related->title }}</h3>
                        <span style="font-weight: 800; color: var(--primary-color);">{{ number_format($related->price, 2) }} TL</span>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection
