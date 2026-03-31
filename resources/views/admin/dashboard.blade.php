@extends('layouts.admin')

@section('content')
<h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem;">Hoşgeldiniz, <span style="color:var(--admin-primary)">Satıcı Profili</span></h1>

<div class="stat-grid">
    <div class="stat-card">
        <p style="color: var(--text-muted); font-weight: 600;">Toplam Ürün</p>
        <h2 style="font-size: 2.2rem; margin: 0.5rem 0;">{{ $stats['total_products'] }}</h2>
        <span style="color: #10b981; font-size: 0.85rem;"><i class="fas fa-arrow-up"></i> +12% Bu Ay</span>
    </div>
    <div class="stat-card">
        <p style="color: var(--text-muted); font-weight: 600;">Siparişler</p>
        <h2 style="font-size: 2.2rem; margin: 0.5rem 0;">{{ $stats['total_orders'] }}</h2>
        <span style="color: #ef4444; font-size: 0.85rem;"><i class="fas fa-arrow-down"></i> -2% Geçen Hafta</span>
    </div>
    <div class="stat-card">
        <p style="color: var(--text-muted); font-weight: 600;">Cari Hesaplar</p>
        <h2 style="font-size: 2.2rem; margin: 0.5rem 0;">{{ $stats['total_customers'] }}</h2>
        <span style="color: #10b981; font-size: 0.85rem;"><i class="fas fa-check"></i> Hepsi Aktif</span>
    </div>
    <div class="stat-card" style="background: var(--admin-primary); color: white;">
        <p style="opacity: 0.8;">Toplam Gelir</p>
        <h2 style="font-size: 2.2rem; margin: 0.5rem 0;">{{ number_format($stats['total_revenue'], 2) }} TL</h2>
        <span style="opacity: 0.7; font-size: 0.85rem;">Gerçekleşen Satışlar</span>
    </div>
</div>

<div class="card">
    <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Son Siparişler</h3>
    <table>
        <thead>
            <tr>
                <th>Sipariş No</th>
                <th>Müşteri</th>
                <th>Tutar</th>
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recent_orders as $order)
            <tr>
                <td style="font-weight: 700;">#{{ $order->order_number }}</td>
                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                <td>{{ number_format($order->total_amount, 2) }} TL</td>
                <td>
                    <span class="badge badge-blue">{{ $order->status }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
