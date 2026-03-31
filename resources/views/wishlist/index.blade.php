@extends('layouts.app')

@section('title', 'Favorilerim - Umut Medikal')

@section('content')
<h1 class="section-title">Favori Ürünlerim</h1>

@if($products->count() > 0)
    <div class="product-grid">
        @foreach($products as $product)
        <div class="product-card">
            <div style="position: absolute; top: 1rem; right: 1rem; z-index: 10;">
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: white; border: none; padding: 0.8rem; border-radius: 50%; box-shadow: var(--shadow); cursor: pointer; color: #ff4757; font-size: 1.2rem;">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
            </div>
            <a href="{{ route('products.show', $product->slug) }}">
                <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/600x400?text=Urun+Resmi' }}" alt="{{ $product->title }}" class="product-image">
            </a>
            <div class="product-info">
                <span class="product-category">{{ $product->category ? $product->category->name : 'Genel' }}</span>
                <h3 class="product-title">
                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                </h3>
                
                <div class="product-price-wrapper">
                    <span class="current-price">{{ number_format($product->discounted_price ?? $product->price, 2) }} TL</span>
                    @if($product->discounted_price)
                        <span class="old-price">{{ number_format($product->price, 2) }} TL</span>
                    @endif
                </div>
                
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Sepete Ekle</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div style="text-align: center; padding: 5rem 0; background: white; border-radius: 12px; box-shadow: var(--shadow);">
        <i class="fas fa-heart" style="font-size: 4rem; color: #eee; margin-bottom: 2rem;"></i>
        <h2>Henüz favori ürününüz yok.</h2>
        <p style="margin: 1rem 0 2rem;">İlginizi çeken ürünleri kalp butonuna basarak buraya ekleyebilirsiniz.</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto; padding: 1rem 2rem;">Alışverişe Devam Et</a>
    </div>
@endif
@endsection
