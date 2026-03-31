@extends('layouts.app')

@section('title', 'Siparişiniz Alındı - Umut Medikal')

@section('content')
<div class="container" style="max-width: 800px; text-align: center; padding: 5rem 0;">
    <div style="background: white; padding: 4rem; border-radius: 12px; box-shadow: var(--shadow);">
        <i class="fas fa-check-circle" style="font-size: 5rem; color: #28a745; margin-bottom: 2rem;"></i>
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Teşekkürler!</h1>
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 2rem;">Siparişiniz başarıyla alındı. Sipariş numaranız: <strong>{{ $order->order_number }}</strong></p>
        
        <div style="text-align: left; background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 3rem;">
            <p><strong>Müşteri:</strong> {{ $order->customer_name }}</p>
            <p><strong>E-Posta:</strong> {{ $order->customer_email }}</p>
            <p><strong>Toplam Tutar:</strong> {{ number_format($order->total_amount, 2) }} TL</p>
            <p><strong>Durum:</strong> Hazırlanıyor</p>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto; padding: 1rem 2rem;">Alışverişe Devam Et</a>
        </div>
    </div>
</div>
@endsection
