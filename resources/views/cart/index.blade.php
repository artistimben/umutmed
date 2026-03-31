@extends('layouts.app')

@section('title', 'Sepetim - Umut Medikal')

@section('content')
<h1 class="section-title">Alışveriş Sepetim</h1>

@if(count($cart) > 0)
    <table class="cart-table">
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Fiyat</th>
                <th>Adet</th>
                <th>Toplam</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $id => $details)
                <tr>
                    <td>
                        <div class="cart-item-info">
                            <img src="{{ $details['image'] ?? 'https://via.placeholder.com/60/eeeeee?text=?' }}" alt="{{ $details['title'] }}" class="cart-item-image">
                            <div>
                                <a href="{{ route('products.show', $details['slug']) }}" style="font-weight: 600;">{{ $details['title'] }}</a>
                            </div>
                        </div>
                    </td>
                    <td>{{ number_format($details['price'], 2) }} TL</td>
                    <td>
                        <form action="{{ route('cart.update', $id) }}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="quantity-input">
                            <button type="submit" class="btn btn-primary btn-sm">Güncelle</button>
                        </form>
                    </td>
                    <td>{{ number_format($details['price'] * $details['quantity'], 2) }} TL</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="cart-summary">
        <div style="margin-bottom: 2rem;">
            <p style="font-weight: 600; margin-bottom: 0.8rem;">Kupon Kodunuz mu var?</p>
            <form action="#" method="POST" style="display: flex; gap: 0.5rem;">
                <input type="text" name="coupon" placeholder="KUPON10" class="form-control" style="width: 100%; padding: 0.6rem; border: 1px solid #ddd; border-radius: 8px;">
                <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.6rem 1.5rem;">Uygula</button>
            </form>
        </div>
        <div class="summary-row">
            <span>Ara Toplam</span>
            <span>{{ number_format($total, 2) }} TL</span>
        </div>
        <div class="summary-row" style="color: #28a745; display: none;"> <!-- Hidden until coupon applied -->
            <span>İndirim (KUPON)</span>
            <span>- 0.00 TL</span>
        </div>
        <div class="summary-row">
            <span>Kargo</span>
            <span>Ücretsiz</span>
        </div>
        <div class="summary-row summary-total">
            <span>Toplam</span>
            <span>{{ number_format($total, 2) }} TL</span>
        </div>
        
        <a href="{{ route('checkout') }}" class="btn btn-primary" style="margin-top: 1rem; padding: 1rem; font-size: 1.1rem;">Güvenli Ödeme Yap</a>
    </div>
@else
    <div style="text-align: center; padding: 5rem 0; background: white; border-radius: 12px; box-shadow: var(--shadow);">
        <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #eee; margin-bottom: 2rem;"></i>
        <h2>Sepetiniz henüz boş.</h2>
        <p style="margin: 1rem 0 2rem;">Sağlığınız için ihtiyacınız olan ürünlere göz atın.</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto; padding: 1rem 2rem;">Alışverişe Başla</a>
    </div>
@endif
@endsection
