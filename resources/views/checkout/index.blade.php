@extends('layouts.app')

@section('title', 'Ödeme ve Adres Bilgileri - Umut Medikal')

@section('content')
<h1 class="section-title">Ödeme ve Adres Bilgileri</h1>

<div class="product-detail-layout" style="grid-template-columns: 1.5fr 1fr; gap: 2rem;">
    <div class="checkout-form">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
                <h3 style="margin-bottom: 1.5rem;">İrtibat Bilgileri</h3>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Ad Soyad</label>
                    <input type="text" name="customer_name" required class="form-control" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">E-Posta</label>
                        <input type="email" name="customer_email" required class="form-control" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Telefon</label>
                        <input type="text" name="customer_phone" required class="form-control" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                </div>

                <h3 style="margin: 2rem 0 1.5rem;">Teslimat Adresi</h3>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Adres Detayı</label>
                    <textarea name="shipping_address" required rows="4" class="form-control" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                </div>
                
                <div style="margin-top: 2rem; padding: 1.5rem; background: #e3f2fd; border-radius: 8px; color: #0056b3;">
                    <i class="fas fa-info-circle"></i> Bir sonraki adımda Sanal POS (PayTR/Iyzico) ödeme ekranına yönlendirileceksiniz.
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 2rem; padding: 1.2rem; font-size: 1.2rem;">Siparişi Tamamla</button>
            </div>
        </form>
    </div>

    <div class="order-summary">
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); position: sticky; top: 120px;">
            <h3 style="margin-bottom: 1.5rem;">Sipariş Özeti</h3>
            @foreach($cart as $item)
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 0.9rem;">
                    <span>{{ $item['title'] }} (x{{ $item['quantity'] }})</span>
                    <span>{{ number_format($item['price'] * $item['quantity'], 2) }} TL</span>
                </div>
            @endforeach
            <hr style="border: none; border-top: 1px solid #eee; margin: 1rem 0;">
            <div class="summary-row summary-total" style="font-size: 1.2rem;">
                <span>Toplam</span>
                <span>{{ number_format($total, 2) }} TL</span>
            </div>
        </div>
    </div>
</div>
@endsection
